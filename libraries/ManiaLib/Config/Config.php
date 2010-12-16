<?php

class ManiaLib_Config_Config extends ManiaLib_Config_Configurable
{
	/**
	 * @var ManiaLib_Application_Config
	 */
	public $application;
	/**
	 * @var ManiaLib_Database_Config
	 */
	public $database;
	/**
	 * @var ManiaLib_I18n_Config
	 */
	public $i18n;
	/**
	 * @var ManiaLib_Log_Config
	 */
	public $log;
	
	public $timezone = 'Europe/Paris';
	public $timezoneName = 'GMT+1';
	
	public $debug = false;
	
	public $disableCache = false;
	
	public function __construct()
	{
		parent::__construct();
		$this->loadNestedConfig(array(
			'application' => 'ManiaLib_Application_Config',
			'database' => 'ManiaLib_Database_Config',
			'i18n' => 'ManiaLib_I18n_Config',
			'log' => 'ManiaLib_Log_Config',
		));
	}
}

?>