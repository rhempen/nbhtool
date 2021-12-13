<?php namespace Model;

class Log extends \Base\Record
{
    public $table_name = 'service_request_state_log';

    public $storable = True;

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'service_request_id' => [
            'type' => 'int',
            'required' => True
        ],
        'service_request_state_id' => [
            'type' => 'int',
            'required' => True
        ],
        'timestamp' => [
            'type' => 'int',
            'required' => True
        ],
        'note' => [
            'type' => 'text'
        ],
    ];

    public function person()
    {
        return new \Model\Person($this->field('person_id')->data());
    }

    public function state()
    {
        return new \Model\RequestState($this->field('service_request_state_id')->data());
    }

}

?>
