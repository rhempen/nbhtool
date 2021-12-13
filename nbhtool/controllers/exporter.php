<?php

namespace Controller;

    class Exporter extends \Base\Controller
    {
        function excel()
        {
            $view = \RT::$layout->view('xlsx');
            $view->value('table_title', \RT::$params->get('export_table_title')->data());
            $view->value('table_file_name', \RT::$params->get('export_table_file_name')->data());
            $view->value('table_sheet_name', \RT::$params->get('export_table_sheet_name')->data());
            $view->value('table_data', unserialize(\RT::$params->get('export_table_data')->data()));
            $view->value('table_columns_filter', \RT::$params->get('export_table_columns')->data());
            $view->value('table_columns_name', unserialize(\RT::$params->get('export_table_columns_name')->data()));
            $view->value('table_timestamp_columns', unserialize(\RT::$params->get('export_table_timestamp_columns')->data()));
            $view->render();
        }
    }

namespace Controller\Acl;

    class Exporter extends \Base\Acl\Controller
    {
        function excel()
        {
            return \RT::$auth->needed();
        }
    }

?>
