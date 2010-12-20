<?php

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
				$this->tracking = true;
				ManiaLib_Log_Logger::info('tracking');
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