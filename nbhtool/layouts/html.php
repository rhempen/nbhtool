<?php namespace Layout;

require($GLOBALS['LIB_DIR']."layouts/html/tools.php");

class Html extends \Base\Layout
{
    private $template = NULL;
    private $template_base_path = 'views/html';

    public function template($template_name=NULL)
    {
        if(isset($template_name))
        {
            $this->template = $template_name;
        }
        else
        {
            $this->template = sprintf('%s/%s',
                \RT::$request->controller(),
                \RT::$request->action()
            );
        }
        return $this->template;
    }

    public function render($template_name=NULL, $clean = false)
    {
        $this->template($template_name);

        if(is_array($this->value))
        {
            foreach($this->value as $__key => $__val)
            {
                $$__key = $__val;
            }
        }
        if($clean)
        {
            include($this->template_path());
        }
        elseif($this->template_path())
        {
            $view = $this->template_path();
            include($GLOBALS['LIB_DIR'].$this->template_base_path.".php");
        }
        else
        {
            print '<h1>Could not find the view, that has been defined for this the called action</h1>';
            exit;
        }
    }

    private function template_path()
    {
        if(!isset($this->template))
        {
            return FALSE;
        }
        $template_settings =
            \RT::$config->get('layout','html');
        if(
            is_array($template_settings) and
            array_key_exists('base_path', $template_settings)
        )
        {
            $this->template_base_path = $template_settings['base_path'];
        }
        $template_path = realpath($GLOBALS['LIB_DIR'].$this->template_base_path."/".$this->template.".php");
        if(is_readable($template_path) and is_file($template_path))
        {
            return $template_path;
        }
        else
        {
            return FALSE;
        }
    }
}

?>
