<?php namespace Model;

class PersonGroup extends \Base\Record
{
    public $table_name = 'person_group';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'branch_id' => [
            'type' => 'int',
            'required' => True
        ],
        'timestamp' => [
            'type' => 'date',
            'required' => true,
            'default' => 'preset:time'
        ],
        'text' => [
            'type' => 'string',
            'default' => '' 
        ],
        'note' => [
            'type' => 'string',
            'default' => '' 
        ],
        'auto_add_new_volunteer' => [
            'type' => 'int',
            'default' => '' 
        ],
        'auto_add_new_client' => [
            'type' => 'int',
            'default' => '' 
        ],
        'auto_add_new_person' => [
            'type' => 'int',
            'default' => '' 
        ],
        'auto_add_new_agent' => [
            'type' => 'int',
            'default' => '' 
        ],
        'auto_add_new_active_member' => [
            'type' => 'int',
            'default' => '' 
        ],
        'auto_add_new_passive_member' => [
            'type' => 'int',
            'default' => '' 
        ]
    ];

    public function persons()
    {
        $reltable = new \Table\PersonHasGroups(
            ['person_group_id' => $this->field('id')->data()]
        );
        return $reltable->get();
    }

    public function display_name()
    {
        return $this->field('text')->data();
    }

    public function add_person($person_id = NULL)
    {
        if(isset($person_id) && is_numeric($person_id))
        {
            $person_group_rel = new \Model\PersonHasGroup();
            $person_group_rel->field('person_id', $person_id);
            $person_group_rel->field('person_group_id', $this->id());
            if($person_group_rel->store())
            {
                return True;
            }
            else
            {
                return False;
            }
        }
        return False;
    }

    public function auto_add_person($person_id = NULL)
    {
        if(isset($person_id) && is_numeric($person_id) && $this->field('auto_add_new_person')->data() == 1)
        {
            return $this->add_person($person_id);
        }
        return False;
    }

    public function auto_add_volunteer($person_id = NULL)
    {
        if(isset($person_id) && is_numeric($person_id) && $this->field('auto_add_new_volunteer')->data() == 1)
        {
            return $this->add_person($person_id);
        }
        return False;
    }

    public function auto_add_client($person_id = NULL)
    {
        if(isset($person_id) && is_numeric($person_id) && $this->field('auto_add_new_client')->data() == 1)
        {
            return $this->add_person($person_id);
        }
        return False;
    }

    public function auto_add_agent($person_id = NULL)
    {
        if(isset($person_id) && is_numeric($person_id) && $this->field('auto_add_new_agent')->data() == 1)
        {
            return $this->add_person($person_id);
        }
        return False;
    }

    public function auto_add_active_member($person_id = NULL)
    {
        if(isset($person_id) && is_numeric($person_id) && $this->field('auto_add_new_active_member')->data() == 1)
        {
            return $this->add_person($person_id);
        }
        return False;
    }

    public function auto_add_passive_member($person_id = NULL)
    {
        if(isset($person_id) && is_numeric($person_id) && $this->field('auto_add_new_passive_member')->data() == 1)
        {
            return $this->add_person($person_id);
        }
        return False;
    }

    public function remove_person($person_id = NULL)
    {
        if(isset($person_id) && is_numeric($person_id))
        {
            $person_group_rel = new \Model\PersonHasGroup(
                [ 'AND' =>
                    [
                        'person_id' => $person_id,
                        'person_group_id' => $this->id()
                    ]
                ]
            );
            if($person_group_rel->delete())
            {
                return True;
            }
            else
            {
                return False;
            }
        }
        return False;
    }
}
?>
