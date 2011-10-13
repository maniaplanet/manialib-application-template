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

namespace ManiaLib\Gui\Maniacode\Elements;

/**
 * Add favorite
 */
class AddFavourite extends \ManiaLib\Gui\Maniacode\Elements\AddBuddy
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