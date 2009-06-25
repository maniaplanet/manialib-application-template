<?php
/**
 * Admin manage posts
 * @author Maxime Raoust
 * @package posts
 */

require_once( dirname(__FILE__) . "/../core.inc.php" );

AdminEngine::checkAuthentication();

$posts = PostsEngine::getInstance();
$link = LinkEngine::getInstance();

if($postId = Gpc::get("post_id"))
{
	if($post = $posts->getPost($postId))
	{
		if(Gpc::get("edit"))
		{
			
			$session->set("post_object", rawurlencode(serialize($post)));
			$session->set("post_editing", 1);
			$link->redirectManialink("posts_post.php");
		}
		elseif(Gpc::get("delete"))
		{
			// TODO Confirm post deletion
			$post->dbDelete();
			$posts->clear();
		}
	}
}

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Manage posts");
$ui->subTitle->setText("Modify posts");
$ui->logo->setSubStyle("Paint");

$ui->quitButton->setManialink($link->createLinkArgList("posts.php"));
$ui->draw();

Manialink::beginFrame(15, 40, 1);
 
	$ui = new Panel(80, 80);
	$ui->setHalign("center");
	$ui->title->setText("Manage posts");
	$ui->draw();
	
	$i = 0;
	foreach($posts->getPosts() as $postId=>$post)
	{
		$images = (array) $post->getMetaTags("image");
		$image = reset($images);
		
		Manialink::beginFrame(-39, -6-$i*7, 1);
			
			$ui = new Quad(78, 7);
			$ui->setSubStyle("BgList");
			$ui->draw();
			
			$ui = new Icon(6);
			$ui->setPosition(1, -0.5, 1);
			$ui->setSubStyle("Paint");
			if($image)
			{
				$ui->setImage($image);			
			}
			$ui->draw();
			
			$link->setParam("post_id", $post->id);
			$linkstr = $link->createLink("../index.php");
			
			$ui = new Label(40);
			$ui->setPosition(10, -1, 1);
			$ui->setStyle("TextValueMedium");
			$ui->setText('$ff0' . $post->getTitle());
			$ui->setManialink($linkstr);
			$ui->draw();
			
			$link->setParam("edit", 1);
			$linkstr = $link->createLink();
			$link->deleteParam("edit");
			
			$ui = new Label(10);
			$ui->setPosition(58, -2.5, 1);
			$ui->setStyle("TextValueSmall");
			$ui->setText('$o$s' . "Edit");
			$ui->setManialink($linkstr);
			$ui->draw();
			
			$link->setParam("delete", 1);
			$linkstr = $link->createLink();
			$link->deleteParam("delete");
			
			$ui = new Label(10);
			$ui->setPosition(65, -2.5, 1);
			$ui->setStyle("TextValueSmall");
			$ui->setText('$o$s' . "Delete");
			$ui->setManialink($linkstr);
			$ui->draw();
			
			$ui = new Label(46);
			$ui->setPosition(10, -4, 1);
			$ui->setStyle("TextCardInfoSmall");
			$ui->setText('by $<$ccf' . $post->getAuthor() . '$>, ' . $post->getDate());
			$ui->draw();
			
		Manialink::endFrame();
		
		$i++;
	}

Manialink::endFrame();

require_once( APP_PATH . "footer.php" );

?>