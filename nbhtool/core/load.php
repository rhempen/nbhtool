<?php

require('runtime.php');
require('db.php');
require('handler.php');
require('controller.php');
require('acl.php');
require('base.php');
require('3party.php');
require('validator.php');
require('tools.php');
require('exception.php');

require('controllers/auth.php');
require('controllers/error.php');

foreach (glob($GLOBALS['LIB_DIR']."models/*.php") as $filename)
{
    require($filename);
}

foreach (glob($GLOBALS['LIB_DIR']."params/*.php") as $filename)
{
    require($filename);
}

foreach (glob($GLOBALS['LIB_DIR']."controllers/*.php") as $filename)
{
    require($filename);
}

foreach (glob($GLOBALS['LIB_DIR']."layouts/*.php") as $filename)
{
    require($filename);
}


foreach (glob($GLOBALS['LIB_DIR']."auth/*.php") as $filename)
{
    require($filename);
}

foreach (glob($GLOBALS['LIB_DIR']."validator/*.php") as $filename)
{
    require($filename);
}

foreach (glob($GLOBALS['LIB_DIR']."tools/*.php") as $filename)
{
    require($filename);
}

?>
