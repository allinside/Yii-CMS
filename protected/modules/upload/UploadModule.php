<?php
class UploadModule extends WebModule
{

    public function init()
    {
        $this->setImport(array(
            'upload.components.*',
            'upload.models.*'
        ));
    }


    public static function name()
    {
        return 'Загрузчик файлов';
    }

    public static function description()
    {
        return 'Добавляет возможность использования HTML5 загрузчика. Используется для создания своих модулей.';
    }

    public static function version()
    {
        return '2.0';
    }
}