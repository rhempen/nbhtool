<?php namespace Validator;

class Timestamp extends \Base\Validator
{
    public $error_string = 'Kein korrekter Zeitpunkt eingegeben';

    function validate()
    {
        if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', $this->params_obj_ref->data))
        {
            $this->set_param_error();
        }
    }

}
