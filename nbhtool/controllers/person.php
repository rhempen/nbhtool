<?php

namespace Controller;

    class Person extends \Base\Controller
    {
        function details()
        {
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            $lang_query = new \Table\languages();
            if($person->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Person wurde nicht gefunden.');
            }
            if(\RT::$params->exists('remove_language'))
            {
                $language = new \Model\PersonLanguage();
                $language->field('language_id', \RT::$params->get('language_id')->data());
                $language->field('person_id', \RT::$params->get('person_id')->data());
                if($language->delete())
                {
                    \Tools\Log::add('Sprachen angepasst', [$person]);
                }
            }
            if(\RT::$params->exists('add_language'))
            {
                $language = new \Model\PersonLanguage();
                $language->field('language_id', \RT::$params->get('language_id')->data());
                $language->field('person_id', \RT::$params->get('person_id')->data());
                if($language->store())
                {
                    \Tools\Log::add('Sprachen angepasst', [$person]);
                }
            }
            $view = \RT::$layout->view();
            $view->value('languages_list', $lang_query->search([], [], True));
            $view->value('person', $person, True);
            $view->render();
        }

        function client()
        {
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            if($person->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Person wurde nicht gefunden.');
            }
            if(\RT::$params->exists('form_submit_client_enable'))
            {
                $client = new \Model\Client(['person_id' => $person->id()]);
                if($client->exists())
                {
                    $person->volunteer()->add_log(
                        \RT::$auth->info()->person(),
                        'Als Klient/in erneut erfasst',
                        1
                    );
                    \Tools\Log::add('Person als Klient/-in erneut erfasst', [$volunteer]);
                }
                else
                {
                    $client->field('person_id', $person->id());
                    if($client->store())
                    {
                        $person->client()->add_log(
                            \RT::$auth->info()->person(),
                            'Als Klient/in neu erfasst',
                            1
                        );
                        \Tools\Log::add('Person als Klient/-in neu erfasst', [$client]);
                        $groups_query = new \Table\PersonGroups();
                        $groups = $groups_query->search(['branch_id' => \RT::$params->get('branch_id')->data()]);
                        foreach($groups as $group)
                        {
                            $group->auto_add_client($client->person()->id());
                        }
                    }
                }
            }
            if(\RT::$params->exists('form_submit_edit_note'))
            {
                $person->client()->field('note', \RT::$params->get('note')->data());
                $person->client()->store();
            }
            $view = \RT::$layout->view();
            $view->value('person', $person, True);
            $view->render();
        }

        function agent()
        {
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            $view = \RT::$layout->view();
            if($person->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Person wurde nicht gefunden.');
            }
            if(\RT::$params->exists('create'))
            {
                if(!$person->agent()->is())
                {
                    $agent = new \Model\Agent();
                    $agent->field('person_id', $person->id());
                    if($agent->store())
                    {
                        $agent->add_branch(\RT::$params->get('branch_id')->data());
                        \Tools\Log::add('Person als Vermittler/in erfasst', [$person]);
                        $groups_query = new \Table\PersonGroups();
                        $groups = $groups_query->search(['branch_id' => \RT::$params->get('branch_id')->data()]);
                        foreach($groups as $group)
                        {
                            $group->auto_add_agent($agent->person()->id());
                        }
                    }
                    else
                    {
                        \RT::$error->fatal('Diese Person konnte nicht als Vermittler/in erfasst werden.');
                    }
                }
                else
                {
                    $person->agent()->add_branch(\RT::$params->get('branch_id')->data());
                    \Tools\Log::add('Person als Vermittler/in erfasst (Person ist auch in anderen Vermittlungsstellen als Vermittler/in t&auml;tig', [$person]);
                }
                if(!$person->account()->is())
                {
                    $username = '';
                    $username .= substr($person->field('firstname')->data(),0,1);
                    $username .= substr($person->field('lastname')->data(),0,5);
                    $username = strtolower($username);
                    if(strlen($username) > 2)
                    {
                        $account_query = new \Table\UserAccounts();
                        if($account_query->user_exists($username))
                        {
                            $username = '';
                            $username .= substr($person->field('firstname')->data(),0,3);
                            $username .= substr($person->field('lastname')->data(),0,4);
                            $username = strtolower($username);
                        }
                        $account = new \Model\UserAccount();
                        $account->field('username', $username);
                        $account->field('person_id', $person->id());
                        $account->store();
                    }
                }
            }
            if(\RT::$params->exists('enable'))
            {
                    if($person->agent()->activate(\RT::$params->get('branch_id')->data()))
                    {
                        \Tools\Log::add('Vermittler/innen-Status von dieser Person aktiviert', [$person]);
                    }
            }
            if(\RT::$params->exists('disable'))
            {
                    if($person->agent()->deactivate(\RT::$params->get('branch_id')->data()))
                    {
                        \Tools\Log::add('Vermittler/innen-Status von dieser Person deaktiviert', [$person]);
                    }
            }
            if(\RT::$params->exists('gen_new_pw'))
            {
                    $new_agent_password =
                    substr(base64_encode(openssl_random_pseudo_bytes(12)),0, 12);
                    if($person->account()->change_password($new_agent_password))
                    {
                        $view->value('new_agent_password', $new_agent_password);
                        \Tools\Log::add('Passwort des/der Vermittlers/innen geändert', [$person]);
                    }
            }
            if(!$person->agent()->is() && !\RT::$params->exists('confirm'))
            {
                \RT::$error->fatal('Die angeforderte Person hat keinen Vermittler/innen-Status.');
            }
            $view->value('confirm', \RT::$params->exists('confirm'));
            $view->value('person', $person);
            $view->render();
        }

        function volunteer()
        {
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            $services_query = new \Table\Services();
            $state_table = new \Table\VolunteerStates();
            if($person->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Person wurde nicht gefunden.');
            }
            if(\RT::$params->exists('add_log'))
            {
                $person->volunteer()->add_log(
                    \RT::$auth->info()->person(),
                    \RT::$params->get('volunteer_status_log') && is_string(\RT::$params->get('volunteer_status_log')->data()) ? \RT::$params->get('volunteer_status_log')->data() : '',
                    \RT::$params->get('volunteer_status_id') && is_numeric(\RT::$params->get('volunteer_status_id')->data()) ? \RT::$params->get('volunteer_status_id')->data() : NULL
                );
                if(\RT::$params->get('volunteer_status_id')->data() == 3)
                {
                    return \Layout\Html\Tools::redirect('person/details', ['person_id' => $person->id()]);
                }
            }
            if(\RT::$params->exists('form_submit_volunteer_enable'))
            {
                $volunteer = new \Model\Volunteer(['person_id' => $person->id()]);
                if($volunteer->exists())
                {
                    $person->volunteer()->add_log(
                        \RT::$auth->info()->person(),
                        'Als Freiwillige/n erneut erfasst',
                        2
                    );
                    \Tools\Log::add('Person als Freiwilligen/-n erneut erfasst', [$volunteer]);
                }
                else
                {
                    $volunteer->field('person_id', $person->id());
                    if($volunteer->store())
                    {
                        $person->volunteer()->add_log(
                            \RT::$auth->info()->person(),
                            'Als Freiwillige/n neu erfasst',
                            2
                        );
                        \Tools\Log::add('Person als Freiwillige/-n neu erfasst', [$volunteer]);
                    }
                }
                $groups_query = new \Table\PersonGroups();
                $groups = $groups_query->search(['branch_id' => \RT::$params->get('branch_id')->data()]);
                foreach($groups as $group)
                {
                    $group->auto_add_volunteer($volunteer->person()->id());
                }
            }
            if(\RT::$params->exists('form_submit_edit_note'))
            {
                $person->volunteer()->field('note', \RT::$params->get('note')->data());
                if($person->volunteer()->store())
                {
                    \Tools\Log::add("Notizen bearbeitet", [$person->volunteer()]);
                }
            }
            if(\RT::$params->exists('set_profession'))
            {
                $person->volunteer()->field('profession', \RT::$params->get('profession')->data());
                if($person->volunteer()->store())
                {
                    \Tools\Log::add("Beruf angepasst", [$person->volunteer()]);
                }
            }
            if(\RT::$params->exists('set_availability'))
            {
                $person->volunteer()->field('availability', \RT::$params->get('availability')->data());
                if($person->volunteer()->store())
                {
                    \Tools\Log::add("Verfuegbarkeit angepasst", [$person->volunteer()]);
                }
            }
            if(\RT::$params->exists('set_car'))
            {
                $person->volunteer()->field('car_model', \RT::$params->get('car_model')->data());
                $person->volunteer()->field('car_register_number', \RT::$params->get('car_register_number')->data());
                if($person->volunteer()->store())
                {
                    \Tools\Log::add("Motorfahrzeug angepasst", [$person->volunteer()]);
                }
            }
            if(
                \RT::$params->exists('set_services') &&
                \RT::$params->exists('selected_services') &&
                is_array(\RT::$params->get('selected_services')->data())
            )
            {
                foreach($person->volunteer()->services() as $old_service)
                {
                    $old_service->delete();
                }
                foreach(\RT::$params->get('selected_services')->data() as $service_id)
                {
                    $volunteer_service = new \Model\VolunteerService();
                    $volunteer_service->field('service_id', $service_id);
                    $volunteer_service->field('volunteer_id', $person->volunteer()->id());
                    $volunteer_service->store();
                    if($volunteer_service->service()->field('parent_service_id')->data())
                    {
                        $volunteer_service_parent = new \Model\VolunteerService();
                        $volunteer_service_parent->field('service_id',
                            $volunteer_service->service()->field('parent_service_id')->data());
                        $volunteer_service_parent->field('volunteer_id', $person->volunteer()->id());
                        $volunteer_service_parent->store();
                    }
                }
            }
            elseif(
                \RT::$params->exists('set_services') &&
                \RT::$params->exists('form_submit_set_services') 
            )
            {
                foreach($person->volunteer()->services() as $old_service)
                {
                    $old_service->delete();
                }
            }
            $volunteer_service_list = array();
            $volunteer_service_list_flat = array();
            foreach($person->volunteer()->services() as $service)
            {
                $volunteer_service_list_flat[$service->service()->id()] = $service->service();
                if($service->service()->parent_service() !== NULL)
                {
                    $volunteer_service_list[$service->service()->parent_service()->id()]['sub_services'][$service->service()->id()]
                        = $service->service();
                }
                else
                {
                    $volunteer_service_list[$service->service()->id()]['service'] = $service->service();
                }
            }

            $view = \RT::$layout->view();
            $view->value('service_list', $services_query->search(['parent_service_id' => NULL]));
            $view->value('volunteer_service_list', $volunteer_service_list);
            $view->value('volunteer_service_list_flat', $volunteer_service_list_flat);
            $view->value('person', $person, True);
            $view->value('state_list', $state_table->search());
            $view->render();
        }

        function create()
        {
            $person = new \Model\Person();
            $nationality_query = new \Table\Nationalities();
            $gender_query = new \Table\Genders();
            $title_query = new \Table\Titles();
            if(\RT::$params->get('name_preset')->data())
            {
                if(preg_match('/^\s*(.*?)\s+(.*?)\s+\((.*)\)\s*$/', \RT::$params->get('name_preset')->data(), $matches))
                {
                    $person->field('firstname', ucfirst($matches[1]));
                    $person->field('lastname', ucfirst($matches[2]));
                    $person->field('organization', ucfirst($matches[3]));
                }
                elseif(preg_match('/^\s*(.*?)\s+(.*)\s*$/', \RT::$params->get('name_preset')->data(), $matches))
                {
                    $person->field('firstname', ucfirst($matches[1]));
                    $person->field('lastname', ucfirst($matches[2]));
                }
                else
                {
                    $person->field('lastname', ucfirst(\RT::$params->get('name_preset')->data()));
                }
            }
            $view = \RT::$layout->view();
            $view->value('title_list', $title_query->search([], [], True));
            $view->value('nationality_list', $nationality_query->search([], [], True));
            $view->value('gender_list', $gender_query->search([], [], True));
            $view->value('person', $person);
            $view->render();
        }

        function membership()
        {
            $membership_query = new \Table\Memberships();
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            if($person->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Person wurde nicht gefunden.');
            }
            if(\RT::$params->exists('form_submit_edit_membership'))
            {
                $old_membership = $person->membership()->field('text')->data();
                $person->update_by_params();
                if($person->store())
                {
                    \Tools\Log::add("Mitgliederstatus angepasst von '".$old_membership."' auf '".$person->membership()->field('text')->data()."'", [$person]);
                    $groups_query = new \Table\PersonGroups();
                    $groups = $groups_query->search(['branch_id' => \RT::$params->get('branch_id')->data()]);
                    foreach($groups as $group)
                    {
                        if($person->membership()->id() == 1)
                        {
                            $group->auto_add_active_member($person->id());
                        }
                        if($person->membership()->id() == 2)
                        {
                            $group->auto_add_passive_member($person->id());
                        }
                    }
                }
            }
            $view = \RT::$layout->view();
            $view->value('person', $person, True);
            $view->value('membership_list', $membership_query->search([], [], True), True);
            $view->render();
        }

        function groups()
        {
            $groups_query = new \Table\PersonGroups();
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            if($person->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Person wurde nicht gefunden.');
            }
            if(\RT::$params->exists('add'))
            {
                $grouprel = new \Model\PersonHasGroup();
                $grouprel->field('person_group_id', \RT::$params->get('person_group_id')->data());
                $grouprel->field('person_id', \RT::$params->get('person_id')->data());
                if($grouprel->store())
                {
                    \Tools\Log::add('Person zu Gruppe hinzugefügt', [$person, $grouprel->group()]);
                }
            }
            if(\RT::$params->exists('remove'))
            {
                $grouprel = new \Model\PersonHasGroup(
                    [ 'AND' => [
                        'person_id' => \RT::$params->get('person_id')->data(),
                        'person_group_id' => \RT::$params->get('person_group_id')->data()
                    ]]
                );
                $group = $grouprel->group();
                if($grouprel->delete())
                {
                    \Tools\Log::add('Person aus Gruppe entfernt', [$person, $group]);
                }
            }
            $view = \RT::$layout->view();
            $view->value('person', $person, True);
            $view->value('group_list', $groups_query->search(['branch_id' => \RT::$params->get('branch_id')->data()]), True);
            $view->render();
        }

        function jobs()
        {
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            if($person->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Person wurde nicht gefunden.');
            }
            $request_list = array();
            foreach($person->volunteer()->request_relations()->get() as $request_rel)
            {
                if(\RT::$params->exists('show_closed') === False && $request_rel->field('end')->data())
                {
                    continue;
                }
                $request_entry = $request_rel->request()->raw();
                $request_entry['state'] = $request_rel->request()->current_state()->state()->field('text')->data();
                $request_entry['state_id'] = $request_rel->request()->current_state()->state()->field('id')->data();
                $request_entry['service'] = $request_rel->request()->service()->field('text')->data();
                $request_entry['last_change'] = date("d.m.Y, H:i", $request_rel->request()->current_state()->field('timestamp')->data());
                $request_entry['last_user'] = $request_rel->request()->current_state()->person()->display_name();
                $request_entry['client'] = $request_rel->request()->client()->person()->display_name();
                $request_entry['client_person_id'] = $request_rel->request()->client()->person()->id();
                $request_entry['rel_start'] = date("d.m.Y, H:i", $request_rel->field('start')->data());
                $request_entry['rel_end'] = $request_rel->field('end')->data() ? date("d.m.Y, H:i", $request_rel->field('end')->data()) : '';
                array_push($request_list, $request_entry);
            }

            $view = \RT::$layout->view();
            $view->value('request_list', $request_list);
            $view->value('person', $person, True);
            $view->render();
        }

        function requests()
        {
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            if($person->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Person wurde nicht gefunden.');
            }
            if(\RT::$params->exists('form_submit_edit_membership'))
            {
                $person->update_by_params();
                $person->store();
            }

            $request_list = array();
            foreach($person->client()->requests() as $request)
            {
                $request_entry = $request->raw();
                $request_entry['state'] = $request->current_state()->state()->field('text')->data();
                $request_entry['state_id'] = $request->current_state()->state()->field('id')->data();
                $request_entry['service'] = $request->service()->field('text')->data();
                $request_entry['last_change'] = date("d.m.Y, H:i", $request->current_state()->field('timestamp')->data());
                $request_entry['last_user'] = $request->current_state()->person()->display_name();
                array_push($request_list, $request_entry);
            }

            $view = \RT::$layout->view();
            $view->value('request_list', $request_list);
            $view->value('person', $person, True);
            $view->render();
        }

        function save()
        {
            if(preg_match(
                '/^([0-9]{2})\.([0-9]{2})\.([0-9]{4})$/',
                \RT::$params->get('date_of_birth')->data(),
                $date_matches
            ))
            {
                \RT::$params->get('date_of_birth')->data(
                    strtotime(sprintf('%d/%d/%d',
                        $date_matches[3],
                        $date_matches[2],
                        $date_matches[1]
                    ))
                );
            }
            $new_person = False;
            if(\RT::$params->exists('person_id'))
            {
                $person = new \Model\Person(\RT::$params->get('person_id')->data());
            }
            else
            {
                $person = new \Model\Person();
                $new_person = True;
            }
            $person->update_by_params();
            if($person->store())
            {
                if($new_person)
                {
                    $groups_query = new \Table\PersonGroups();
                    $groups = $groups_query->search(['branch_id' => \RT::$params->get('branch_id')->data()]);
                    foreach($groups as $group)
                    {
                        $group->auto_add_person($person->id());
                    }
                    \Tools\Log::add('Neue Person erfasst', [$person]);
                }
                else
                {
                    \Tools\Log::add('Personendetails angepasst', [$person]);
                }
                return \Layout\Html\Tools::redirect('person/details', ['person_id' => $person->id()]);
            }
            else
            {
                $nationality_query = new \Table\Nationalities();
                $gender_query = new \Table\Genders();
                $title_query = new \Table\Titles();

                $view = \RT::$layout->view();
                $view->value('title_list', $title_query->search([], [], True));
                $view->value('nationality_list', $nationality_query->search([], [], True));
                $view->value('gender_list', $gender_query->search([], [], True));
                $view->value('person', $person);
                $view->render('person/create');
            }
        }

        function update()
        {
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            $nationality_query = new \Table\Nationalities();
            $gender_query = new \Table\Genders();
            $title_query = new \Table\Titles();

            $view = \RT::$layout->view();
            $view->value('title_list', $title_query->search([], [], True));
            $view->value('nationality_list', $nationality_query->search([], [], True));
            $view->value('gender_list', $gender_query->search([], [], True));
            $view->value('person', $person);
            $view->render();
        }

        function delete()
        {
            $person = new \Model\Person(\RT::$params->get('person_id')->data());
            if(\RT::$params->exists('confirmed'))
            {
                $person->field('deleted', 1);
                $person->store();
                \Tools\Log::add('Person wurde auf Status gelöscht gesetzt', [$person]);
                if($person->volunteer()->is())
                {
                    $person->volunteer()->add_log(
                        \RT::$auth->info()->person(),
                        'Diese Person wurde mit dem Status gel&ouml;scht vermerkt',
                        3
                    );
                }
                if($person->agent()->is())
                {
                    foreach($person->agent()->branches_all() as $branch)
                    {
                        $person->agent()->deactivate($branch->id());
                    }
                }
                foreach($person->groups() as $grouprel)
                {
                    $grouprel->delete();
                }
                return \Layout\Html\Tools::redirect('home/index');
            }

            $view = \RT::$layout->view();
            $view->value('confirmed', \RT::$params->exists('confirmed'));
            $view->value('person', $person);
            $view->render();
        }
    }

namespace Controller\Acl;
    class Person extends \Base\Acl\Controller
    {
        function create()
        {
            return \RT::$auth->needed('agent');
        }

        function details()
        {
            return \RT::$auth->needed('agent');
        }

        function update()
        {
            return \RT::$auth->needed('agent');
        }

        function save()
        {
            return \RT::$auth->needed('agent');
        }

        function client()
        {
            return \RT::$auth->needed('agent');
        }

        function volunteer()
        {
            return \RT::$auth->needed('agent');
        }

        function agent()
        {
            return \RT::$auth->needed('agent');
        }

        function membership()
        {
            return \RT::$auth->needed('agent');
        }
        
        function groups()
        {
            return \RT::$auth->needed('agent');
        }

        function jobs()
        {
            return \RT::$auth->needed('agent');
        }

        function requests()
        {
            return \RT::$auth->needed('agent');
        }

        function delete()
        {
            return \RT::$auth->needed('agent');
        }
    }

?>
