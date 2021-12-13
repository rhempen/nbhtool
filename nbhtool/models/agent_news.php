<?php namespace Table;

class AgentNews extends \Base\Table
{
    public $table_name = 'agent_news';
    public $unique = True;
    public $model = 'Model\AgentNewsEntry';
    public $where = ['AND' => ['show' => 1, 'OR' => ['agent_id' => '', 'agent_id' => 2]], 'ORDER' => ['agent_news.timestamp' => 'DESC']];
    public $join = [
        "[<]agent_dismissed_agent_news" => [ "id" => "agent_news_id" ],
    ];
}

?>
