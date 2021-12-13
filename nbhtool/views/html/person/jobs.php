<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<nav class="navbar navbar-default navbar-sub">
<ul class="nav navbar-nav">
    <li>
        <a href="<?=
        \Layout\Html\Tools::url('person/jobs/select_new',['person_id'=> $person->id(),'show_closed' => 1]) ?>">zeige auch beendete Verbindungen</a>
    </li>
    <li>
        <a href="<?= \Layout\Html\Tools::url('person/jobs/select_new',['person_id'=> $person->id()]) ?>">Einer offenen Anfrage hinzuf&uuml;gen</a>
    </li>
</ul>
</nav>
<?php if($person->volunteer()->is()): ?>
<?php \Layout\Html\Tools::widget('table', [
    'data' => $request_list,
    'columns' => [
        '#' => ['field' => 'id', 'template' => '<strong><a href="'.\Layout\Html\Tools::url('request/volunteers',['request_id' => '{id}']).'">#{id}<a></strong>'],
        'Status' => ['field' => 'state', 'template' => '<span class="label color-state-{state_id}">{state}</span>'],
        'Kategorie der Anfrage' => ['field' => 'service'],
        'Name Klient/in' => [
            'field' => 'client', 'template' => '<a href="'.\Layout\Html\Tools::url('person/client',['person_id' => '{client_person_id}']).'">{client}<a>'
        ],
        'Zugewiesen' => ['field' => 'rel_start'],
        'Beendet' => ['field' => 'rel_end']
    ]
    ]
); ?>
<?php endif; ?>


<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
