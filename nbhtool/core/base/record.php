<?php namespace Base;

class Record
{
    public $fields_data = array();
    public $fields_data_obj = array();
    public $fields = array();
    public $error = '';
    public $id_field_name = 'id';
    public $exists = False;
    public $storable = True;

    public function __construct($search = NULL)
    {
        if(is_array($search))
        {
            $this->fields_data = \DB::$handle->get($this->table_name(),'*',$search);
        }
        else
        {
            $this->fields_data =
                \DB::$handle->get($this->table_name(),'*',[$this->id_field_name => $search]);
        }
        if($this->fields_data)
        {
            $this->exists = True;
            foreach($this->fields_data as $field_id => $field_data)
            {
                $this->fields_data_obj[$field_id] = new \Base\Param($field_data, $field_id);
            }
        }
        else
        {
            $this->exists = False;
        }
    }

    public function delete()
    {
        if(isset($this->storable))
        {
            if($this->field($this->id_field_name) && $this->field($this->id_field_name)->data())
            {
                \DB::$handle->delete($this->table_name(),[$this->id_field_name => $this->field($this->id_field_name)->data()]);
                if(\DB::$handle->error()[1])
                {
                    $this->error(\DB::$handle->error()[2]);
                    return False;
                }
            }
            else
            {
                \DB::$handle->delete($this->table_name(),['AND' => $this->raw()]);
                if(\DB::$handle->error()[1])
                {

                    $this->error(\DB::$handle->error()[2]);
                    return False;
                }
            }
            return True;
        }
        else
        {
            $this->error('This Model is not storable and yet deletable.');
            return False;
        }
    }

    public function store()
    {
        if(isset($this->storable))
        {
            if($this->field($this->id_field_name) && $this->field($this->id_field_name)->data())
            {
                if(\DB::$handle->update($this->table_name(),$this->raw(),[$this->id_field_name => $this->field($this->id_field_name)->data()]))
                {
                    return True;
                }
                else
                {
                    $this->error(\DB::$handle->error()[2]);
                    return False;
                }
            }
            else
            {
                if(\DB::$handle->insert($this->table_name(),$this->raw()))
                {
                    $insert_id =
                        \DB::$handle->id();
                }
                if(isset($insert_id) && is_numeric($insert_id))
                {
                    $this->field($this->id_field_name, $insert_id);
                    $this->exists = True;
                    return True;
                }
                $this->error(\DB::$handle->error()[2]);
                return False;
            }
        }
        $this->error('This Model is not storable yet.');
        return False;
    }

    public function table_name()
    {
        return $this->table_name;
    }

    public function exists()
    {
        return $this->exists;
    }

    public function is()
    {
        return $this->exists;
    }

    public function id()
    {
        if($this->exists())
        {
            return $this->field($this->id_field_name)->data();
        }
        else
        {
            return NULL;
        }
    }

    public function field_data($name)
    {
        if(is_string($name) && array_key_exists($name, $this->fields_data))
        {
            return $this->fields_data[$name];
        }
    }

    public function update_by_params($overwrites = array(), $params = array())
    {
        foreach($this->fields as $id => $values)
        {
            if(\RT::$params->exists($id))
            {
                if(is_array($params) && count($params) > 0)
                {
                    if(array_search($id, $params)) 
                    {
                        $this->fields_data_obj[$id] = \RT::$params->get($id);
                    }
                }
                else
                {
                    $this->fields_data_obj[$id] = \RT::$params->get($id);
                }
            }
            if(
                count($overwrites) > 0 &&
                array_key_exists($id, $overwrites)
            )
            {
                $this->fields_data_obj[$id] = new \Base\Param($overwrites[$id], $id);
            }
        }
    }

    public function field($name, $field_obj = NULL)
    {
        if(is_string($name) && isset($field_obj) && is_object($field_obj))
        {
            if(array_key_exists($name, $this->fields))
            {
                $this->fields_data_obj[$name] = $field_obj;

                return $this->fields_data_obj[$name];
            }
        }
        if(is_string($name) && isset($field_obj) && isset($field_obj))
        {
            if(array_key_exists($name, $this->fields))
            {
                $this->fields_data_obj[$name] = new \Base\Param($field_obj, $name);
            }
        }
        if(is_string($name) && array_key_exists($name, $this->fields_data_obj))
        {
            return $this->fields_data_obj[$name];
        }
        elseif(is_string($name) && array_key_exists($name, $this->fields))
        {
            if(array_key_exists('default', $this->fields[$name]))
            {
                return new \Base\Param($this->default_parse($this->fields[$name]['default']), $name);
            }
            else
            {
                return new \Base\Param(NULL, $name);
            }
        }
    }

    private function default_parse($value = NULL)
    {
        if($value !== NULL)
        {
            if($value === 'preset:time')
            {
                return time();
            }
            return $value;
        }
        return $value;
    }

    public function error($text=NULL)
    {
        if($text !== NULL)
        {
            $this->error = $text;
        }
        return $this->error;
    }

    public function raw()
    {
        $raw_data = array();
        foreach($this->fields as $id => $data)
        {
            $raw_data[$id] = $this->field($id)->data();
        }
        return $raw_data;
    }

    public function fields_obj()
    {
        return $this->fields_data_obj;
    }

    public function validate()
    {
        $data_valid = True;
        foreach($this->fields_data_obj as $id => $data_obj)
        {
            if(array_key_exists($id, $this->fields) && array_key_exists('type', $this->fields[$id]))
            {
                $global_validator_namespace =
                    "\\Validator\\".ucfirst($this->fields[$id]["type"]);
                if(class_exists($global_validator_namespace))
                {
                    $data_obj->validator(new $global_validator_namespace($data_obj));
                    if(array_key_exists('type_args', $this->fields[$id]))
                    {
                        foreach($this->fields[$id]['type_args'] as $param_key => $param_data)
                        {
                            $data_obj->validator->set_param($param_key, $param_value);
                        }
                    }
                }
            }
            else
            {
                $data_obj->validator(new \Validator\NoValidator($data_obj));
            }
            $data_obj->validator->validate();
            if(!$data_obj->is_valid)
            {
                $data_valid = False;
            }
        }
        return $data_valid;
    }

    public function display_name()
    {
        return $this->id() ? $this->id() : '';
    }
}

?>
