<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'person'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('lists/person') ?>">Alle</a>
    </li>
</ul>
