<?php
/**
 * Show post panel example
 * @author Maxime Raoust
 * @package posts
 */

$posts = PostsEngine::getInstance();
$link = LinkEngine::GetInstance();

$post = $posts->getPost(Gpc::get("post_id"));

$ui = new Panel(50, 60);
$ui->title->setText("Post");
$ui->draw();

if($post)
{
	$images = $post->getImages();
	$image = reset($images);
	$tags = implode(", ", (array) $post->getTags());
	
	Manialink::beginFrame(1, -6, 1);
		
		$ui = new Quad(48, 48);
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
		
		$ui = new Label(40);
		$ui->setPosition(10, -1, 1);
		$ui->setStyle("TextValueMedium");
		$ui->setText('$ff0' . $post->getTitle());
		$ui->setManialink($link->createLink());
		$ui->draw();
		
		$ui = new Label(46);
		$ui->setPosition(10, -4, 1);
		$ui->setStyle("TextCardInfoSmall");
		$ui->setText('by $<$ccf' . $post->getAuthor() . '$>, ' . $post->getDate());
		$ui->draw();
		
		$ui = new Label(46);
		$ui->setPosition(2, -8, 1);
		$ui->setText('$<$o$ff0Tags: $>' . $tags);
		$ui->draw();
		
		$ui = new Label(46);
		$ui->setPosition(2, -12, 1);
		$ui->enableAutoNewLine();
		$ui->setMaxline(13);
		$ui->setText($post->getContent());
		$ui->draw();
		
	Manialink::endFrame();
}

$link->deleteParam("post_id");
$linkstr = $link->createLink("index.php");

$ui = new Button;
$ui->setHalign("center");
$ui->setPosition(25, -55, 1);
$ui->setScale(0.8);
$ui->setText("Back");
$ui->setManialink($linkstr);
$ui->draw();


?>