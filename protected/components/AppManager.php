<?php
 
class AppManager
{
    public static function getModulesData($active = null, $check_allowed_links = false)
    {
        $modules = array();

        $modules_dirs = scandir(MODULES_PATH);
        foreach ($modules_dirs as $ind => $module_dir)
        {
            if ($module_dir[0] == '.')
            {
                continue;
            }

            $module_class = ucfirst($module_dir) . 'Module';
            $module_path  = MODULES_PATH . $module_dir . '/' . $module_class . '.php';

            if (!file_exists($module_path))
            {
                continue;
            }

            require_once $module_path;

            $vars = get_class_vars($module_class);

            if ($active !== null)
            {	
            	if (!array_key_exists('active', $vars)) 
            	{
        			continue;
            	}
            	
				if ($active && !$vars['active']) 
				{
					continue;
				}
            }

            $module = array(
                'description' => call_user_func(array($module_class, 'description')),
                'version'     => call_user_func(array($module_class, 'version')),
                'name'        => call_user_func(array($module_class, 'name')),
                'class'       => $module_class,
                'dir'         => $module_dir
            );

            if (method_exists($module_class, 'adminMenu'))
            {
                $module['admin_menu'] = call_user_func(array($module_class, 'adminMenu'));

                if ($check_allowed_links)
                {   
                    foreach ($module['admin_menu'] as $title => $url)
                    {
                        list($module_name, $controller, $action) = explode('/', trim($url, '/'));

                        $auth_item = ucfirst($controller) . '_' . $action;

                        if (!Yii::app()->controller->checkAccess($auth_item))
                        {
                            unset($module['admin_menu'][$title]);
                        }
                    }                    
                }
            }

            $modules[$module_class] = $module;
        }

        return $modules;
    }
    
    
    public function getModuleActions($module_class, $use_admin_prefix = false) 
    {
        $actions = array();
    
        $controllers_dir = MODULES_PATH . strtolower(str_replace('Module', '', $module_class)) . '/controllers/';
        
        $controllers = scandir($controllers_dir);
        foreach ($controllers as $controller) 
        {
            if ($controller[0] == ".") 
            {
                continue;
            }

            $class = str_replace('.php', '', $controller); 
            if (!class_exists($class, false)) 
            {   
                require_once $controllers_dir . $controller;
            }
            
            $reflection = new ReflectionClass($class);
            
            $actions_titles = call_user_func(array($class, 'actionsTitles'));
           
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC); 
            foreach ($methods as $method) 
            {   
                if (in_array($method->name, array('actionsTitles', 'actions')) || mb_substr($method->name, 0, 6, 'utf-8') != 'action') 
                {
                    continue;
                }
                
                $action = str_replace('action', '', $method->name);
                
                $action_name = str_replace('Controller', '', $class) . '_' . $action;

				$title = isset($actions_titles[$action]) ? $actions_titles[$action] : ""; 					
				if ($title && $use_admin_prefix && strpos($action_name, "Admin_") !== false) 
				{
					$title.= " (админка)";		
				}				
	
                $actions[$action_name] = $title;
            }
            
        } 
        
        return $actions;
    }
    
    
    public function getActionModule($action) 
    {
        $controller_file = array_shift(explode("_", $action)) . "Controller.php";
        
        $modules_dirs = scandir(MODULES_PATH);   
        foreach ($modules_dirs as $dir) 
        {
            if ($dir[0] == ".") 
            {
                continue;
            }
            
            $controllers = scandir(MODULES_PATH . "/" . $dir . "/controllers");
            
            if (in_array($controller_file, $controllers)) 
            {
                return ucfirst($dir) . "Module";
            }
        }
    }
}





































