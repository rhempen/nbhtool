<?php namespace Params;

class Volunteer_id extends \Base\Param
{
    public function acl($value = NULL)
    {
        if(
            isset($value) &&
            is_numeric($value)
        )
        {
            return (count(\DB::$handle->select(
                'volunteer', 
                [
                    "[>]person" => [
                        "volunteer.person_id" => "id"
                    ]
                ],
                 "*",
                [
                    "AND" =>
                    [
                        'volunteer.id' => $value,
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
