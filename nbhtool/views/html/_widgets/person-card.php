<div class="list-group-item person-card">
    <div class="row person-card-first-row">
        <div class="col-md-1">
            <img src="<?= \Layout\Html\Tools::web("/img/person-p.png") ?>" alt="Person">
        </div>
        <div class="col-md-6">
            <h4 class="list-group-item-heading">
                <?php if(isset($url) && is_string($url)): ?>
                <a href="<?= $url ?>">
                    <?= $person->display_name() ?>
                </a>
                <?php else: ?>
                <a href="<?= \Layout\Html\Tools::url('person/details', ['person_id' => $person->field('id')->data()]); ?>">
                    <?= $person->display_name() ?>
                </a>
                <?php endif; ?>
                <?php if($person->client()->is()): ?>
                    <span class="badge badge-client">
                    <a href="<?= \Layout\Html\Tools::url('person/client', ['person_id' => $person->field('id')->data()]); ?>">
                    <?= $person->gender_text('Klientin', 'Klient', 'Klient/in') ?>&nbsp;
                    (<?= $person->client()->has_active_requests() ?>)
                    </a>
                    </span>
                <?php endif; ?>
                <?php if($person->volunteer()->is()): ?>
                    <span class="badge badge-volunteer<?php if($person->volunteer()->current_state()->state()->id() == '1'): ?> badge-volunteer-passive<?php endif; if($person->volunteer()->current_state()->state()->id() == '0'): ?> badge-volunteer-busy<?php endif; ?>">
                    <a href="<?= \Layout\Html\Tools::url('person/volunteer', ['person_id' => $person->field('id')->data()]); ?>">
                    <?= $person->gender_text('Freiwillige', 'Freiwilliger', 'Freiwillige/r') ?>
                    </a>
                    </span>
                <?php endif; ?>
                <?php if($person->agent()->is()): ?>
                    <span class="badge badge-agent<?php if(!$person->agent()->active(\RT::$params->get('branch_id')->data())): ?> badge-agent-passive<?php endif; ?>"><?= $person->gender_text('Vermittlerin', 'Vermittler', 'Vermittler/in') ?></span>
                <?php endif; ?>
            </h4>
            <p class="list-group-item-text"><?= $person->display_address_single_line() ?></p>
        </div>
        <div class="col-md-5">
            <dl class="dl-horizontal"> 
                <?php if($person->field('email_address')->data()): ?>
                <dt>Email</dt>
                <dd>
                    <?php if($person->field('email_address')->data()): ?><?= $person->field('email_address')->data() ?>&nbsp; <a href="mailto:<?= $person->field('email_address')->data() ?>"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                    <?php endif; ?>
                </dd>
                <?php endif; ?>
                <?php if($person->field('phone_home')->data()): ?>
                <dt>Privat</dt>
                <dd>
                    <?php if($person->field('phone_home')->data()): ?><?= $person->field('phone_home')->data() ?>&nbsp;<a href="tel:<?= $person->field('phone_home')->data() ?>"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a>
                    <?php endif; ?>
                </dd>
                <?php endif; ?>
                <?php if($person->field('phone_mobile')->data()): ?>
                <dt>Mobil</dt>
                <dd>
                    <?php if($person->field('phone_mobile')->data()): ?><?=
                    $person->field('phone_mobile')->data() ?>&nbsp;<a href="tel:<?= $person->field('phone_mobile')->data() ?>"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a>
                    <?php endif; ?>
                </dd>
                <?php endif; ?>
                <?php if($person->field('phone_mobile')->data()): ?>
                <dt>Gesch&auml;ftlich</dt>
                <dd>
                    <?php if($person->field('phone_work')->data()): ?><?=
                    $person->field('phone_work')->data() ?>&nbsp;<a href="tel:<?= $person->field('phone_work')->data() ?>"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a>
                    <?php endif; ?>
                </dd>
                <?php endif; ?>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-11">
            <?php if(isset($menu) && is_array($menu)): ?>
            &nbsp;
                <?php foreach($menu as $menu_title => $menu_entry): ?>
                    <?php if(is_array($menu_entry['class']) && count($menu_entry['class']) == 0): ?>
                        <a href="<?= $menu_entry['url']?>"<?= array_key_exists('data-toggle', $menu_entry) ? ' data-toggle="'.$menu_entry['data-toggle'].'"' : '' ?><?= array_key_exists('data-target', $menu_entry) ?  ' data-target="'.$menu_entry['data-target'].'"': '' ?>>
                            <span title="<?= $menu_title ?>" class="glyphicon glyphicon-<?= $menu_entry['icon']?>" aria-hidden="true"></span>
                            <?= $menu_title ?>
                        </a>&nbsp;
                    <?php elseif(is_array($menu_entry['class']) && count($menu_entry['class']) > 0 && $person->client()->is() && in_array('client', $menu_entry['class'])): ?>
                        <a href="<?= $menu_entry['url']?>"<?= array_key_exists('data-toggle', $menu_entry) ? ' data-toggle="'.$menu_entry['data-toggle'].'"' : '' ?><?= array_key_exists('data-target', $menu_entry) ?  ' data-target="'.$menu_entry['data-target'].'"': '' ?>>
                            <span title="<?= $menu_title ?>" class="glyphicon glyphicon-<?= $menu_entry['icon']?>" aria-hidden="true"></span>
                            <?= $menu_title ?>
                        </a>&nbsp;

                    <?php elseif(is_array($menu_entry['class']) && count($menu_entry['class']) > 0 && $person->volunteer()->is() && in_array('volunteer', $menu_entry['class'])): ?>
                        <a href="<?= $menu_entry['url']?>"<?= array_key_exists('data-toggle', $menu_entry) ? ' data-toggle="'.$menu_entry['data-toggle'].'"' : '' ?><?= array_key_exists('data-target', $menu_entry) ?  ' data-target="'.$menu_entry['data-target'].'"': '' ?>>
                            <span title="<?= $menu_title ?>" class="glyphicon glyphicon-<?= $menu_entry['icon']?>" aria-hidden="true"></span>
                            <?= $menu_title ?>
                        </a>&nbsp;

                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
