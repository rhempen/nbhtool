<?php $page = \RT::$params->exists('page') && preg_match('/^[0-9]+$/', \RT::$params->get('page')->data()) ? \RT::$params->get('page')->data() : 1; ?>
<?php $page_size = 10; ?>
<?php include('_requesttitle.php') ?>
<?php include('_requestnav.php') ?>
    <nav class="navbar navbar-default navbar-sub">
        <ul class="nav navbar-nav">
            <li><p class="navbar-text">Filtern nach &Uuml;bereinstimmung:</p></li>
            <li><a href="<?= \Layout\Html\Tools::url('request/browse_volunteers/service_filter', ['request_id' => $request_id]) ?>">Hauptkategeorie</a></li>
            <li><a href="<?=
            \Layout\Html\Tools::url('request/browse_volunteers/sub_service_or_filter',
            ['request_id' => $request_id]) ?>">mindestens eine
            T&auml;tigkeit</a></li>
            <li><a href="<?=
            \Layout\Html\Tools::url('request/browse_volunteers/sub_service_and_filter',
            ['request_id' => $request_id]) ?>">alle T&auml;tigkeiten</a></li>
            <li><a href="<?= \Layout\Html\Tools::url('request/browse_volunteers',
            ['request_id' => $request_id]) ?>">kein Filter</a></li>
        </ul>
    </nav>

    <div class="panel panel-default">
        <div class="panel-heading">
                <h3 class="panel-title"><?= count($person_list) ?> Freiwillige durchsuchen
                <?php if(\RT::$params->exists('service_filter')): ?>
                    - Hauptkategeorie &uuml;bereinstimmend
                <?php elseif(\RT::$params->exists('sub_service_or_filter')): ?>
                    - mindestens eine T&auml;tigkeit &uuml;bereinstimmend
                <?php elseif(\RT::$params->exists('sub_service_and_filter')): ?>
                    - alle T&auml;tigkeiten &uuml;bereinstimmend
                <?php endif; ?>
                </h3>
        </div>
        <div class="panel-body">
        <?php foreach($person_list as $person): ?>
            <?php \Layout\Html\Tools::widget(
            'person-card',
            [
                "person" => $person,
                "menu" => [
                    'Details einblenden' => [
                        'url' =>  'javascript:',
                        'icon' => 'search',
                        'class' => ['volunteer'],
                        'data-toggle' => 'modal',
                        'data-target' => '.volunteer-detail-modal-'.$person->field('id')->data()
                    ],
                    'Als Freiwillige(n) zuweisen' => [
                        'url' => \Layout\Html\Tools::url( 'request/volunteers', [
                                'request_id' => $request->id(),
                                'volunteer_person_id' => $person->id()
                            ]),
                        'icon' => 'ok',
                        'class' => ['volunteer'],
                    ],
                ]
            ])
            ?>
            <div class="modal fade volunteer-detail-modal-<?= $person->field('id')->data() ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?php include('_volunteermodal.php') ?>
                  </div>
               </div>
            </div>

        <?php endforeach; ?>

         <ul class="pagination">
         <?php for($ipage=1; $ipage <= ceil(count($person_list)/10); $ipage++): ?>
            <?php if(\RT::$params->get('service_filter')->data()): ?>
            <li <?= $page == $ipage ? ' class="active"' : '' ?>><a href="<?= \Layout\Html\Tools::url('request/browse_volunteers/service_filter', ['request_id' => $request_id, 'page' => $ipage]) ?>"><?= $ipage ?></a></li>
            <?php elseif(\RT::$params->get('sub_service_or_filter')->data()): ?>
            <li <?= $page == $ipage ? ' class="active"' : '' ?>><a href="<?= \Layout\Html\Tools::url('request/browse_volunteers/sub_service_or_filter', ['request_id' => $request_id, 'page' => $ipage]) ?>"><?= $ipage ?></a></li>
            <?php elseif(\RT::$params->get('sub_service_and_filter')->data()): ?>
            <li <?= $page == $ipage ? ' class="active"' : '' ?>><a href="<?= \Layout\Html\Tools::url('request/browse_volunteers/sub_service_and_filter', ['request_id' => $request_id, 'page' => $ipage]) ?>"><?= $ipage ?></a></li>
            <?php else: ?>
            <li <?= $page == $ipage ? ' class="active"' : '' ?>><a href="<?= \Layout\Html\Tools::url('request/browse_volunteers', ['request_id' => $request_id, 'page' => $ipage]) ?>"><?= $ipage ?></a></li>
            <?php endif; ?>
         <?php endfor; ?>
         </ul>
        </div>
    </div>
