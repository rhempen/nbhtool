<?php namespace Model;

class CLientLog extends \Base\Record
{
    public $table_name = 'client_state_log';

    public $storable = True;

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'client_id' => [
            'type' => 'int',
            'required' => True
        ],
        'client_state_id' => [
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
        $return = new \Model\ClientState($this->field('client_state_id')->data());
        return $return;
    }

}

?>
