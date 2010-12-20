<?php

class ManiaLib_Application_Tracking_Filter implements ManiaLib_Application_Filterable
{
	/**
	 * @var ManiaLib_Application_Tracking_GoogleAnalytics
	 */
	protected $tracker;
	
	function preFilter()
	{
		$this->tracker = new ManiaLib_Application_Tracking_GoogleAnalytics();
		$this->tracker->loadFromConfig();
	}
	
	function postFilter() 
	{
		$response = ManiaLib_Application_Response::getInstance();
		$response->trackingURL = $this->tracker->getTrackingURL();
		$response->registerView('ManiaLib_Application_Tracking_View');
	}
}


?>