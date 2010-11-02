<?php
/**
 * @author Maxime Raoust 
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC_DefaultFilters
 */

/**
 * User agent checker
 * Forces GameBox user agent, redirects to trackmania.com otherwise
 * @package ManiaLib
 * @subpackage MVC_DefaultFilters
 */
class UserAgentCheckFilter extends AdvancedFilter
{
	/**
	 * @ignore
	 */
	protected static $callback = array('UserAgentCheckFilter', 'defaultHTMLView');
	
	/**
	 * Sets the callback when someone tries to access the Manialink from outside the game.
	 * The callback prints some HTML and returns void.  
	 */
	static function setCallback($callback)
	{
		self::$callback = $callback;
	}
	
/**
	 * This is the default HTML view when someone tries to access the Manialink from outside the game.
	 * You can override this default behaviour by changing the callback with UserAgentCheckFilter::setCallback()
	 */
	static function defaultHTMLView() 
	{
		$APP_MANIALINK = APP_MANIALINK;
				echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>$APP_MANIALINK</title>
		<style type="text/css">
		
			body {
				background: #333333;
				color: #eeeeee;
				font-family: Verdana, Arial, Helvetica, sans-serif;
				font-size: 12px;
				line-height: 15px;
			}
			
			#frame {
				width: 500px;
				margin: 25px auto;
				padding: 25px;
				border: 1px #cccccc solid;
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
			}
			
			h1 {
				color: #ffff00;
				text-align: center;
			}
			
			p {
				text-align: justify;
			}
			
			a, a:visited {
				color: #ffff00;
				text-decoration: underline;
			}
			
			a:hover, a:active {
				color: orange;
			}
		</style>
	</head>
	<body>
		<div id="frame">
			<h1>$APP_MANIALINK</h1>
			<p>
			The page your are trying to access is a Manialink for TrackMania. 
			You can only view it using the in-game browser.
			<p>
			
			<p>
			To access it, <a href="tmtp:///:$APP_MANIALINK">click here</a> or 
			launch TrackMania Forever and go to the <b>$APP_MANIALINK</b> Manialink.
			</p>
			
			<p>
			TrackMania is a series of fast-paced racing video games in which you 
			drive at mind-blowing speeds on fun and spectacular tracks in solo 
			and multi player modes. Several in-game editors allow for track 
			building, car painting or video editing.
			</p>
			
			<p>
			For more information, please visit <a href="http://www.trackmania.com">www.trackmania.com</a>
			</p>
		</div>
	</body>
</html>				
HTML;
	}
	
	/**
	 * @ignore
	 */
	function preFilter()
	{
		if(APP_DEBUG_LEVEL == 0)
		{
			if(!array_key_exists('HTTP_USER_AGENT', $_SERVER) || $_SERVER['HTTP_USER_AGENT'] != 'GameBox')
			{
				call_user_func(self::$callback);
				exit;
			}
		}
	}
	
	/**
	 * @ignore
	 */
	function postFilter() {}
}

?>