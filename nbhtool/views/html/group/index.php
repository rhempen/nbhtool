<h1><span class="db-id">Gruppen: </span>Liste der Gruppen</h1>
<?php include('_groupnav.php') ?>
<p></p>
<?php foreach($group_list as $group): ?>
    <div class="list-group-item">
        <div class="row group-card-first-row">
            <div class="col-md-1">
                <img src="<?= \Layout\Html\Tools::web("/img/group.png") ?>" alt="Group">
            </div>
            <div class="col-md-8">
                <a href="<?= \Layout\Html\Tools::url('group/details',
                ['person_group_id' => $group->id()]) ?>"><h4><?= $group->field('text')->data() ?> <span class="badge badge-in-nav"><?= count($group->persons()) ?></span></h4></a>
                <p><?= $group->field('note')->data() ?></p>
            </div>
            <div class="col-md-3" style="text-align: right">
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
