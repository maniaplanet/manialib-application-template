<?php

class ManiaLibDemo_Controllers_Home extends ManiaLib_Application_Controller
{
	protected $defaultAction = 'about';
	
	protected function onConstruct()
	{
		$this->addFilter(new ManiaLib_Application_Tracking_Filter());
		$this->addFilter(new ManiaLib_Application_Filters_UserAgentCheck());
		$this->addFilter(new ManiaLib_Application_Filters_RegisterRequestParameters());
		$this->addFilter(new ManiaLibDemo_Filters_MoodSelector());
		$this->addFilter(new ManiaLibDemo_Filters_SplashScreen());
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