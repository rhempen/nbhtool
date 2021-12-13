<?php namespace Params;

class Year extends \Base\Param
{
    public function acl($value = NULL)
    {
        if(
            isset($value) &&
            is_numeric($value) &&
            ($value >= date('Y') - 1 || $value <= date('Y'))
        )
        {
            return True;
        }
        else
        {
            return False;
        }
    }
}

?>
