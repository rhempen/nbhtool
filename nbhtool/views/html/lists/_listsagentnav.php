<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'agent'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/agent') ?>">Alle</a>
    </li>
</ul>
