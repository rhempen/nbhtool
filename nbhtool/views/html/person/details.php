<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<nav class="navbar navbar-default navbar-sub">
    <ul class="nav navbar-nav">
        <li>
            <a href="<?= \Layout\Html\Tools::url('person/update',['person_id'=> $person->id()]) ?>">
                Personendaten bearbeiten
            </a>
        </li>
        <?php if(!$person->client()->is()): ?>
        <li>
            <a href="<?= \Layout\Html\Tools::url('person/client',['person_id'=> $person->id()]) ?>">
                Als <?= $person->gender_text('Klientin', 'Klient', 'Klient/in') ?> erfassen
            </a>
        </li>
        <?php endif; ?>
        <?php if(!$person->volunteer()->is()): ?>
        <li>
            <a href="<?= \Layout\Html\Tools::url('person/volunteer',['person_id'=> $person->id()]) ?>">
                als <?= $person->gender_text('Freiwillige', 'Freiwilliger', 'Freiwillige/r') ?> erfassen
            </a>
        </li>
        <?php endif; ?>
        <?php if(!$person->agent()->is() && !$person->agent()->has_branch_all(\RT::$params->get('branch_id')->data())): ?>
        <li>
            <a href="<?= \Layout\Html\Tools::url('person/agent/confirm',['person_id'=> $person->id()]) ?>">
                als <?= $person->gender_text('Vermittlerin', 'Vermittler', 'Vermittler/in') ?> erfassen
            </a>
        </li>
        <?php endif; ?>
        <li>
            <a href="<?= \Layout\Html\Tools::url('person/delete/confirm',['person_id'=> $person->id()]) ?>">
                diese Person l&ouml;schen
            </a>
        </li>
    </ul>
</nav>
<div class="row">
    <div class="col-md-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Name</h3>
            </div>
            <div class="panel-body">
                <dl class="dl-horizontal"> 
                    <dt>Anrede</dt>
                    <dd><?= \Layout\Html\Tools::enc($person->gender()->field('text')->data()) ?></dd>
                    <dt>Titel</dt>
                    <dd><?= \Layout\Html\Tools::enc($person->title()->field('text')->data()) ?></dd>
                    <dt>Vorname</dt>
                    <dd><?= \Layout\Html\Tools::enc($person->field('firstname')->data()) ?></dd>
                    <dt>Nachname</dt>
                    <dd><?= \Layout\Html\Tools::enc($person->field('lastname')->data()) ?></dd>
                    <dt>Organisation/Firma</dt>
                    <dd><?= \Layout\Html\Tools::enc($person->field('organization')->data()) ?></dd>
                </dl>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Adresse</h3>
            </div>
            <div class="panel-body">
                <dl class="dl-horizontal"> 
                    <dt>Strasse</dt>
                    <dd><?= $person->field('address_line1')->data() ?></dd>
                    <dt>Adresszusatz</dt>
                    <dd><?= $person->field('address_line2')->data() ?></dd>
                    <dt>Postfach</dt>
                    <dd><?= $person->field('postbox')->data() ?></dd>
                    <dt>Postleitzahl</dt>
                    <dd><?= $person->field('zip_code')->data() ?></dd>
                    <dt>Ort</dt>
                    <dd><?= $person->field('city')->data() ?></dd>
                    <dt>Land</dt>
                    <dd><?= $person->field('country')->data() ?></dd>
                </dl>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Sonstige Personalien</h3>
            </div>
            <div class="panel-body">
                <dl class="dl-horizontal"> 
                    <dt>Geburtstag</dt>
                    <dd><?= $person->field('date_of_birth')->data() ? date("d.m.Y", $person->field('date_of_birth')->data()) : ''?></dd>
                    <dt>Nationalit&aumlt</dt>
                    <dd><?= $person->nationality()->field('text')->data() ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Email und Telefon</h3>
            </div>
            <div class="panel-body">
                <dl class="dl-horizontal"> 
                    <dt>Email</dt>
                    <dd>
                        <?php if($person->field('email_address')->data()): ?><?= $person->field('email_address')->data() ?>&nbsp; <a href="mailto:<?= $person->field('email_address')->data() ?>"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                        <?php endif; ?>
                    </dd>
                    <dt>Private Rufnummer</dt>
                    <dd>
                        <?php if($person->field('phone_home')->data()): ?><?= $person->field('phone_home')->data() ?>&nbsp;<a href="tel:<?= $person->field('phone_home')->data() ?>"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a>
                        <?php endif; ?>
                    </dd>
                    <dt>Mobile Rufnummer</dt>
                    <dd>
                        <?php if($person->field('phone_mobile')->data()): ?><?=
                        $person->field('phone_mobile')->data() ?>&nbsp;<a href="tel:<?= $person->field('phone_mobile')->data() ?>"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a>
                        <?php endif; ?>
                    </dd>
                    <dt>Gesch&auml;tliche Rufnummer</dt>
                    <dd>
                        <?php if($person->field('phone_work')->data()): ?><?=
                        $person->field('phone_work')->data() ?>&nbsp;<a href="tel:<?= $person->field('phone_work')->data() ?>"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading nav navbar-default">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="panel-title">Sprachen</h3>
                    </div>
                    <div class="col-md-8">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a id="display-lang-form" href="#" class="" onclick="$('#display-lang-form').hide(); $('#lang-form').show(); return false;">hinzuf&uuml;gen</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <ul> 
                    <?php foreach($person->languages()->get() as $language): ?>
                    <li>
                        <?= \Layout\Html\Tools::enc($language->field('text')->data()) ?>
                        <a href="<?=\Layout\Html\Tools::url('person/details/remove_language',['person_id'=> $person->id(), 'language_id' => $language->id()])?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </li>
                    <?php endforeach;?>
                </ul>
                <form id="lang-form" class="start-invisible form-inline"
                enctype="multipart/form-data" method="post" action="<?=
                \Layout\Html\Tools::url('person/details/add_language', ['person_id' => $person->id()]) ?>">
                <?php \Layout\Html\Tools::widget(
                'form/input-select',
                [
                    "data" => '',
                    "list" => $languages_list,
                    "id" => 'language_id',
                    "no_help_block" => 1
                ]) ?>
                <button name="form_submit_person" type="submit" class="btn btn-default">hinzuf&uuml;gen</button>
                </form>
            </div>
        </div>
    </div>
</div>

