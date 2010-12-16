<?php

/**
 * Add favorite
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
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