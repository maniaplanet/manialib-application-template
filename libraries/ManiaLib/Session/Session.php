<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */
 
namespace ManiaLib\Session;

/**
 * Session handling for humans
 */
class Session extends \ManiaLib\Utils\Singleton
{
	protected static $started = false;	
	
	public $login;
	public $nickname;
	public $lang;
	public $path;
	public $game;
	
	protected function __construct()
	{
		if(!Config::getInstance()->enabled)
		{
			throw new Exception(
				'Cannot instanciate session: session handling has been disabled in the config');
		}
		
		if(self::$started)
		{
			return;
		}
		
		session_start();
		self::$started = true;
		
		$keys = array('login', 'nickname', 'lang', 'path', 'game');
		$session = $this;
		array_walk($keys, function ($value) use ($session) {
			if(isset($_SESSION[$value]))
			{
				 $session->$value =& $_SESSION[$value];
			}
			else
			{
				$_SESSION[$value] =& $session->$value;
			}
		});
	}

	/**
	 * Sets a session var
	 * @param string
	 * @param mixed
	 */
	function set($name, $value = null)
	{
		$_SESSION[$name] = $value;
	}

	/**
	 * Deletes a session var
	 * @param string
	 */
	function delete($name)
	{
		unset($_SESSION[$name]);
	}

	/**
	 * Gets a session var, or the default value if nothing was found
	 * @param string The name of the variable
	 * @param mixed The default value
	 * @return mixed
	 */
	function get($name, $default = null)
	{
		return array_key_exists($name, $_SESSION) ? $_SESSION[$name] : $default;
	}
	
	/**
	 * Gets a session var, throws an exception if not found
	 * @param string The name of the variable
	 * @return mixed
	 */
	function getStrict($name)
	{
		if(array_key_exists($name, $_SESSION))
		{
			return $_SESSION[$name];
		}
		throw new Exception('Session variable "'.$name.'" not found');
	}

	/**
	 * Checks if the specified session var exists
	 * @return boolean
	 */
	function exists($name)
	{
		return array_key_exists($name, $_SESSION);
	}
}

/**
 * @package ManiaLib
 * @ignore
 */
class Exception extends \Exception {}

?>