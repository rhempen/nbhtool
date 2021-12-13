<?php namespace Layout\Html;

class Tools
{
    static function widget($widget_name, $vars = array())
    {
        if(is_array($vars))
        {
            foreach($vars as $key => $val)
            {
                $$key = $val;
            }
        }
        include($GLOBALS['LIB_DIR'].'/views/html/_widgets/'.$widget_name.'.php');
    }

    static function w_br($data = '')
    {
        if(is_string($data))
        {
            return preg_replace_callback('/\n/sm', function($matches) {return '<br />';}, $data);
        }
        else
        {
            return $data;
        }
    }

    static function w_br_enc($data = '')
    {
        if(is_string($data))
        {
            return preg_replace_callback('/\n/sm', function($matches) {return '<br />';}, htmlentities($data));
        }
        else
        {
            return '';
        }
    }

    static function enc($data = NULL)
    {
        if(isset($data) && is_string($data))
        {
            return htmlentities($data);
        }
        return $data;
    }

    static function web($static_path = NULL)
    {
        return \RT::$config->get('url', 'static').$static_path;
    }

    static function self_url($url_part = "", $get_string_array = array())
    {
        $self_url = \RT::$request->controller()."/".\RT::$request->action()."/".$url_part;
        return \Layout\Html\Tools::url($self_url, $get_string_array);
    }

    static function url($url_part, $get_string_array = array())
    {
        if($url_part === False)
        {
            return $_SERVER['SCRIPT_NAME']; 
        }
        $get_string = "";
        $get_var_total_count = count($get_string_array);
        if($get_var_total_count > 0)
        {
            $get_string = "?";
        }
        $get_var_count = 1;
        foreach($get_string_array as $key => $value)
        {
            $get_string .= sprintf('%s=%s', $key, $value);
            if($get_var_total_count > $get_var_count)
            {
                $get_string .= '&';
            }
            $get_var_count++;
        }
        return sprintf("%s/%s/%s", $_SERVER['SCRIPT_NAME'], $url_part, $get_string);
    }

    static function redirect($url_part, $get_string_array = array())
    {
        header('Location: '.\Layout\Html\Tools::url($url_part, $get_string_array));
        return True;
    }
}
