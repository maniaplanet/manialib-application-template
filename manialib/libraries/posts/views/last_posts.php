<?php
/**
 * Last posts panel example
 * @author Maxime Raoust
 * @package posts
 */

$posts = PostsEngine::getInstance();
$request = RequestEngine::GetInstance();
 
$ui = new Panel(50, 60);
$ui->title->setText("Last posts");
$ui->draw();

$i = 0;
foreach($posts->getPosts() as $postId=>$post)
{
	$images = (array) $post->getMetaTags("image");
	$image = reset($images);
	
	Manialink::beginFrame(1, -6-$i*7, 1);
		
		$ui = new Quad(48, 7);
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
		
		$request->set("post_id", $post->id);
		
		$ui = new Label(40);
		$ui->setPosition(10, -1, 1);
		$ui->setStyle("TextValueMedium");
		$ui->setText('$ff0' . $post->getTitle());
		$ui->setManialink($request->createLink());
		$ui->draw();
		
		$ui = new Label(46);
		$ui->setPosition(10, -4, 1);
		$ui->setStyle("TextCardInfoSmall");
		$ui->setText('by $<$ccf' . $post->getAuthor() . '$>, ' . $post->getDate());
		$ui->draw();
		
	Manialink::endFrame();
	
	$i++;
}


?>