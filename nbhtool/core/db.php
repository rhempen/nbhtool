<?php

class DB
{
    public static $handle = NULL;

    public static function init()
    {
        self::$handle = new \Medoo\Medoo([
            'database_type' => 
                \RT::$config->get('db', 'type') ?
                \RT::$config->get('db', 'type') :
                'mysql',
            'database_name' => \RT::$config->get('db', 'name'),
            'server' => 
                \RT::$config->get('db', 'server') ?
                \RT::$config->get('db', 'server') :
                'localhost',
            'username' =>
                \RT::$config->get('db', 'username') ?
                \RT::$config->get('db', 'username') :
                'root',
            'password' =>
                \RT::$config->get('db', 'password') ?
                \RT::$config->get('db', 'password') :
                '',
            'charset' =>
                \RT::$config->get('db', 'charset') ?
                \RT::$config->get('db', 'charset') :
                'utf8',
        ]);
        if(self::$handle === false)
        {
            print '<h1>Could not connect to the database</h1>';
        }
    }
}

?>
