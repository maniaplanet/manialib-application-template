<?php
/**
 * Session engine
 * 
 * @author Maxime Raoust
 * @package Manialib
 */

class SessionEngine
{
	private static $instance;
	public static $name = "maniasid";

	/**
	 * Constructor
	 */
	private function __construct()
	{
		session_name(self::$name);
		session_start();
	}

	/**
	 * Get the instance
	 */
	public static function getInstance()
	{
		if (!self::$instance)
		{
			$class = __CLASS__;
			self::$instance = new $class;
		}
		return self::$instance;
	}

	/**
	 * Set a session var
	 * 
	 * @param String $name
	 * @param Mixed $value=null
	 */
	function set($name, $value = null)
	{
		$_SESSION[$name] = $value;
	}

	/**
	 * Delete a session var
	 * 
	 * @param String $name
	 */
	function delete($name)
	{
		if ($this->exists($name))
		{
			unset ($_SESSION[$name]);
			return true;
		}

		return false;
	}

	/**
	 * Get a session var, or the default value if nothing was found
	 * 
	 * @param string The name of the variable
	 * @param mixed The default value
	 * @return mixed
	 */
	function get($name, $default = null)
	{
		return isset ($_SESSION[$name]) ? $_SESSION[$name] : $default;
	}
	
	/**
	 * Gets a session var, throws an exception if not found
	 * 
	 * @param string The name of the variable
	 * @return mixed
	 */
	function getStrict($name)
	{
		if(isset ($_SESSION[$name]))
		{
			return $_SESSION[$name];
		}
		throw new ManialinkException('Session variable "'.$name.'" not found');
	}

	/**
	 * Check if the specified session var exists
	 * 
	 * @return Bool
	 */
	function exists($name)
	{
		return isset ($_SESSION[$name]);
	}
}
?>