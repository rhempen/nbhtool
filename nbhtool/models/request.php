<?php namespace Model;

class Request extends \Base\Record
{
    public $table_name = 'service_request';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'service_id' => [
            'type' => 'int',
            'required' => True
        ],
        'client_id' => [
            'type' => 'int',
            'required' => True
        ],
        'branch_id' => [
            'type' => 'int',
            'required' => True
        ],
        'contact_person_id' => [
            'type' => 'int',
        ],
        'note' => [
            'type' => 'text'
        ],
    ];

    public function add_log($person_obj, $note = "", $service_request_state_id = 0, $timestamp = NULL)
    {
        if(!$timestamp)
        {
            $timestamp = time();
        }
        \DB::$handle->insert(
            'service_request_state_log',
            [
                'service_request_id' => $this->field('id')->data(),
                'person_id' => $person_obj->field('id')->data(),
                'service_request_state_id' => $service_request_state_id,
                'note' => $note,
                'timestamp' => $timestamp
            ]);
        $this->error(\DB::$handle->error()[2]);
    }

    public function client()
    {
        return new \Model\Client($this->field('client_id')->data());
    }

    public function volunteers($return_closed = False)
    {
        $volunteer_query = new \Table\RequestVolunteers();
        if($return_closed)
        {
            $volunteer_list =  $volunteer_query->search([
                'service_request_id' => $this->field('id')->data()
            ]);

        }
        else
        {
            $volunteer_list =  $volunteer_query->search([
                'AND' => ['service_request_id' => $this->field('id')->data(),
                'end' => 0]
            ]);
        }
        return $volunteer_list;
    }

    public function add_volunteer($volunteer_id)
    {
        $result = \DB::$handle->insert(
            'service_request_has_volunteer',
            [
                'volunteer_id' => $volunteer_id,
                'service_request_id' => $this->field('id')->data(),
                'start' => time(),
                'end' => 0
            ]
        );
        $this->error(\DB::$handle->error()[2]);
    }

    public function stop_volunteer_connection($volunteer_connection_id)
    {
        $result = \DB::$handle->update(
            'service_request_has_volunteer',
            [
                'end' => time()
            ],
            [
                'id' => $volunteer_connection_id
            ]
        );
        $this->error(\DB::$handle->error()[2]);
    }


    public function log()
    {
        $result_obj = array();
        $result = \DB::$handle->select(
            'service_request_state_log',
            ['id'],
            ['service_request_id' => $this->field('id')->data(), 'ORDER' => ['timestamp' => 'DESC']]
        );
        $this->error(\DB::$handle->error()[2]);

        if(is_array($result))
        {
            foreach($result as $log)
            {
                array_push($result_obj, new \Model\Log($log['id']));
            }
        }
        return $result_obj;
    }

    public function current_state()
    {
        $result = \DB::$handle->get(
            'service_request_state_log',
            '*',
            [
                'service_request_id' => $this->field('id')->data(),
                'ORDER' => ['timestamp' => 'DESC']
            ]
        );
        return new \Model\Log($result['id']);
    }

    public function first_state()
    {
        $result = \DB::$handle->get(
            'service_request_state_log',
            '*',
            [
                'service_request_id' => $this->field('id')->data(),
                'ORDER' => ['timestamp' => 'ASC']
            ]
        );
        return new \Model\Log($result['id']);
    }

    public function service()
    {
        return new \Model\Service($this->field('service_id')->data());
    }

    public function contact_person()
    {
        return new \Model\Person($this->field('contact_person_id')->data());
    }

    public function sub_services()
    {
        $result_obj = array();
        $result = \DB::$handle->select(
            'service_request_sub_services',
            ['service_id'],
            ['service_request_id' => $this->field('id')->data()]
        );
        $this->error(\DB::$handle->error()[2]);
        if(is_array($result))
        {
            foreach($result as $sub_service)
            {
                array_push($result_obj, new \Model\Service($sub_service['service_id']));
            }
        }
        return $result_obj;
    }

    public function add_sub_services($sub_services_id=array())
    {
        if(is_array($sub_services_id))
        { 
            foreach($sub_services_id as $sub_service_id)
            {
                $result = \DB::$handle->insert(
                    'service_request_sub_services',
                    [
                        'service_request_id' => $this->field('id')->data(),
                        'service_id' => $sub_service_id
                    ]
                );
            }
            $this->error(\DB::$handle->error()[2]);
        }
        return true;
    }
}

?>
