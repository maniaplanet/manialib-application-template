<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Log config
 */
class ManiaLib_Log_Config extends ManiaLib_Config_Configurable
{
	public $path;
	public $prefix;
	public $error = 'error.log';
	public $user = 'user-error.log';
	public $debug = 'debug.log';
	public $loader = 'loader.log';
	public $verbose = false;
}


?>