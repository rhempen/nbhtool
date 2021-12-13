<?php 
if(!isset($id))
{
    $id = uniqid('table_');
}
if(!isset($excel_export_url))
{
    $excel_export_url =
    \RT::$request->controller()."/".\RT::$request->action()."/excel";
}
?>
<div id="toolbar_<?= $id ?>">
        <button type="button" id="table-export" class="btn btn-default"
        role="button" data-toggle="modal" data-target="#export_modal_<?= $id ?>">Export nach Excel</button>
</div>
<div id="<?= $id ?>"> 
    <table 
        class="table table-condensed" 
        data-toolbar="#toolbar_<?= $id ?>" 
        data-toggle="table" 
        data-search="true" 
        data-show-columns="true" 
        data-show-toggle="false"
        data-mobile-responsive="true"
        data-striped="true" 
        data-sortable="true" 
        data-undefined-text ="&nbsp;" 
        data-search-align = "right" 
        data-toolbar-align = "left" 
        data-buttons-align = "right" 
    >
        <?php $table_timestamp_columns = array() ?>
        <?php $table_columns_name = array() ?>
        <thead>
            <tr>
        <?php foreach($columns as $key => $definition ): ?>
                <th data-searchable="true" data-switchable="<?= array_key_exists('switchable', $definition) ?  $definition['switchable'] : 'true' ?>" data-sortable="<?= array_key_exists('sortable', $definition) ? $definition['sortable'] : 'true' ?>" data-formatter="tableFormatter" data-field="<?= $definition['field'] ?>"><?= $key ?></th>
            <?php if(array_key_exists('timestamp', $definition)): ?>
                <?php array_push($table_timestamp_columns, $definition['field']) ?>
           <?php endif; ?>
           <?php $table_columns_name[$definition['field']] = $key ?>
        <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data as $record):
            // We need to provide data via GLOBALS to access it by
            // preg_replace_callback (Check sometimes for a better way) ?>
            <?php foreach($record as $__key => $__val)
            {
                $GLOBALS[$__key] = $__val;
            } ?>
            <tr>
                <?php foreach($columns as $key => $definition): ?>
                    <td>
                    <?php if(array_key_exists('template', $definition)): ?> <?=
                    preg_replace_callback('/\{(.+?)\}/m',
                    function($matches){return $GLOBALS[$matches[1]];}, $definition['template']) ?>
                    <?php elseif(array_key_exists('timestamp', $definition)): ?>
                       <?php if(isset($GLOBALS[$definition['field']]) && $GLOBALS[$definition['field']] != 0): ?>
                           <?= date("d.m.Y", $GLOBALS[$definition['field']]) ?>
                       <?php endif; ?>
                    <?php else: ?>
                       <?= isset($GLOBALS[$definition['field']]) ? $GLOBALS[$definition['field']] : '' ?>
                    <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="export_modal_<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="export_modal_<?= $id ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3>Datenexport nach Excel</h3>
                </div>
                <div class="modal-body">
                    <form id="export_form_<?= $id ?>" method="post" action="<?= \Layout\Html\Tools::url('/exporter/excel') ?>">
                    <h4>Dateiname</h4>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-text',
                        [
                            "title" => "Dateiname",
                            "data" => $id,
                            "id" => "export_table_file_name",
                        ]) ?>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-text',
                        [
                            "title" => "Name Tabellenblatt",
                            "data" => 'NBHTool Export',
                            "id" => "export_table_sheet_name",
                        ]) ?>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-hidden',
                        [
                            "data" => \Layout\Html\Tools::enc(serialize($table_columns_name)),
                            "id" => "export_table_columns_name",
                        ]) ?>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-hidden',
                        [
                            "data" => \Layout\Html\Tools::enc(serialize($table_timestamp_columns)),
                            "id" => "export_table_timestamp_columns",
                        ]) ?>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-hidden',
                        [
                            "data" => \Layout\Html\Tools::enc(serialize($data)),
                            "id" => "export_table_data",
                        ]) ?>
                    <h4>Spalten w&auml;hlen</h4>
                    <?php foreach($columns as $key => $definition): ?>
                         <div class="checkbox">
                             <label>
                                   <input type="checkbox" value="<?= $definition['field'] ?>" name="export_table_columns[]" checked="1"><?= $key ?></input>
                             </label>
                         </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary">exportieren</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">schliessen</button>
                    </form>
                </div>
        </div>
    </div>
</div>

<!-- Widgets local Javascript -->

<script type ="text/javascript">
    function tableFormatter(value,row) {
       var e = document.createElement('div');
       e.innerHTML = value;
       return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
    }

    $(".fixed-table-toolbar").append('<button class="btn btn-default">Export</button>' )
</script>
