<?php 

abstract class ManiaLib_Utils_Debug
{
	static function isDebug()
	{
		return ManiaLib_Config_Loader::$config->debug;
	}
}

?>