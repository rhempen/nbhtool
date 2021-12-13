<?php include('_grouptitle.php') ?>
<?php include('_groupdetailsnav.php') ?>
<nav class="navbar navbar-default navbar-sub">
    <ul class="nav navbar-nav">
        <li>
            <a href="<?= \Layout\Html\Tools::url('group/delete', ['person_group_id' => $group->id() ]) ?>">
                Gruppe l&ouml;schen
            </a>
        </li>
    </ul>
</nav>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Name der Gruppe</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" onclick="$('#display-text').hide(); $('#form-edit-text').show(); return false;">&Auml;ndern</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="form-edit-text" class="start-invisible">
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('group/details/update', ['person_group_id' => $group->id() ]) ?>">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "",
                        "id" => "text",
                        "data" => $group->field('text'),
                    ]) ?>
                    <button name="form_submit_edit_text" type="submit" class="btn btn-primary">speichern</button>
                    <button name="form_cancel_edit_text" type="button" class="btn btn-default" onclick="$('#display-note').show(); $('#form-edit-text').hide(); return false;">abbrechen</button>
                </form>
            </div>
            <div id="display-text">
                <?= \Layout\Html\Tools::w_br_enc($group->field('text')->data()); ?>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Bemerkung</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" onclick="$('#display-note').hide(); $('#form-edit-note').show(); return false;">&Auml;ndern</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="form-edit-note" class="start-invisible">
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('group/details/update', ['person_group_id' => $group->id() ]) ?>">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-textarea',
                    [
                        "title" => "",
                        "id" => "note",
                        "data" => $group->field('note')->data(),
                        "rows" => 6,
                    ]) ?>
                    <button name="form_submit_edit_note" type="submit" class="btn btn-primary">speichern</button>
                    <button name="form_cancel_edit_note" type="button" class="btn btn-default" onclick="$('#display-note').show(); $('#form-edit-note').hide(); return false;">abbrechen</button>
                </form>
            </div>
            <div id="display-note">
                <?= \Layout\Html\Tools::w_br_enc($group->field('note')->data()); ?>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Erstelldatum</h3>
        </div>
        <div class="panel-body">
            <?= date("d.m.Y, H:i", $group->field('timestamp')->data()) ?>
        </div>
    </div>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
