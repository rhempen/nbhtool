<?php namespace Controller;

function dispatch()
{
    $controller_class_name = "Controller\\".ucfirst(\RT::$request->controller());
    $action_function_name = \RT::$request->action();
    if(!class_exists($controller_class_name))
    {
        \RT::$error->fatal('Routed to undefined controller');
    }
    $current_controller = new $controller_class_name();
    if(!method_exists($current_controller, $action_function_name))
    {
        \RT::$error->fatal('Call to undefined action');
    }

    $current_controller->$action_function_name();
}

?>
