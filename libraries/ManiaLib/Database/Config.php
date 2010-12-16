<?php

class ManiaLib_Database_Config extends ManiaLib_Config_Configurable
{
	public $host = '127.0.0.1';
	public $user = 'root';
	public $password = '';
	public $database;
	public $charset = 'utf8';
	
	public $queryLog = false;
	public $queryLogFilename = 'queries.log';
	public $slowQueryLog = false;
	public $slowQueryLogFilename = 'slow-queries.log';
	public $slowQueryThreshold = 1000; // in ms
}

?>