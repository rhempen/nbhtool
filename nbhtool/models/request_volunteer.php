<?php namespace Model;

class RequestVolunteer extends \Base\Record
{
    public $table_name = 'service_request_has_volunteer';

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
        'note' => [
            'type' => 'string',
        ],
        'start' => [
            'type' => 'int',
            'required' => True
        ],
        'end' => [
            'type' => 'int',
            'default' => 0
        ]
    ];

    public function volunteer()
    {
        return new \Model\Volunteer($this->field('volunteer_id')->data());
    }

    public function request()
    {
        return new \Model\Request($this->field('service_request_id')->data());
    }

    public function is_active()
    {
        if($this->field('end')->data() == 0)
        {
            return True;
        }
        else
        {
            return False;
        }
    }
}

?>
