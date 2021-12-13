<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<nav class="navbar navbar-default navbar-sub">
    <ul class="nav navbar-nav">
        <li>
            <a href="<?= \Layout\Html\Tools::url('request/create',['client_id'=> $person->client()->id()]) ?>">
                Neue Anfrage erfassen
            </a>
        </li>
    </ul>
</nav>
<?php if($person->client()->is()): ?>


<?php \Layout\Html\Tools::widget('table', [
    'data' => $request_list,
    'columns' => [
        '#' => ['field' => 'id', 'template' => '<strong><a
        href="'.\Layout\Html\Tools::url('request/details',['request_id' => '{id}']).'">#{id}<a></strong>'],
        'Status' => ['field' => 'state', 'template' => '<span class="label color-state-{state_id}">{state}</span>'],
        'Kategorie der Anfrage' => ['field' => 'service'],
        'Status seit' => ['field' => 'last_change'],
        'Zuletzt bearbeitet durch' => ['field' => 'last_user'],
    ]
    ]
); ?>

<?php endif; ?>


<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
