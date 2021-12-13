<?php namespace Params;

class report_branch_id extends \Base\Param
{
    public function acl($value = NULL)
    {
        if(
            isset($value) &&
            is_numeric($value) &&
            \RT::$auth->info()->person()->agent() &&
            \RT::$auth->info()->person()->agent()->has_branch($value)
        )
        {
            return TRUE;
        }
        return FALSE;
    }
}

?>
