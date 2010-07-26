<?php
/**
 * @author Maxime Raoust
 * @copyright NADEO
 */

/**
 * Main controller of our ManiaLib demo 
 */
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