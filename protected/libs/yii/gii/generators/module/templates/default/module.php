<?php echo "<?php\n"; ?>

class <?php echo $this->moduleClass; ?> extends WebModule
{	
	public static $active = false;


    public static function name()
    {
        return '';
    }


    public static function description()
    {
        return '';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'<?php echo $this->moduleID; ?>.models.*',
			'<?php echo $this->moduleID; ?>.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
        {
            return false;
        }
	}


    public static function adminMenu()
    {
        return array(
        	'Управление' => '/Admin/manage',
        	'Создать'    => '/Admin/create'
        );
    }
}
