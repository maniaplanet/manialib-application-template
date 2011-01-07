<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Application\Tracking;

/**
 * Tracking filter
 */
class Filter implements \ManiaLib\Application\Filterable
{
	/**
	 * @var \ManiaLib\Application\Tracking\GoogleAnalytics
	 */
	protected $tracker;
	protected $tracking = false;
	
	function preFilter()
	{
		$config = \ManiaLib\Config\Loader::$config;
		if($config->application->tracking instanceof Config)
		{
			if($config->application->tracking->account)
			{
				$this->tracker = new GoogleAnalytics();
				$this->tracker->loadFromConfig();
				$this->tracker->loadCookie();
				$this->tracking = true;
				if($config->session->enabled)
				{
					$session = \ManiaLib\Session\Session::getInstance();
					$this->tracker->utmul = $session->get('lang', 'en');
				}
			}
		}
	}
	
	function postFilter() 
	{
		if($this->tracking)
		{
			$response = \ManiaLib\Application\Response::getInstance();
			$response->trackingURL = $this->tracker->getTrackingURL();
			$response->registerView('\ManiaLib\Application\Tracking\View');
		}
	}
}


?>