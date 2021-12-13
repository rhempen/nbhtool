<?php

namespace Controller;

    class Home extends \Base\Controller
    {
        function index()
        {
            $view = \RT::$layout->view();
            if(\RT::$auth->info()->person()->agent())
            {
                return \Layout\Html\Tools::redirect('dashboard/person');
            }
            else
            {
                \RT::$layout->view()->render();
            }
        }

        function help()
        {

            $view = \RT::$layout->view();
            $view->render();
        }
    }

namespace Controller\Acl;
    class Home extends \Base\Acl\Controller
    {
        function index()
        {
            return \RT::$auth->needed();
        }
    }

?>
