<?php namespace Controller;

    class Error extends \Base\Controller
    {
        function fatal()
        {
            \RT::$layout->view()->render();
        }

        function fatal_404()
        {
            \RT::$layout->view()->render();
        }
    }

namespace Controller\Acl;
    class Error extends \Base\Acl\Controller
    {
        function fatal()
        {
            return TRUE;
        }

        function fatal_404()
        {
            return TRUE;
        }
    }
?>
