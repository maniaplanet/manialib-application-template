<?php
require_once(APP_MVC_FILTERS_PATH.'MoodSelectorFilter.class.php');
// TODO Autoload filters
class homeController extends ActionController
{
	protected $defaultAction = 'about';
	
	function __construct($controllerName)
	{
		parent::__construct($controllerName);
		$this->addFilter(new MoodSelectorFilter());
	}
	
	function about() 
	{
	}
	
	function features() 
	{
		$this->request->registerReferer();
	}
	
	function download() 
	{
		$this->request->registerReferer();
	}
	
	function showcase() 
	{
		$this->request->registerReferer();
	}
}

?>