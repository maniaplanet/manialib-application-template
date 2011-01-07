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

namespace ManiaLibDemo\Services\Shout;

/**
 * Data structures for the shouts
 */
class Shout
{
	public $id;
	public $datePosted;
	public $login;
	public $nickname;
	public $message;
	
	/**
	 * @return \ManiaLibDemo\Services\Shout\Shout
	 */
	static function fromRecordSet(\ManiaLib\Database\RecordSet $result)
	{
		$object = $result->fetchObject('\ManiaLibDemo\Services\Shout\Shout');
		if($object)
		{
			// This allows to convert string type from the MySQL's TIMESTAMP to int
			// when using the DatabaseRecordSet::FetchObject() method.
			// This is possible because mysql_fetch_object() sets the object
			// properties before calling the constructor
			if(is_string($object->datePosted))
			{
				$object->datePosted = strtotime($object->datePosted);
			}
		}
		return $object;
	}
}

?>