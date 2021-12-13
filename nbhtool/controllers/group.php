<?php

namespace Controller;

    class Group extends \Base\Controller
    {
        function index()
        {
            $groups_query = new \Table\PersonGroups();
            $view = \RT::$layout->view();
            $view->value('group_list', $groups_query->search(['branch_id' => \RT::$params->get('branch_id')->data()]), True);
            $view->render();
        }

        function details()
        {
            $group = new \Model\PersonGroup(\RT::$params->get('person_group_id')->data());
            if($group->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Gruppe wurde nicht gefunden.');
            }
            if(\RT::$params->exists('update'))
            {
                if(\RT::$params->exists('note'))
                {
                    $group->field('note')->data(\RT::$params->get('note')->data());
                    if($group->store())
                    {
                        \Tools\Log::add('Bemerkung zur Gruppe angepasst', [$group]);
                    }
                }

                if(\RT::$params->exists('text'))
                {
                    $old_name = $group->field('text')->data();
                    $group->field('text')->data(\RT::$params->get('text')->data());
                    if($group->store())
                    {
                        \Tools\Log::add("Titel der Gruppe von '".$old_name."' auf '".\RT::$params->get('text')->data()."' angepasst", [$group]);
                    }
                }

            }
            $view = \RT::$layout->view();
            $view->value('group', $group, True);
            $view->render();
        }

        function create()
        {
            $group = new \Model\PersonGroup();
            if(\RT::$params->exists('save'))
            {
                if(\RT::$params->exists('text') && strlen(utf8_decode(\RT::$params->get('text')->data())) > 0)
                {
                    $group->update_by_params();
                    if($group->store())
                    {
                        \Tools\Log::add("Neue Gruppe '".$group->display_name()."' erfasst", [$group]);
                    }
                    return \Layout\Html\Tools::redirect('group/details', ['person_group_id' => $group->id()]);
                }
                else
                {
                    \RT::$params->get('text')->error('Der Name der Gruppe muss eingegeben werden');
                    $view = \RT::$layout->view();
                    $view->render();
                    return True;
                }
            }
            else
            {
                $view = \RT::$layout->view();
                $view->render();
            }
        }

        function delete()
        {
            $group = new \Model\PersonGroup(\RT::$params->get('person_group_id')->data());
            if(\RT::$params->exists('confirmed'))
            {
                $group_name = $group->display_name();
                $member_count = 0;
                foreach($group->persons() as $personrel)
                {
                    $personrel->delete();
                    $member_count++;
                }
                if($group->delete())
                {
                    \Tools\Log::add("Gruppe '$group_name' wurde gelösch dabei wurden $member_count Mitgliedereinträge entfernt");
                }
                return \Layout\Html\Tools::redirect('group/index');
            }
            else
            {
                $view = \RT::$layout->view();
                $view->value('group', $group, True);
                $view->render();
            }
        }


        function members()
        {
            $group = new \Model\PersonGroup(\RT::$params->get('person_group_id')->data());
            $view = \RT::$layout->view();
            $view->value('group', $group, True);
            if($group->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Gruppe wurde nicht gefunden.');
            }
            if(\RT::$params->exists('remove'))
            {
                $grouprel = new \Model\PersonHasGroup(
                    [ 'AND' => [
                        'person_id' => \RT::$params->get('person_id')->data(),
                        'person_group_id' => \RT::$params->get('person_group_id')->data()
                    ]]
                );
                $person = $grouprel->person();
                if($grouprel->delete())
                {
                    \Tools\Log::add('Person aus Gruppe entfernt', [$person, $group]);
                }
                return \Layout\Html\Tools::redirect('group/members/browse', ['person_group_id' => $group->id()]);
            }
            if(\RT::$params->exists('browse'))
            {
                $members_list = array();
                foreach($group->persons() as $personrel)
                {
                    $members_entry = $personrel->person();
                    array_push($members_list, $members_entry);
                }
                $view->value('members_list', $members_list , True);
                return $view->render('group/browse_members');
            }
            if(\RT::$params->exists('mass_mod_by_id'))
            {
                $person_ids = preg_split('/\s+/m', \RT::$params->get('person_ids')->data());
                $add_counter = 0;
                foreach($person_ids as $person_id)
                {
                    if(preg_match('/^#([0-9]+)$/', $person_id, $matches))
                    {
                        $person_id = $matches[1];
                    }
                    else if(preg_match('/^([0-9]+)$/', $person_id, $matches))
                    {
                        $person_id = $matches[1];
                    }
                    else
                    {
                        continue;
                    }
                    $param_acl_obj = new \Params\Person_id();
                    if(!$param_acl_obj->acl($person_id))
                    {
                        continue;
                    }
                    if(\RT::$params->exists('members_add') && $group->add_person($person_id))
                    {
                        $add_counter++;
                    }
                    if(\RT::$params->exists('members_remove') && $group->remove_person($person_id))
                    {
                        \Tools\Debug(\DB::$handle->last_query());
                        $add_counter++;
                    }
                }
                if(\RT::$params->exists('members_add') && $add_counter > 0)
                {
                    \Tools\Log::add("$add_counter Personen zu Gruppe hinzugefügt", [$group]);
                }
                if(\RT::$params->exists('members_remove')&&  $add_counter > 0)
                {
                    \Tools\Log::add("$add_counter Personen von Gruppe entfernt", [$group]);
                }
                return \Layout\Html\Tools::redirect('group/members', ['person_group_id' => $group->id()]);
            }
            if(\RT::$params->exists('mass_mod_by_class') && \RT::$params->exists('selected_person_classes') && is_array(\RT::$params->get('selected_person_classes')->data()))
            {
                $add_counter = 0;
                if(in_array('volunteer', \RT::$params->get('selected_person_classes')->data()))
                {
                    $volunteer_query = new \Table\Volunteers();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $volunteers = $volunteer_query->search(['AND' => [
                        'person.branch_id' => $branch_id,
                        'person.deleted' => 0
                    ]]);
                    foreach($volunteers as $volunteer)
                    {
                        if(\RT::$params->exists('members_add') && $volunteer->person()->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $volunteer->person()->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('volunteer-active', \RT::$params->get('selected_person_classes')->data()))
                {
                    $volunteer_query = new \Table\Volunteers();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $volunteers = $volunteer_query->search(['AND' => [
                        'person.branch_id' => $branch_id,
                        'person.deleted' => 0
                    ]]);
                    foreach($volunteers as $volunteer)
                    {
                        if($volunteer->current_state()->state()->id() != 2)
                        {
                            continue;
                        }
                        if(\RT::$params->exists('members_add') && $volunteer->person()->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $volunteer->person()->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('volunteer-passive', \RT::$params->get('selected_person_classes')->data()))
                {
                    $volunteer_query = new \Table\Volunteers();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $volunteers = $volunteer_query->search(['AND' => [
                        'person.branch_id' => $branch_id,
                        'person.deleted' => 0
                    ]]);
                    foreach($volunteers as $volunteer)
                    {
                        if($volunteer->current_state()->state()->id() != 1)
                        {
                            continue;
                        }
                        if(\RT::$params->exists('members_add') && $volunteer->person()->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $volunteer->person()->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('volunteer-busy', \RT::$params->get('selected_person_classes')->data()))
                {
                    $volunteer_query = new \Table\Volunteers();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $volunteers = $volunteer_query->search(['AND' => [
                        'person.branch_id' => $branch_id,
                        'person.deleted' => 0
                    ]]);
                    foreach($volunteers as $volunteer)
                    {
                        if($volunteer->current_state()->state()->id() != 0 || $volunteer->current_state()->state()->id() == NULL)
                        {
                            continue;
                        }
                        if(\RT::$params->exists('members_add') && $volunteer->person()->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $volunteer->person()->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('volunteer-terminated', \RT::$params->get('selected_person_classes')->data()))
                {
                    $volunteer_query = new \Table\Volunteers();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $volunteers = $volunteer_query->search(['AND' => [
                        'person.branch_id' => $branch_id,
                        'person.deleted' => 0
                    ]]);
                    foreach($volunteers as $volunteer)
                    {
                        if($volunteer->current_state()->state()->id() != 3)
                        {
                            continue;
                        }
                        if(\RT::$params->exists('members_add') && $volunteer->person()->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $volunteer->person()->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('client', \RT::$params->get('selected_person_classes')->data()))
                {
                    $client_query = new \Table\Clients();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $clients = $client_query->search(['AND' => [
                        'person.branch_id' => $branch_id,
                        'person.deleted' => 0
                    ]]);
                    foreach($clients as $client)
                    {
                        if(\RT::$params->exists('members_add') && $client->person()->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $client->person()->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('persons', \RT::$params->get('selected_person_classes')->data()))
                {
                    $persons_query = new \Table\Persons();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $persons = $persons_query->search(['AND' => ['branch_id' => $branch_id, 'deleted' => 0]]);
                    foreach($persons as $person)
                    {
                        if(\RT::$params->exists('members_add') && $person->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $person->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('members-active', \RT::$params->get('selected_person_classes')->data()))
                {
                    $persons_query = new \Table\Persons();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $persons = $persons_query->search(['AND' => ['branch_id' => $branch_id, 'deleted' => 0]]);
                    foreach($persons as $person)
                    {
                        if($person->membership()->id() != 1)
                        {
                            continue;
                        }
                        if(\RT::$params->exists('members_add') && $person->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $person->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('members-passive', \RT::$params->get('selected_person_classes')->data()))
                {
                    $persons_query = new \Table\Persons();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $persons = $persons_query->search(['AND' => ['branch_id' => $branch_id, 'deleted' => 0]]);
                    foreach($persons as $person)
                    {
                        if($person->membership()->id() != 2)
                        {
                            continue;
                        }
                        if(\RT::$params->exists('members_add') && $person->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $person->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(in_array('members-non', \RT::$params->get('selected_person_classes')->data()))
                {
                    $persons_query = new \Table\Persons();
                    $branch_id = \RT::$params->get('branch_id')->data();
                    $persons = $persons_query->search(['AND' => ['branch_id' => $branch_id, 'deleted' => 0]]);
                    foreach($persons as $person)
                    {
                        if($person->membership()->id() != 0)
                        {
                            continue;
                        }
                        if(\RT::$params->exists('members_add') && $person->add_to_group($group->id()))
                        {
                            $add_counter++;
                        }
                        if(\RT::$params->exists('members_remove') && $person->remove_from_group($group->id()))
                        {
                            $add_counter++;
                        }
                    }
                }
                if(\RT::$params->exists('members_add') && $add_counter > 0)
                {
                    \Tools\Log::add("$add_counter Personen zu Gruppe hinzugefügt", [$group]);
                }
                if(\RT::$params->exists('members_remove') && $add_counter > 0)
                {
                    \Tools\Log::add("$add_counter Personen von Gruppe entfernt", [$group]);
                }
                return \Layout\Html\Tools::redirect('group/members', ['person_group_id' => $group->id()]);
            }
            $view->render();
        }

        function options()
        {
            $group = new \Model\PersonGroup(\RT::$params->get('person_group_id')->data());
            $view = \RT::$layout->view();
            if($group->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Gruppe wurde nicht gefunden.');
            }

            if(\RT::$params->exists('set_auto_add') && is_array(\RT::$params->get('auto_add_classes')->data()))
            {
                $group->field('auto_add_new_client', in_array('client', \RT::$params->get('auto_add_classes')->data()) ? 1 : 0);
                $group->field('auto_add_new_volunteer', in_array('volunteer', \RT::$params->get('auto_add_classes')->data()) ? 1 : 0);
                $group->field('auto_add_new_person', in_array('person', \RT::$params->get('auto_add_classes')->data()) ? 1 : 0);
                $group->field('auto_add_new_agent', in_array('agent', \RT::$params->get('auto_add_classes')->data()) ? 1 : 0);
                $group->field('auto_add_new_active_member', in_array('member-active', \RT::$params->get('auto_add_classes')->data()) ? 1 : 0);
                $group->field('auto_add_new_passive_member', in_array('member-passive', \RT::$params->get('auto_add_classes')->data()) ? 1 : 0);
                if($group->store())
                {
                    \Tools\Log::add("Automatische Mitgliedschaft dieser Gruppe angepasst", [$group]);
                }
            }
            $view->value('group', $group, True);
            $view->render();
        }
    }

namespace Controller\Acl;
    class Group extends \Base\Acl\Controller
    {
        function create()
        {
            return \RT::$auth->needed('agent');
        }
        function index()
        {
            return \RT::$auth->needed('agent');
        }

        function details()
        {
            return \RT::$auth->needed('agent');
        }

        function members()
        {
            return \RT::$auth->needed('agent');
        }

        function options()
        {
            return \RT::$auth->needed('agent');
        }

        function delete()
        {
            return \RT::$auth->needed('agent');
        }
    }

?>
