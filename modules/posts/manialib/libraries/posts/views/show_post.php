<?php
/**
 * Show post panel example
 * @author Maxime Raoust
 * @package posts
 */

$posts = PostsEngine::getInstance();
$request = RequestEngine::GetInstance();

$post = $posts->getPost($request->get("post_id"));

$ui = new Panel(50, 84);
$ui->title->setText("Post");
$ui->save();

if($post)
{
	$images = (array) $post->getMetaTags("image");
	$image = reset($images);
	$tags = implode(", ", (array) $post->getMetaTags("tag"));
	
	Manialink::beginFrame(1, -6, 1);
		
		$ui = new Quad(48, 70);
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
		
		$ui = new Label(40);
		$ui->setPosition(10, -1, 1);
		$ui->setStyle("TextValueMedium");
		$ui->setText('$ff0' . $post->getTitle());
		$ui->setManialink($request->createLink());
		$ui->save();
		
		$ui = new Label(46);
		$ui->setPosition(10, -4, 1);
		$ui->setStyle("TextCardInfoSmall");
		$ui->setText('by $<$ccf' . $post->getAuthor() . '$>, ' . $post->getDate());
		$ui->save();
		
		$ui = new Label(46);
		$ui->setPosition(2, -8, 1);
		$ui->setText('$<$o$ff0Tags: $>' . $tags);
		$ui->save();
		
		$ui = new Label(44);
		$ui->setPosition(2, -12, 1);
		$ui->enableAutonewline();
		$ui->setMaxline(22);
		$ui->setText($post->getContent());
		$ui->save();
		
	Manialink::endFrame();
}

$request->delete("post_id");
$link = $request->createLink("index.php");

$ui = new Button;
$ui->setHalign("center");
$ui->setPosition(25, -78, 1);
$ui->setScale(0.8);
$ui->setText("Back");
$ui->setManialink($link);
$ui->save();


?>