<?php namespace Model;

class UserAccount extends \Base\Record
{
    public $table_name = 'user_account';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'person_id' => [
            'type' => 'int',
            'required' => True
        ],
        'active' => [
            'type' => 'int',
            'required' => True,
            'default' => 1
        ],
        'last_login_timestamp' => [
            'type' => 'int',
            'required' => False
        ],
        'username' => [
            'type' => 'string',
            'required' => True,
            'default' => '' 
        ]
    ];


    public function person()
    {
        return new \Model\Person($this->field('person_id')->data());
    }

    public function change_password($password_cleartext = NULL)
    {
        if(isset($password_cleartext) && is_string($password_cleartext))
        {
            return \DB::$handle->update(
                $this->table_name(),
                [
                    'password' => hash(
                        \RT::$config->get('auth', 'pw_hash_algo'),
                        $password_cleartext.\RT::$config->get('auth', 'pw_salt')
                     ),
                     'pw_change_timestamp' => time()
                ],
                [ 
                    'id' => $this->field('id')->data()
                ]
            );
        }
    }
}

?>
