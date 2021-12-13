<?php namespace Handler;

class Params
{
    public $params = array();

    public function set($name=NULL,$obj=NULL)
    {
        if(isset($name) and is_object($obj))
        {
            $this->params[$name] = $obj;
        }
    }

    public function delete($name=NULL)
    {
        if(isset($name))
        {
            if(array_key_exists($name, $this->params))
            {
                unset($this->params[$name]);
            }
            if(array_key_exists($name, $_SESSION))
            {
                unset($_SESSION[$name]);
            }
        }
    }

    public function flush_all()
    {
        $_SESSION = array();
        $_GET = array();
        $_POST = array();
    }


    public function store($name=NULL,$obj=NULL)
    {
        if(isset($name))
        {
            if(is_object($obj))
            {
                $this->params[$name] = $obj;
                $_SESSION[$name] = $obj->data();
            }
            elseif(array_key_exists($name, $this->params))
            {
                $_SESSION[$name] = $this->params[$name]->data();
            }
        }
    }

    public function get($name=NULL)
    {
        if(isset($name))
        {
            if(array_key_exists($name, $this->params))
            {
                return $this->params[$name];
            }
        }
        return new \Base\Param(NULL, $name);
    }

    public function exists($name=NULL)
    {
        if(isset($name))
        {
            if(array_key_exists($name, $this->params))
            {
                return TRUE;
            }
        }
        return FALSE;
    }
}

?>
