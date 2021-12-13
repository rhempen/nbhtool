<?php include('_grouptitle.php') ?>
<?php include('_groupdetailsnav.php') ?>
<p></p>
<div class="panel panel-default">
    <div class="panel-heading nav navbar-default">
        <h3 class="panel-title">Mitglieder nach ID hinzuf&uuml;gen/entfernen</h3>
    </div>
    <div class="panel-body">
        <p>F&uuml;gen Sie hier bitte die Personen IDs ein in der Form
        #143233 oder 143233, die Sie der Gruppe hinzuf&uuml;gen
        m&ouml;chten. Die IDs bitte mit mindestens einer Zeilenschaltung oder einem Leerzeichen trennen. Sie
        k&ouml;nnen z.B. die Personen-ID-Spalte einer gefilterten Personenliste
        im Excel direkt in dieses Feld kopieren.</p>
        <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('group/members/mass_mod_by_id', ['person_group_id' => $group->id() ]) ?>">
            <?php \Layout\Html\Tools::widget(
            'form/input-textarea',
            [
                "title" => "",
                "id" => "person_ids",
                "data" => '',
                "rows" => 6,
            ]) ?>
            <button name="members_add" type="submit" class="btn btn-primary">hinzuf&uuml;gen</button>
            <button name="members_remove" type="submit" class="btn btn-warning">entfernen</button>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading nav navbar-default">
        <h3 class="panel-title">Mitglieder nach Personenklassen hinzuf&uuml;gen/entfernen</h3>
    </div>
    <div class="panel-body">
        <div id="form-mod-member-classes">
            <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('group/members/mass_mod_by_class', ['person_group_id' => $group->id() ]) ?>">
                <div class="checkbox"><label>
                <input type="checkbox" value="volunteer" name="selected_person_classes[]">alle Freiwillige</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="volunteer-active" name="selected_person_classes[]">alle aktiven Freiwillige</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="volunteer-passive" name="selected_person_classes[]">alle passiven Freiwillige</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="volunteer-busy" name="selected_person_classes[]">alle ausgelasteten Freiwillige</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="volunteer-terminated" name="selected_person_classes[]">alle ausgetretenen Freiwillige</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="client" name="selected_person_classes[]">alle Klienten</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="members-active" name="selected_person_classes[]">alle aktiven Mitglieder</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="members-passive" name="selected_person_classes[]">alle passiven Mitglieder</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="members-non" name="selected_person_classes[]">alle Nichtmitglieder</input>
                </label></div>
                <div class="checkbox"><label>
                <input type="checkbox" value="persons" name="selected_person_classes[]">alle Personen</input>
                </label></div>
            <button name="members_add" type="submit" class="btn btn-primary">hinzuf&uuml;gen</button>
            <button name="members_remove" type="submit" class="btn btn-warning">entfernen</button>
            </form>
        </div>
    </div>
</div>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
