<?php foreach($person_list as $person): ?>
    <?php if($person->volunteer()->is_asignable()): ?>
    <?php \Layout\Html\Tools::widget(
    'person-card',
    [
        "person" => $person,
        "url" => \Layout\Html\Tools::url($contact_action ? $contact_action : 'person/details', array_merge($card_url_params, [$person_id_name => $person->field('id')->data(), ])),
        "menu" => [
            'Als Freiwillige(n) zuweisen' => [
                'url' => \Layout\Html\Tools::url( 'request/volunteers', [
                        'request_id' => $request_id,
                        'volunteer_person_id' => $person->id()
                    ]),
                'icon' => 'ok',
                'class' => ['volunteer'],
            ],
        ]
    ]) 
    ?>
    <?php endif; ?>
<?php endforeach; ?>
<?php if(count($person_list) == 0): ?>
<div class="list-group-item">
    <h4 class="list-group-item-heading">Keine Freiwilligen gefunden</h4>
</div>
<?php endif; ?>
