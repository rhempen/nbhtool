<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'client' && !\RT::$params->exists('state_filter')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/client') ?>">Alle</a>
    </li>
    <li <?php if(\RT::$request->action() == 'client' && \RT::$params->get('state_filter')->data() == '1'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/client',['state_filter' => 1]) ?>">Aktiv</a>
    </li>
    <li <?php if(\RT::$request->action() == 'client' && \RT::$params->get('state_filter')->data() == '0'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/client',['state_filter' => 0]) ?>">Gelöscht</a>
    </li>
</ul>
