<<<<<<< HEAD
<?php
class Zend_framework{
	public function __construct()
	{
		set_include_path(implode(
		PATH_SEPARATOR,
		array(realpath(APPPATH.'third_party/Zend_framework'),
		get_include_path()))
		);
		
		require_once 'Zend/Loader/Autoloader.php';
		$autoloader = Zend_Loader_Autoloader::getInstance();
	}
}
=======
<?php
class Zend_framework{
	public function __construct()
	{
		set_include_path(implode(
		PATH_SEPARATOR,
		array(realpath(APPPATH.'third_party/Zend_framework'),
		get_include_path()))
		);
		
		require_once 'Zend/Loader/Autoloader.php';
		$autoloader = Zend_Loader_Autoloader::getInstance();
	}
}
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
