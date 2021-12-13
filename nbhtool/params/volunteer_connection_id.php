<?php namespace Params;

class Volunteer_connection_id extends \Base\Param
{
    public function acl($value = NULL)
    {
        if(
            isset($value) &&
            is_numeric($value)
        )
        {
            $connection = new \Model\RequestVolunteer($value);
            if($connection)
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
                            'volunteer.id' => $connection->volunteer()->id(),
                            'branch_id' => 
                                \RT::$auth->info()->person()->agent()->selected_branch()->field('id')->data()
                        ]
                    ]
                )) > 0 ? True: False);
            }
        }
        return False;
    }
}

?>
