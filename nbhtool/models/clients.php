<?php namespace Table;

class Clients extends \Base\Table
{
    public $table_name = 'client';
    public $model = 'Model\Client';
    public $join =  [
        "[>]person" => ['person_id' => 'id']
    ];
    public $where = [
        'AND' => [ 'deleted' => 0 ],
        'ORDER' => [ 'lastname' => 'ASC' ]
    ];
    public $id = 'id';
}

?>
