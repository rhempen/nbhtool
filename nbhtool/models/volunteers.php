<?php namespace Table;

class Volunteers extends \Base\Table
{
    public $table_name = 'volunteer';
    public $model = 'Model\Volunteer';
    public $join =  [
        "[>]person" => ['person_id' => 'id']
    ];
    public $id = 'id';
    public $where = [
        'AND' => [ 'deleted' => 0 ],
        'ORDER' => [ 'lastname' => 'ASC' ]
    ];
}

?>
