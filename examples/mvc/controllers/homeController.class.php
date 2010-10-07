<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

/**
 * Main controller of our ManiaLib demo 
 */
class homeController extends ActionController
{
	protected $defaultAction = 'about';
	
	function onConstruct()
	{
		$this->addFilter(new RegisterRequestParametersFilter());
		$this->addFilter(new MoodSelectorFilter());
		$this->addFilter(new ForceSplashScreenFilter());
	}
	
	function about() 
	{
		$this->request->registerReferer();
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