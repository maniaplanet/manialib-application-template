<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Database tools
 */
abstract class ManiaLib_Database_Tools
{
	/**
	 * Returns the "LIMIT x,x" string depending on both values
	 */
	static function getLimitString($offset, $length)
	{
		$offset = (int)$offset;
		$length = (int)$length;
		if(!$offset && !$length)
		{
			return '';
		}
		elseif(!$offset && $length==1)
		{
			return 'LIMIT 1';
		}
		else
		{
			return 'LIMIT '.$offset.', '.$length;
		}
	}
	
	/**
	 * Returns string like "(name1, name2) VALUES (value1, value2)" 
	 */
	static function getValuesString(array $values)
	{
		return 
			'('.implode(', ', array_keys($values)).') '.
			'VALUES '.
			'('.implode(', ', $values).')';
	}
	
	/**
	 * Returns string like "name1=VALUES(name1), name2=VALUES(name2)"
	 */
	static function getOnDuplicateKeyUpdateValuesString(array $valueNames)
	{
		$strings = array(); 
		foreach($valueNames as $valueName)
		{
			$strings[] = $valueName.'=VALUES('.$valueName.')';
		}
		return implode(', ', $strings);
	}
	
	/**
	 * Returns string like "name1=value1, name2=value2"
	 */
	static function getUpdateString(array $values)
	{
		$tmp = array();
		
		foreach ($values as $key => $value)
		{
			$tmp[] = $key.'='.$value;
		}
		return implode(', ', $tmp);
	}
}

?>