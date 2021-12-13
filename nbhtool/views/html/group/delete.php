<?php include('_grouptitle.php') ?>
<?php include('_groupdetailsnav.php') ?>
<p></p>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">L&ouml;schen der Gruppe best&auml;tigen</h3>
    </div>
    <div class="panel-body">
        <p>Durch die Best&auml;tigung dieser Meldung wird die Grupp
        <strong><?= $group->display_name() ?></strong>
        unwiederruflich gel&ouml;scht.</p>
        <a href="<?=
        \Layout\Html\Tools::url('group/delete/confirmed',['person_group_id'=> $group->id()]) ?>" class="btn btn-primary">Ja, Gruppe l&ouml;schen</button>
        <a href="<?= \Layout\Html\Tools::url('group/details',['person_group_id'=> $group->id()]) ?>" class="btn btn-default" role="button">Abbrechen</a>
    </div>
</div>
<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
