<?php namespace Base;


class Layout 
{
    public $value = array();

    public function value($name, $value=NULL)
    {
        if(is_array($name))
        {
            $this->value = array_merge($this->value, $name);
        }
        else
        {
            if(isset($name) and preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name))
            {
                $this->value[$name] = $value;
            }
        }
        if(!is_array($name) and key_exists($name, $this->value))
        {
            return $value;
        }
    }

    public function render()
    {
        print "render the view!";
    }
}


?>
