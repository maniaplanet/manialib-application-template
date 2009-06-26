<?php
/**
 * @author Maxime Raoust
 */
 
require_once("core.inc.php");

$request = RequestEngine::getInstance();

require_once("header.php");

require_once("navigation.php");



Manialink::beginFrame(-34, 48, 1);
	
	Manialink::beginFrame(25, -15, 1);
		
		PostsEngine::getInstance();
		if($request->get("post_id")) require_once( APP_LIBRARIES_PATH . "posts/views/show_post.php");
		else                    require_once( APP_LIBRARIES_PATH . "posts/views/last_posts.php");

	Manialink::endFrame();

Manialink::endFrame();

require_once("footer.php");


?>