<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

/**
 * Data structures for the shouts
 */
class ManiaLibDemo_Services_Shout_Shout
{
	public $id;
	public $datePosted;
	public $login;
	public $nickname;
	public $message;
	
	/**
	 * @return ManiaLibDemo_Services_Shout_Shout
	 */
	static function fromRecordSet(ManiaLib_Database_RecordSet $result)
	{
		$object = $result->fetchObject('ManiaLibDemo_Services_Shout_Shout');
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