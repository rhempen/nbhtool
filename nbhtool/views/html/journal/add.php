<h1><span class="db-id">Journal: </span>Journaleintrag erfassen</h1>
<?php include('_journalnav.php') ?>
<p></p>

    <div class="row">
    <div class="col-md-8"> 
    <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('journal/add') ?>">
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Aktion</h3>
        </div>
        <div class="panel-body">
            <p>Geben Sie hier die Beschreibung der Aktion ein.</p>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-textarea',
                    [
                        "title" => "",
                        "id" => "journal_text",
                        "data" => \RT::$params->get('journal_text'),
                        "rows" => 6
                    ]) ?>
        </div>
    </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading nav navbar-default">
                <h3 class="panel-title">Zeitpunkt</h3>
            </div>
            <div class="panel-body">
                <p>Legen Sie einen alternativen Zeitpunkt fest.</p>
                    <?php \Layout\Html\Tools::widget('form/input-date',
                    [
                        "title" => "Zeitpunkt",
                        "id" => "start",
                        "data" => \RT::$params->exists('start') ? \RT::$params->get('start') : date('d.m.Y', time())
                    ]) ?>
            </div>
        </div>
    </div>
    </div>
    <button name="form_submit_journal" type="submit" class="btn btn-primary">speichern</button>
    </form>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
