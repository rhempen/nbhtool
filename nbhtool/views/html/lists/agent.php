<h1><span class="db-id">Liste: </span>Vermittler/-innen</h1>
<?php include('_listsagentnav.php') ?>

<?php \Layout\Html\Tools::widget('table', [
    'data' => $person_list,
    'columns' => [
        'Id' => [
            'field' => 'id',
            'template' => '<a
            href="'.\Layout\Html\Tools::url('person/details',['person_id' =>
            '{id}']).'"><strong>#{id}<strong><a>'
        ],
        'Erfasst als Vermittler/-in' => ['field' => 'created', 'timestamp' => 1],
        'Status Vermittler/-in' => ['field' => 'state'],
        'Anrede' => ['field' => 'gender'],
        'Titel' => ['field' => 'title'],
        'Vorname' => ['field' => 'firstname'],
        'Nachname' => ['field' => 'lastname'],
        'Organisation/Firma' => ['field' => 'organization'],
        'Strasse' => ['field' => 'address_line1'],
        'Adresszusatz' => ['field' => 'address_line2'],
        'Postfach' => ['field' => 'postbox'],
        'PLZ' => ['field' => 'zip_code'],
        'Ort' => ['field' => 'city'],
        'Land' => ['field' => 'country'],
        'Email' => ['field' => 'email_address'],
        'Private Rufnummer' => ['field' => 'phone_home'],
        'Geschäftliche Rufnummer' => ['field' => 'phone_work'],
        'Mobile Rufnummer' => ['field' => 'phone_mobile'],
        'Geburtstag' => ['field' => 'date_of_birth', 'timestamp' => 1],
        'Nationalität' => ['field' => 'nationality'],
        'Eingetreten' => [ 'field' => 'timestamp', 'timestamp' => 1]
    ]
    ]
); ?>
