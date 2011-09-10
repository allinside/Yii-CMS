<?php

if (substr($_SERVER['DOCUMENT_ROOT'], -1) != '/')
{
    $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'].'/';
}

define("PROTECTED_PATH", $_SERVER["DOCUMENT_ROOT"] . "protected/");
define("MODULES_PATH", $_SERVER["DOCUMENT_ROOT"] . "protected/modules/");
define("LIBRARY_PATH", PROTECTED_PATH . "libs/");

$yii    = LIBRARY_PATH . 'yii/yii.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);

defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

ini_set("display_errors", 1);
error_reporting(E_ALL);

$config = $_SERVER['DOCUMENT_ROOT'] . 'protected/config/' . getenv("APP_ENV") . '.php';

require_once($yii);

$session = new CHttpSession;
$session->open();

Yii::createWebApplication($config)->run();


function p($data)
{
    echo "<pre>". print_r($data, 1) . "</pre>";
}

function v($data)
{
    echo "<pre>". var_dump($data) . "</pre>";
}


?>

