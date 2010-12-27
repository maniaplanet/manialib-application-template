<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Splash screen with "enter" button controller of our ManiaLib demo 
 */
class ManiaLibDemo_Controllers_Splashscreen extends ManiaLib_Application_Splashscreen_Controller 
{
	protected function onConstruct()
	{
		parent::onConstruct();
		$this->addFilter(new ManiaLibDemo_Filters_MoodSelector());
	}
}

?>