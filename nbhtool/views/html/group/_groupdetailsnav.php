<ul class="nav nav-tabs">
    <li<?= \RT::$request->action() == "details" || \RT::$request->action() == "delete" ? ' class="active"' : '' ?>>
        <a href="<?= \Layout\Html\Tools::url('group/details', ['person_group_id' => $group->id()]) ?>">Details</a>
    </li>
    <li<?= \RT::$request->action() == "members" && \RT::$params->exists('browse') ? ' class="active"' : '' ?>>
        <a href="<?= \Layout\Html\Tools::url('group/members/browse',
        ['person_group_id' => $group->id()]) ?>">Gruppenmitglieder <span class="badge badge-in-nav"><?= count($group->persons()) ?></span></a>
    </li>
    <li<?= \RT::$request->action() == "members"  && !\RT::$params->exists('browse') ? ' class="active"' : '' ?>>
        <a href="<?= \Layout\Html\Tools::url('group/members',
        ['person_group_id' => $group->id()]) ?>">Gruppenmitglieder hinzuf&uuml;gen/entfernen</a>
    </li>
    <li<?= \RT::$request->action() == "options" ? ' class="active"' : '' ?>>
        <a href="<?= \Layout\Html\Tools::url('group/options', ['person_group_id' => $group->id()]) ?>">Erweiterte Optionen</a>
    </li>
</ul>
