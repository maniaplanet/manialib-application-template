<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Google Analytics tracking in Manialinks
 */
class ManiaLib_Application_Tracking_GoogleAnalytics
{
	const GA_TRACKING_URL = 'http://www.google-analytics.com/__utm.gif';
	
	/**
	 * @var string
	 */
	public $trackingURL;
	/**
	 * @var ManiaLib_Gui_Elements_Quad
	 */
	public $trackingQuad;
	
	/**
	 * Urchin version
	 */
	public $utmwv = '4.8.6';
	/**
	 * Hostname
	 */
	public $utmhn;
	/**
	 * Charsert
	 */
	public $utmcs = 'UTF-8';
	/**
	 * Screen resolution
	 */
	public $utmsr = '-';
	/**
	 * Color-depth
	 */
	public $utmsc = '-';
	/**
	 * Language
	 */
	public $utmul;
	/**
	 * Java enabled
	 */
	public $utmje = 0;
	/**
	 * Flash version
	 */
	public $utmfl = 0;
	/**
	 * Random
	 */
	public $utmhid;
	/**
	 * Referer
	 */
	public $utmr = 0;
	/**
	 * Route
	 */
	public $utmp;
	/**
	 * Google Analytics account
	 */
	public $utmac;
	/**
	 * Random
	 */
	public $utmn;
	/**
	 * ?
	 */
	public $utmu = 'q';
	/**
	 * Carriage return (?)
	 */
	public $utmcr = 1;
	/**
	 * Document title
	 */
	public $utmdt;
	/**
	 * Cookie
	 */
	public $utmcc;
	/**
	 * Cookie var
	 */
	public $__utma;
	/**
	 * Cookie var
	 */
	public $__utmb;
	/**
	 * Cookie var
	 */
	public $__utmc;
	/**
	 * Cookie var
	 */
	public $__utmz;

	function __construct()
	{
		$this->utmhid = rand(1000000000,9999999999);
		$this->utmn = rand(1000000000,9999999999);
		$this->utmul = 'en';
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
	 * Loads cookie information
	 * @see http://services.google.com/analytics/breeze/en/ga_cookies/index.html
	 */
	function loadCookie()
	{
		$cookieNumber = rand(10000000,99999999);
		$cookieRandom = rand(1000000000,2147483647); //number under 2147483647
		
		$utma = ManiaLib_Utils_Array::get($_COOKIE, '__utma', '');
		$utma = $utma ? explode('.', $utma) : array();
		
		$utmb = ManiaLib_Utils_Array::get($_COOKIE, '__utmb', '');
		$utmb = $utmb ? explode('.', $utmb) : array();
		
		$utmc = ManiaLib_Utils_Array::get($_COOKIE, '__utmc', '');
		$utmc = $utmc ? explode('.', $utmc) : array();
		
		$utmz = array();
		
		$utma[0] = ManiaLib_Utils_Array::get($utma, 0, $cookieNumber); // Domain hash
		$utma[1] = ManiaLib_Utils_Array::get($utma, 1, $cookieRandom); // Random unique ID
		$utma[2] = ManiaLib_Utils_Array::get($utma, 2, time()); // Time of initial visit
		$utma[3] = ManiaLib_Utils_Array::get($utma, 3, time()); // Begining of previous session
		$utma[4] = ManiaLib_Utils_Array::get($utma, 4, time()); // Begining of current session
		$utma[5] = ManiaLib_Utils_Array::get($utma, 5, 0); // Session counter
		
		$cookieNumber = $utma[0];
		
		if(!$utmb || !$utmc)
		{
			// New session has started
			$utma[5]++;
			$utma[3] = $utma[4];
			$utma[4] = time();
		}
		
		$utmb[0] = $cookieNumber;
		
		$utmc[0] = $cookieNumber;
		
		$utmz[0] = $cookieNumber; // Domain hash
		$utmz[1] = time(); // Timestamp
		$utmz[2] = $utma[5]; // Session number
		$utmz[3] = // Campaign information
			'utmcsr=(direct)|'. //utm_source
			'utmccn=(direct)|'. //utm_campaign
			'utmcmd=(none)'; //utm_medium'
		
		$__utma = implode('.', $utma);
		$__utmb = implode('.', $utmb);
		$__utmc = implode('.', $utmc);
		$__utmz = implode('.', $utmz);
		
		setcookie('__utma', $__utma, strtotime('+2 years'));
		setcookie('__utmb', $__utmb, strtotime('+30 minutes'));
		setcookie('__utmc', $__utmb, 0);
		setcookie('__utmz', $__utmz, strtotime('+6 months'));
		
		$this->__utma = $__utma.';';
		$this->__utmb = $__utmb.';';
		$this->__utmc = $__utmc.';';
		$this->__utmz = $__utmz.';';
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
					'__utma='.$this->__utma.'+'.
					'__utmb='.$this->__utmb.'+'.
					'__utmc='.$this->__utmc.'+'.
					'__utmz='.$this->__utmz
				);
		
			$this->trackingURL = self::GA_TRACKING_URL.'?'.http_build_query($params);
		}
		return $this->trackingURL;
	}
}






?>