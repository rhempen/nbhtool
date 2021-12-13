<?php namespace Table;

class Persons extends \Base\Table
{
    public $table_name = 'person';
    public $model = 'Model\Person';
    public $where = [
        'AND' => [ 'deleted' => 0 ],
        'ORDER' => [ 'lastname' => 'ASC' ]
    ];

    public function search_clients($where=array(), $raw=False)
    {
        if(is_array($where))
        {
            if($raw === True)
            {
                $result = \DB::$handle->select($this->table_name(), [">client" => ['id' => 'person_id']], '*', $where);
                if(\DB::$handle->error()[2] !== NULL)
                {
                    $this->error(\DB::$handle->error()[2]);
                    return False;
                }
                return $result;
            } 
            else
            {
                $result = \DB::$handle->select($this->table_name(), ["[<]client" => ['person.id' => 'person_id']], ['person.id'] , $where);
                if(\DB::$handle->error()[2] !== NULL)
                {
                    $this->error(\DB::$handle->error()[2]);
                    return False;
                }
                $records = array();
                foreach($result as $id)
                {
                    array_push($records, new $this->model($id['id']));
                }
                return $records;
            }
        }
        $this->error('Bad where statement given to select records');
    }

    public function search_volunteers($where=array(), $raw=False)
    {
        if(is_array($where))
        {
            if($raw === True)
            {
                $result = \DB::$handle->select($this->table_name(), [">volunteer" => ['id' => 'person_id']], '*', $where);
                if(\DB::$handle->error()[2] !== NULL)
                {
                    $this->error(\DB::$handle->error()[2]);
                    return False;
                }
                return $result;
            } 
            else
            {
                $result = \DB::$handle->select($this->table_name(), [">volunteer" => ['id' => 'person_id']], ['id'], $where);
                if(\DB::$handle->error()[2] !== NULL)
                {
                    $this->error(\DB::$handle->error()[2]);
                    return False;
                }
                $records = array();
                foreach($result as $id)
                {
                    array_push($records, new $this->model($id['id']));
                }
                return $records;
            }
        }
        $this->error('Bad where statement given to select records');
    }


}

?>
