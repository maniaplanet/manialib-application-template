<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLibMvc
 */

/**
 * Filter interface
 */
interface Filterable 
{
	public function preFilter();
	public function postFilter(); 
}

?>