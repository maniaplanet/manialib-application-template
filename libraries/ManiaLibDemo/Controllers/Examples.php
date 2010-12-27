<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 */
class ManiaLibDemo_Controllers_Examples extends ManiaLib_Application_Controller
{
	protected $defaultAction = 'layouts';
	
	protected function onConstruct()
	{
		$this->addFilter(new ManiaLib_Application_Tracking_Filter());
		$this->addFilter(new ManiaLib_Application_Filters_UserAgentCheck());
		$this->addFilter(new ManiaLib_Application_Filters_RegisterRequestParameters());
		$this->addFilter(new ManiaLibDemo_Filters_MoodSelector());
		$this->addFilter(new ManiaLib_Application_Splashscreen_Filter());
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