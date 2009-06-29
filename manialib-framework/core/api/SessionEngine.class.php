<?php
/**
 * Session engine
 * 
 * @author Maxime Raoust
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
		session_name(self :: $name);
		session_start();
	}

	/**
	 * Get the instance
	 */
	public static function getInstance()
	{
		if (!self :: $instance)
		{
			$class = __CLASS__;
			self :: $instance = new $class;
		}
		return self :: $instance;
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
	 * @param String $name
	 * @param Mixed $default=null
	 * @return Mixed
	 */
	function get($name, $default = null)
	{
		if (isset ($_SESSION[$name]))
			$value = $_SESSION[$name];
		else
			return $default;

		if (get_magic_quotes_gpc())
			return stripslashes($value);
		else
			return $value;

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