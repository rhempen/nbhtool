<?php namespace Validator;

class Intr extends \Base\Validator
{
    public $error_string = 'Darf nur Zahlen enthalten';

    function validate()
    {
        if(is_numeric($this->params_obj_data->data()) && $this->params_obj_data->data() <= 4294967295)
        {
            return True;
        }
        elseif(is_numeric($this->params_obj_data->data()) && $data <= 2147483647 && $this->params_obj_data->data() >= -2147483648)
        {
            return True;
        }
        $this->set_param_error();
    }

}
