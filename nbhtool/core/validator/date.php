<?php namespace Validator;

class Date extends \Base\Validator
{
    public $error_string = 'Falsches Datums Format';
    function validate()
    {
        if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $this->params_obj_ref->data()))
        {
            $this->set_param_error();
        }
    }
}
