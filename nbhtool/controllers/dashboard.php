<?php

namespace Controller;

    class Dashboard extends \Base\Controller
    {
        function person()
        {
            $view = \RT::$layout->view();
            $branch_id = \RT::$params->get('branch_id')->data();
            $request_query = new \Table\Requests();
            $requests = $request_query->search([ 'AND' => ['branch_id' => $branch_id]]);
            $open_request_list = array();
            $provisional_request_list = array();
            foreach($requests as $request)
            {
                if($request->current_state()->field('service_request_state_id')->data() == 0)
                {
                    array_push($open_request_list, $request);
                }
                if($request->current_state()->field('service_request_state_id')->data() == 1)
                {
                    array_push($provisional_request_list, $request);
                }
            }
            $view->value('open_request_list', $open_request_list);
            $view->value('provisional_request_list', $provisional_request_list);
            $view->render();
        }

        function request()
        {
            $view = \RT::$layout->view();
            $branch_id = \RT::$params->get('branch_id')->data();
            $request_query = new \Table\Requests();
            $requests = $request_query->search([ 'AND' => ['branch_id' => $branch_id]]);
            $request_list = array();
            foreach($requests as $request)
            {
                if(\RT::$params->exists('provisional'))
                {
                    if($request->current_state()->field('service_request_state_id')->data() != 1)
                    {
                        continue;
                    }
                }
                elseif(\RT::$params->exists('open'))
                {
                    if($request->current_state()->field('service_request_state_id')->data() != 0)
                    {
                        continue;
                    }
                }
                $request_entry = $request->raw();
                $request_entry['state'] = $request->current_state()->state()->field('text')->data();
                $request_entry['state_id'] = $request->current_state()->state()->field('id')->data();
                $request_entry['service'] = $request->service()->field('text')->data();
                $request_entry['last_change'] = date("d.m.Y, H:i", $request->current_state()->field('timestamp')->data());
                $request_entry['last_user'] = $request->current_state()->person()->display_name();
                $request_entry['client'] = $request->client()->person()->display_name();
                $request_entry['client_person_id'] = $request->client()->person()->id();
                array_push($request_list, $request_entry);
            }
            $open_request_list = array();
            $provisional_request_list = array();
            //Only needed to present counters in tab title (actualy a bit
            //stupid
            foreach($requests as $request)
            {
                if($request->current_state()->field('service_request_state_id')->data() == 0)
                {
                    array_push($open_request_list, $request);
                }
                if($request->current_state()->field('service_request_state_id')->data() == 1)
                {
                    array_push($provisional_request_list, $request);
                }
            }
            $view->value('request_list', $request_list);
            $view->value('open_request_list', $open_request_list);
            $view->value('provisional_request_list', $provisional_request_list);
            $view->render();
        }
    }

namespace Controller\Acl;
    class Dashboard extends \Base\Acl\Controller
    {
        function person()
        {
            return \RT::$auth->needed('agent');
        }
        function request()
        {
            return \RT::$auth->needed('agent');
        }
    }

?>
