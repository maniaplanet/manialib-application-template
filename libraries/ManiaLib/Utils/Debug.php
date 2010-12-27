<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Debug stuff
 */
abstract class ManiaLib_Utils_Debug
{
	static function isDebug()
	{
		return ManiaLib_Config_Loader::$config->debug;
	}
}

?>