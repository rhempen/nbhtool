<?php if(is_string($group_name)): ?>
<h1><span class="db-id">Liste: </span>Alle Personen in der Gruppe <i><?= \Layout\Html\Tools::enc($group_name) ?></i></h1>
<?php else: ?>
<h1><span class="db-id">Liste: </span>Alle Personen</h1>
<?php endif; ?>
<?php include('_listspersonnav.php') ?>

<?php \Layout\Html\Tools::widget('table', [
    'data' => $person_list,
    'columns' => [
        'Id' => [
            'field' => 'id',
            'template' => '<a
            href="'.\Layout\Html\Tools::url('person/details',['person_id' =>
            '{id}']).'"><strong>#{id}<strong><a>'
        ],
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
        'Tel Privat' => ['field' => 'phone_home'],
        'Tel Geschäft' => ['field' => 'phone_work'],
        'Mobile' => ['field' => 'phone_mobile'],
        'Geburtstag' => ['field' => 'date_of_birth', 'timestamp' => 1],
        'Nationalität' => ['field' => 'nationality'],
        'Mitgliederstatus' => [
            'field' => 'membership',
            'template' => '<a href="'.\Layout\Html\Tools::url('person/membership',['person_id' => '{id}']).'">{membership}<a>'
        ],
        'Gruppen' => [ 'field' => 'groups' ],
        'Eingetreten' => [ 'field' => 'timestamp', 'timestamp' => 1]
    ]
    ]
); ?>
