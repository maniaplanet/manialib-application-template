<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Add favorite
 */
class ManiaLib_Maniacode_Elements_AddFavourite extends ManiaLib_Maniacode_Elements_AddBuddy
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'add_favourite';
	
	function __construct($login)
	{
		parent::__construct($login);
	}
}

?>