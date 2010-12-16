<?php

class ManiaLibDemo_Controllers_Examples extends ManiaLib_Application_Controller
{
protected $defaultAction = 'layouts';
	
	protected function onConstruct()
	{
		$this->addFilter(new ManiaLib_Application_Filters_UserAgentCheck());
		$this->addFilter(new ManiaLib_Application_Filters_RegisterRequestParameters());
		$this->addFilter(new ManiaLibDemo_Filters_MoodSelector());
		$this->addFilter(new ManiaLibDemo_Filters_SplashScreen());
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