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

namespace ManiaLibDemo\Controllers;

class Home extends \ManiaLib\Application\Controller
{

	/**
	 * Maps to /index.php/home/index
	 */
	function index()
	{
		
	}

	/**
	 * Maps to /index.php/home/some-page
	 */
	function somePage()
	{
		
	}

	/**
	 * Does not map to any URL since it's protected
	 */
	protected function foobar()
	{
		
	}

}

?>