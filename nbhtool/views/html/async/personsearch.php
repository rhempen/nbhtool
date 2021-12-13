<?php foreach($person_list as $person): ?>
    <?php
    \Layout\Html\Tools::widget(
    'person-card',
    [
        "person" => $person,
        "url" => \Layout\Html\Tools::url($contact_action ? $contact_action : 'person/details', array_merge($card_url_params, [$person_id_name => $person->field('id')->data(), ])),
        "menu" => [
            '&auml;ndern' => [
                'url' =>  \Layout\Html\Tools::url('person/update', ['person_id' => $person->field('id')->data()]),
                'icon' => 'pencil',
                'class' => []
            ],
            'Neue Anfrage' => [
                'url' =>  \Layout\Html\Tools::url('request/create', ['client_id' => $person->client()->field('id')->data()]),
                'icon' => 'link',
                'class' => ['client']
            ],
        ]
    ]) 
    ?>
<?php endforeach; ?>
<?php if(count($person_list) == 0): ?>
<div class="list-group-item">
    <h4 class="list-group-item-heading">Keine Person gefunden</h4>
    <a type="button" class="btn btn-default" href="<?=
    \Layout\Html\Tools::url('person/create', ['name_preset' => $search_string ]) ?>">Neue Person erfassen</a>
</div>
<?php endif; ?>
