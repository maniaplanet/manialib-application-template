<?php
/**
 * Auto connect 
 * @author Maxime Raoust
 * @package auto_connect
 */

abstract class AutoConnect
{
	final public static function check()
	{
		if(basename($_SERVER["SCRIPT_FILENAME"]) == "connect.php")
		{
			return false;
		}
		$session = SessionEngine::getInstance();
		if($session->get("login"))
		{
			return true;
		}
		$request = RequestEngine::getInstance();
		$request->redirectManialink("connect.php");
	}
}

?>