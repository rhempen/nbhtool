<?php namespace Base;

class Table
{
    public $fields = array();
    public $error = '';
    public $where = array();
    public $join = array();
    public $id = 'id';
    public $unique = False;

    public function table_name()
    {
        return $this->table_name;
    }

    public function model()
    {
        return $this->model;
    }

    public function __construct($where = NULL, $join = NULL)
    {
        if(isset($where) && is_array($where))
        {
            $this->where = array_merge_recursive($this->where, $where);
        }
        if(isset($join) && is_array($join))
        {
            $this->join = array_merge_recursive($this->join, $join);
        }
        return True;
    }

    public function get()
    {
        return $this->search();
    }

    public function search($where=array(), $join=array(), $raw=False)
    {
        if(isset($where) && is_array($where))
        {
            $this->where = array_merge_recursive($this->where, $where);
        }
        if(isset($join) && is_array($join))
        {
            $this->join = array_merge_recursive($this->join, $join);
        }
        if($raw === True)
        {
            if(count($this->join) > 0)
            {
                $result = \DB::$handle->select(
                    $this->table_name(),
                    $this->join,
                    '*',
                    $this->where
                );
            }
            else
            {
                $result = \DB::$handle->select(
                    $this->table_name(),
                    '*',
                    $this->where
                );
            }
            if(!$result)
            {
                $this->error(\DB::$handle->error()[2]);
                return False;
            }
            return $result;
        } 
        else
        {
            if(count($this->join) > 0)
            {
                $result = \DB::$handle->select(
                    $this->table_name(),
                    $this->join,
                    [$this->table_name.".".$this->id],
                    $this->where
                );
            }
            else
            {
                $result = \DB::$handle->select(
                    $this->table_name(),
                    [$this->table_name.".".$this->id],
                    $this->where
                );
            }

            if(!is_array($result))
            {
                $this->error(\DB::$handle->error()[2]);
                return False;
            }
            $records = array();
            if($this->unique)
            {
                $result = array_unique($result);
            }
            foreach($result as $id)
            {
                array_push($records, new $this->model($id[$this->id]));
            }
            return $records;
        }
    }
    
    public function error($text=NULL)
    {
        if($text !== NULL)
        {
            $this->error = $text;
        }
        return $this->error;
    }
}

