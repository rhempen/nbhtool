<?php namespace Params;

class Request_id extends \Base\Param
{
    public function acl($value = NULL)
    {
        if(
            isset($value) &&
            is_numeric($value)
        )
        {
            return (count(\DB::$handle->select(
                'service_request', [
                    "[><]client" => [
                        "service_request.client_id" => "id"
                    ],
                    "[><]person" => [
                        "client.person_id" => "id"
                    ],
                 ],
                 "*",
                 [
                    "AND" =>
                    [
                        'service_request.id' => $value,
                        'person.branch_id' => 
                            \RT::$auth->info()->person()->agent()->selected_branch()->field('id')->data()
                    ]
                 ]
            )) > 0 ? True: False);
        }
        return False;
    }
}

?>
