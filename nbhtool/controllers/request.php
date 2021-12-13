<?php

namespace Controller;

    class Request extends \Base\Controller
    {
        function details()
        {
            $request = new \Model\Request(\RT::$params->get('request_id')->data());
            $view = \RT::$layout->view();
            if($request->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Anfrage wurde nicht gefunden.');
            }

            if(\RT::$params->exists('form_submit_edit_note'))
            {
                $request->field('note',\RT::$params->get('note'));
                $request->store();
            }
            if(\RT::$params->exists('contact_person_id'))
            {
                $request->update_by_params();
                if($request->store())
                {
                    \Tools\Log::add('Kontaktperson zu dieser Anfrage erfasst', [$request]);
                }
            }
            if(\RT::$params->exists('remove_contact_person'))
            {
                $request->update_by_params(['contact_person_id' => NULL]);
                if($request->store())
                {
                    \Tools\Log::add('Kontaktperson von dieser Anfrage entfernt', [$request]);
                }
            }
            $view->value('request_id', \RT::$params->get('request_id')->data(), True);
            $view->value('request', $request, True);
            $view->render();
        }

        function add_alt_contact()
        {
            $request = new \Model\Request(\RT::$params->get('request_id')->data());
            $view = \RT::$layout->view();
            if($request->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Anfrage wurde nicht gefunden.');
            }

            $view->value('request_id', \RT::$params->get('request_id')->data(), True);
            $view->value('request', $request, True);
            $view->render();
        }

        function add_volunteer()
        {
            $request = new \Model\Request(\RT::$params->get('request_id')->data());
            $view = \RT::$layout->view();
            if($request->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Anfrage wurde nicht gefunden.');
            }

            $view->value('request_id', \RT::$params->get('request_id')->data(), True);
            $view->value('request', $request, True);
            $view->render();
        }

        function browse_volunteers()
        {
            $request = new \Model\Request(\RT::$params->get('request_id')->data());
            $view = \RT::$layout->view();
            if($request->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Anfrage wurde nicht gefunden.');
            }
            $person_query = new \Table\Persons();
            $persons = $person_query->search(
                ['AND' => [
                    'branch_id' => \RT::$params->get('branch_id')->data(),
                    'deleted' => 0,
                    ],
                 'ORDER' => ['lastname' => 'ASC']

                ]
            );
            $person_list = array();
            foreach($persons as $person)
            {
                if($person->volunteer()->is_asignable())
                {
                    if(\RT::$params->exists('service_filter') && is_numeric(\RT::$params->get('service_filter')->data()))
                    {
                        foreach($person->volunteer()->services() as $service)
                        {
                            if($service->service()->id() == $request->service()->id())
                            {
                                array_push($person_list, $person);
                                break;
                            }
                        }
                    }
                    else if(\RT::$params->exists('sub_service_or_filter') && is_array($request->sub_services()))
                    {
                        foreach($person->volunteer()->services() as $service)
                        {
                            foreach($request->sub_services() as $requested_service)
                            {
                                if($service->service()->id() == $requested_service->id())
                                {
                                    array_push($person_list, $person);
                                    break 2;
                                }
                            }
                        }
                    }
                    else if(\RT::$params->exists('sub_service_and_filter') && is_array($request->sub_services()))
                    {
                        if(count($person->volunteer()->sub_services()) > 0)
                        {
                            foreach($request->sub_services() as $requested_service)
                            {
                                foreach($person->volunteer()->sub_services() as $service)
                                {
                                    if($service->service()->id() === $requested_service->id())
                                    {
                                        continue 2;
                                    }
                                }
                                continue 2;
                            }
                            array_push($person_list, $person);
                        }
                    }
                    else
                    {
                        array_push($person_list, $person);
                    }
                }
            }

            usort($person_list, function($a, $b) {
                return strcmp(
                    strtolower($a->field('lastname')->data()),
                    strtolower($b->field('lastname')->data())
                );
            });

            $view->value('person_list', $person_list);
            $view->value('request_id', \RT::$params->get('request_id')->data(), True);
            $view->value('request', $request, True);
            $view->render();
        }

        function log()
        {
            $request = new \Model\Request(\RT::$params->get('request_id')->data());
            $view = \RT::$layout->view();
            if($request->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Anfrage wurde nicht gefunden.');
            }

            if(\RT::$params->exists('form_submit_add_log'))
            {
                $new_state = new \Model\RequestState(\RT::$params->get('status_id')->data());
                if(!$new_state)
                {
                    \RT::$error->fatal('Der neue Status ist nicht erlaubt.');
                }
                $is_new_state = $request->current_state()->state()->id() == $new_state->id() ? True: False;
                $old_state_text = $request->current_state()->state()->field('text')->data();
                $request->add_log(
                    \RT::$auth->info()->person(),
                    \RT::$params->exists('status_log') && is_string(\RT::$params->get('status_log')->data()) ? \RT::$params->get('status_log')->data() : '',
                    \RT::$params->exists('status_id') && is_numeric(\RT::$params->get('status_id')->data()) ? \RT::$params->get('status_id')->data() : NULL
                );
                if($is_new_state)
                {
                    \Tools\Log::add(
                        "Neuen Logbucheintrag erfasst:\n ".
                        (\RT::$params->exists('status_log') &&
                        is_string(\RT::$params->get('status_log')->data()) ?
                        \RT::$params->get('status_log')->data() : ''),
                        [$request]
                    );
                }
                else
                {
                    \Tools\Log::add(
                        "Neuen Logbucheintrag erfasst und Status von '".$old_state_text."' auf '".$new_state->field('text')->data()."' gesetzt:\n ".
                        (\RT::$params->exists('status_log') &&
                        is_string(\RT::$params->get('status_log')->data()) ?
                        \RT::$params->get('status_log')->data() : ''),
                        [$request]
                    );
                }
            }
            $view->value('request_id', \RT::$params->get('request_id')->data(), True);
            $view->value('request', $request, True);
            $view->render();
        }

        function add_log()
        {
            $request = new \Model\Request(\RT::$params->get('request_id')->data());
            $state_table = new \Table\RequestStates();
            if($request->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Anfrage wurde nicht gefunden.');
            }

            $view = \RT::$layout->view();
            $view->value('state_list', $state_table->search());
            $view->value('request_id', \RT::$params->get('request_id')->data(), True);
            $view->value('request', $request, True);
            $view->render();
        }

        function volunteers()
        {
            $request = new \Model\Request(\RT::$params->get('request_id')->data());
            if($request->exists() === False)
            {
                \RT::$error->fatal('Die angeforderte Anfrage wurde nicht gefunden.');
            }
            if(\RT::$params->exists('volunteer_connection_id') && \RT::$params->exists('stop_volunteer'))
            {
                $request->stop_volunteer_connection(\RT::$params->get('volunteer_connection_id')->data());
            }
            elseif(\RT::$params->exists('volunteer_connection_id') && \RT::$params->exists('form_update_volunteer_note'))
            {
                $volunteer_connection = new \Model\RequestVolunteer(\RT::$params->get('volunteer_connection_id')->data());
                $volunteer_connection->field('note', \RT::$params->get('note')->data());
                $volunteer_connection->store();
            }
            elseif(\RT::$params->exists('volunteer_person_id'))
            {
                $volunteer_person = new \Model\Person(\RT::$params->get('volunteer_person_id')->data());
                if($volunteer_person->volunteer()->is())
                {
                    $request->add_volunteer($volunteer_person->volunteer()->id());
                    \Tools\Log::add('Neue/r Frewillige/r zur Anfrage addiert', [$request, $volunteer_person->volunteer()]);
                }
            }
            if(\RT::$params->exists('remove_time') && \RT::$params->exists('volunteer_journal_id'))
            {
                $new_log = new \Model\VolunteerJournal(\RT::$params->get('volunteer_journal_id')->data());
                if($new_log->delete())
                {
                    \Tools\Log::add('Zeit/Kilometer/Einsaetze geloescht', [$request]);
                }
            }
            if(\RT::$params->exists('add_time'))
            {
                $new_log = new \Model\VolunteerJournal(); 
                $year = \RT::$params->exists('year') ? \RT::$params->get('year')->data() : date('Y');
                $month = \RT::$params->exists('month') ? \RT::$params->get('month')->data() : date('m');
                $hours = \RT::$params->exists('hours') ?  \RT::$params->get('hours')->data() : 0;
                $period = 0;
                if(preg_match('/^([0-9]+):([0-9]+)$/', $hours, $hours_match))
                {
                    $period = $hours_match[1];
                    if($hours_match[2] >0 && $hours_match[2] < 60)
                    {
                        $period = $hours_match[1] * 60 * 60;
                        $period = $period + $hours_match[2] * 60;
                    }
                    else
                    {
                        $hours = $hours_match[1];
                    }
                }
                else
                {
                    $period = $hours * 60 * 60;
                }

                $start = strtotime(
                    sprintf('%d/%d/%d',
                        $year,
                        $month,
                        1
                    )
                );
                $new_log->update_by_params(['start' => $start, 'end' => ($start+$period)]);
                if($new_log->store())
                {
                    \Tools\Log::add('Zeit/Kilometer/Einsaetze erfasst', [$request]);
                }
            
            }
            $view = \RT::$layout->view();
            $view->value('request_id', \RT::$params->get('request_id')->data(), True);
            $view->value('request', $request, True);
            $view->render();
        }

        function create()
        {
            $view = \RT::$layout->view();
            if(\RT::$params->exists('client_id'))
            {
                $client = new \Model\Client(\RT::$params->get('client_id')->data());
                if($client->exists() === False)
                {
                    \RT::$error->fatal('Der/Die angeforderte Klient/-in wurde nicht gefunden.');
                }
                $view->value('client', $client);
            }
            $service_table = new \Table\Services();
            $services = $service_table->search(['parent_service_id' => NULL]);
            $view->value('service_list', $services);
            $view->render();
        }

        function save()
        {
            $request = new \Model\Request();
            if(\RT::$params->get('service_id')->data() !== 'empty')
            {
                $request->update_by_params();
                $request->store();

                $request->add_log(\RT::$auth->info()->person(), 'Anfrage erfasst');

                if(\RT::$params->get('selected_sub_services')->data())
                {
                    $request->add_sub_services(\RT::$params->get('selected_sub_services')->data());
                }
            }
            else
            {
                \RT::$params->get('service_id')->error('Es muss eine Anfrage Kategorie ausgew&auml;hlt werden');
                \RT::$request->controller('request');
                \RT::$request->action('create');
                \Controller\dispatch(\Acl\verify(1));
                return True;
            }
            \Tools\Log::add('Neue Anfrage erfasst', [$request, $request->client()]);
            header('Location: '.\Layout\Html\Tools::url('request/details', ['request_id' => $request->id()]));
        }
    }

namespace Controller\Acl;
    class Request extends \Base\Acl\Controller
    {
        function details()
        {
            return \RT::$auth->needed();
        }

        function log()
        {
            return \RT::$auth->needed();
        }

        function volunteers()
        {
            return \RT::$auth->needed();
        }

        function create()
        {
            return \RT::$auth->needed();
        }

        function save()
        {
            return \RT::$auth->needed();
        }

        function add_alt_contact()
        {
            return \RT::$auth->needed();
        }

        function add_volunteer()
        {
            return \RT::$auth->needed();
        }

        function browse_volunteers()
        {
            return \RT::$auth->needed();
        }

        function add_log()
        {
            return \RT::$auth->needed();
        }
    }

?>
