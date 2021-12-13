<?php namespace Auth\Database;
    class Provider extends \Base\Auth\Provider
    {
        private $info = NULL;
        private $error = '';
        private $username = NULL;

        public function login()
        {
            if(array_key_exists('username', $_POST) && array_key_exists('password', $_POST))
            {
                $user_info = array();
                if($_POST['password'] != '')
                {
                    $user_info = \DB::$handle->select(
                        'user_account',
                        ['id'],
                        [ 'AND' => [
                            'username' => htmlentities($_POST['username'], NULL, 'UTF-8'),
                            'password' => $this->gen_pw_hash($_POST['password'])
                            ]
                        ]
                    );
                }

                if(count($user_info) === 1)
                {
                    $info = new \Model\UserAccount($user_info[0]['id']);
                    if($info->person()->agent()->is())
                    {
                        $_SESSION['auth'] = TRUE;
                        $_SESSION['auth_ent_id'] = $user_info[0]['id'];
                        \DB::$handle->update(
                            'user_account',
                            ['last_login_timestamp' => time()],
                            ['id' => $user_info[0]['id']]
                        );
                        return TRUE;
                    }
                    else
                    {
                        return FALSE;
                    }
                }
                else
                {
                    unset($_SESSION['auth']);
                    unset($_SESSION['auth_ent_id']);
                    $this->error = 'Username oder Password nicht korrekt.';
                    return FALSE;
                }
            }
            else
            {
                return FALSE;
            }
        }

        public function check()
        {
            if(\RT::$session->get('auth'))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }

        public function role_agent()
        {
            if($this->info() && $this->info()->person()->agent()->is())
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }

        public function info()
        {
            if($this->check() && !$this->info)
            {
                $this->info = new \Model\UserAccount($_SESSION['auth_ent_id']);
            }
            return $this->info;
        }

        public function error()
        {
            return $this->error;
        }

        public function logout()
        {
            unset($_SESSION['auth']);
            unset($_SESSION['auth_ent_id']);
            return TRUE;
        }
        
        public function gen_pw_hash($password_cleartext = '')
        {
            return hash(\RT::$config->get('auth', 'pw_hash_algo'), $password_cleartext.\RT::$config->get('auth', 'pw_salt'));
        }

        public function post_actions()
        {
            $_POST['branch_id'] = $this->info()->person()->agent()->selected_branch()->field('id')->data();
            unset($_POST['password']);
            return True;
        }
    }
?>
