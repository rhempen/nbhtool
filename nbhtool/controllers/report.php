<?php

namespace Controller;

    class Report extends \Base\Controller
    {
        function volunteers()
        {
            $selected_report_year = \RT::$params->exists('selected_report_year') ? \RT::$params->get('selected_report_year')->data() : date('Y');
            $start = new \DateTime(sprintf("1/1/%d 0:0:00", $selected_report_year));
            $end = new \DateTime(sprintf("12/31/%d 23:59:59", $selected_report_year));
            $volunteer_query = new \Table\Volunteers();
            $branch_id =
                \RT::$params->exists('report_branch_id') ?
                \RT::$params->exists('report_branch_id') :
                \RT::$params->get('branch_id')->data();

            $volunteers = $volunteer_query->search([ 'AND' => ['person.branch_id' => $branch_id]]);
            $volunteer_sum_report = array();
            $volunteer_monthly_report = array();
            $hours_report = array();
            $total_time = 0;
            $total_visits = 0;
            $total_km = 0;
            for($month = 1; $month <= 12; $month++)
            {
                $dt = \DateTime::createFromFormat('!m', $month);
                $volunteer_monthly_report[$month] = ['month' => $dt->format('F'), 'km' => 0, 'visits' => 0, 'time' => 0];
            }
            foreach($volunteers as $volunteer)
            {
                $time = 0;
                $km = 0;
                $visits = 0;
                foreach($volunteer->work_journal() as $journal_entry)
                {
                    if(
                        $journal_entry->field('start')->data() >= $start->getTimestamp() && $journal_entry->field('start')->data() < $end->getTimestamp()
                    )
                    {
                        $dateinfo = getdate($journal_entry->field('start')->data());
                        $time += $journal_entry->duration();
                        $km += $journal_entry->field('private_car_km')->data();
                        $visits += $journal_entry->field('visit_count')->data();
                        $volunteer_monthly_report[$dateinfo['mon']]['km'] +=
                        $journal_entry->field('private_car_km')->data();
                        $volunteer_monthly_report[$dateinfo['mon']]['visits'] += $journal_entry->field('visit_count')->data();
                        $volunteer_monthly_report[$dateinfo['mon']]['time'] += $journal_entry->duration() / 60 /60 ;
                    }
                }
                $total_visits += $visits;
                $total_km += $km;
                $total_time += $time;
                array_push($volunteer_sum_report, [
                    'name' => $volunteer->person()->display_name(),
                    'time' => $time/60/60,
                    'km' => $km,
                    'car_model' => $volunteer->field('car_model')->data(),
                    'branch' => $volunteer->person()->branch()->field('name')->data(),
                    'car_register_number' => $volunteer->field('car_register_number')->data(),
                    'visits' => $visits
                ]);
            }

            $view = \RT::$layout->view();
            $view->value('selected_report_year', $selected_report_year);
            $view->value('volunteer_sum_report', $volunteer_sum_report);
            $view->value('volunteer_monthly_report', $volunteer_monthly_report);
            $view->value('total_time', $total_time);
            $view->value('total_visits', $total_visits);
            $view->value('total_km', $total_km);
            $view->render();
        } 

        function requests()
        {
            $selected_report_year = \RT::$params->exists('selected_report_year') ? \RT::$params->get('selected_report_year')->data() : date('Y');
            $start = new \DateTime(sprintf("1/1/%d 0:0:00", $selected_report_year));
            $end = new \DateTime(sprintf("12/31/%d 23:59:59", $selected_report_year));
            $request_query = new \Table\Requests();
            $volunteer_query = new \Table\Volunteers();
            $branch_id =
                \RT::$params->exists('report_branch_id') ?
                \RT::$params->exists('report_branch_id') :
                \RT::$params->get('branch_id')->data();

            $requests = $request_query->search([ 'AND' => ['branch_id' => $branch_id]]);
            $categories = $request_query->search([ 'AND' => ['branch_id' => $branch_id]]);
            $volunteers = $volunteer_query->search([ 'AND' => ['person.branch_id' => $branch_id]]);
            $service_table = new \Table\Services();
            $services = $service_table->search(['parent_service_id' => NULL]);
            $request_monthly_report = array();
            $request_yearly_total = 0;
            $request_yearly_work_total = 0;
            $request_monthly_work_report = array();
            foreach($services as $service)
            {
                $request_monthly_report[$service->field('text')->data()] = [
                    'service' => $service->field('text')->data(),
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 0,
                    12 => 0,
                    'total' => 0,
                    'total_precent' => 0
                ];
                $request_monthly_work_report[$service->field('text')->data()] = [
                    'service' => $service->field('text')->data(),
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 0,
                    12 => 0,
                    'total' => 0,
                    'total_precent' => 0
                ];
            }
            foreach($requests as $request)
            {
                if(date('Y', $request->first_state()->field('timestamp')->data()) === $selected_report_year)
                {
                    $request_monthly_report[$request->service()->field('text')->data()][date('n', $request->first_state()->field('timestamp')->data())]++;
                    $request_monthly_report[$request->service()->field('text')->data()]['total']++;
                    $request_yearly_total++;
                }
            }

            foreach($volunteers as $volunteer)
            {
                $journal = $volunteer->work_journal();
                foreach($journal as $journal_entry)
                {
                    if($journal_entry->field('start')->data() >= $start->getTimestamp() && $journal_entry->field('start')->data() < $end->getTimestamp())
                    {
                        $request_monthly_work_report[$journal_entry->request()->service()->field('text')->data()][date('n',
                        $journal_entry->field('start')->data())] += $journal_entry->duration()/60/60;
                        $request_monthly_work_report[$journal_entry->request()->service()->field('text')->data()]['total'] += $journal_entry->duration()/60/60;
                        $request_yearly_work_total += $journal_entry->duration()/60/60;
                    }
                }
            }

            foreach(array_keys($request_monthly_report) as $request_monthly_report_key)
            {
                if($request_yearly_total > 0)
                {
                    $request_monthly_report[$request_monthly_report_key]['total_precent'] =
                    round($request_monthly_report[$request_monthly_report_key]['total']
                    / $request_yearly_total * 100);
                }
                else
                {
                    $request_monthly_report[$request_monthly_report_key]['total_precent'] = 0;
                }

                if($request_yearly_work_total > 0)
                {
                    $request_monthly_work_report[$request_monthly_report_key]['total_precent'] =
                    round($request_monthly_work_report[$request_monthly_report_key]['total']
                    / $request_yearly_work_total * 100);
                }
                else
                {
                    $request_monthly_work_report[$request_monthly_report_key]['total_precent'] = 0;
                }
            }
            
            //Collection Data for second report

            $established_request_monthly_report = array();
            $established_request_yearly_total = 0;

            foreach($services as $service)
            {
                $established_request_monthly_report[$service->field('text')->data()] = [
                    'service' => $service->field('text')->data(),
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 0,
                    12 => 0,
                    'total' => 0,
                    'total_precent' => 0
                ];
            }
            $log_entry_prev = Null;
            foreach($requests as $request)
            {
                foreach($request->log() as $log_entry)
                {
                    if($log_entry->field('service_request_state_id')->data() == 2)
                    {
                        if(date('Y', $log_entry->field('timestamp')->data()) === $selected_report_year)
                        {
                            if($log_entry_prev && $log_entry_prev->field('service_request_state_id')->data() != 2)
                            {
                                $established_request_monthly_report[$request->service()->field('text')->data()][date('n', $log_entry->field('timestamp')->data())]++;
                                $established_request_monthly_report[$request->service()->field('text')->data()]['total']++;
                                $established_request_yearly_total++;
                                break;
                            }
                        }
                    }
                }
                $log_entry_prev = $log_entry;
            }

            foreach(array_keys($established_request_monthly_report) as $established_request_monthly_report_key)
            {
                if($established_request_yearly_total > 0)
                {
                    $established_request_monthly_report[$established_request_monthly_report_key]['total_precent'] =
                    round($established_request_monthly_report[$established_request_monthly_report_key]['total']
                    / $established_request_yearly_total * 100);
                }
                else
                {
                    $established_request_monthly_report[$established_request_monthly_report_key]['total_precent'] = 0;
                }
            }
            $view = \RT::$layout->view();
            $view->value('selected_report_year', $selected_report_year);
            $view->value('request_monthly_report', $request_monthly_report);
            $view->value('request_yearly_total', $request_yearly_total);
            $view->value('request_monthly_work_report', $request_monthly_work_report);
            $view->value('request_yearly_work_total', $request_yearly_work_total);
            $view->value('established_request_monthly_report', $established_request_monthly_report);
            $view->value('established_request_yearly_total', $established_request_yearly_total);
            $view->render();
        }
    }

namespace Controller\Acl;
    class Report extends \Base\Acl\Controller
    {
        function volunteers()
        {
            return \RT::$auth->needed('agent');
        }

        function requests()
        {
            return \RT::$auth->needed('agent');
        }
    }

?>
