<?php namespace Model;

class AgentDismissedAgentNewsEntry extends \Base\Record
{
    public $table_name = 'agent_dismissed_agent_news';

    public $fields = [
        'agent_news_id' => [
            'type' => 'int',
            'required' => True
        ],
        'agent_id' => [
            'type' => 'int',
            'required' => True
        ],
        'timestamp' => [
            'type' => 'int',
            'required' => True
        ]
    ];
}
?>
