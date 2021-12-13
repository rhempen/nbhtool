<?php include('_requesttitle.php') ?>
<?php include('_requestnav.php') ?>
    <nav class="navbar navbar-default navbar-sub">
        <ul class="nav navbar-nav">
            <li>
                <a href="<?=
                \Layout\Html\Tools::url('request/add_log',['request_id'=> $request->id()]) ?>">
                    Neue Bemerkung oder Status &auml;ndern
                </a>
            </li>
        </ul>
    </nav>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Logbuch-Eintrag erfassen/Status &auml;ndern</h3>
        </div>
        <div class="panel-body">
            <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('request/log', ['request_id' => $request_id ]) ?>">
                <?php \Layout\Html\Tools::widget(
                'form/input-select',
                [
                    "title" => "Status",
                    "id" => "status_id",
                    "data" => $request->current_state()->state()->field('id')->data(),
                    "list" => $state_list
                ]) ?>
                <?php \Layout\Html\Tools::widget(
                'form/input-textarea',
                [
                    "title" => "Bemerkung",
                    "id" => "status_log",
                    "data" => '',
                    "rows" => 4,
                ]) ?>
                <button name="form_submit_add_log" type="submit" class="btn btn-primary">speichern</button>
                <button name="form_cancel_add_log" type="button" class="btn btn-default" onclick="$('#form-add-log').hide(); return false;">abbrechen</button>
            </form>
        </div>
    </div>
