<?php namespace Model;

class AgentNewsEntry extends \Base\Record
{
    public $table_name = 'agent_news';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'timestamp' => [
            'type' => 'date',
            'required' => true,
            'default' => 'preset:time'
        ],
        'subject' => [
            'type' => 'string',
            'default' => '',
            'required' => true
        ],
        'body' => [
            'type' => 'string',
            'default' => '',
            'required' => true
        ],
        'show' => [
            'type' => 'int',
            'default' => 1 
        ]
    ];
}
?>
