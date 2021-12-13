<?php namespace Model;

class Volunteer extends \Base\Record
{
    public $table_name = 'volunteer';

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
            'type' => 'string',
        ],
        'profession' => [
            'type' => 'string',
        ],
        'availability' => [
            'type' => 'string',
        ],
        'car_register_number' => [
            'type' => 'string',
        ],
        'car_model' => [
            'type' => 'string',
        ]
    ];

    public function person()
    {
        return new \Model\Person($this->field('person_id')->data());
    }

    public function requests()
    {
        $reltable = new \Table\Requests(
            ['volunteer_id' => $this->field('id')->data()],
            ["[>]service_request_has_volunteer" => ["id" => "service_request_id"]]
        );
        return $reltable;
    }

    public function request_relations()
    {
        $reltable = new \Table\RequestVolunteers(
            ['volunteer_id' => $this->field('id')->data()]
        );
        return $reltable;
    }

    public function work_journal($request_id = NULL)
    {
        if(isset($request_id))
        {
            $journal_query = new \Table\VolunteerJournals();
            return $journal_query->search([
            'AND' => [
                'volunteer_id' => $this->id(),
                'service_request_id' => $request_id,
            ],
            'ORDER' => ['start' => 'DESC']
            ]);
        }
        else
        {
            $journal_query = new \Table\VolunteerJournals();
            return $journal_query->search([
                'volunteer_id' => $this->id(),
                'ORDER' => ['start' => 'DESC']
            ]);
        }
    }

    public function services()
    {
        $service_query = new \Table\VolunteerServices();
        $result_array = array();
        $result = $service_query->search(['volunteer_id' => $this->id()], [], True);
        if(!$result)
        {
            return array();
        }
        foreach($result as $record)
        {
            array_push($result_array, new \Model\VolunteerService(
            ['AND' => [
                'service_id' => $record['service_id'],
                'volunteer_id' => $record['volunteer_id']
                ]
            ]));
        }
        return $result_array;
    }

    public function log()
    {
        $result_obj = array();
        $result = \DB::$handle->select(
            'volunteer_state_log',
            ['id'],
            ['volunteer_id' => $this->field('id')->data(), 'ORDER' => ['timestamp' => 'DESC']]
        );
        $this->error(\DB::$handle->error()[2]);

        if(is_array($result))
        {
            foreach($result as $log)
            {
                array_push($result_obj, new \Model\VolunteerLog($log['id']));
            }
        }
        return $result_obj;
    }

    public function current_state()
    {
        $result = \DB::$handle->get(
            'volunteer_state_log',
            '*',
            [
                'volunteer_id' => $this->id(),
                'ORDER' => ['timestamp' => 'DESC']
                
            ]
        );
        return new \Model\VolunteerLog($result['id']);
    }

    public function add_log($person_obj, $note = "", $volunteer_state_id = 0, $timestamp = NULL)
    {
        if(!$timestamp)
        {
            $timestamp = time();
        }
        $log = new \Model\VolunteerLog();
        $log->field('volunteer_id', $this->field('id')->data());
        $log->field('person_id', $person_obj->field('id')->data());
        $log->field('volunteer_state_id', $volunteer_state_id);
        $log->field('note', $note);
        $log->field('timestamp', $timestamp);
        $log->store();
        $this->error($log->error());
    }

    public function is()
    {
        if($this->exists && $this->current_state()->state()->id() != 3)
        {
            return True;
        }
        else
        {
            return False;
        }
    }

    public function is_asignable()
    {
        if($this->exists && $this->current_state()->state()->id() != 3 && $this->current_state()->state()->id() != 1)
        {
            return True;
        }
        else
        {
            return False;
        }
    }

    public function services_struct()
    {
            $volunteer_service_list = array();
            foreach($this->services() as $service)
            {
                if($service->service()->parent_service() !== NULL)
                {
                    $volunteer_service_list[$service->service()->parent_service()->id()]['sub_services'][$service->service()->id()]
                        = $service->service();
                }
                else
                {
                    $volunteer_service_list[$service->service()->id()]['service'] = $service->service();
                }
            }
            return $volunteer_service_list;
    }

    public function sub_services()
    {
            $volunteer_service_list = array();
            foreach($this->services() as $service)
            {
                if($service->service()->parent_service() !== NULL)
                {
                    $volunteer_service_list[] = $service;
                }
            }
            return $volunteer_service_list;
    }
}

?>
