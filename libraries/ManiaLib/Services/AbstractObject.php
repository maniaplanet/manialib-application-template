<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2467 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-18 12:27:52 +0100 (ven., 18 févr. 2011) $:
 */
 
namespace ManiaLib\Services;

/**
 * Abstract object for (very) simple object relational mapping
 * Provides convenient methods for dealing with db result sets
 */
abstract class AbstractObject
{
	/**
	 * Fetches a single object from the record set
	 */
	static function fromRecordSet(\ManiaLib\Database\RecordSet $result, $strict=true, $default=null)
	{
		if(!($object = $result->fetchObject(get_called_class())))
		{
			if($strict)
			{
				throw new NotFoundException(sprintf('in %s::fromRecorSet()', get_called_class()));
			}
			else
			{
				return $default;
			}
		}
		$object->onFetchObject();
		return $object;
	}
	
	/**
	 * Fetches an array of object from the record set
	 */
	static function arrayFromRecordSet(\ManiaLib\Database\RecordSet $result)
	{
		$array = array();
		while($object = static::fromRecordSet($result, false))
		{
			$array[] = $object;
		}
		return $array;
	}
	
	/**
	 * Override this to do things when the object is fetched from a record set.
	 * Eg.: convering MySQL's TIMESTAMP fields into timestamp integers.
	 * 
	 * You can also use the constructor since myqsl_fetch_object fills props before calling it
	 */
	protected function onFetchObject() {}
}

?>