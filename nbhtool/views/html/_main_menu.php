                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Personen <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= \Layout\Html\Tools::url('person/create') ?>">erfassen...</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/person') ?>">Alle</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/volunteer') ?>">Freiwillige</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/client') ?>">Klienten</a></li>
                            <li><a href="<?=
                            \Layout\Html\Tools::url('lists/agent') ?>">Vermittler/-innen</a></li>
                            </ul>
                        </li>
                    </li>
                    <li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle"
                            data-toggle="dropdown">Anfragen<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= \Layout\Html\Tools::url('request/create') ?>">erfassen...</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/request') ?>">Alle</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => '0']) ?>">Offene</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => 1]) ?>">Provisorische</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => 2]) ?>">Etablierte</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => 3]) ?>">Beendete</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('lists/request',['state_filter' => 4]) ?>">Beendete (weitergeleitet)</a></li>
                            </ul>
                        </li>
                    </li>
                    <li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle"
                            data-toggle="dropdown">Gruppen<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= \Layout\Html\Tools::url('group/create') ?>">erfassen...</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('group/index') ?>">Liste</a></li>
                            <li class="divider"></li>
                            <?php
                                $group_list = array();
                                if(\RT::$params->exists('branch_id'))
                                {
                                    $groups_query = new \Table\PersonGroups();
                                    $group_list = $groups_query->search(['branch_id' => \RT::$params->get('branch_id')->data()]);
                                }
                            ?>
                            <?php foreach($group_list as $group_entry): ?>
                                <li><a href="<?=
                                \Layout\Html\Tools::url('group/members/browse',['person_group_id' => $group_entry->id()]) ?>"><?= \Layout\Html\Tools::enc($group_entry->display_name()) ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                        </li>
                    </li>
                    <li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Berichte<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= \Layout\Html\Tools::url('report/volunteers') ?>">Freiwillige</a></li>
                            <li><a href="<?= \Layout\Html\Tools::url('report/requests') ?>">Anfragen und Vermittlungen</a></li>
                            </ul>
                        </li>
                    </li>
                    <li><a href="<?= \Layout\Html\Tools::url('journal/index/today') ?>">Journal</a></li>
                    <li><a href="<?= \Layout\Html\Tools::url('doc/index') ?>">Hilfe</a></li>
                </ul>
