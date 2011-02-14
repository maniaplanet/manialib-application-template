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
 * PHP Session handling simplified
 */
final class Session
{
	protected static $instance;
	protected static $started = false;

	/**
	 * Gets the instance
	 * @return \ManiaLib\Session\Session
	 */
	public static function getInstance()
	{
		if (!self::$instance)
		{
			if(!Config::getInstance()->enabled)
			{
				throw new Exception(
					'Cannot instanciate session: session handling has been disabled in the config');
			}
			$class = __CLASS__;
			self::$instance = new $class;
		}
		return self::$instance;
	}
	
	/**
	 * @ignore
	 */
	protected function __construct()
	{
		if(!self::$started)
		{
			try 
			{
				session_start();
				self::$started = true;
			}
			catch(\Exception $exception)
			{
				\ManiaLib\Log\Logger::error($exception->getMessage());
			}
		}
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