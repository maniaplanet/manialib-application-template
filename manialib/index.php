<?php
/**
 * @author Maxime Raoust
 */
 
require_once("core.inc.php");

require_once("header.php");

Manialink::beginFrame(5, -5, 1);

	if(Gpc::get("post_id"))	require_once( APP_LIBRARIES_PATH . "posts/views/show_post.php");
	else 					require_once( APP_LIBRARIES_PATH . "posts/views/last_posts.php");

Manialink::endFrame();


require_once("footer.php");


?>