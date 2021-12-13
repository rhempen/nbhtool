<?php namespace Handler;

class Request
{
    private $controller = array();
    private $action = array();

    function __construct()
    {
        $this->parse_url();
    }

    private function parse_url()
    {
        $path_info = array_key_exists('PATH_INFO', $_SERVER) ? $_SERVER['PATH_INFO'] : '';
        preg_match("/\/(.*?)\/*$/i", $path_info, $matches);
        $uri_extras = 
            array_key_exists(1, $matches) ? 
                preg_split('/\/+/', $matches[1]) :
                array();
        if(
            array_key_exists(0, $uri_extras) &&
            preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $uri_extras[0])
        )
        {
            $this->controller(strtolower(urldecode($uri_extras[0])));
        }
        else
        {
            $this->controller('home');
        }
        if(
            array_key_exists(1, $uri_extras) &&
            preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $uri_extras[1])
        )
        {
            $this->action(strtolower(urldecode($uri_extras[1])));
        }
        else
        {
            $this->action('index');
        }

        if(array_key_exists(2, $uri_extras))
        {
            foreach(array_slice($uri_extras, 2) as $singleton)
            {
                if(preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $singleton))
                {
                    $_POST[$singleton] = 1;
                }
            }
        }
    }

    public function controller($name=NULL)
    {
        if(isset($name))
        {
            array_push($this->controller, $name);
        }
        return end($this->controller);
    }

    public function action($name=NULL)
    {
        if(isset($name))
        {
            array_push($this->action, $name);
        }
        return end($this->action);
    }

    public function origin_path()
    {
        return
            $this->template = sprintf('%s/%s/%s',
                $_SERVER['SCRIPT_NAME'],
                $this->controller[0],
                $this->action[0]
            );
    }

    public function path()
    {
        return
            $this->template = sprintf('%s/%s/%s',
                $_SERVER['SCRIPT_NAME'],
                end($this->controller),
                end($this->action)
            );
    }

}

?>
