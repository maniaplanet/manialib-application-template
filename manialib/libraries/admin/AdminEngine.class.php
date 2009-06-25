<?php
/**
 * Admin
 * @author Maxime Raoust
 * @package admin
 */

class AdminEngine 
{
	// TODO Admin management
	// TODO Mettre les scripts d'install dans les classes "Structure"
	private static $instance;
	private static $engineLoadedId = "admin_engine_loaded";
 	protected $adminsTable;
 	
 	public static function checkAuthentication()
 	{
 		if(!self::authenticate())
		{
			LinkEngine::getInstance()->redirectManialink("admin/login.php");
		}
 	}
 	 	
 	public static function authenticate()
 	{
 		$session = SessionEngine::getInstance();
 		
 		if($session->get("admin_authenticated"))
 		{
 			return true;
 		}
 		
 		$password = Gpc::get("password");
 		$login = $session->get("login", "");
 		
 		if(empty($login) || empty($password))
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
 	
 	public static function getInstance()
	{
		if (!self :: $instance)
		{
			$class = __CLASS__;
			self :: $instance = new $class;
		}
		return self :: $instance;
	}
 	
 	private function __construct()
 	{
 		$session = SessionEngine::getInstance();
 		
 		$this->adminsTable = AdminStructure::getAdminsTable();
 		
 		if(!$session->get(self::$engineLoadedId))
		{
			if($this->dbInstall() === true)
			{
				$session->set(self::$engineLoadedId, 1);
			}
		}
 	}
 	
 	protected function dbAuthenticate($login, $passwordHash)
 	{
 		$db = DatabaseEngine::getInstance();
 		$login = quote_smart($login);
 		$passwordHash = quote_smart($passwordHash);
 		
 		$db->query = 	"SELECT COUNT(*) AS c " .
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
 	
 	protected function dbInstall()
 	{
 		$db = DatabaseEngine::getInstance();
		
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
		$db->query = 	"CREATE TABLE IF NOT EXISTS $this->adminsTable " .
						"(" .
							"login VARCHAR(25) NOT NULL PRIMARY KEY, " .
							"password_hash CHAR(40) NOT NULL" .
						")" .
						"ENGINE = InnoDB " .
						"CHARACTER SET utf8 " .
						"COLLATE utf8_general_ci";
		$db->query();
		
		// Admin
		$admin = new Admin("gou1", "a");
		$admin->dbUpdate();
 	}
 	
}
?>