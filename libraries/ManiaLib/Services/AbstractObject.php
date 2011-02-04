<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 1955 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-01-20 12:46:46 +0100 (jeu., 20 janv. 2011) $:
 */
 
namespace ManiaLib\Services;

// TODO Move this next to db, eg. Database/LightORM

/**
 * Abstract object for (very) simple object relational mapping
 * Provides convenient methods for dealing with db result sets
 */
abstract class AbstractObject
{
	/**
	 * Fetches a single object from the record set
	 */
	static function fromRecordSet(\ManiaLib\Database\RecordSet $result)
	{
		if(!$result->recordCount())
		{
			throw new NotFoundException();
		}
		$object = $result->fetchObject(get_called_class());
		$object->onFetchObject();
		return $object;
	}
	
	/**
	 * Fetches an array of object from the record set
	 */
	static function arrayFromRecordSet(\ManiaLib\Database\RecordSet $result)
	{
		$array = array();
		while($object = $result->fetchObject(get_called_class()))
		{
			$object->onFetchObject();
			$array[] = $object;
		}
		return $array;
	}
	
	/**
	 * Override this to do things when the object is fetched from a record set.
	 * Eg.: convering MySQL's TIMESTAMP fields into timestamp integers.
	 */
	protected function onFetchObject() {}
}

?>