<?php
/**
 * Post example class
 * @author Maxime Raoust
 * @package posts
 */
 
class Post 
{
	public $id;
	protected $postType;
	protected $author;
	protected $date;
	protected $title;
	protected $content;
	protected $metaTags;
	
	function __construct($id = null)
	{
		$this->id = $id;
	}
	
	function getPostType()
	{
		return $this->postType;
	}
	
	function getAuthor()
	{
		return $this->author;
	}
	
	function getDate()
	{
		return $this->date;
	}
	
	function getTitle()
	{
		return $this->title;
	}
	
	function getContent()
	{
		return $this->content;
	}
	
	function getMetaTags($name)
	{
		if(isset($this->metaTags[$name]))
		{
			return $this->metaTags[$name];
		}
		return null;
	}
	
	function setAuthor($author)
	{
		$this->author = $author;
	}
	
	function setDate($date)
	{
		$this->date = $date;
	}
	
	function setTitle($title)
	{
		$this->title = $title;
	}
	
	function setPostType($postType)
	{
		$this->postType = $postType;
	}
	
	
	function setContent($content)
	{
		$this->content = $content;
	}
		
	function addMetaTag($name, $value)
	{
		if(!isset($this->metaTags[$name]))
		{
			$this->metaTags[$name] = array();
		}
		if(!in_array($value, $this->metaTags[$name]))
		{
			$this->metaTags[$name][] = $value;
		}
	}
	
	function deleteMetaTag($name, $value=null)
	{
		if(isset($this->metaTags[$name]))
		{
			if($value === null)
			{
				unset($this->metaTags[$name]);
				return true;
			}
			else
			{
				if($keys = (array) array_keys($name, $this->metaTags, $value))
				{
					foreach($keys as $key)
					{
						unset($this->metaTags[$name][$key]);
					}
					return true;
				}
			}
		}
		return false;
	}
		
	function dbUpdate()
	{
		$db = DatabaseEngine::getInstance();
		
		$postsTable = PostsStructure::getPostsTable();
		$metaTagsTable = PostsStructure::getMetaTagsTable();
		$contentTable = PostsStructure::getContentTable();
		
		$postId = $this->id ? $this->id : "NULL" ;
		$postType = $this->postType;
		$author = quote_smart($this->author);
		$title = quote_smart($this->title);
		$content = quote_smart($this->content);
		
		$db->query = 	
			"INSERT INTO $postsTable " .
			"(post_id, post_type, author, title) " .
			"VALUES " .
			"($postId, $postType, $author, $title) " .
			"ON DUPLICATE KEY UPDATE " .
			"post_type = VALUES(post_type), " .
			"author = VALUES(author), " .
			"title = VALUES(title)";
		$db->query();
		
		if(!$this->id)
		{
			$this->id = $db->insertId();
			$postId = $this->id ? $this->id : "NULL" ;
		}
		
		$db->query = 	
			"INSERT INTO $contentTable " .
			"(post_id, content) " .
			"VALUES " .
			"($postId, $content) " .
			"ON DUPLICATE KEY UPDATE " .
			"content = VALUES(content) ";
		$db->query();
		
		$db->query = 	
			"DELETE FROM $metaTagsTable " .
			"WHERE post_id=$postId";
		$db->query();
		
		if(empty($this->metaTags))
		{
			return true;
		}
		
		$mysqlTags = array();
		
		foreach($this->metaTags as $name=>$value)
		{
			$name = quote_smart($name);
			if(is_array($value))
			{
				foreach($value as $key=>$_value)
				{
					$_value = quote_smart($_value);
					$mysqlTags[] = "($postId, $name, $_value)";
				}
			}
			else
			{
				$value = quote_smart($value);
				$mysqlTags[] = "($postId, $name, $value)";
			}
		}
		
		$mysqlTags = implode(",", $mysqlTags);
		
		$db->query = 	
			"INSERT INTO $metaTagsTable " .
			"(post_id, name, value) " .
			"VALUES $mysqlTags";
		$db->query();
		
		return true;
	}
	
	function dbDelete()
	{
		if(!$this->id)
		{
			return false;
		}
		
		$postsTable = PostsStructure::getPostsTable();
		
		$db = DatabaseEngine::getInstance();
		$db->query = "DELETE FROM $postsTable WHERE post_id=$this->id";
		$db->query();
		
		// That's it ! The forein keys take care of the rest
		return true;	
	}
}
?>