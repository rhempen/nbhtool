<?php

class RT
{
    public static $error;
    public static $config;
    public static $request;
    public static $params;
    public static $session;
    public static $layout;
    public static $auth;

    public static function start()
    {
        self::$error = new \Handler\Error();
        self::$config = new \Handler\Config();
        self::$request = new \Handler\Request();
        self::$params = new \Handler\Params();
        self::$session = new \Handler\Session();
        self::$layout = new \Handler\Layout();
        self::$auth = new \Handler\Auth();
        \DB::init();
    }
}

?>
