<?php namespace Model;

class Agent extends \Base\Record
{
    public $table_name = 'agent';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'person_id' => [
            'type' => 'int',
            'required' => True
        ]
    ];

    public function branches()
    {
        $result = \DB::$handle->select(
            'branch_has_agent',
            'branch_id',
            [
                "AND" =>
                [
                    'agent_id' => $this->field('id')->data(),
                    'active' => 1
                ]
            ]
        );
        $return = array();
        foreach($result as $branch)
        {
            array_push($return, new \Model\Branch($branch));
        }
        return $return;
    }

    public function branches_all()
    {
        $result = \DB::$handle->select(
            'branch_has_agent',
            'branch_id',
            [
                'agent_id' => $this->field('id')->data(),
            ]
        );
        $return = array();
        foreach($result as $branch)
        {
            array_push($return, new \Model\Branch($branch));
        }
        return $return;
    }

    public function add_branch($branch_id=NULL)
    {
        if(isset($branch_id) && is_numeric($branch_id))
        {
            return \DB::$handle->insert(
                'branch_has_agent',
                [
                    'agent_id' => $this->id(),
                    'branch_id' => $branch_id,
                    'active' => 1,
                    'timestamp' => time()
                ]
            );
        }
        return FALSE;
    }

    public function has_branch($branch_id=NULL)
    {
        if(isset($branch_id) && is_numeric($branch_id))
        {
            foreach($this->branches() as $branch)
            {
                if($branch->field('id')->data() == $branch_id)
                {
                    return $branch;
                }
            }
        }
        return FALSE;
    }

    public function has_branch_all($branch_id=NULL)
    {
        if(isset($branch_id) && is_numeric($branch_id))
        {
            foreach($this->branches_all() as $branch)
            {
                if($branch->field('id')->data() == $branch_id)
                {
                    return $branch;
                }
            }
        }
        return FALSE;
    }

    public function select_branch($branch_id=NULL)
    {
        if(!$this->has_branch($branch_id))
        {
            return FALSE;
        }
        \DB::$handle->pdo->beginTransaction();
        \DB::$handle->update(
            'branch_has_agent',
            ['selected' => 0],
            [
                "AND" => [
                    'agent_id' => $this->field($this->id_field_name)->data(),
                ]
            ]
        );
        \DB::$handle->update(
            'branch_has_agent',
            ['selected' => 1],
            [
                "AND" => [
                    'agent_id' => $this->field($this->id_field_name)->data(),
                    'active' => '1',
                    'branch_id' => $branch_id
                ]
            ]
        );
        \DB::$handle->pdo->commit();
    }
    public function activate($branch_id=NULL)
    {
        if(!$this->has_branch_all($branch_id))
        {
            return FALSE;
        }
        return \DB::$handle->update(
            'branch_has_agent',
            ['active' => 1],
            [
                "AND" => [
                    'agent_id' => $this->field($this->id_field_name)->data(),
                    'branch_id' => $branch_id
                ]
            ]
        );
    }

    public function deactivate($branch_id=NULL)
    {
        if(!$this->has_branch($branch_id))
        {
            return FALSE;
        }
        return \DB::$handle->update(
            'branch_has_agent',
            ['active' => 0],
            [
                "AND" => [
                    'agent_id' => $this->field($this->id_field_name)->data(),
                    'branch_id' => $branch_id
                ]
            ]
        );
    }

    public function selected_branch()
    {
        $result = \DB::$handle->get(
            'branch_has_agent',
            'branch_id',
            [
                "AND" => [
                    'agent_id' => $this->field($this->id_field_name)->data(),
                    'selected' => '1',
                    'active' => '1',
                ]
            ]
        );
        If($result)
        {
            return new \Model\Branch($result);
        }
        else
        {
            return $this->branches()[0];
        }
    }

    public function person()
    {
        return new \Model\Person($this->field('person_id')->data());
    }

    public function active($branch_id)
    {
        if(!(isset($branch_id) && is_numeric($branch_id)))
        {
            $branch_id = $this->selected_branch();
        }
        $result = \DB::$handle->select(
            'branch_has_agent',
            'active',
            [
                'AND' =>
                [ 
                    'agent_id' => $this->field('id')->data(),
                    'branch_id' => $branch_id
                ]
            ]
        );
        return $result[0];
    }

    public function created($branch_id)
    {
        if(!(isset($branch_id) && is_numeric($branch_id)))
        {
            $branch_id = $this->selected_branch();
        }
        $result = \DB::$handle->get(
            'branch_has_agent',
            'timestamp',
            [
                'AND' =>
                [ 
                    'agent_id' => $this->field('id')->data(),
                    'branch_id' => $branch_id
                ]
            ]
        );
        return $result;
    }

    public function display_name()
    {
        return $this->person()->display_name();
    }

    public function news_inbox()
    {
        $reltable = new \Table\AgentNews();
        return is_array($reltable->get()) ? $reltable->get() : array();
    }
}

?>
