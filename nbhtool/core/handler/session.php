<?php namespace Handler;

class Session
{
    public function __construct()
    {
        session_set_cookie_params(
            \RT::$config->get('session', 'cookie_lifetime') ?
                \RT::$config->get('session', 'cookie_lifetime') :
                0
        );
        session_start();
        if(!$this->is_session_valid())
        {
            $_SESSION = array();
            $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['sessionStart'] = time();
            $_SESSION['instanceId'] = (
                \RT::$config->get('session', 'instance_id') ?
                \RT::$config->get('session', 'instance_id') :
                undef
            );
            $_POST['newSession'] = 1;
        }
        return TRUE;
    }

    public function is_session_valid()
    {
        if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']) || !isset($_SESSION['instanceId']))
            return FALSE;

        if($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
            return FALSE;

        if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
            return FALSE;
        if(
            $_SESSION['instanceId'] !== (
                \RT::$config->get('session', 'instance_id') ?
                \RT::$config->get('session', 'instance_id') :
                ''
            )
        )
        {
            return FALSE;
        }
        if(
            $_SESSION['sessionStart'] + (
                \RT::$config->get('session', 'lifetime') ?
                \RT::$config->get('session', 'lifetime') :
                32400 ) < time())
        {
            return FALSE;
        }
        else
        {
            $_SESSION['sessionStart'] = time();
        }

        return TRUE;
    }

    public function get($name=NULL)
    {
        if(isset($name) && array_key_exists($name, $_SESSION))
        {
            return $_SESSION[$name];
        }
    }
}

?>
