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
