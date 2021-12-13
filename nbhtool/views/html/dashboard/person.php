<h1>&Uuml;bersicht <?=
\RT::$auth->info()->person()->agent()->selected_branch()->field('name')->data ?></h1>
<?php include('_dashboardnav.php') ?>
<p></p>
<?php \Layout\Html\Tools::widget(
'person-search',
[
    "async_url" => \Layout\Html\Tools::url('async/personsearch', [])
]) ?>

