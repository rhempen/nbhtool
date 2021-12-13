<?php

namespace Controller;

    class Lists extends \Base\Controller
    {
        function person()
        {
            $persons_query = new \Table\Persons();
            $branch_id = \RT::$params->get('branch_id')->data();
            $persons = $persons_query->search(['AND' => ['branch_id' => $branch_id, 'deleted' => 0]]);
            $person_list = array();
            $group_name = NULL;
            foreach($persons as $person)
            {
                $person_entry = $person->raw();
                $person_entry['groups'] = '';
                $group_match = False;
                foreach($person->groups() as $group)
                {
                    $person_entry['groups'] .= ($person_entry['groups'] === ''? '': ', '). $group->group()->field('text')->data();
                    if(\RT::$params->exists('by_group') && \RT::$params->exists('person_group_id'))
                    {
                        if($group->field('person_group_id')->data() === \RT::$params->get('person_group_id')->data())
                        {
                            $group_name = $group->group()->field('text')->data();
                            $group_match = True;
                        }
                    }
                }
                if($group_match === False && \RT::$params->exists('by_group'))
                {
                    continue;
                }
                $person_entry['gender'] = $person->gender()->field('text')->data();
                $person_entry['nationality'] = $person->nationality()->field('text')->data();
                $person_entry['title'] = $person->title()->field('text')->data();
                $person_entry['membership'] = $person->membership()->field('text')->data();
                array_push($person_list, $person_entry);
            }
            $view = \RT::$layout->view();
            $view->value('person_list', $person_list);
            $view->value('group_name', $group_name);
            $view->render();
        }

        function client()
        {
            $client_query = new \Table\Clients();
            $branch_id = \RT::$params->get('branch_id')->data();
            $clients = $client_query->search(['AND' => ['person.branch_id' => $branch_id]]);
            $person_list = array();
            foreach($clients as $client)
            {
                $person_entry = $client->person()->raw();
                $person_entry['person_id'] = $client->person()->id();
                $person_entry['gender'] = $client->person()->gender()->field('text')->data();
                $person_entry['nationality'] = $client->person()->nationality()->field('text')->data();
                $person_entry['title'] = $client->person()->title()->field('text')->data();
                array_push($person_list, $person_entry);
            }
            $view = \RT::$layout->view();
            $view->value('person_list', $person_list);
            $view->render();
        }

        function agent()
        {
            $agent_query = new \Table\AgentBranches();
            $branch_id = \RT::$params->get('branch_id')->data();
            $agentrels = $agent_query->agent_for_branch($branch_id);
            $person_list = array();
            foreach($agentrels as $agentrel)
            {
                $person_entry = $agentrel->agent()->person()->raw();
                $person_entry['person_id'] = $agentrel->agent()->person()->id();
                $person_entry['gender'] = $agentrel->agent()->person()->gender()->field('text')->data();
                $person_entry['nationality'] = $agentrel->agent()->person()->nationality()->field('text')->data();
                $person_entry['title'] = $agentrel->agent()->person()->title()->field('text')->data();
                $person_entry['created'] = $agentrel->field('timestamp')->data();
                $person_entry['state'] = $agentrel->field('active')->data() ? 'aktiv' : 'deaktiviert';
                array_push($person_list, $person_entry);
            }
            $view = \RT::$layout->view();
            $view->value('person_list', $person_list);
            $view->render();
        }

        function volunteer()
        {
            $volunteer_query = new \Table\Volunteers();
            $branch_id = \RT::$params->get('branch_id')->data();
            $volunteers = $volunteer_query->search([ 'AND' => ['person.branch_id' => $branch_id]]);
            $person_list = array();
            foreach($volunteers as $volunteer)
            {
                if(\RT::$params->exists('state_filter') && \RT::$params->get('state_filter')->data() != $volunteer->current_state()->state()->id())
                {
                    continue;
                }
                $person_entry = $volunteer->person()->raw();
                $person_entry['gender'] = $volunteer->person()->gender()->field('text')->data();
                $person_entry['person_id'] = $volunteer->person()->id();
                $person_entry['nationality'] = $volunteer->person()->nationality()->field('text')->data();
                $person_entry['title'] = $volunteer->person()->title()->field('text')->data();
                $person_entry['state'] =
                    $volunteer->current_state()->state()->field('text') ?
                    $volunteer->current_state()->state()->field('text')->data()
                    : '';
                array_push($person_list, $person_entry);
            }
            $view = \RT::$layout->view();
            $view->value('person_list', $person_list);
            $view->render();
        }

        function request()
        {
            $request_query = new \Table\Requests();
            $branch_id = \RT::$params->get('branch_id')->data();
            $requests = $request_query->search([ 'AND' => ['branch_id' => $branch_id]]);
            $request_list = array();
            foreach($requests as $request)
            {
                if(\RT::$params->exists('state_filter') && \RT::$params->get('state_filter')->data() != $request->current_state()->state()->id())
                {
                    continue;
                }
                $request_entry = $request->raw();
                $request_entry['state'] = $request->current_state()->state()->field('text')->data();
                $request_entry['state_id'] = $request->current_state()->state()->field('id')->data();
                $request_entry['service'] = $request->service()->field('text')->data();
                $request_entry['last_change'] = date("d.m.Y, H:i", $request->current_state()->field('timestamp')->data());
                $request_entry['created'] = date("d.m.Y, H:i", $request->first_state()->field('timestamp')->data());
                $request_entry['last_user'] = $request->current_state()->person()->display_name();
                $request_entry['client'] = $request->client()->person()->display_name();
                $request_entry['client_person_id'] = $request->client()->person()->id();
                array_push($request_list, $request_entry);
            }
            $view = \RT::$layout->view();
            $view->value('request_list', $request_list);
            $view->render();
        }
    }

namespace Controller\Acl;
    class Lists extends \Base\Acl\Controller
    {
        function person()
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

        function request()
        {
            return \RT::$auth->needed('agent');
        }

        function agent()
        {
            return \RT::$auth->needed('agent');
        }
    }

?>
