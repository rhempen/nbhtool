<ul class="nav nav-tabs">
    <li <?php if(\RT::$request->action() == 'details' || \RT::$request->action() == 'add_alt_contact'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('request/details', ['request_id' => $request_id]) ?>">Details</a>
    </li>
    <li <?php if(\RT::$request->action() == 'volunteers'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('request/volunteers',['request_id' => $request_id]) ?>">Freiwillige</span></a>
    </li>
    <li <?php if(\RT::$request->action() == 'log'): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('request/log', ['request_id' => $request_id]) ?>">Logbuch und Status</span></a>
    </li>
</ul>
