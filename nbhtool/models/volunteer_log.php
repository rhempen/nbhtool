<?php namespace Model;

class VolunteerLog extends \Base\Record
{
    public $table_name = 'volunteer_state_log';

    public $storable = True;

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'volunteer_id' => [
            'type' => 'int',
            'required' => True
        ],
        'volunteer_state_id' => [
            'type' => 'int',
            'required' => True
        ],
        'person_id' => [
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
        $return = new \Model\VolunteerState($this->field('volunteer_state_id')->data());
        return $return;
    }

}

?>
