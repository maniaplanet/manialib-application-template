<?php
/**
 * Post example class
 * @author Maxime Raoust
 * @package posts
 */
 
class Post 
{
	public $id;
	protected $author;
	protected $date;
	protected $title;
	protected $content;
	protected $images;
	protected $tags;
	
	function __construct($id = 0)
	{
		$this->id = $id;
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
	
	function getImages()
	{
		return (array) $this->images;
	}
	
	function getTags()
	{
		return $this->tags;
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
	
	function setContent($content)
	{
		$this->content = $content;
	}
	
	function addImage($image)
	{
		if(!in_array($image, (array) $this->images))
		{
			$this->images[] = $image;
		}
	}
	
	function addTag($tag)
	{
		if(!in_array($tag, (array) $this->tags))
		{
			$this->tags[] = $tag;
		}
	}
	
	function dbGet()
	{
		$db = DatabaseEngine::getInstance();
		$id = intval($this->id);
	}
	
	function dbUpdate()
	{
		
	}
}
?>