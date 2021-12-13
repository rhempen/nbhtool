<?php namespace Table;

class PersonHasGroups extends \Base\Table
{
    public $table_name = 'person_has_person_group';
    public $model = 'Model\PersonHasGroup';
    public $where = ['ORDER' => [
        'text' => 'ASC',
        'lastname' => 'ASC'
    ]];
    public $join = [
        "[>]person_group" => [ "person_group_id" => "id" ],
        "[>]person" => [ "person_id" => "id" ],
    ];
}

?>
