<?php namespace Handler;

class Layout
{
    function view($layout=FALSE)
    {
        if($layout === FALSE)
        {
            $layout = \RT::$config->get('layout', 'default') or "html" ;
        }
        $layout_class_name = "Layout\\".ucfirst($layout);
        if(!class_exists($layout_class_name))
        {
            print "<h1>Requested layout not defined.</h1>";
        }
        return new $layout_class_name();
    }
}

?>
