<?php namespace Model;

class PersonHasGroup extends \Base\Record
{
    public $table_name = 'person_has_person_group';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'person_id' => [
            'type' => 'int',
            'required' => True
        ],
        'person_group_id' => [
            'type' => 'int',
            'required' => True
        ],
        'timestamp' => [
            'type' => 'date',
            'required' => true,
            'default' => 'preset:time'
        ]
    ];
    
    public function group()
    {
        return new \Model\PersonGroup($this->field('person_group_id')->data());
    }

    public function person()
    {
        return new \Model\Person($this->field('person_id')->data());
    }
}

?>
