<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'details' || \RT::$request->action() == 'update'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('person/details', ['person_id' => $person->id() ]) ?>">Person</a>
    </li>
    <?php if($person->client()->is() or \RT::$request->action() == 'client'): ?>
        <li <?php if(\RT::$request->action() == 'client'): ?>class="active"<?php  endif; ?>>
            <a href="<?= \Layout\Html\Tools::url('person/client', ['person_id' => $person->id() ]) ?>"><?= $person->gender_text('Klientin', 'Klient', 'Klient/in') ?></a>
        </li>
    <?php endif; ?>
    <?php if($person->volunteer()->is() or \RT::$request->action() == 'volunteer'): ?>
        <li <?php if(\RT::$request->action() == 'volunteer'): ?>class="active"<?php  endif; ?>>
            <a href="<?= \Layout\Html\Tools::url('person/volunteer', ['person_id' => $person->id() ]) ?>"><?= $person->gender_text('Freiwillige', 'Freiwilliger', 'Freiwillige/r') ?></a>
        </li>
    <?php endif; ?>

    <?php if($person->volunteer()->is()): ?>
    <li <?php if(\RT::$request->action() == 'jobs'): ?>class="active"<?php  endif; ?>><a href="<?= \Layout\Html\Tools::url('person/jobs', ['person_id' => $person->id() ]) ?>">Eins&auml;tze</a></li>
    <?php endif; ?>

    <?php if($person->client()->is()): ?>
    <li <?php if(\RT::$request->action() == 'requests'): ?>class="active"<?php  endif; ?>><a href="<?= \Layout\Html\Tools::url('person/requests', ['person_id' => $person->id() ]) ?>">Anfragen</a></li>
    <?php endif; ?>

    <li <?php if(\RT::$request->action() == 'membership'): ?>class="active"<?php endif; ?>><a href="<?= \Layout\Html\Tools::url('person/membership', ['person_id' => $person->id() ]) ?>">Mitgliedschaft</a></li>
    <?php if($person->agent()->is() && $person->agent()->has_branch_all(\RT::$params->get('branch_id')->data()) or \RT::$request->action() == 'agent'): ?>
        <li <?php if(\RT::$request->action() == 'agent'): ?>class="active"<?php  endif; ?>>
            <a href="<?= \Layout\Html\Tools::url('person/agent', ['person_id' => $person->id() ]) ?>"><?= $person->gender_text('Vermittlerin', 'Vermittler', 'Vermittler/in') ?></a>
        </li>
    <?php endif; ?>
    <li <?php if(\RT::$request->action() == 'groups'): ?>class="active"<?php  endif; ?>><a href="<?= \Layout\Html\Tools::url('person/groups', ['person_id' => $person->id() ]) ?>">Gruppen</a></li>
</ul>
