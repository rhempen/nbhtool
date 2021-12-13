<?php namespace Model;

class AgentBranch extends \Base\Record
{
    public $table_name = 'branch_has_agent';

    public $fields = [
        'agent_id' => [
            'type' => 'int',
            'required' => True
        ],
        'branch_id' => [
            'type' => 'int',
            'required' => True
        ],
        'active' => [
            'type' => 'int',
            'required' => True
        ],
        'timestamp' => [
            'type' => 'int',
            'required' => True,
            'default' => 'preset:time'
        ],
    ];

    public function branch()
    {
        return new \Model\Branch($this->field('branch_id')->data());
    }

    public function agent()
    {
        return new \Model\Agent($this->field('agent_id')->data());
    }
}

?>
