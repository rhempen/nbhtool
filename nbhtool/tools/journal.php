<?php namespace Tools;

class Log extends \Base\Tools
{
    static function add($note = '', $subjects = array(), $start = NULL, $duration = 0)
    {
        $person_id = NULL;
        $service_request_id = NULL;
        $volunteer_id = NULL;
        $client_id = NULL;
        $group_id = NULL;
        if(is_array($subjects))
        {
            foreach($subjects as $subject)
            {
                if(is_a($subject, 'Model\Client'))
                {
                    $client_id = $subject->id();
                }
                if(is_a($subject, 'Model\Request'))
                {
                    $service_request_id = $subject->id();
                }
                if(is_a($subject, 'Model\Volunteer'))
                {
                    $volunteer_id = $subject->id();
                }
                if(is_a($subject, 'Model\Person'))
                {
                    $person_id = $subject->id();
                }
                if(is_a($subject, 'Model\PersonGroup'))
                {
                    $group_id = $subject->id();
                }
            }
        }
        $start_time = isset($start) && is_numeric($start) ? $start : time();
        $new_journal_entry = new \Model\AgentJournal();
        $new_journal_entry->field('text', $note);
        $new_journal_entry->field('start', $start_time);
        $new_journal_entry->field('end', $start_time+$duration);
        $new_journal_entry->field('agent_id', \RT::$auth->info()->person()->agent()->id());
        $new_journal_entry->field('branch_id', \RT::$params->get('branch_id')->data());
        $new_journal_entry->field('person_id', $person_id );
        $new_journal_entry->field('client_id', $client_id );
        $new_journal_entry->field('person_group_id', $group_id );
        $new_journal_entry->field('volunteer_id', $volunteer_id);
        $new_journal_entry->field('service_request_id', $service_request_id);
        $new_journal_entry->store();
        return True;
    }

}

?>
