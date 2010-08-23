<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

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
	
	function __construct()
	{
		// This allows to convert string type from the MySQL's TIMESTAMP to int
		// when using the DatabaseRecordSet::FetchObject() method.
		// This is possible because mysql_fetch_object() sets the object
		// properties before calling the constructor
		if(is_string($this->datePosted))
		{
			$this->datePosted = strtotime($this->datePosted);
		}
	}
}

?>