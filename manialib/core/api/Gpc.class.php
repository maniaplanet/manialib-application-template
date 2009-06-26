<?php
/**
 * Get API
 * 
 * @author Maxime Raoust
 */

// TODO Class GPC may be useless. LinkEngine should become RequestHandler ?

class Gpc
{	
	/**
	 * Retrieve a GPC var, of the specified default if nothing was found
	 * 
	 * @param String $name
	 * @param Mixed $default=null
	 * @return Mixed
	 */
	static function get($name, $default=null)
	{
		if(isset($_POST[$name]))
		{
			$value = $_POST[$name];
		}
		else if(isset($_GET[$name]))
		{
			$value =  $_GET[$name];
		}
		else
		{
			$value =  $default;
		}
		
		if(get_magic_quotes_gpc())
			return stripslashes($value);
		else
			return $value;
	}
	
	/**
	 * Retrieve a GPC int, of the specified default if nothing was found.
	 * Max and min value can be specified, those will be returned if retrieved 
	 * value is beyond the boudaries
	 * 
	 * @param String $name
	 * @param Int $default=0
	 * @param Int $min=null
	 * @param Int $max=null
	 * @return Int
	 */
	static function getInt($name, $default=0, $min=null, $max=null)
	{
		$return =  intval(self::get($name, $default));
		if($min!=null)
			if($return<$min)
				return $min;
		if($max!=null)
			if($return>$max)
				return $max;
		return $return;
	}
	static function getUrl($name, $default=null)
	{
		$return = Gpc::get($name);
		if($return)
		{
			return rawurldecode($return);
		}
		return $default;
	}
	
	/**
	 * Return all GET vars as an array
	 * 
	 * @return Array
	 */
	static function getArray()
	{
		$arr = array();
		foreach($_GET as $key=>$elt)
		{
			$arr[$key] = $elt;
		}
		return $arr;
	}
}

?>