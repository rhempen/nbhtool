<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'client'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/client') ?>">Alle</a>
    </li>
</ul>
