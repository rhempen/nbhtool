<h1><span class="db-id">Gruppen: </span>Neue Gruppe erstellen</h1>
<?php include('_groupnav.php') ?>
<p></p>
    <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('group/create/save') ?>">
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Name der Gruppe</h3>
        </div>
        <div class="panel-body">
            <p>Geben Sie hier einen m&ouml;glichst kurzen und pr&auml;zisen Namen ein f&uuml;r die neue Gruppe.</p>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "",
                        "id" => "text",
                        "data" => \RT::$params->get('text'),
                    ]) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Bemerkung</h3>
        </div>
        <div class="panel-body">
            <p>Wenn Sie m&ouml;chten, k&ouml;nnen Sie in diesem Feld eine Detailbeschreibung zum Nutzen der neuen Gruppe erfassen.</p>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-textarea',
                    [
                        "title" => "",
                        "id" => "note",
                        "data" => '',
                        "rows" => 6,
                    ]) ?>
        </div>
    </div>
                    <button name="form_submit_group" type="submit" class="btn btn-primary">speichern</button>
    </form>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
