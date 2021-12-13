<h1><?= $person->field('deleted')->data() ? '<s>' : ''; ?>
<span class="db-id">Person#<?= $person->id() ?>:</span> <?= htmlentities($person->display_name()) ?>
<?php if($person->client()->is()): ?>
    <span class="badge badge-client"><?= $person->gender_text('Klientin', 'Klient', 'Klient/in') ?>&nbsp;(<?= $person->client()->has_active_requests() ?>)</span>
<?php endif; ?>
<?php if($person->volunteer()->is()): ?>
    <span class="badge badge-volunteer<?php if($person->volunteer()->current_state()->state()->id() == '1'): ?> badge-volunteer-passive<?php endif; if($person->volunteer()->current_state()->state()->id() == '0'): ?> badge-volunteer-busy<?php endif; ?>"><?= $person->gender_text('Freiwillige', 'Freiwilliger', 'Freiwillige/r') ?></span>
<?php endif; ?>
<?php if($person->agent()->is()): ?>
    <span class="badge badge-agent<?php if(!$person->agent()->active(\RT::$params->get('branch_id')->data())): ?> badge-agent-passive<?php endif; ?>"><?= $person->gender_text('Vermittlerin', 'Vermittler', 'Vermittler/in') ?></span>
<?php endif; ?>
<?= $person->field('deleted')->data() ? '</s>' : ''; ?></h1>
