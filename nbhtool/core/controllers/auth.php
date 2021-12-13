<?php namespace Controller;

    class Auth extends \Base\Controller
    {
        function login()
        {
            \RT::$layout->view()->render();
        }

        function logout()
        {
            \RT::$auth->logout();
            \RT::$layout->view()->render();
        }
    }

namespace Controller\Acl;
    class Auth extends \Base\Acl\Controller
    {
        function login()
        {
            return TRUE;
        }
        function logout()
        {
            return TRUE;
        }
    }
?>
