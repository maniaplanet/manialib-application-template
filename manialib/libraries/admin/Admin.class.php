<?php
/**
 * Admin
 * @author Maxime Raoust
 * @package admin
 */

class Admin 
{
	protected $login;
	protected $passwordHash;
	
	function __construct($login, $password)
	{
		$this->login = $login;
		$this->passwordHash = sha1($password);
	}
	
	function dbUpdate()
	{
		$db = DatabaseEngine::getInstance();
		$adminsTable = AdminStructure::getAdminsTable();
		
		$login = quote_smart($this->login);
		$passwordHash = quote_smart($this->passwordHash);
		
		$db->query = 
			"INSERT INTO $adminsTable " .
			"(login, password_hash) " .
			"VALUES " .
			"($login, $passwordHash) " .
			"ON DUPLICATE KEY UPDATE " .
			"login = VALUES(login), " .
			"password_hash = VALUES(password_hash) ";
		$db->query();
		
		return $db->affectedRows();	
	}
	
}
?>