<?php namespace Base;

class Param
{
    public $data = NULL;
    public $id = NULL;
    public $error = '';
    public $valid = TRUE;
    public $validator = NULL;

    public function __construct($data = NULL, $id='')
    {
        $this->id = htmlentities($id, NULL, 'UTF-8');
        $this->data($data);
    }

    public function validator($validator_obj = NULL)
    {
        $this->validator = $validator_obj;
    }

    public function acl($value)
    {
        return TRUE;
    }

    public function error($text=NULL)
    {
        if($text !== NULL)
        {
            $this->valid = False;
            $this->error = $text;
        }
        return $this->error;
    }

    public function is_valid()
    {
        return $this->valid;
    }

    public function is()
    {
        return isset($data);
    }

    public function data($data=NULL)
    {
        if($data !== NULL)
        {
            if(isset($data) && is_array($data))
            {
                $this->data = array();
                foreach($data as $element)
                {
                    array_push($this->data, htmlentities($element, NULL, 'UTF-8'));
                }
            }
            else
            {
                $this->data = $data;
            }
        }
        return $this->data;
    }

    public function view()
    {
        return htmlentities($this->data);
    }


    public function id()
    {
        return $this->id;
    }
}

?>
