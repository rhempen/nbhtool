<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<p></p>
<?php if($person->volunteer()->is()): ?>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Notizen</h3>
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
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/volunteer', ['person_id' => $person->id() ]) ?>">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-textarea',
                    [
                        "title" => "",
                        "id" => "note",
                        "data" => $person->volunteer()->field('note')->data(),
                        "rows" => 6,
                    ]) ?>
                    <button name="form_submit_edit_note" type="submit" class="btn btn-primary">speichern</button>
                    <button name="form_cancel_edit_note" type="button" class="btn btn-default" onclick="$('#display-note').show(); $('#form-edit-note').hide(); return false;">abbrechen</button>
                </form>
            </div>
            <div id="display-note" style="max-height: 120px; overflow-y: auto;">
                <?= \Layout\Html\Tools::w_br_enc($person->volunteer()->field('note')->data()); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"> 
            <div class="panel panel-default">
                <div class="panel-heading nav navbar-default">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="panel-title">Zeitliche Verf&uuml;gbarkeit</h3>
                        </div>
                        <div class="col-md-4">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#" onclick="$('#display-availability').hide(); $('#form-edit-availability').show(); return false;">&Auml;ndern</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="form-edit-availability" class="start-invisible">
                        <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/volunteer/set_availability', ['person_id' => $person->id() ]) ?>">
                            <?php \Layout\Html\Tools::widget(
                            'form/input-textarea',
                            [
                                "title" => "",
                                "id" => "availability",
                                "data" =>
                                $person->volunteer()->field('availability')->data(), "rows" => 6,
                            ]) ?>
                            <button name="form_submit_edit_availability" type="submit" class="btn btn-primary">speichern</button>
                            <button name="form_cancel_edit_availability" type="button" class="btn btn-default" onclick="$('#display-availability').show(); $('#form-edit-availability').hide(); return false;">abbrechen</button>
                        </form>
                    </div>
                    <div id="display-availability">
                        <?php if($person->volunteer()->field('availability')->data()): ?>
                            <p><?= \Layout\Html\Tools::w_br_enc($person->volunteer()->field('availability')->data());
                            ?></p>
                        <?php else: ?>
                            <p>keine Angaben</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"> 
            <div class="panel panel-default">
                <div class="panel-heading nav navbar-default">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="panel-title">Beruf</h3>
                        </div>
                        <div class="col-md-8">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#" onclick="$('#display-profession').hide(); $('#form-edit-profession').show(); return false;">&Auml;ndern</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="form-edit-profession" class="start-invisible">
                        <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/volunteer/set_profession', ['person_id' => $person->id() ]) ?>">
                            <?php \Layout\Html\Tools::widget(
                            'form/input-text',
                            [
                                "title" => "",
                                "id" => "profession",
                                "data" => $person->volunteer()->field('profession'),
                            ]) ?>
                            <button name="form_submit_edit_profession" type="submit" class="btn btn-primary">speichern</button>
                            <button name="form_cancel_edit_profession" type="button" class="btn btn-default" onclick="$('#display-profession').show(); $('#form-edit-profession').hide(); return false;">abbrechen</button>
                        </form>
                    </div>
                    <div id="display-profession">
                        <?php if($person->volunteer()->field('profession')->data()): ?>
                            <p><?= \Layout\Html\Tools::enc($person->volunteer()->field('profession')->data()) ?></p>
                        <?php else: ?>
                            <p>keine Angaben</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"> 
            <div class="panel panel-default">
                <div class="panel-heading nav navbar-default">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="panel-title">Motorfahrzeug</h3>
                        </div>
                        <div class="col-md-4">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#"
                                onclick="$('#display-car').hide(); $('#form-edit-car').show(); return false;">&Auml;ndern</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="form-edit-car" class="start-invisible">
                        <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/volunteer/set_car', ['person_id' => $person->id() ]) ?>">
                            <?php \Layout\Html\Tools::widget(
                            'form/input-text',
                            [
                                "title" => "Fahrzeugmarke/-Model",
                                "id" => "car_model",
                                "data" => $person->volunteer()->field('car_model'),
                            ]) ?>
                            <?php \Layout\Html\Tools::widget(
                            'form/input-text',
                            [
                                "title" => "Kennzeichen",
                                "id" => "car_register_number",
                                "data" => $person->volunteer()->field('car_register_number'),
                            ]) ?>
                            <button name="form_submit_edit_car" type="submit" class="btn btn-primary">speichern</button>
                            <button name="form_cancel_edit_car" type="button" class="btn btn-default" onclick="$('#display-car').show(); $('#form-edit-car').hide(); return false;">abbrechen</button>
                        </form>
                    </div>
                    <div id="display-car">
                        <p>
                        <?php if($person->volunteer()->field('car_model')->data()): ?><?= \Layout\Html\Tools::enc($person->volunteer()->field('car_model')->data()); ?><?php endif; ?><?php if($person->volunteer()->field('car_register_number')->data()): ?><?php if($person->volunteer()->field('car_model')->data()): ?>, <?php endif; ?><?= \Layout\Html\Tools::enc($person->volunteer()->field('car_register_number')->data()); ?><?php endif; ?>
                        <?php if(!$person->volunteer()->field('car_register_number')->data() && !$person->volunteer()->field('car_model')->data()): ?>
                            keine Angaben
                        <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Dienstleistungsangebot</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" onclick="$('#display-service-catalogue').hide(); $('#form-service-catalogue').show(); return false;">&Auml;ndern</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="form-service-catalogue" class="start-invisible">
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/volunteer/set_services', ['person_id' => $person->id() ]) ?>">
                    <?php foreach($service_list as $service): ?>
                         <div class="checkbox">
                             <label>
                                   <input id="service_<?= $service->id(); ?>" onchange="if($('#service_<?= $service->id(); ?>').prop('checked')) {$('.service_<?= $service->id(); ?>').prop('checked', true); } else {$('.service_<?= $service->id(); ?>').prop('checked', false);}" type="checkbox" value="<?= $service->id(); ?>" name="selected_services[]"<?= array_key_exists($service->id(), $volunteer_service_list_flat) ? ' checked="1" ' : '' ?>><?= $service->field('text')->data() ?></input>
                             </label>
                         </div>
                        <?php foreach($service->sub_services() as $sub_service): ?>
                             <div class="checkbox">
                                 <label>
                                       &nbsp;&nbsp;&nbsp;<input id="service_<?= $service->id() ?>_<?= $sub_service->id() ?>" class="service_<?= $service->id();
                                       ?>" onchange="if($('#service_<?= $service->id() ?>_<?= $sub_service->id() ?>').prop('checked')) {$('#service_<?= $service->id(); ?>').prop('checked', true);}" type="checkbox" value="<?= $sub_service->id() ?>" name="selected_services[]"<?= array_key_exists($sub_service->id(), $volunteer_service_list_flat) ?  'checked="1" ' : '' ?>><?= $sub_service->field('text')->data() ?></input>
                                 </label>
                             </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <button name="form_submit_set_services" type="submit" class="btn btn-primary">speichern</button>
                    <button name="form_cancel_set_services" type="button"
                    class="btn btn-default" onclick="$('#display-service-catalogue').show(); $('#form-service-catalogue').hide(); return false;">abbrechen</button>
                </form>
            </div>
            <div id="display-service-catalogue">
                <?php if(count($volunteer_service_list) > 0): ?>
                <ul>
                <?php foreach($volunteer_service_list as $volunteer_service): ?>
                    <li>
                    <?= $volunteer_service['service']->field('text')->data() ?>
                        <?php if(array_key_exists('sub_services', $volunteer_service) && is_array($volunteer_service['sub_services'])): ?>
                        <ul>
                            <?php foreach($volunteer_service['sub_services'] as $volunteer_sub_service): ?>
                            <li>
                                <?= $volunteer_sub_service->field('text')->data() ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>Kein Dienstleistungsangebot spezifiziert</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Logbuch und Status</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="javascript:" onclick="$('#display-volunteer-log').hide(); $('#display-volunteer-log-add-form').show(); return false;">Neue Bemerkung oder Status &auml;ndern</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="display-volunteer-log-add-form" class="start-invisible">
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/volunteer/add_log', ['person_id' => $person->id() ]) ?>">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-select',
                    [
                        "title" => "Status",
                        "id" => "volunteer_status_id",
                        "data" =>
                        $person->volunteer()->current_state()->state()->id() ?
                            $person->volunteer()->current_state()->state()->field('id')->data()
                            : '',
                        "list" => $state_list
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-textarea',
                    [
                        "title" => "Bemerkung",
                        "id" => "volunteer_status_log",
                        "data" => '',
                        "rows" => 4,
                    ]) ?>
                    <button name="form_submit_add_volunteer_log" type="submit" class="btn btn-primary">speichern</button>
                    <button name="form_cancel_add_volunteer_log" type="button" class="btn btn-default" onclick="$('#form-add-log').hide(); return false;">abbrechen</button>
                    <p></p>
                </form>
            </div>
            <div class="display-volunteer-log">
                <table class="table">
                    <tbody>
                    <?php foreach($person->volunteer()->log() as $log): ?>

                        <td class="color-state-<?= $log->state()->id(); ?>"><?= $log->state()->field('text')->data(); ?></td>
                        <td><?= date("d.m.Y, H:i", $log->field('timestamp')->data()); ?></td>
                        <td><?= $log->person()->display_name(); ?></td>
                        <td style="width: 60%;"><?= \Layout\Html\Tools::w_br_enc($log->field('note')->data()); ?></td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Erfassen</h3>
        </div>
        <div class="panel-body">
            <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/volunteer',['person_id'=> $person->id()]) ?>">
                <p>
                <?= $person->gender()->field('text')->data() ?> <?= $person->display_name() ?> als 
                <?= $person->gender_text('Freiwillige', 'Freiwilligen', 'Freiwillige/r') ?> erfassen?
                </p>
                <button name="form_submit_volunteer_enable" type="submit" class="btn btn-primary">Erfassen</button>
                <a href="<?= \Layout\Html\Tools::url('person/details',['person_id'=> $person->id()]) ?>" class="btn btn-default" role="button">Abbrechen</a>
            </form>
        </div>
    </div>
<?php endif; ?>


<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
