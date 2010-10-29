<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
 */

/**
 * Filter interface
 * @package ManiaLib
 * @subpackage MVC
 * @todo doc
 */
interface Filterable 
{
	public function preFilter();
	public function postFilter(); 
}

?>