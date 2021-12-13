<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<nav class="navbar navbar-default navbar-sub">
    <ul class="nav navbar-nav">
        <li><a href="<?=
        \Layout\Html\Tools::url('person/update',['person_id'=> $person->id()]) ?>">Personendaten bearbeiten</a></li>
    </ul>
</nav>
<?php include('_personform.php') ?>
