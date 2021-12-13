<?php $page = \RT::$params->exists('page') && preg_match('/^[0-9]+$/', \RT::$params->get('page')->data()) ? \RT::$params->get('page')->data() : 1; ?>
<?php $page_size = 10; ?>
<?php include('_grouptitle.php') ?>
<?php include('_groupdetailsnav.php') ?>
<nav class="navbar navbar-default navbar-sub">
    <ul class="nav navbar-nav">
        <li>
            <a href="<?= \Layout\Html\Tools::url('lists/person/by_group', ['person_group_id' => $group->id() ]) ?>">
                Zeige Gruppenmitglieder in Detailtabelle
            </a>
        </li>
        <li>
            <a href="mailto:Undisclosed recipients?subject=<?=$group->field('text')->data()?>&bcc=<?php foreach($members_list as $member):?><?= ($member->field('email_address')->data() ?  $member->field('email_address')->data().";":'')?><?php endforeach;?>">
                E-Mail an alle Gruppenmitglieder senden
            </a>
        </li>
    </ul>
</nav>

        <?php $member_counter = 0 ?>
        <?php foreach($members_list as $member): ?>
            <?php $member_counter++ ?>
            <?php if($member_counter <= $page * $page_size - $page_size) {continue;} ?>
            <?php if($member_counter >= $page * $page_size) {break;} ?>
            <?php \Layout\Html\Tools::widget(
            'person-card',
            [
                "person" => $member,
                "menu" => [
                    'aus Gruppe entfernen' => [ 'url' =>
                    \Layout\Html\Tools::url('group/members/remove',
                    ['person_group_id' => $group->id(), 'person_id' => $member->id(), 'page' => $page]),
                        'icon' => 'remove',
                        'class' => []
                    ]
                ]
            ])
            ?>
        <?php endforeach; ?>

         <ul class="pagination">
         <?php for($ipage=1; $ipage <= ceil(count($members_list)/10); $ipage++): ?>
            <?php if(\RT::$params->get('service_filter')->data()): ?>
            <li <?= $page == $ipage ? ' class="active"' : '' ?>><a href="<?=
            \Layout\Html\Tools::url('group/members/browse', ['person_group_id' => $group->id(), 'service_filter' => $request->service()->id(), 'page' => $ipage]) ?>"><?= $ipage ?></a></li>
            <?php else: ?>
            <li <?= $page == $ipage ? ' class="active"' : '' ?>><a href="<?=
            \Layout\Html\Tools::url('group/members/browse', ['person_group_id' => $group->id(), 'page' => $ipage]) ?>"><?= $ipage ?></a></li>
            <?php endif; ?>
         <?php endfor; ?>
         </ul>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
