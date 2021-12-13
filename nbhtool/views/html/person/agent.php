<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<p></p>
<?php if($confirm): ?>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Erfassen dieser Person als <?= $person->gender_text('Vermittlerin', 'Vermittler', 'Vermittler/in') ?></h3>
            </div>
            <div class="panel-body">
                <p>Durch die Best&auml;tigung dieser Meldung wird die Person
                <strong><?= $person->display_name() ?></strong>
                als <?= $person->gender_text('Vermittlerin', 'Vermittler',
                'Vermittler/in') ?> f&uuml;r diese Vermittlungsstelle
                aktiviert. Nach erhalt des Passwortes kann <strong><?=
                $person->display_name() ?></strong> auf
                alle Daten zugreifen. Es ist empfehlenswert, <strong><?=
                $person->display_name() ?></strong>
                eine entsprechende Einweisung zu geben.</p>
                <a href="<?= \Layout\Html\Tools::url('person/agent/create',['person_id'=> $person->id()]) ?>" class="btn btn-primary">Ja, aktivieren</button>
                <a href="<?= \Layout\Html\Tools::url('person/details',['person_id'=> $person->id()]) ?>" class="btn btn-default" role="button">Abbrechen</a>
            </div>
        </div>
    
<?php else: ?>
        <div class="panel panel-default">
            <div class="panel-heading nav navbar-default">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="panel-title">Status</h3>
                    </div>
                    <div class="col-md-8">
                        <ul class="nav navbar-nav navbar-right">
                        <?php  if($person->agent()->active(\RT::$params->get('branch_id')->data())): ?> <li><a href="<?=
                            \Layout\Html\Tools::url('person/agent/disable', ['person_id' => $person->id() ]) ?>">Deaktivieren</a></li>
                        <?php else: ?> <li><a href="<?= \Layout\Html\Tools::url('person/agent/enable', ['person_id' => $person->id() ]) ?>">Aktivieren</a></li>
                        <?php endif; ?> 
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt>Status:</dt>
                    <dd>
                    <?php  if($person->agent()->active(\RT::$params->get('branch_id')->data())): ?>
                        aktiv
                    <?php else: ?>
                        deaktiviert
                    <?php endif; ?> 
                    </dd>
                    <dt>Erfasst:</dt>
                    <dd>
                        <?= date("d.m.Y, H:i", $person->agent()->created(\RT::$params->get('branch_id')->data())) ?>
                    </dd>
                    <dt>Letztes Login:</dt>
                    <dd>
                        <?= $person->account()->field('last_login_timestamp')->data() == 0 ? 'nie' : date("d.m.Y, H:i", $person->account()->field('last_login_timestamp')->data()) ?>
                    </dd>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Benutzername und Passwort</h3>
            </div>
            <div class="panel-body">
                <?php if($person->account()->is()): ?>
                    <dl class="dl-horizontal">
                    <dt>Benutzername:</dt>
                    <dd><?= $person->account()->field('username')->data() ?></dd>
                    <dt>Passwort:</dt>
                    <dd>
                    <?php if(isset($new_agent_password) && is_string($new_agent_password)): ?>
                        <strong><?= $new_agent_password ?></strong>&nbsp;(<a href="<?= \Layout\Html\Tools::url('person/agent', ['person_id' => $person->id() ]) ?>">ausblenden</a>)
                    <?php else: ?>
                       <a href="<?=
                       \Layout\Html\Tools::url('person/agent/gen_new_pw', ['person_id' => $person->id() ]) ?>">Neues Passwort generieren</a>
                    <?php endif; ?>
                    </dd>
                    </dl>
                <?php else: ?>
                    Keine Accountdaten vorhanden, bitte kontaktieren Sie den technischen Support
                <?php endif; ?>
            </div>
        </div>
<?php endif; ?>


<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
