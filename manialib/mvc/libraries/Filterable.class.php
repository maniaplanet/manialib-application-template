<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
 */

/**
 * Filter interface
 * Filters allows you to execute code before and after every actions of a controller.
 * It is usefull for things like authentication, etc.
 * @see ActionController::addFilter()
 * @package ManiaLib
 * @subpackage MVC
 */
interface Filterable 
{
	public function preFilter();
	public function postFilter(); 
}

?>