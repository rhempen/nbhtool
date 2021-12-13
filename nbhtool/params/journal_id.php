<?php namespace Params;

class Journal_id extends \Base\Param
{
    public function acl($value = NULL)
    {
        if(
            isset($value) &&
            is_numeric($value)
        )
        {
            $result = \DB::$handle->select(
                'agent_work_journal', 
                [
                    "[>]agent" => [
                        "agent_id" => "id"
                    ],
                    "[>]branch_has_agent" => [
                        "agent.id" => "agent_id"
                    ]
                ],
                 "*",
                [
                    "AND" =>
                    [
                        'agent_work_journal.id' => $value,
                        'branch_has_agent.branch_id' => 
                            \RT::$auth->info()->person()->agent()->selected_branch()->field('id')->data()
                    ]
                ]
            );
            if($result === False)
            {
                return False; 
            }
            return count($result) > 0 ? True: False;
        }
        return False;
    }
}

?>
