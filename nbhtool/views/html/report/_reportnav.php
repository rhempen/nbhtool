<ul class="nav nav-tabs">
    <?php $start_year = \RT::$config->get('nbhtool', 'report_start_year') ?>
    <?php $current_year = date('Y') ?>
    <?php foreach(range($start_year, $current_year) as $year): ?>
        <li <?php if($selected_report_year == $year): ?>class="active"<?php endif; ?>>
            <a href="<?= \Layout\Html\Tools::url('report/'.\RT::$request->action(), ['selected_report_year' => $year]) ?>"><?= $year ?></a>
        </li>
    <?php endforeach; ?>
</ul>
