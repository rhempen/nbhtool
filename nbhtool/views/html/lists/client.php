<h1><span class="db-id">Liste: </span>Klientinnen und Klienten</h1>
<?php include('_listsclientnav.php') ?>

<?php \Layout\Html\Tools::widget('table', [
    'data' => $person_list,
    'columns' => [
        'Id' => [
            'field' => 'id',
            'template' => '<a
            href="'.\Layout\Html\Tools::url('person/client',['person_id' =>
            '{person_id}']).'"><strong>#{person_id}</strong><a>'
        ],
        'Status' => ['field' => 'state'],
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
        'Geschätliche Rufnummer' => ['field' => 'phone_work'],
        'Mobile Rufnummer' => ['field' => 'phone_mobile'],
        'Geburtstag' => ['field' => 'date_of_birth', 'timestamp' => 1],
        'Nationalität' => ['field' => 'nationality'],
        'Eingetreten' => [ 'field' => 'timestamp', 'timestamp' => 1]
    ]
    ]
); ?>
