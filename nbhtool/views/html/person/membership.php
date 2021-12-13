<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<p></p>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Mitgliederstatus</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" onclick="$('#display-membership').hide(); $('#form-edit-membership').show(); return false;">&Auml;ndern</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="form-edit-membership" class="start-invisible">
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/membership', ['person_id' => $person->id() ]) ?>">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-select',
                    [
                        "title" => "Neuer Mitgliederstatus",
                        "data" => $person->field('membership_id'),
                        "list" => $membership_list,
                    ]) ?>
                    <button name="form_submit_edit_membership" type="submit" class="btn btn-primary">&auml;ndern</button>
                    <button name="form_cancel_edit_membership" type="button" class="btn btn-default" onclick="$('#display-membership').show(); $('#form-edit-membership').hide(); return false;">abbrechen</button>
                </form>
            </div>
            <div id="display-membership">
                Aktueller Mitgliederstatus: <strong><?= $person->membership()->field('text')->data(); ?></strong>
            </div>
        </div>
    </div>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
