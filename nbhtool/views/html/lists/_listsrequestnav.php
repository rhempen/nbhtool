<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'request' && !\RT::$params->exists('state_filter')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/request') ?>">Alle</a>
    </li>
    <li <?php if(\RT::$request->action() == 'request' && \RT::$params->get('state_filter')->data() == '0'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => '0']) ?>">offen</a>
    </li>
    <li <?php if(\RT::$request->action() == 'request' && \RT::$params->get('state_filter')->data() == 1): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => 1]) ?>">provisorisch</a>
    </li>
    <li <?php if(\RT::$request->action() == 'request' && \RT::$params->get('state_filter')->data() == 2): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => 2]) ?>">etabliert</a>
    </li>
    <li <?php if(\RT::$request->action() == 'request' && \RT::$params->get('state_filter')->data() == 3): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => 3]) ?>">beendet</a>
    </li>
    <li <?php if(\RT::$request->action() == 'request' && \RT::$params->get('state_filter')->data() == 4): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => 4]) ?>">beendet (weitergeleitet)</a>
    </li>
</ul>
