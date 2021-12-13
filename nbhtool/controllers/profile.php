<?php

namespace Controller;

    class Profile extends \Base\Controller
    {
        function switch_branch()
        {
            \RT::$auth->info()->person()->agent()->select_branch(\RT::$params->get('branch')->data());
            \RT::$params->set(
                'branch_id',
                \RT::$auth->info()->person()->agent()->selected_branch()->field('id')
            );
            return \Layout\Html\Tools::redirect('home/index');
        }

        function change_pw()
        {

            if(
                \RT::$params->get('new_pw_2')->data() &&
                strlen(\RT::$params->get('new_pw_2')->data()) >= 8
            )
            {
                
                \RT::$auth->info()->person()->account()->change_password(
                    \RT::$params->get('new_pw_2')->data()
                );
                \Tools\Log::add('Vermittler/in hat sein/ihr Passwort gewechselt.', []);
            }
            else
            {
                \RT::$error->warn('Das Passwort wurde nicht ge&auml;ndert, da es nicht die minimale Zeichenl&auml;nge von 8 Zeichen einh&auml;lt'); 
            }
            return \Layout\Html\Tools::redirect('home/index/profile');
        }

        function index()
        {
            return \Layout\Html\Tools::redirect('home/index');
        }
    }

namespace Controller\Acl;
    class Profile extends \Base\Acl\Controller
    {
        function switch_branch()
        {
            return \RT::$auth->needed('agent');
        }

        function change_pw()
        {
            return \RT::$auth->needed();
        }

        function index()
        {
            return \RT::$auth->needed();
        }
    }

?>
