<?php include('_grouptitle.php') ?>
<?php include('_groupdetailsnav.php') ?>
<p></p>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Automatische Mitgliedschaft aktivieren</h3>
        </div>
        <div class="panel-body">
            <div id="form-auto-add">
                <p>Wird eine der folgenden Personenklassen aktiviert, wird diese Gruppe automatisch bei einer Neuerfassung in der Klasse hinzugef&uuml;gt.</p>
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('group/options/set_auto_add', ['person_group_id' => $group->id() ]) ?>">
                     <div class="checkbox">
                         <label>
                               <input type="checkbox" value="volunteer" name="auto_add_classes[]" <?= $group->field('auto_add_new_volunteer')->data() ?  'checked="1" ' : '' ?>>Freiwillige</input>
                         </label>
                     </div>
                     <div class="checkbox">
                         <label>
                               <input type="checkbox" value="client" name="auto_add_classes[]" <?= $group->field('auto_add_new_client')->data() ?  'checked="1" ' : '' ?>>Klienten</input>
                         </label>
                     </div>
                     <div class="checkbox">
                         <label>
                               <input type="checkbox" value="person" name="auto_add_classes[]" <?= $group->field('auto_add_new_person')->data() ?  'checked="1" ' : '' ?>>Personen</input>
                         </label>
                     </div>
                     <div class="checkbox">
                         <label>
                               <input type="checkbox" value="agent" name="auto_add_classes[]" <?= $group->field('auto_add_new_agent')->data() ?  'checked="1" ' : '' ?>>Vermittler/-innen</input>
                         </label>
                     </div>
                     <div class="checkbox">
                         <label>
                               <input type="checkbox" value="member-active" name="auto_add_classes[]" <?= $group->field('auto_add_new_active_member')->data() ?  'checked="1" ' : '' ?>>Aktives Mitglied</input>
                         </label>
                     </div>
                     <div class="checkbox">
                         <label>
                               <input type="checkbox" value="member-passive" name="auto_add_classes[]" <?= $group->field('auto_add_new_passive_member')->data() ?  'checked="1" ' : '' ?>>Passives Mitglied</input>
                         </label>
                     </div>
                    <button name="form_submit_edit_note" type="submit" class="btn btn-primary">speichern</button>
                </form>
            </div>
        </div>
    </div>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
