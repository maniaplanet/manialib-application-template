<?php
/**
 * Admin data structure
 * @author Maxime Raoust
 * @package admin
 */
 
abstract class AdminStructure 
{
	final public static function getAdminsTable()
	{
		return DATABASE_PREFIX . "admins";
	}
}
?>