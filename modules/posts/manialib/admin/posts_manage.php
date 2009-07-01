<?php
/**
 * Admin manage posts
 * @author Maxime Raoust
 * @package posts
 */

require_once( dirname(__FILE__) . "/../core.inc.php" );

AdminEngine::checkAuthentication();

$posts = PostsEngine::getInstance();
$request = RequestEngine::getInstance();

$currentPage = abs((int) $request->get("page", 1)); 

if($postId = $request->get("post_id"))
{
	if($post = $posts->getPost($postId))
	{
		if($request->get("edit"))
		{
			
			$session->set("post_object", rawurlencode(serialize($post)));
			$session->set("post_editing", 1);
			$request->redirectManialink("posts_post.php");
		}
		elseif($request->get("delete") && $request->get("confirm"))
		{
			$post->dbDelete();
			$posts->clear();
			$request->delete("delete");
			$request->delete("confirm");
		}
	}
}

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Manage posts");
$ui->subTitle->setText("Modify posts");
$ui->logo->setSubStyle("Paint");

$ui->quitButton->setManialink($request->createLinkArgList("posts.php"));
$ui->save();

Manialink::beginFrame(15, 44, 1);
 
	$ui = new Panel(80, 84);
	$ui->setHalign("center");
	$ui->title->setText("Manage posts");
	$ui->save();

	if($request->get("delete"))
	{
		$ui = new Label(50);
		$ui->setHalign("center");
		$ui->setPosition(0, -10, 1);
		$ui->enableAutoNewLine();
		$ui->setStyle("TextRaceValue");
		$ui->setText("Do you really want to delete this post ?");
		$ui->save();
		
		$request->set("confirm", 1);
		$link = $request->createLink();
		
		$ui = new Button;
		$ui->setHalign("center");
		$ui->setPosition(0, -30, 1);
		$ui->setText("Confirm");
		$ui->setManialink($link);
		$ui->save();
	}
	else
	{
		$i = 0;
		foreach($posts->getPosts($currentPage) as $postId=>$post)
		{
			$images = (array) $post->getMetaTags("image");
			$image = reset($images);
			
			Manialink::beginFrame(-39, -6-$i*7, 1);
				
				$ui = new Quad(78, 7);
				$ui->setSubStyle("BgList");
				$ui->save();
				
				$ui = new Icon(6);
				$ui->setPosition(1, -0.5, 1);
				$ui->setSubStyle("Paint");
				if($image)
				{
					$ui->setImage($image);			
				}
				$ui->save();
				
				$request->set("post_id", $post->id);
				$link = $request->createLink("../index.php");
				
				$ui = new Label(40);
				$ui->setPosition(10, -1, 1);
				$ui->setStyle("TextValueMedium");
				$ui->setText('$ff0' . $post->getTitle());
				$ui->setManialink($link);
				$ui->save();
				
				$request->set("edit", 1);
				$link = $request->createLink();
				$request->delete("edit");
				
				$ui = new Label(10);
				$ui->setPosition(58, -2.5, 1);
				$ui->setStyle("TextValueSmall");
				$ui->setText('$o$s' . "Edit");
				$ui->setManialink($link);
				$ui->save();
				
				$request->set("delete", 1);
				$link = $request->createLink();
				$request->delete("delete");
				
				$ui = new Label(10);
				$ui->setPosition(65, -2.5, 1);
				$ui->setStyle("TextValueSmall");
				$ui->setText('$o$s' . "Delete");
				$ui->setManialink($link);
				$ui->save();
				
				$ui = new Label(46);
				$ui->setPosition(10, -4, 1);
				$ui->setStyle("TextCardInfoSmall");
				$ui->setText('by $<$ccf' . $post->getAuthor() . '$>, ' . $post->getDate());
				$ui->save();
				
			Manialink::endFrame();
			
			$i++;
		}
	}
	
	$request->delete("post_id");
	
	$ui = new PageNavigator;
	$ui->setPosition(0, -80, 1);
	$ui->hideText();
	$ui->hideLast();
	
	
	if($currentPage > 1)
	{
		$request->set("page", $currentPage-1);
		$link = $request->createLink();
		
		$ui->arrowPrev->setManialink($link);
	}
	
	if($posts->hasMorePosts())
	{
		$request->set("page", $currentPage+1);
		$link = $request->createLink();
		
		$ui->arrowNext->setManialink($link);
	}
	
	$request->restore("page");
	
	$ui->save();
	
Manialink::endFrame();

require_once( APP_PATH . "footer.php" );

?>