<?php namespace Model;

class Person extends \Base\Record
{
    public $table_name = 'person';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'nationality_id' => [
            'type' => 'int',
            'required' => True,
            'default' => 0

        ],
        'gender_id' => [
            'type' => 'int',
            'required' => True,
            'default' => 0
        ],
        'title_id' => [
            'type' => 'int',
            'required' => True,
            'default' => 0
        ],
        'membership_id' => [
            'type' => 'int',
            'required' => True,
            'default' => 0
        ],
        'branch_id' => [
            'type' => 'int',
            'required' => True
        ],
        'firstname' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '20'],
        ],
        'lastname' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '20'],
        ],
        'organization' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '80'],
        ],
        'address_line1' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '80'],
        ],
        'address_line2' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '80'],
        ],
        'postbox' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '20'],
        ],
        'zip_code' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '80'],
        ],
        'city' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '80'],
        ],
        'country' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '80'],
        ],
        'email_address' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '45'],
        ],
        'phone_home' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '45'],
        ],
        'phone_work' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '45'],
        ],
        'phone_mobile' => [
            'type' => 'varchar',
            'type_args' => ['chars' => '45'],
        ],
        'date_of_birth' => [
            'type' => 'date',
        ],
        'timestamp' => [
            'type' => 'date',
            'required' => True,
            'default' => 'preset:time'
        ],
        'deleted' => [
            'type' => 'int',
            'required' => True,
            'default' => 0
        ],
    ];

    public function agent()
    {
        return new \Model\Agent(['person_id' => $this->field('id')->data()]);
    }

    public function volunteer()
    {
        if(!isset($this->volunteer))
        {
            $this->volunteer = new \Model\Volunteer(['person_id' => $this->field('id')->data()]);
        }
        return $this->volunteer;
    }

    public function client()
    {
        if(!isset($this->client))
        {
            $this->client = new \Model\Client(['person_id' => $this->field('id')->data()]);
        }
        return $this->client;
    }

    public function branch()
    {
        return new \Model\Branch($this->field('branch_id')->data());
    }

    public function membership()
    {
        return new \Model\Membership($this->field('membership_id')->data());
    }

    public function gender()
    {
        return new \Model\Gender($this->field('gender_id')->data());
    }

    public function nationality()
    {
        return new \Model\Nationality($this->field('nationality_id')->data());
    }

    public function title()
    {
        return new \Model\Title($this->field('title_id')->data());
    }

    public function account()
    {
        return new \Model\UserAccount(['person_id' => $this->field('id')->data()]);
    }

    public function role_short()
    {
        $role = 'p';
        if($this->agent()->is())
        {
            $role .= 'v';
        }
        if($this->client()->is())
        {
            $role .= 'k';
        }
        if($this->volunteer()->is())
        {
            $role .= 'f';
        }
        return $role;
    }

    public function display_name()
    {
        if($this->field('firstname')->data() || $this->field('lastname')->data())
        {
            $name = '';
            if($this->title()->field('text')->data())
            {
                $name .= $this->title()->field('text')->data();
            }
            if($this->field('firstname')->data())
            {
                $name .= $name !=='' ? ' ' : '';
                $name .= $this->field('firstname')->data();
            }
            if($this->field('lastname')->data())
            {
                $name .= $name !=='' ? ' ' : '';
                $name .= $this->field('lastname')->data();
            }
            if($this->field('organization')->data())
            {
                $name .= $name !=='' ? ' ' : '';
                $name .= "(".$this->field('organization')->data().")";
            }
            return $name;
        }
        else if($this->field('organization')->data())
        {
            return $this->field('organization')->data(); 
        }
        else
        {
            return 'Namenlose Person!';
        }
    }

    public function display_address_single_line()
    {
        $address_line = '';
        if($this->field('address_line1')->data())
        {
            $address_line .= $address_line !=='' ? ', ' : '';
            $address_line .= $this->field('address_line1')->data();
        }
        if($this->field('address_line2')->data())
        {
            $address_line .= $address_line !=='' ? ', ' : '';
            $address_line .= $this->field('address_line2')->data();
        }
        if($this->field('postbox')->data())
        {
            $address_line .= $address_line !=='' ? ', ' : '';
            $address_line .= $this->field('postbox')->data();
        }
        if($this->field('zip_code')->data())
        {
            $address_line .= $address_line !=='' ? ', ' : '';
            $address_line .= $this->field('zip_code')->data();
        }
        if($this->field('city')->data())
        {
            $address_line .= $address_line !=='' ? ' ' : '';
            $address_line .= $this->field('city')->data();
        }
        if($this->field('country')->data())
        {
            $address_line .= $address_line !=='' ? ', ' : '';
            $address_line .= $this->field('country')->data();
        }
        return $address_line;
    }

    public function gender_text($female, $male, $neutral)
    {
        if($this->gender()->field('text')->data() == 'Frau')
        {
            return $female;
        }
        elseif($this->gender()->field('text')->data() == 'Herr')
        {
            return $male;
        }
        else
        {
            return $neutral;
        }
    }

    public function languages()
    {
        $reltable = new \Table\Languages(
            ['person_id' => $this->field('id')->data()],
            ["[<]person_has_language" => ["id" => "language_id"]]
        );
        return $reltable;
    }

    public function is_deleted()
    {
        return $this->field('deleted')->data();
    }

    public function groups()
    {
        $reltable = new \Table\PersonHasGroups(
            ['person_id' => $this->field('id')->data()]
        );
        return is_array($reltable->get()) ? $reltable->get() : array();
    }

    public function add_to_group($person_group_id = NULL)
    {
        if(isset($person_group_id) && is_numeric($person_group_id))
        {
            $person_group_rel = new \Model\PersonHasGroup();
            $person_group_rel->field('person_id', $this->id());
            $person_group_rel->field('person_group_id', $person_group_id);
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

    public function remove_from_group($person_group_id = NULL)
    {
        if(isset($person_group_id) && is_numeric($person_group_id))
        {
            $person_group_rel = new \Model\PersonHasGroup(
                ['AND' =>
                    [
                        'person_id' => $this->id(),
                        'person_group_id' => $person_group_id
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
