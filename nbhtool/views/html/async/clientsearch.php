<?php foreach($person_list as $person): ?>
    <?php \Layout\Html\Tools::widget(
    'person-card',
    [
        "person" => $person,
        "url" => \Layout\Html\Tools::url('request/create', ['client_id' => $person->client()->field('id')->data()])
    ]) 
    ?>
<?php endforeach; ?>
<?php if(count($person_list) == 0): ?>
<div class="list-group-item">
    <h4 class="list-group-item-heading">Keine Person gefunden</h4>
</div>
<?php endif; ?>
