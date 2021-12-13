<?php namespace Handler;

class Auth 
{
    private $provider = NULL;

    public function __construct()
    {
        $controller_auth_class_name = "Auth\\".(
            \RT::$config->get('auth', 'provider') ?
            ucfirst(\RT::$config->get('auth', 'provider')) :
            'None'
            )."\\Provider";

        if(!class_exists($controller_auth_class_name))
        {
            print '<h1>Auth Provider not found</h1>';
        }
        $this->provider = new $controller_auth_class_name();
    }

    public function needed($role = NULL)
    {
        if(!$this->check())
        {
            \RT::$params->flush_all();
            \RT::$request->controller('auth');
            \RT::$request->action('login');
            return TRUE;
        }
        $this->provider->post_actions();
        if($role === NULL)
        {
            return TRUE;
        }
        $role_func_name = sprintf('role_%s', $role);
        if(isset($role) && $this->provider->$role_func_name())
        {
            return TRUE;
        }
        else
        {
            \RT::$params->flush_all();
            \RT::$request->controller('auth');
            \RT::$request->action('login');
        }
        
    }

    public function check()
    {
        if(\RT::$session->is_session_valid())
        {
            if($this->provider->check())
            {
                return TRUE;
            }
            elseif($this->provider->login())
            {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function logout()
    {
        $this->provider->logout();
        $_SESSION = array();
        session_destroy();
    }

    public function error()
    {
        if($this->provider->error())
        {
            return $this->provider->error();
        }
    }

    public function info()
    {
        return $this->provider->info();
    }
}
