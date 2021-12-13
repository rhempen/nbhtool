<?php namespace Params;

class Client_id extends \Base\Param
{
    public function acl($value = NULL)
    {
        if(
            isset($value) &&
            is_numeric($value)
        )
        {
            return (count(\DB::$handle->select(
                'client', 
                [
                    "[>]person" => [
                        "client.person_id" => "id"
                    ]
                ],
                 "*",
                [
                    "AND" =>
                    [
                        'client.id' => $value,
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
