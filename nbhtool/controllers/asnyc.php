<?php

namespace Controller;

    class Async extends \Base\Controller
    {
        function personsearch()
        {
            $person_table = new \Table\Persons();
            $search = \RT::$params->get('person_search_string')->data() ?
                \RT::$params->get('person_search_string')->data() :
                '';
            $view = \RT::$layout->view();
            $branch_id = \RT::$params->get('branch_id')->data();
            $persons = $person_table->search(
                [ "AND" => [
                      "branch_id" => $branch_id,
                      "deleted" => 0,
                      "OR" => [
                          'firstname[~]' => $search,
                          'lastname[~]' => $search,
                          'organization[~]' => $search
                      ]
                  ],
                  "ORDER" => ['lastname' => 'ASC']
            ]);
            $view->value('person_list', $persons);
            $view->value('search_string', $search);
            $view->value('contact_action', \RT::$params->exists('contact_action') ?  \RT::$params->get('contact_action')->data() : '');
            $view->value('person_id_name', \RT::$params->exists('person_id_name') ? \RT::$params->get('person_id_name')->data() : 'person_id');
            $card_url_params = array();
            if(\RT::$params->exists('request_id'))
            {
                $card_url_params['request_id'] = \RT::$params->get('request_id')->data();
            }
            $view->value('card_url_params', $card_url_params);
            $view->render(NULL, true);
        }

        function clientsearch()
        {
            $person_table = new \Table\Persons();
            $search = \RT::$params->get('person_search_string')->data() ?
                \RT::$params->get('person_search_string')->data() :
                '';
            $view = \RT::$layout->view();
            $branch_id = \RT::$params->get('branch_id')->data();
            $persons = $person_table->search_clients([ "AND" => [
                "branch_id" => $branch_id,
                "deleted" => 0,
                "OR" => [
                    'firstname[~]' => $search,
                    'lastname[~]' => $search,
                    'organization[~]' => $search
                ]]
            ]);
            $view->value('person_list', $persons);
            $view->render(NULL, true);
        }

        function volunteersearch()
        {
            $person_table = new \Table\Persons();
            $search = \RT::$params->get('person_search_string')->data() ?
                \RT::$params->get('person_search_string')->data() :
                '';
            $view = \RT::$layout->view();
            $branch_id = \RT::$params->get('branch_id')->data();
            $persons = $person_table->search([ "AND" => [
                "branch_id" => $branch_id,
                "deleted" => 0,
                "OR" => [
                    'firstname[~]' => $search,
                    'lastname[~]' => $search,
                    'organization[~]' => $search
                ]]
            ]);
            $view->value('person_list', $persons);
            $view->value('search_string', $search);
            $view->value('contact_action', \RT::$params->exists('contact_action') ?  \RT::$params->get('contact_action')->data() : '');
            $view->value('person_id_name', \RT::$params->exists('person_id_name') ? \RT::$params->get('person_id_name')->data() : 'person_id');
            $card_url_params = array();
            if(\RT::$params->exists('request_id'))
            {
                $card_url_params['request_id'] = \RT::$params->get('request_id')->data();
                $view->value('request_id', \RT::$params->get('request_id')->data());
            }
            $view->value('card_url_params', $card_url_params);
            $view->render(NULL, true);
        }

        function subserviceform()
        {
            $view = \RT::$layout->view();
            if(\RT::$params->get('service_id')->data())
            {
                $service = 
                    new \Model\Service(\RT::$params->get('service_id')->data());
                $subservices = $service->sub_services();
            }
            else
            {
                $subservices = array();
            }

            $view->value('subservices_list', $subservices);
            $view->render(NULL, true);
        }
    }

namespace Controller\Acl;
    class Async extends \Base\Acl\Controller
    {
        function personsearch()
        {
            return \RT::$auth->needed('agent');
        }

        function clientsearch()
        {
            return \RT::$auth->needed('agent');
        }

        function volunteersearch()
        {
            return \RT::$auth->needed('agent');
        }

        function subserviceform()
        {
            return \RT::$auth->needed('agent');
        }
    }

?>
