<?php include('_requesttitle.php') ?>
<?php include('_requestnav.php') ?>
    <nav class="navbar navbar-default navbar-sub">
        <ul class="nav navbar-nav">
            <li><a href="<?= \Layout\Html\Tools::url('request/add_volunteer', ['request_id' => $request_id ]) ?>">Freiwillige/r zuweisen</a></li>
        </ul>
    </nav>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Freiwillige/r suchen und zuweisen</h3>
        </div>
        <div class="panel-body">
            <?php \Layout\Html\Tools::widget(
            'person-search',
            [
                "async_url" => \Layout\Html\Tools::url('async/volunteersearch',
                [
                    'request_id' => $request_id,
                    "contact_action" => 'person/details',
                    'person_id_name' => 'person_id'
                ])
            ]) ?>
            <a href="<?= \Layout\Html\Tools::url('request/volunteers', ['request_id' => $request_id]) ?>" type="button" class="btn btn-default">abbrechen</a>
        </div>
    </div>
