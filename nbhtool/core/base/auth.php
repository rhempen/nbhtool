<?php namespace Base\Auth;

class Provider
{
    public $user = NULL;

    public function login()
    {
        die('Method login must be implemented by the login() method!');
    }

    public function logout()
    {
        die('Method logout must be implemented by the logout() method!');
    }

    public function info()
    {
        die('Method check must be implemented by the info() method!');
    }

    public function post_actions()
    {
        return True;
    }
}

namespace Auth\None;
    class Provider extends \Base\Auth\Provider {}
?>
