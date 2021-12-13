<h1><span class="db-id">Liste: </span>Anfragen</h1>
<?php include('_listsrequestnav.php') ?>

<?php \Layout\Html\Tools::widget('table', [
    'data' => $request_list,
    'columns' => [
        '#' => ['field' => 'id', 'template' => '<strong><a
        href="'.\Layout\Html\Tools::url('request/details',['request_id' => '{id}']).'">#{id}<a></strong>'],
        'Status' => ['field' => 'state', 'template' => '<span class="label color-state-{state_id}"><a href="'.\Layout\Html\Tools::url('request/log',['request_id' => '{id}']).'">{state}</a></span>'],
        'Kategorie der Anfrage' => ['field' => 'service'],
        'Name Klient/in' => [
            'field' => 'client', 'template' => '<a href="'.\Layout\Html\Tools::url('person/client',['person_id' => '{client_person_id}']).'">{client}<a>'
        ],
        'Status seit' => ['field' => 'last_change'],
        'erfasst' => ['field' => 'created'],
        'Zuletzt bearbeitet durch' => ['field' => 'last_user'],
    ]
    ]
); ?>

