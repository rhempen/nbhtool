<?php namespace Validator;

class Text extends \Base\Validator
{
    public $error_string = 'Kann nur Text enthalten';

    function validate()
    {
        if(is_string($this->params_obj_data->data()))
        {
            return True;
        }
        $this->set_param_error();
    }

}
