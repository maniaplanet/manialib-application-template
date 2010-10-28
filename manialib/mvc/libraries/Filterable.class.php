<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/**
 * Filter interface
 * @package ManiaLib_MVC
 * @todo doc
 */
interface Filterable 
{
	public function preFilter();
	public function postFilter(); 
}

?>