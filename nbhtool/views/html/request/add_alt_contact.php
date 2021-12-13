<?php include('_requesttitle.php') ?>
<?php include('_requestnav.php') ?>
    <nav class="navbar navbar-default navbar-sub">
        <ul class="nav navbar-nav">
            <li>
                <a href="<?=
                \Layout\Html\Tools::url('request/add_alt_contact',['request_id'=> $request->id()]) ?>">
                    alternative Kontaktperson zuweisen
                </a>
            </li>
        </ul>
    </nav>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Alternative Kontaktperson suchen und zuweisen</h3>
        </div>
        <div class="panel-body">
            <?php \Layout\Html\Tools::widget(
            'person-search',
            [
                "async_url" => \Layout\Html\Tools::url('async/personsearch',
                [
                    'request_id' => $request_id,
                    "contact_action" => 'request/details',
                    'person_id_name' => 'contact_person_id'
                ])
            ]) ?>
            <a href="<?= \Layout\Html\Tools::url('request/details', ['request_id' => $request_id]) ?>" type="button" class="btn btn-default">abbrechen</a>
        </div>
    </div>
