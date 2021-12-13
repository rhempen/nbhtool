<ul class="nav nav-tabs">
    <li <?php if(\RT::$params->exists('today')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('journal/index/today', ['filter_start_date' => date('d.m.Y', time())]) ?>">heute</a>
    </li>
    <li <?php if(\RT::$params->exists('yesterday')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('journal/index/yesterday', ['filter_start_date' => date('d.m.Y', strtotime('-1 days'))]) ?>">gestern</a>
    </li>
    <li <?php if(\RT::$params->exists('past2')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('journal/index/past2', ['filter_start_date' => date('d.m.Y', strtotime('-2 days'))]) ?>"><?= date('d.m.Y', strtotime('-2 days')) ?></a>
    </li>
    <li <?php if(\RT::$params->exists('past3')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('journal/index/past3', ['filter_start_date' => date('d.m.Y', strtotime('-3 days'))]) ?>"><?= date('d.m.Y', strtotime('-3 days')) ?></a>
    </li>
    <li <?php if(\RT::$params->exists('past4')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('journal/index/past4', ['filter_start_date' => date('d.m.Y', strtotime('-4 days'))]) ?>"><?= date('d.m.Y', strtotime('-4 days')) ?></a>
    </li>
    <li <?php if(\RT::$params->exists('past5')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('journal/index/past5', ['filter_start_date' => date('d.m.Y', strtotime('-5 days'))]) ?>"><?= date('d.m.Y', strtotime('-5 days')) ?></a>
    </li>
    <li <?php if(\RT::$params->exists('past6')): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('journal/index/past6', ['filter_start_date' => date('d.m.Y', strtotime('-6 days'))]) ?>"><?= date('d.m.Y', strtotime('-6 days')) ?></a>
    </li>
    <li <?php if(\RT::$request->action() == "add"): ?>class="active"<?php endif; ?>>
        <a href="<?= \Layout\Html\Tools::url('journal/add')
        ?>">Eintrag erfassen</a>
    </li>
</ul>
