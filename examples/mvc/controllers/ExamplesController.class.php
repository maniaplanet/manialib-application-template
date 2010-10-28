<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

/**
 * A controller that hosts some example pages
 */
class ExamplesController extends ActionController
{
	protected $defaultAction = 'layouts';
	
	protected function onConstruct()
	{
		$this->addFilter(new RegisterRequestParametersFilter());
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