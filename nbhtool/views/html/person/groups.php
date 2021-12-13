<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<p></p>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">zugewiesene Gruppen</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" onclick="$('#display-membership').hide(); $('#form-edit-membership').show(); return false;">einer Gruppe hinzuf&uuml;gen</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="form-edit-membership" class="start-invisible">
                <p>Die gew&uuml;nschte Gruppe anklicken, um sie der Person zuzuweisen:</p>
                <?php foreach($group_list as $group): ?>
                <div class="list-group-item">
                    <div class="row group-card-first-row">
                        <div class="col-md-1">
                            <img src="<?= \Layout\Html\Tools::web("/img/group.png") ?>" alt="Group">
                        </div>
                        <div class="col-md-8">
                            <a href="<?=
                            \Layout\Html\Tools::url('person/groups/add', ['person_id' => $person->id(), 'person_group_id' => $group->id()]) ?>"><h4><?= $group->field('text')->data() ?> <span class="badge badge-in-nav"><?= count($group->persons()) ?></h4></a> <p><?= $group->field('note')->data() ?></p>
                        </div>
                        <div class="col-md-3" style="text-align: right">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="display-membership">
                <?php foreach($person->groups() as $group): ?>
                    <div class="list-group-item">
                        <div class="row group-card-first-row">
                            <div class="col-md-1">
                                <img src="<?= \Layout\Html\Tools::web("/img/group.png") ?>" alt="Group">
                            </div>
                            <div class="col-md-8">
                                <a href="<?=
                                \Layout\Html\Tools::url('group/details',
                                ['person_group_id' =>
                                $group->group()->id()]) ?>"><h4><?=
                                $group->group()->field('text')->data() ?>
                                <span class="badge badge-in-nav"><?= count( $group->group()->persons()) ?></h4></a> <p><?= $group->group()->field('note')->data() ?></p>
                            </div>
                            <div class="col-md-3" style="text-align: right">
                                <a href="<?= \Layout\Html\Tools::url('person/groups/remove', ['person_id' => $person->id(), 'person_group_id' => $group->group()->id()]) ?>"><span title="Von Gruppe l&ouml;schen" class="glyphicon glyphicon-remove" aria-hidden="true"></span> Aus Gruppe entfernen</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
