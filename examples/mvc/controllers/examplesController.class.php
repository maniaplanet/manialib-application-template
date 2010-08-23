<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

/**
 * A controller that hosts some example pages
 */
class examplesController extends ActionController
{
	protected $defaultAction = 'layouts';
	
	function __construct($controllerName)
	{
		parent::__construct($controllerName);
		$this->addFilter(new MoodSelectorFilter());
		$this->addFilter(new ForceSplashScreenFilter());
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