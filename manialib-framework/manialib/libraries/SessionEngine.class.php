<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * <b>Session engine</b>: helps handling PHP sessions
 */
final class SessionEngine
{
	/**
	 * Session identifier name. Used as parameter name for transporting the
	 * session Id in the URL when the client doesn't support cookies.
	 */
	const SIDName = 'maniasid';
	protected static $instance;
	

	/**
	 * Gets the instance
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
	
	protected function __construct()
	{
		session_name(self::SIDName);
		session_start();
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
		unset ($_SESSION[$name]);
	}

	/**
	 * Gets a session var, or the default value if nothing was found
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
	 * Checks if the specified session var exists
	 * @return boolean
	 */
	function exists($name)
	{
		return isset ($_SESSION[$name]);
	}
}

?>