<?php namespace Model;

class VolunteerJournal extends \Base\Record
{
    public $table_name = 'volunteer_work_journal';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'volunteer_id' => [
            'type' => 'int',
            'required' => True
        ],
        'service_request_id' => [
            'type' => 'int',
            'required' => True
        ],
        'start' => [
            'type' => 'int',
            'required' => True
        ],
        'end' => [
            'type' => 'int',
            'required' => True
        ],
        'private_car_km' => [
            'type' => 'int',
            'required' => True,
            'default' => 0
        ],
        'visit_count' => [
            'type' => 'int',
            'required' => True,
            'default' => 0
        ],
        'note' => [
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

    public function request()
    {
        return new \Model\Request($this->field('service_request_id')->data());
    }

}

?>
