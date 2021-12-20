<?php namespace Model;

class Client extends \Base\Record
{
    public $table_name = 'client';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'person_id' => [
            'type' => 'int',
            'required' => True
        ],
        'note' => [
            'type' => 'string'
        ],
    ];

    public function person()
    {
        return new \Model\Person($this->field('person_id')->data());
    }

    public function current_state()
    {
        $result = \DB::$handle->get(
            'client_state_log',
            '*',
            [
                'client_id' => $this->id(),
                'ORDER' => ['timestamp' => 'DESC']
                
            ]
        );
        return new \Model\ClientLog($result['id']);
    }
    
    public function requests()
    {
        $result_obj = array();
        $result = \DB::$handle->select(
            'service_request',
            ['id'],
            ['client_id' => $this->field('id')->data()]
        );
        $this->error(\DB::$handle->error()[2]);
        if(is_array($result))
        {
            foreach($result as $request)
            {
                array_push($result_obj, new \Model\Request($request['id']));
            }
        }
        return $result_obj;
    }

    public function add_log($person_obj, $note = "", $client_state_id = 0, $timestamp = NULL)
    {
        if(!$timestamp)
        {
            $timestamp = time();
        }
        $log = new \Model\ClientLog();
        $log->field('client_id', $this->field('id')->data());
        $log->field('person_id', $person_obj->field('id')->data());
        $log->field('client_state_id', $client_state_id);
        $log->field('note', $note);
        $log->field('timestamp', $timestamp);
        $log->store();
        $this->error($log->error());
    }

    public function has_active_requests()
    {
        $active_requests = 0;
        foreach($this->requests() as $request)
        {
            if($request->current_state()->state()->id() < 3)
            {
                $active_requests++;
            }
        }
        return $active_requests;
    }

    public function had_active_request_in_year($year = NULL)
    {
        return 1;
    }
}

?>
