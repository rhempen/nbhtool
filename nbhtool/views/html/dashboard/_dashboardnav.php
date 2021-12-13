<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'person'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('dashboard/person') ?>">Personen suchen</a>
    </li>
    <li <?php if(\RT::$request->action() == 'request' && \RT::$params->exists('open')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('dashboard/request/open') ?>">offene Anfragen <span class="badge badge-in-nav"><?= count($open_request_list) ?></span></a>
    </li>
    <li <?php if(\RT::$request->action() == 'request' && \RT::$params->exists('provisional')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('dashboard/request/provisional') ?>">provisorische Anfragen <span class="badge badge-in-nav"><?= count($provisional_request_list) ?></span></a>
    </li>
</ul>
