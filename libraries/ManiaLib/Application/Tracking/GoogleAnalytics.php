<?php

/**
 * Google Analytics tracking in Manialinks
 */
class ManiaLib_Application_Tracking_GoogleAnalytics
{
	const GA_TRACKING_URL = 'http://www.google-analytics.com/__utm.gif';
	
	/**
	 * @var string
	 */
	protected $trackingURL;
	/**
	 * @var ManiaLib_Gui_Elements_Quad
	 */
	protected $trackingQuad;
	
	/**
	 * Urchin version
	 */
	protected $utmwv = '4.8.6';
	/**
	 * Hostname
	 */
	protected $utmhn;
	/**
	 * Charsert
	 */
	protected $utmcs = 'UTF-8';
	/**
	 * Screen resolution
	 */
	protected $utmsr = '-';
	/**
	 * Color-depth
	 */
	protected $utmsc = '-';
	/**
	 * Language
	 */
	protected $utmul;
	/**
	 * Java enabled
	 */
	protected $utmje = 0;
	/**
	 * Flash version
	 */
	protected $utmfl = 0;
	/**
	 * Random
	 */
	protected $utmhid;
	/**
	 * Referer
	 */
	protected $utmr = 0;
	/**
	 * Route
	 */
	protected $utmp;
	/**
	 * Google Analytics account
	 */
	protected $utmac;
	/**
	 * Random
	 */
	protected $utmn;
	/**
	 * ?
	 */
	protected $utmu = 'q';
	/**
	 * Carriage return (?)
	 */
	protected $utmcr = 1;
	/**
	 * Document title
	 */
	protected $utmdt;
	/**
	 * Cookie
	 */
	protected $utmcc;
	/**
	 * Cookie var
	 */
	protected $__utma;
	/**
	 * Cookie var
	 */
	protected $__utmb;
	/**
	 * Cookie var
	 */
	protected $__utmc;
	/**
	 * Cookie var
	 */
	protected $__utmz;

	function __construct()
	{
		$this->utmhid = rand(1000000000,9999999999);
		$this->utmn = rand(1000000000,9999999999);
		$this->utmul = 'en-us';  // TODO Language
		if(array_key_exists('HTTP_REFERER', $_SERVER))
		{
			$this->utmr = $_SERVER['HTTP_REFERER'];
		}
	}
	
	/**
	 * Loads the parameters from the application config
	 * @see ManiaLib_Config_Config
	 */
	function loadFromConfig()
	{
		$config = ManiaLib_Config_Loader::$config;
		
		$this->utmac = $config->application->tracking->account;
		$this->utmdt = $config->application->name; 
		$this->utmhn = parse_url($config->application->URL, PHP_URL_HOST);
		
		$request = ManiaLib_Application_Request::getInstance();
		$route = '/'.$request->getController().'/';
		$action = $request->getAction();
		if($action) $route.= $action.'/';
		
		$this->utmp = $route;
	}
	
	/**
	 * Computes the tracking URL and returns it. Its is a 1*1 gif image that
	 * should be called by the client.
	 * @return string
	 */
	function getTrackingURL()
	{
		if(!$this->trackingURL)
		{
			// TODO Better cookie handling
			$cookieNumber = rand(10000000,99999999);
			$cookieRandom = rand(1000000000,2147483647);
			$cookieToday = time();
					
			$this->__utma =
				$cookieNumber.'.'. // Cookie bumber
				$cookieRandom.'.'. //number under 2147483647
				$cookieToday.'.'. //time (20-01-2007) cookie first set
				$cookieToday.'.'. //time (24-02-2007) cookie previous set
				$cookieToday.'.'. //time (03-03-2007) today
				'3;+';
			$this->__utmb = $cookieNumber.';+'; //cookie number
			$this->__utmc = $cookieNumber.';+'; //cookie number
			$this->__utmz = 
				$cookieNumber.'.'. //cookie number
				$cookieToday.'.'. //time (03-03-2007) today
				'1.'.
				'1.'.
				'utmccn=(direct)|'. //utm_campaign
				'utmcsr=(direct)|'. //utm_source
				'utmcmd=(none);'; //utm_medium'
			
			$params = array(
				'utmwv' => $this->utmwv,
				'utmhn' => $this->utmhn,
				'utmcs' => $this->utmcs,
				'utmsr' => $this->utmsr,
				'utmsc' => $this->utmsc,
				'utmul' => $this->utmul,
				'utmje' => $this->utmje,
				'utmfl' => $this->utmfl,
				'utmhid' => $this->utmhid,
				'utmr' => $this->utmr,
				'utmp' => $this->utmp,
				'utmac' => $this->utmac,
				'utmn' => $this->utmn,
				'utmu' => $this->utmu,
				'utmcr' => $this->utmcr,
				'utmdt' => $this->utmdt,
				'utmcc' => 
					$this->__utma.
					//$this->__utmb.
					//$this->__utmc.
					$this->__utmz
				);
		
			$this->trackingURL = self::GA_TRACKING_URL.'?'.http_build_query($params);
		}
		return $this->trackingURL;
	}
}






?>