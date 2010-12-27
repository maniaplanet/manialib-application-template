<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Base controller for the splash screen feature
 * Extends this controller in your app
 * 
 * Controller name should be "[..]_Controllers_Splashscreen"
 */
abstract class ManiaLib_Application_Splashscreen_Controller extends ManiaLib_Application_Controller
{
	protected function onConstruct()
	{
		$this->addFilter(new ManiaLib_Application_Filters_UserAgentCheck());
		$this->addFilter(new ManiaLib_Application_Filters_RegisterRequestParameters());
	}
	
	function index() 
	{
		$manialink = $this->request->createLink(Route::CUR, 'enter');
		
		$this->response->enterManialink = $manialink;
	}
	
	function enter()
	{
		$this->session->set(ManiaLib_Application_Splashscreen_Filter::SESSION_VARIABLE, 1);
		$this->request->redirectManialink(Route::NONE, Route::NONE);
	}
}
 
?>