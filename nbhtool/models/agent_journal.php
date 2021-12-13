<?php namespace Model;

class AgentJournal extends \Base\Record
{
    public $table_name = 'agent_work_journal';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'agent_id' => [
            'type' => 'int',
            'required' => True
        ],
        'branch_id' => [
            'type' => 'int',
            'required' => True
        ],
        'service_request_id' => [
            'type' => 'int'
        ],
        'client_id' => [
            'type' => 'int'
        ],
        'person_id' => [
            'type' => 'int'
        ],
        'volunteer_id' => [
            'type' => 'int'
        ],
        'person_group_id' => [
            'type' => 'int'
        ],
        'start' => [
            'type' => 'int'
        ],
        'end' => [
            'type' => 'int'
        ],
        'note' => [
            'type' => 'string',
            'default' => '' 
        ],
        'text' => [
            'type' => 'string',
            'default' => '' 
        ]
    ];


    public function duration()
    {
        if($this->field('end')->data() > $this->field('start')->data())
        {
            return $this->field('end')->data() - $this->field('start')->data();
        }
        else
        {
            return 0;
        }
    }

    public function person()
    {
        if(!isset($this->person))
        {
            $this->person = new \Model\Person(['id' => $this->field('person_id')->data()]);
        }
        return $this->person;
    }

    public function client()
    {
        if(!isset($this->client))
        {
            $this->client = new \Model\Client(['id' => $this->field('client_id')->data()]);
        }
        return $this->client;
    }

    public function group()
    {
        if(!isset($this->group))
        {
            $this->group = new \Model\PersonGroup(['id' => $this->field('person_group_id')->data()]);
        }
        return $this->group;
    }


    public function volunteer()
    {
        if(!isset($this->volunteer))
        {
            $this->volunteer = new \Model\Volunteer(['id' => $this->field('volunteer_id')->data()]);
        }
        return $this->volunteer;
    }

    public function request()
    {
        if(!isset($this->request))
        {
            $this->request = new \Model\Request(['id' => $this->field('service_request_id')->data()]);
        }
        return $this->request;
    }

    public function agent()
    {
        if(!isset($this->agent))
        {
            $this->agent = new \Model\Agent(['id' => $this->field('agent_id')->data()]);
        }
        return $this->agent;
    }
}

?>
