<?php
/**
 * Last posts panel example
 * @author Maxime Raoust
 * @package posts
 */

$posts = PostsEngine::getInstance();
$request = RequestEngine::GetInstance();
 
$currentPage = abs((int) $request->get("page", 1)); 
 
$ui = new Panel(50, 84);
$ui->title->setText("Last posts");
$ui->save();

$i = 0;
foreach($posts->getPosts($currentPage) as $postId=>$post)
{
	$images = (array) $post->getMetaTags("image");
	$image = reset($images);
	
	Manialink::beginFrame(1, -6-$i*7, 1);
		
		$ui = new Quad(48, 7);
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
		$link = $request->createLink();
		$request->delete("post_id");
		
		$ui = new Label(40);
		$ui->setPosition(10, -1, 1);
		$ui->setStyle("TextValueMedium");
		$ui->setText('$ff0' . $post->getTitle());
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

$ui = new PageNavigator;
$ui->setPosition(25, -80, 1);


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


?>