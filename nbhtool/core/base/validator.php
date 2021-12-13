<?php namespace Base;

class Validator
{
    public $params_obj_ref = NULL;
    public $error_string = 'Keine korrekte Eingabe';

    public function __construct(&$params_obj_ref)
    {
        $this->params_obj_ref = $params_obj_ref;
    }

    public function set_param($name, $value)
    {
        $this->$name = $value;
    }

    public function set_param_error()
    {
        $this->params_obj_ref->error($this->error_string);
    }

    public function validate()
    {
        return True;
    }
}

?>
