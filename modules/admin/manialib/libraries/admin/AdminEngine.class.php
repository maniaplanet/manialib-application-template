<?php
/**
 * Admin
 * @author Maxime Raoust
 * @package admin
 */

class AdminEngine 
{
	private static $instance;
 	protected $adminsTable;
 	
 	public static function checkAuthentication()
 	{
 		if(!self::authenticate())
		{
			RequestEngine::getInstance()->redirectManialink("login.php");
		}
 	}
 	 	
 	public static function authenticate()
 	{
 		$session = SessionEngine::getInstance();
 		
 		if(!($login = $session->get("login", "")))
 		{
 			return false;
 		}
 		
 		if($session->get("admin_authenticated"))
 		{
 			return true;
 		}
 		
 		$password = RequestEngine::getInstance()->get("password");
 		
 		if(empty($password))
 		{
 			return false;
 		}
 		
 		if(self::getInstance()->dbAuthenticate($login, sha1($password)))
 		{
 			$session->set("admin_authenticated", 1);
 			return true;
 		}
 		
 		return false;
 	}
 	
 	public static function changePassword($login, $current, $new)
 	{
 		if(!self::getInstance()->dbAuthenticate($login, sha1($current)))
 		{
 			return false;
 		}
 		
 		$admin = new Admin($login, $new);
		$admin->dbUpdate();
		
		return true;
 	}
 	
 	public static function exists($login)
 	{
 		return self::getInstance()->dbExists($login);
 	}
 	
 	public static function getInstance()
	{
		if (!self::$instance)
		{
			$class = __CLASS__;
			self::$instance = new $class;
		}
		return self::$instance;
	}
 	
 	private function __construct()
 	{
 		$session = SessionEngine::getInstance();
 		$request = RequestEngine::getInstance();
 		
 		$this->adminsTable = AdminStructure::getAdminsTable();
 		
 		if(!$session->get(__CLASS__))
		{
			if(!$session->get("login"))
			{
				$request->redirectManialink("login.php");
			}
			elseif($this->dbInstall() === true)
			{
				$session->set(__CLASS__, 1);
			}
		}
 	}
 	
 	protected function dbAuthenticate($login, $passwordHash)
 	{
 		$db = DatabaseEngine::getInstance();
 		$login = quote_smart($login);
 		$passwordHash = quote_smart($passwordHash);
 		
 		$db->query = 
			"SELECT COUNT(*) AS c " .
 			"FROM $this->adminsTable " .
 			"WHERE login = $login " .
 			"AND password_hash = $passwordHash";
 		$db->query();
 		
 		if($arr = $db->fetchArray())
 		{
 			if($arr["c"])
 			{
 				return true;
 			}
 		}
 		return false;
 	}
 	
 	protected function dbExists($login)
 	{
 		$db = DatabaseEngine::getInstance();
 		$login = quote_smart($login);
 		
 		$db->query = 
			"SELECT COUNT(*) AS c " .
 			"FROM $this->adminsTable " .
 			"WHERE login = $login ";
 		$db->query();
 		
 		if($arr = $db->fetchArray())
 		{
 			if($arr["c"])
 			{
 				return true;
 			}
 		}
 		return false;
 	}
 	
 	protected function dbInstall()
 	{
 		$db = DatabaseEngine::getInstance();
		$session = SessionEngine::getInstance();
		
		// Check if the tables exists
		$like = DATABASE_PREFIX . "admin%";
		$like = quote_smart($like);
		
		$db->query = "SHOW TABLES LIKE $like";
		$db->query();
		
		$tables = array();
		while($row = $db->fetchRow())
		{
			$tables[] = $row[0];
		}
		
		if(	in_array($this->adminsTable, $tables))
		{
			return true;
		}
		
		// If one of them is not found, we create them
		$db->query = 	
			"CREATE TABLE IF NOT EXISTS $this->adminsTable " .
			"(" .
				"login VARCHAR(25) NOT NULL PRIMARY KEY, " .
				"password_hash CHAR(40) NOT NULL" .
			")" .
			"ENGINE = InnoDB " .
			"CHARACTER SET utf8 " .
			"COLLATE utf8_general_ci";
		$db->query();
		
		// Default admin
		$admin = new Admin($session->get("login"), $session->get("login"));
		$admin->dbUpdate();
 	}
 	
}
?>