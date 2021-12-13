<?php namespace Table;

class AgentBranches extends \Base\Table
{
    public $table_name = 'branch_has_agent';
    public $model = 'Model\AgentBranch';

    function agent_for_branch($branch_id = NULL)
    {
        $objects = array();
        if(isset($branch_id) && is_numeric($branch_id))
        {
            $result = \DB::$handle->select(
                $this->table_name(),
                '*',
                ['branch_id' => $branch_id]
            );
            foreach($result as $record)
            {
                array_push($objects, new \Model\AgentBranch([ 'AND' => ['branch_id' => $record['branch_id'], 'agent_id' => $record['agent_id']]]));
            }
        }
        return $objects;
    }
}

?>
