<?php namespace Params;

class Contact_person_id extends \Base\Param
{
    public function acl($value = NULL)
    {
        if(
            isset($value) &&
            is_numeric($value)
        )
        {
            return (count(\DB::$handle->select(
                'person', 
                 "*",
                 [
                    "AND" =>
                    [
                        'id' => $value,
                        'branch_id' => 
                            \RT::$auth->info()->person()->agent()->selected_branch()->field('id')->data()
                    ]
                 ]
            )) > 0 ? True: False);
        }
        return False;
    }
}

?>
