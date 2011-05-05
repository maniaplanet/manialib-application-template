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
	protected $account;
	protected $tracking = false;
	protected $cookieNameSuffix;

	function __construct($trackingAccount = null, $cookieNameSuffix=null)
	{
		if($trackingAccount)
		{
			$this->account = $trackingAccount;
		}
		$this->cookieNameSuffix = $cookieNameSuffix;
	}

	function preFilter()
	{
		if(!$this->account)
		{
			$config = Config::getInstance();
			$this->account = $config->account;
		}

		if($this->account)
		{
			$this->tracker = new GoogleAnalytics($this->account, $this->cookieNameSuffix);
			$this->tracker->loadFromConfig();
			$this->tracker->loadCookie();
			$this->tracking = true;
			if(\ManiaLib\Session\Config::getInstance()->enabled)
			{
				$session = \ManiaLib\Session\Session::getInstance();
				$this->tracker->utmul = $session->get('lang', 'en');
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