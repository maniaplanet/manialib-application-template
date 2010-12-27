<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Tracking filter
 */
class ManiaLib_Application_Tracking_Filter implements ManiaLib_Application_Filterable
{
	/**
	 * @var ManiaLib_Application_Tracking_GoogleAnalytics
	 */
	protected $tracker;
	protected $tracking = false;
	
	function preFilter()
	{
		$config = ManiaLib_Config_Loader::$config;
		if($config->application->tracking instanceof Manialib_Application_Tracking_Config)
		{
			if($config->application->tracking->account)
			{
				$this->tracker = new ManiaLib_Application_Tracking_GoogleAnalytics();
				$this->tracker->loadFromConfig();
				$this->tracker->loadCookie();
				$this->tracking = true;
				if($config->session->enabled)
				{
					$session = ManiaLib_Application_Session::getInstance();
					$this->tracker->utmul = $session->get('lang', 'en');
				}
			}
		}
	}
	
	function postFilter() 
	{
		if($this->tracking)
		{
			$response = ManiaLib_Application_Response::getInstance();
			$response->trackingURL = $this->tracker->getTrackingURL();
			$response->registerView('ManiaLib_Application_Tracking_View');
		}
	}
}


?>