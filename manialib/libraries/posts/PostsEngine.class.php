<?php
/**
 * Posts engine example
 * @author Maxime Raoust
 * @package posts
 */
 
class PostsEngine 
{
	private static $instance;
	private static $engineLoadedId = "posts_engine_loaded";
	
	private $posts = array();
	private $postsTable;
	private $contentTable;
	private $tagsTable;
	private $imagesTable;
	
	public static function getInstance()
	{
		if (!self :: $instance)
		{
			$class = __CLASS__;
			self :: $instance = new $class;
		}
		return self :: $instance;
	} 
	
	public function getPosts()
	{
		if(empty($this->posts))
		{
			$this->dbGetPosts();
		}
		return $this->posts;
	}
	
	public function getPost($postId)
	{
		$postId = (int) $postId;
		$this->dbGetPosts("WHERE p.post_id=$postId");
		return reset($this->posts);
	}
	
	private function __construct()
	{
		$session = SessionEngine::getInstance();
		
		$this->postsTable = DATABASE_PREFIX . "posts";
		$this->tagsTable = DATABASE_PREFIX . "posts_tags";
		$this->imagesTable = DATABASE_PREFIX . "posts_images";
		$this->contentTable = DATABASE_PREFIX . "posts_content";
		
		if(!$session->get(self::$engineLoadedId))
		{
			if($this->dbInstall() === true)
			{
				// DEBUG $session->set(self::$engineLoadedId, 1);
			}
		}
	}
	
	private function dbGetPosts($filter = "ORDER BY date DESC LIMIT 0, 5")
	{
		$db = DatabaseEngine::getInstance();
		
		$db->query = 	"SELECT * FROM $this->postsTable AS p " .
						"INNER JOIN $this->contentTable AS c " .
						"ON c.post_id = p.post_id " .
						$filter;
		$db->query();
		
		while($arr = $db->fetchArray())
		{
			$post = new Post($arr["post_id"]);
			$post->setAuthor($arr["author"]);
			$post->setDate($arr["date"]);
			$post->setTitle($arr["title"]);
			$post->setContent($arr["content"]);
			
			$this->posts[$arr["post_id"]] = $post;
		}
		
		$postIds = array_keys($this->posts);
		$postIds = implode("," , $postIds);
		$postIds = "($postIds)";
		
		$db->query = 	"SELECT * FROM $this->postsTable AS p " .
						"INNER JOIN $this->tagsTable AS t " .
						"ON t.post_id = p.post_id " .
						"WHERE p.post_id IN $postIds";
		$db->query();
		
		while($arr = $db->fetchArray())
		{
			$this->posts[$arr["post_id"]]->addTag($arr["tag"]);
		}
		
		$db->query = 	"SELECT * FROM $this->postsTable AS p " .
						"INNER JOIN $this->imagesTable AS i " .
						"ON i.post_id = p.post_id " .
						"WHERE p.post_id IN $postIds";
		$db->query();
		
		while($arr = $db->fetchArray())
		{
			$this->posts[$arr["post_id"]]->addImage($arr["image"]);
		}
		
	}
	
	private function dbInstall()
	{
		
		$db = DatabaseEngine::getInstance();
		
		$db->query = 	"CREATE TABLE IF NOT EXISTS $this->postsTable " .
						"( " .
						"post_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ," .
						"date TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ," .
						"author VARCHAR(25) NOT NULL ," .
						"title VARCHAR(255) NOT NULL ," .
						"INDEX ( date ), " .
						"INDEX ( author )" .
						") ENGINE = MYISAM ";
		$db->query();
		
		$db->query  = 	"CREATE TABLE IF NOT EXISTS $this->tagsTable " .
						"( " .
						"post_id INT NOT NULL , " .
						"tag VARCHAR( 25 ) NOT NULL , " .
						"INDEX ( post_id ), " .
						"INDEX ( tag ), " .
						"UNIQUE ( post_id, tag) " .
						") ENGINE = MYISAM ";
		$db->query();
		
		$db->query =	"CREATE TABLE IF NOT EXISTS $this->imagesTable " .
						"( " .
						"post_id INT NOT NULL ," .
						"image VARCHAR( 255 ) NOT NULL , " .
						"INDEX ( post_id ), " .
						"UNIQUE ( post_id, image )" .
						") ENGINE = MYISAM";
		$db->query();
		
		$db->query =	"CREATE TABLE IF NOT EXISTS $this->contentTable " .
						"( " .
						"post_id INT NOT NULL PRIMARY KEY , " .
						"content TEXT NOT NULL " .
						") ENGINE = MYISAM ";
		$db->query();
		
		
		// Example post
		$db->query = 	"INSERT IGNORE INTO $this->postsTable " .
						"( post_id, date, author, title ) " .
						"VALUES " .
						"( 1, NOW(), 'manialib', 'Hello world !') ";
		$db->query();
		
		$db->query = 	"INSERT IGNORE INTO $this->contentTable " .
						"( post_id, content ) " .
						"VALUES " .
						"( 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing " .
						"elit. Quisque nec felis eu ipsum tristique interdum. " .
						"Quisque purus ante, rutrum at mattis non, imperdiet a " .
						"turpis. Nunc malesuada cursus justo, id sodales est " .
						"consequat id. Cras ipsum libero, cursus a semper sed, " .
						"luctus in odio. Pellentesque nec leo ac est interdum " .
						"pretium. Phasellus faucibus urna eu libero adipiscing " .
						"suscipit. Etiam laoreet aliquam nunc quis sollicitudin.')";
		$db->query();
		
		$db->query = 	"INSERT IGNORE INTO $this->imagesTable " .
						"( post_id, image ) " .
						"VALUES " .
						"( 1, 'bg_coast.dds'), " .
						"( 1, 'bg_island.dds') ";
		$db->query();
		
		$db->query = 	"INSERT IGNORE INTO $this->tagsTable " .
						"( post_id, tag ) " .
						"VALUES " .
						"( 1, 'trackmania'), " .
						"( 1, 'manialib') ";
		$db->query();
		
		return true;
	}
}
?>