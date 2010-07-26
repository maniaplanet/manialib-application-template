<?php
/**
 * @author Maxime Raoust
 */

/**
 * Forces GameBox user agent
 */
class UserAgentCheckFilter extends AdvancedFilter
{
	function preFilter()
	{
		if(APP_DEBUG_LEVEL == 0)
		{
			if(!array_key_exists('HTTP_USER_AGENT', $_SERVER) || $_SERVER['HTTP_USER_AGENT'] != 'GameBox')
			{
				echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-language" content="en" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="3; url=http://www.trackmania.com/" />
		<title>Trackmania redirection</title>
	</head>
	<body>
		You will be redirected to www.trackmania.com in a few seconds. 
		If it does not work click <a href="http://www.trackmania.com">here</a>
	</body>
</html>			
HTML;
				exit;
			}
		}
	}
	
	function postFilter() {}
}

?>