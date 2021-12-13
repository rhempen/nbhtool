<?php namespace Table;

class UserAccounts extends \Base\Table
{
    public $table_name = 'user_account';
    public $model = 'Model\UserAccount';

    function user_exists($username = NULL)
    {
        if($username !== NULL)
        {
            return($this->search(['username' => $username]));
        }
    }
}

?>
