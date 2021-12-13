<ul class="nav nav-tabs">
    <li<?= \RT::$request->action() == "index" ? ' class="active"' : '' ?>>
        <a href="<?= \Layout\Html\Tools::url('group/index') ?>">Alle</a>
    </li>
    <li<?= \RT::$request->action() == "create" ? ' class="active"' : '' ?>>
        <a href="<?= \Layout\Html\Tools::url('group/create') ?>">Neue Gruppe erfassen</a>
    </li>
</ul>
