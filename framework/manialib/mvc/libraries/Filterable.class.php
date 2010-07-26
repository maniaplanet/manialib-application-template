<?php
/**
 * @author Maxime Raoust
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