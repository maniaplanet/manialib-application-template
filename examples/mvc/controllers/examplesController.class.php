<?php
require_once(APP_MVC_FILTERS_PATH.'MoodSelectorFilter.class.php');

class examplesController extends ActionController
{
	protected $defaultAction = 'layouts';
	
	function __construct($controllerName)
	{
		parent::__construct($controllerName);
		$this->addFilter(new MoodSelectorFilter());
	}
	
	function layouts() 
	{
		$this->request->registerReferer();
	}
	
	function tracks() 
	{
		$this->request->registerReferer();
	}
}

?>