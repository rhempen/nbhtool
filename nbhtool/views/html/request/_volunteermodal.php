    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php include('_persontitle.php') ?>
    </div>
    <div class="modal-body">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Notizen</h3>
        </div>
        <div class="panel-body">
            <div id="display-note" style="max-height: 120px; overflow-y: auto;">
                <?= \Layout\Html\Tools::w_br_enc($person->volunteer()->field('note')->data()); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Zeitliche Verf&uuml;gbarkeit</h3>
                </div>
                <div class="panel-body">
                    <div id="display-note" style="max-height: 120px; overflow-y: auto;">
                        <?= \Layout\Html\Tools::w_br_enc($person->volunteer()->field('availability')->data()); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Beruf</h3>
                </div>
                <div class="panel-body">
                    <div id="display-note" style="max-height: 120px; overflow-y: auto;">
                        <?= \Layout\Html\Tools::w_br_enc($person->volunteer()->field('profession')->data()); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Dienstleistungsangebot</h3>
        </div>
        <div class="panel-body">
            <div id="display-service-catalogue">
                <?php if(count($person->volunteer()->services_struct()) > 0): ?>
                <ul>
                <?php foreach($person->volunteer()->services_struct() as $volunteer_service): ?>
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
             <h3 class="panel-title">Logbuch und Status</h3>
        </div>
        <div class="panel-body">
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
</div>
