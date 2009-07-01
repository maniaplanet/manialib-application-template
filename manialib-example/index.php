<?php
/**
 * This file is part of ManiaLib.
 * 
 * ManiaLib is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * ManiaLib is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ManiaLib.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright Maxime Raoust 2009
 * 
 * @author Maxime Raoust
 * 
 */

// TODO Localize the application !
 
require_once("core.inc.php");

$request = RequestEngine::getInstance();

require_once("header.php");

require_once("navigation.php");

Manialink::beginFrame(-34, 48, 1);
	
	Manialink::beginFrame(45, -4, 1);
		
		PostsEngine::getInstance();
		if($request->get("post_id")) require_once( APP_LIBRARIES_PATH . "posts/views/show_post.php");
		else                    require_once( APP_LIBRARIES_PATH . "posts/views/last_posts.php");

	Manialink::endFrame();

Manialink::endFrame();

require_once("footer.php");


?>