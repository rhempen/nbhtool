<?php namespace Acl;

function verify($chain=FALSE)
{
    if($chain === FALSE)
    {
        print '<h1>No valid report about initialization.</h1>';
    }

    $controller_acl_class_name = "Controller\\Acl\\".ucfirst(\RT::$request->controller());
    $action_acl_function_name = \RT::$request->action();
    if(class_exists($controller_acl_class_name))
    {
        $current_acl_controller = new $controller_acl_class_name();
        if(method_exists($current_acl_controller, $action_acl_function_name))
        {
            if(!$current_acl_controller->$action_acl_function_name())
            {
                \RT::$error->fatal('Access to this router not granted: no reason provided or further action to be taken.');
                return False;
            }
        }
        else
        {
            if(\RT::$config->get('acl', 'strict_controllers'))
            {
                \RT::$error->fatal('Method not registered in the controllers acl class');
                return False;
            }
        }
    }
    else
    {
        if(\RT::$config->get('acl', 'strict_controllers'))
        {
            \RT::$error->fatal('No ACL found for targeted controller "'.\RT::$request->controller().'"');
            return False;
        }
    }
    verify_params();
    return True;
}

function verify_params()
{
    foreach($_GET as $request_var_name=>$request_var_data)
    {
        if(preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $request_var_name))
        {
            $param_obj = gen_param_obj($request_var_name, $request_var_data);
            if(\RT::$params->exists($request_var_name) === FALSE)
            {
                if($param_obj->acl($request_var_data))
                {
                    \RT::$params->set(
                        $request_var_name,
                        $param_obj
                    );
                }
                else
                {
                    \RT::$error->fatal('Request varable "'.$request_var_name.'" is out of scope or violates access rules.');
                }
            }
        }
    }
    foreach($_POST as $request_var_name=>$request_var_data)
    {
        if(preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $request_var_name))
        {
            $param_obj = gen_param_obj($request_var_name, $request_var_data);
            if(\RT::$params->exists($request_var_name) === FALSE)
            {
                if($param_obj->acl($request_var_data))
                {
                    \RT::$params->set(
                        $request_var_name,
                        $param_obj
                    );
                }
                else
                {
                    \RT::$error->fatal('Request varable "'.$request_var_name.'" is out of scope or violates access rules.');
                }
            }
        }
    }
    foreach($_SESSION as $request_var_name=>$request_var_data)
    {
        if(preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $request_var_name))
        {
            $param_obj = gen_param_obj($request_var_name, $request_var_data);
            if(\RT::$params->exists($request_var_name) === FALSE)
            {
                if($param_obj->acl($request_var_data))
                {
                    \RT::$params->set(
                        $request_var_name,
                        $param_obj
                    );
                }
                else
                {
                    \RT::$error->fatal('Request varable "'.$request_var_name.'" is out of scope or violates access rules.');
                }
            }
        }
    }
}

function gen_param_obj($varname=NULL, $vardata='')
{
    //going for the special param controller
    if(!isset($varname))
    {
        return FALSE;
    }
    $param_class_name = ucfirst(strtolower($varname));
    $param_class_namespace  = sprintf('\\Controller\\%s\\%s\\Params\\%s',
        ucfirst(\RT::$request->controller()),
        ucfirst(\RT::$request->action()),
        $param_class_name
    );

    if(class_exists($param_class_namespace))
    {
        return new $param_class_namespace($vardata, $varname);
    }

    //going for the common param controller
    $param_class_namespace  = sprintf('\\Params\\%s',
        $param_class_name
    );

    if(class_exists($param_class_namespace))
    {
        return new $param_class_namespace($vardata, $varname);
    }
    
    if(\RT::$config->get('acl','strict_parameters'))
    {
        \RT::$error->fatal('No param controller found for varable "'.$varname.'" while strict params ar set.');
    }
    else
    {
        //going for the base param controller
        $param_class_namespace  = '\\Base\\Param';

        if(class_exists($param_class_namespace))
        {
            return new $param_class_namespace($vardata, $varname);
        }
    }
}

?>
