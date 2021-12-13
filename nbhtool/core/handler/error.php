<?php namespace Handler;

class Error
{
    private $error_stack = array();
    private $back_trace = array();
    private $sql_log = array();
    private $fatal = False;

    function warn($message)
    {
        array_push($this->error_stack, $message);
    }

    function fatal($message)
    {
        $this->fatal = True;
        array_push($this->error_stack, $message);
        if(\DB::$handle)
        {
            $this->sql_log = \DB::$handle->log();
        }
        $this->back_trace = debug_backtrace();
        if(\RT::$config->get('error', 'enable_email_report'))
        {
            $error_body = "\n";
            $error_body .= print_r($this->get_error_stack(), 1);
            $error_body .= "\n\n-------- BACK TRACE -----------\n\n";
            $error_body .= print_r(debug_backtrace(), 1);
            $error_body .= "\n\n--------- SQL LOG -------------\n\n";
            $error_body .= print_r(\DB::$handle->log(), 1);
            $error_body .= "\n\n--------- END OF DEBUG --------\n\n";

            $to_addr = \RT::$config->get('error', 'report_email_address') ?
            \RT::$config->get('error', 'report_email_address') :
            'root@localhost';
            $subj = \RT::$config->get('error', 'report_email_address') ?
            \RT::$config->get('error', 'report_email_address') :
            'Error in RT Application';
            mail(
                $to_addr,
                $subj,
                $error_body
            );
        }
        \RT::$request->controller('error');
        \RT::$request->action('fatal');
        \Controller\dispatch();
        exit(1);

    }
    function fatal_404()
    {
        array_push($this->error_stack, $message);
        \RT::$request->controller('error');
        \RT::$request->action('fatal_404');
        \Controller\dispatch();
        exit(1);

    }

    function get_error_stack()
    {
        return $this->error_stack;
    }

    function get_back_trace()
    {
        return $this->back_trace;
    }

    function get_sql_log()
    {
        return $this->sql_log;
    }

    function is_error()
    {
        if(count($this->error_stack) > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function is_error_fatal()
    {
        return $this->fatal;
    }
}

?>
