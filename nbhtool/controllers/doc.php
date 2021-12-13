<?php

namespace Controller;

    class Doc extends \Base\Controller
    {
        function index()
        {
            $view = \RT::$layout->view();
            $view->render();
        }

        function changelog()
        {
            $view = \RT::$layout->view();
            $view->render();
        }
    }

namespace Controller\Acl;
    class Doc extends \Base\Acl\Controller
    {
        function index()
        {
            return \RT::$auth->needed('agent');
        }

        function changelog()
        {
            return \RT::$auth->needed('agent');
        }
    }

?>
