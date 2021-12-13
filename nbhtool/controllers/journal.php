<?php

namespace Controller;

    class Journal extends \Base\Controller
    {
        function index()
        {
            if(\RT::$params->exists('addcomment'))
            {
                $journal_entry = new \Model\AgentJournal(\RT::$params->get('journal_id')->data());
                if($journal_entry->exists())
                {
                    $journal_entry->field('note', \RT::$params->get('journal_note')->data());
                    $journal_entry->store();
                }
                else
                {
                    \RT::$error->fatal('Der angeforderte Journaleintrag wurde nicht gefunden.');
                }
            }
            $branch_id = \RT::$params->get('branch_id')->data();
            $filter = ['AND' => ['branch_id' => $branch_id], 'ORDER' => ['start' => 'DESC']];
            if(\RT::$params->exists('filter_start_date'))
            {
                $start = strtotime(\RT::$params->get('filter_start_date')->data());
                $end = 0;
                if(!\RT::$params->exists('filter_end_date'))
                {
                    $end = strtotime(\RT::$params->get('filter_start_date')->data())+(24*60*60)-1;
                }
                else
                {
                    $end = strtotime(\RT::$params->get('filter_end_date')->data())+(24*60*60)-1;
                }
                $filter = ['AND' => ['branch_id' => $branch_id, 'start[>=]' => $start, 'start[<=]' => $end], 'ORDER' => ['start' => 'DESC']];
            }
            else
            {
                $start = strtotime(date('d.m.Y'));
                $end = $start + (24*60*60)-1;
                \RT::$params->set('filter_start_date', date('d.m.Y', $start));
                \RT::$params->set('filter_end_date', date('d.m.Y', $end));
                $filter = ['AND' => ['branch_id' => $branch_id, 'start[>=]'
                => $start, 'start[<=]' => $end], 'ORDER' => ['start' => 'DESC']];
            }
            $agent_journals_query = new \Table\AgentJournals();
            $agent_journal = $agent_journals_query->search($filter);
            $view = \RT::$layout->view();
            $view->value('agent_journal', $agent_journal);
            $view->value('filter_start_date', date('d.m.Y', $start));
            $view->value('filter_end_date', date('d.m.Y', $end));
            $view->render();
        } 

        function add()
        {
            $view = \RT::$layout->view();
            if(\RT::$params->exists('form_submit_journal'))
            {
                if(\RT::$params->exists('journal_text') && strlen(utf8_decode(\RT::$params->get('journal_text')->data())) > 0)
                {
                    \Tools\Log::add(
                        \RT::$params->get('journal_text')->data(),
                        array(),
                        \RT::$params->exists('start') ?
                        strtotime(\RT::$params->get('start')->data()) + (24*60*60)-1 :
                        0,
                        0
                    );
                    header('Location: '.\Layout\Html\Tools::url('journal/index/today'));
                }
                else
                {
                    \RT::$params->get('journal_text')->error('Es muss ein Text f&uuml;r diesen Journaleintrag erfasst werden.');
                    $view = \RT::$layout->view();
                    $view->render();
                    return True;
                }
            }
            $view->render();
        }
    }

namespace Controller\Acl;
    class Journal extends \Base\Acl\Controller
    {
        function index()
        {
            return \RT::$auth->needed('agent');
        }

        function add()
        {
            return \RT::$auth->needed('agent');
        }
    }

?>
