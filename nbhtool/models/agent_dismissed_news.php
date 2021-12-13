<?php namespace Table;

class AgentDismissedNews extends \Base\Table
{
    public $table_name = 'agent_dismissed_agent_news';
    public $model = 'Model\AgentDismissedAgentNewsEntry';
    public $where = ['ORDER' => [
        'timestamp' => 'DESC'
    ]];
    public $join = [];

}

?>
