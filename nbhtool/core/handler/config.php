<?php namespace Handler;

class Config
{
    private $config_struct = array();

    function __construct()
    {
        $json_config_string = file_get_contents($GLOBALS['CONF_DIR'].'main.json');
        $this->config_struct = json_decode($json_config_string, TRUE);
    }

    public function get($section_name=NULL, $value_name=NULL)
    {
        if(!isset($section_name))
        {
            return NULL;
        }
        if(!is_array($this->config_struct) or !array_key_exists($section_name, $this->config_struct))
        {
            return NULL;
        }
        if(!isset($value_name))
        {
            return $this->config_struct[$section_name];
        }
        if(
            !is_array($this->config_struct[$section_name]) or
            !array_key_exists($value_name, $this->config_struct[$section_name])
        )
        {
            return NULL;
        }
        return $this->config_struct[$section_name][$value_name];
    }
}

?>
