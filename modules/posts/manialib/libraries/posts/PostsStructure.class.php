<?php
/**
 * Posts structure info
 * @author Maxime Raoust
 * @package posts
 */

define ("POSTS_DATABASE_PREFIX", "posts_"); 
 
abstract class PostsStructure 
{
	final public static function getPostsTable()
	{
		return DATABASE_PREFIX . "posts";
	}
	
	final public static function getContentTable()
	{
		return DATABASE_PREFIX . POSTS_DATABASE_PREFIX . "content";
	}
	
	final public static function getMetaTagsTable()
	{
		return DATABASE_PREFIX . POSTS_DATABASE_PREFIX . "meta_tags";
	}
	
	final public static function getPostTypes()
	{
		return array(
			0 => "None",
			1 => "News",
			2 => "Page",
			3 => "Track"
		);
	}
}
?>