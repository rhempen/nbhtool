<?php namespace Validator;

class Varchar extends \Base\Validator
{
    private $chars = 45;
    public $error_string = 'Eingabe zu lang.';

    function validate()
    {
        if(!strlen($this-params_obj_ref()->data()) <= $this->chars)
        {
            $this->set_param_error();
        }
    }

}
