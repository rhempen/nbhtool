<?php namespace Table;

class Nationalities extends \Base\Table
{
    public $table_name = 'nationality';
    public $model = 'Model\Nationality';
    public $storable = False;
    public $where = ['ORDER' => [
        'sort_override' => 'DESC',
        'text' => 'ASC'
    ]];
}

?>
