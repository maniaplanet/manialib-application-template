<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Splash screen with "enter" button controller of our ManiaLib demo 
 */
 class ManiaLibDemo_Controllers_Splash extends ManiaLib_Application_Controller
 {
 	const SESSION_VARIABLE = 'splash_screen';
 	
 	protected function onConstruct()
	{
		$this->addFilter(new ManiaLib_Application_Tracking_Filter());
		$this->addFilter(new ManiaLib_Application_Filters_UserAgentCheck());
		$this->addFilter(new ManiaLib_Application_Filters_RegisterRequestParameters());
		$this->addFilter(new ManiaLibDemo_Filters_MoodSelector());
	}
	
	function index() 
	{
		$this->request->registerReferer();
	}
	
	function enter()
	{
		$this->session->set(self::SESSION_VARIABLE, 1);
		$this->request->redirectManialink('home', Route::NONE);
	}
 }
 
 ?>