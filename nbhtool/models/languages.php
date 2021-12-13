<?php namespace Table;

class Languages extends \Base\Table
{
    public $table_name = 'language';
    public $model = 'Model\Language';
    public $where = ['ORDER' => [
        'sort_override' => 'DESC',
        'text' => 'ASC'
    ]];
}

?>
