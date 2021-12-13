<?php include('_requesttitle.php') ?>
<?php include('_requestnav.php') ?>
<?php setlocale(LC_ALL, 'de_DE') ?>
    <nav class="navbar navbar-default navbar-sub">
        <ul class="nav navbar-nav">
            <li><a href="<?=
            \Layout\Html\Tools::url('request/browse_volunteers',
            ['request_id' => $request_id ]) ?>">Freiwillige/r aus Liste zuweisen</a></li>
            <li><a href="<?=
            \Layout\Html\Tools::url('request/add_volunteer', ['request_id'
            => $request_id ]) ?>">Freiwillige/r suchen und zuweisen</a></li>
            <li><a href="<?= \Layout\Html\Tools::url('request/volunteers',
            ['request_id' => $request_id, 'show_all_volunteers' => 1 ]) ?>">zeige auch beendete Verbindung</a></li>
        </ul>
    </nav>
    <?php \Layout\Html\Tools::widget(
    'form/input-hidden',
    [
        "id" => "request_id",
        "data" => $request_id,
    ]) ?>
    <?php $volunteer_nr = 1 ?>
    <?php  foreach($request->volunteers(\RT::$params->exists('show_all_volunteers')) as $volunteer_connection): ?>
    <?php $volunteer_nr++ ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php if($volunteer_connection->is_active()): ?>
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">aktive seit <?= date("d.m.Y, H:i", $volunteer_connection->field('start')->data()) ?></h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?=
                        \Layout\Html\Tools::url('request/volunteers/stop_volunteer', [
                        'request_id' => $request_id, 'volunteer_connection_id'=> $volunteer_connection->id()]) ?>" class="">Vebindung beenden</a></li>
                    </ul>
                </div>
            </div>
            <?php else: ?>
                    <h3 class="panel-title">beendet, <?= date("d.m.Y, H:i", $volunteer_connection->field('start')->data()) ?> bis <?= date("d.m.Y, H:i", $volunteer_connection->field('end')->data()) ?></h3>
            <?php endif; ?>
        </div>
        <div class="panel-body">
            <?php \Layout\Html\Tools::widget(
            'person-card',
            [
                "person" => $volunteer_connection->volunteer()->person(),
            ]) 
            ?>
            <br>
            <ul class="nav nav-tabs">
                <li id="tab-volunteer-note-<?= $volunteer_nr ?>" class="<?= \RT::$params->exists('time') ? '' : 'active' ?>">
                    <a href="javascript:" onclick="$('#volunteer-note-<?=
                    $volunteer_nr ?>').show(); $('#volunteer-time-<?=
                    $volunteer_nr ?>').hide(); $('#tab-volunteer-note-<?=
                    $volunteer_nr ?>, #tab-volunteer-time-<?= $volunteer_nr
                    ?>').toggleClass('active'); return false;">Notiz</a>
                </li>
                <li id="tab-volunteer-time-<?= $volunteer_nr ?>" class="<?= \RT::$params->exists('time') ? 'active' : '' ?>">
                    <a href="javascript:" onclick="$('#volunteer-time-<?=
                    $volunteer_nr ?>').show(); $('#volunteer-note-<?=
                    $volunteer_nr ?>').hide(); $('#tab-volunteer-note-<?=
                    $volunteer_nr ?>, #tab-volunteer-time-<?= $volunteer_nr
                    ?>').toggleClass('active'); return false;">Zeit/Km erfassen</span></a>
                </li>
            </ul>
            <div id="volunteer-note-<?= $volunteer_nr ?>" class="person-card<?= \RT::$params->exists('time') ? ' start-invisible' : '' ?>">
                <nav class="navbar navbar-default navbar-sub">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="javascript:" class="" onclick="$('#display-volunteer-note-<?= $volunteer_nr ?>').hide(); $('#form-edit-volunteer-note-<?= $volunteer_nr ?>').show(); return false;">
                            <?php if($volunteer_connection->field('note')->data()):?>
                                Notiz zu dieser Verbindung bearbeiten
                            <?php else: ?>
                                Notiz zu dieser Verbindung hinzuf&uuml;gen
                            <?php endif; ?>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div id="form-edit-volunteer-note-<?= $volunteer_nr ?>" class="start-invisible"> 
                    <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('request/volunteers', ['request_id' => $request_id]) ?>">
                        <?php \Layout\Html\Tools::widget(
                        'form/input-textarea',
                        [
                            "title" => "",
                            "id" => "note",
                            "data" => $volunteer_connection->field('note')->data(),
                            "rows" => 6,
                        ]) ?>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-hidden',
                        [
                        "id" => "volunteer_connection_id",
                        "data" => $volunteer_connection->id()
                        ]) ?>
                        <button name="form_update_volunteer_note" type="submit" class="btn btn-primary">speichern</button>
                        <button name="form_cancel_edit_volunteer_note" type="button" class="btn btn-default" onclick="$('#display-volunteer-note-<?= $volunteer_nr ?>').show(); $('#form-edit-volunteer-note-<?= $volunteer_nr ?>').hide(); return false;">abbrechen</button>
                        </form>
                </div>
                <div id="display-volunteer-note-<?= $volunteer_nr ?>" class="list-group-item">
                    <p><?= \Layout\Html\Tools::w_br_enc($volunteer_connection->field('note')->data()); ?></p>
                </div>
            </div>
            <div id="volunteer-time-<?= $volunteer_nr ?>" class="<?= \RT::$params->exists('time') ? '' : 'start-invisible' ?>">
                <table class="table">
                    <thead>
                        <th>Monat</th>
                        <th></th>
                        <th>Anzahl Stunden</th>
                        <th>Anzahl Eins&auml;tze</th>
                        <th>Kilometer</th>
                        <th>Notiz</th>
                    </thead>
                    <tbody>
                    <form enctype="multipart/form-data" method="post"
                    action="<?= \Layout\Html\Tools::url('request/volunteers/time/add_time', ['request_id' => $request_id]) ?>">
                    <tr>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-hidden',
                        [
                        "id" => "volunteer_id",
                        "data" => $volunteer_connection->volunteer()->id()
                        ]) ?>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-hidden',
                        [
                        "id" => "service_request_id",
                        "data" => $request_id
                        ]) ?>

                        <td>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-select',
                        [
                        "id" => "month",
                        "data" => date('n'),
                        "no_help_block" => 1,
                        "list" => [
                            [
                                'id' => 1,
                                'text' => 'Januar',
                            ],
                            [
                                'id' => 2,
                                'text' => 'Februar',
                            ],
                            [
                                'id' => 3,
                                'text' => 'M&auml;rz',
                            ],
                            [
                                'id' => 4,
                                'text' => 'April',
                            ],
                            [
                                'id' => 5,
                                'text' => 'Mai',
                            ],
                            [
                                'id' => 6,
                                'text' => 'Juni',
                            ],
                            [
                                'id' => 7,
                                'text' => 'Juli',
                            ],
                            [
                                'id' => 8,
                                'text' => 'August',
                            ],
                            [
                                'id' => 9,
                                'text' => 'September',
                            ],
                            [
                                'id' => 10,
                                'text' => 'Oktober',
                            ],
                            [
                                'id' => 11,
                                'text' => 'November',
                            ],
                            [
                                'id' => 12,
                                'text' => 'Dezember'
                            ]
                        ]
                        ]) 
                        ?>
                        </td>
                        <td>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-select',
                        [
                        "id" => "year",
                        "data" => date('Y'),
                        "no_help_block" => 1,
                        "list" => [
                            [
                                'id' => date('Y'),
                                'text' => date('Y'),
                            ],
                            [
                                'id' => date('Y')-1,
                                'text' => date('Y')-1,
                            ]
                        ]
                        ])
                        ?>
                        </td>
                        <td>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-text',
                        [
                        "id" => "hours",
                        "data" => "",
                        "no_help_block" => 1
                        ]) 
                        ?>
                        </td>
                        <td>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-text',
                        [
                        "id" => "visit_count",
                        "data" => "",
                        "no_help_block" => 1
                        ]) 
                        ?>
                        </td>
                        <td>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-text',
                        [
                        "id" => "private_car_km",
                        "data" => "",
                        "no_help_block" => 1
                        ]) 
                        ?>
                        </td>
                        <td>
                        <?php \Layout\Html\Tools::widget(
                        'form/input-text',
                        [
                        "id" => "note",
                        "data" => "",
                        "no_help_block" => 1
                        ]) ?>
                        </td>
                        <td>
                            <div class="form-group">
                            <button name="input_volunteer_time" type="submit" class="btn btn-primary">eintragen</button>
                            </div>
                        </td>
                    </tr>
                    </form>
                <?php foreach($volunteer_connection->volunteer()->work_journal($request_id) as $journal_entry): ?>
                <tr>
                    <td><?= date("F", $journal_entry->field('start')->data()).", ".date("Y", $journal_entry->field('start')->data()) ?></td>
                    <td></td>
                    <td><?= round($journal_entry->duration()/60/60, 2) ?></td>
                    <td><?= $journal_entry->field('visit_count')->data() ?></td>
                    <td><?= $journal_entry->field('private_car_km')->data() ?></td>
                    <td><?= $journal_entry->field('note')->data() ?></td>
                    <td>
                        <a
                        href="<?=\Layout\Html\Tools::url('request/volunteers/time/remove_time',['request_id'=> $request_id, 'volunteer_journal_id' => $journal_entry->id()])?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
