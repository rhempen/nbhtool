<?php namespace Validator;

class NoValidator extends \Base\Validator
{
    public $error_string = 'Keine korrekte Eingabe, daten konnten nicht validiert werden';

    function validate()
    {
        $this->set_param_error();
    }

}
