<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'volunteer' && !\RT::$params->exists('state_filter')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/volunteer') ?>">Alle</a>
    </li>
    <li <?php if(\RT::$request->action() == 'volunteer' && \RT::$params->get('state_filter')->data() == 2): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/volunteer',['state_filter' => '2']) ?>">Aktiv</a>
    </li>
    <li <?php if(\RT::$request->action() == 'volunteer' && \RT::$params->get('state_filter')->data() == 1): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/volunteer',['state_filter' => 1]) ?>">Passiv</a>
    </li>
    <li <?php if(\RT::$request->action() == 'volunteer' && \RT::$params->get('state_filter')->data() == '0'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/volunteer',['state_filter' => 0]) ?>">Ausgelastet</a>
    </li>
    <li <?php if(\RT::$request->action() == 'volunteer' && \RT::$params->get('state_filter')->data() == 3): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/volunteer',['state_filter' => 3]) ?>">Ausgetreten</a>
    </li>
</ul>
