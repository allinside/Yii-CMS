<?php


abstract class WebModule extends CWebModule
{	
	public static $active = true;
	
    public static $base_module = false;

    public static abstract function name();

    public static abstract function description();

    public static abstract function version();

    protected  $_assetsUrl;

    
    public function assetsUrl()
    {
        if ($this->_assetsUrl === null)
        {
            $class = strtolower(str_replace('Module', '', get_class($this)));
            $path  = Yii::getPathOfAlias($class . '.assets');

            if ($path)
            {
                $this->_assetsUrl = Yii::app()->getAssetManager()->publish($path);
            }
        }
        
        return $this->_assetsUrl;
    }


    public static function activate($class)
    {
        $name = AppManager::getModuleNameByClass($class);

        $data_dir = MODULES_PATH . $name . '/data/';
        if (!is_dir($data_dir))
        {
            throw new Exception('Обязательная папка "data" отсутствует! <br/> Полный путь: ' . $data_dir);
        }

        $icons_dir = $_SERVER['DOCUMENT_ROOT'] . 'images/admin/modules/';
        if (!is_writable($icons_dir))
        {
            throw new Exception('Папка для иконок не доступна для записи! Полный путь: ' . $icons_dir);
        }

        $icon_file = $name .  '.png';
        $icon_path = $data_dir . $icon_file;
        if (!file_exists($icon_path))
        {
            throw new Exception('Отсутствует иконка модуля! <br/>Полный путь: ' . $icon_path);
        }

        $active_modules_file_path = AppManager::serializedActiveModulesFilePath();
        if (!is_writable($active_modules_file_path))
        {
            throw new Exception('Файл ' . $active_modules_file_path . ' не доступен для записи!');
        }


        copy($icon_path, $icons_dir . $icon_file);
        chmod($icons_dir . $icon_file, 0777);

        $create_dump_path = $data_dir . 'create.sql';
        if (file_exists($create_dump_path))
        {
            $dump = file_get_contents($create_dump_path);
            Yii::app()->db->createCommand($dump)->execute();
        }

        AppManager::addActiveModule($class);
    }


    public static function deactivate($class)
    {
        $name = AppManager::getModuleNameByClass($class);

        $icon_path = $_SERVER['DOCUMENT_ROOT'] . 'images/admin/modules/' . $name .  '.png';

        if (file_exists($icon_path))
        {
            unlink($icon_path);
        }

        $drop_dump_path = MODULES_PATH . $name . '/data/' . 'drop.sql';

        if (file_exists($drop_dump_path))
        {
            $dump = file_get_contents($drop_dump_path);

            try
            {
                Yii::app()->db->createCommand($dump)->execute();
            }
            catch (Exception $e) {}

        }

        AppManager::removeActiveModule($class);
    }
}
