<?php
/**
 * Admin page to create a new post
 * @author Maxime Raoust
 * @package posts
 */
 
require_once( dirname(__FILE__) . "/../core.inc.php" );

AdminEngine::checkAuthentication();

// TODO Save date created / date modified in posts
// TODO Allow adding of more tags ?

////////////////////////////////////////////////////////////////////////////////
// Processing
////////////////////////////////////////////////////////////////////////////////

$session = SessionEngine::getInstance();
$link = LinkEngine::getInstance();

$currentStep = Gpc::get("step", 1);
$isEditing = (bool) $session->get("post_editing", false);

$steps = array (
	1 => "Choose a type",
	2 => "Write content",
	3 => "Add meta tags",
	4 => "Publish !"
);

$post = $session->get("post_object");
if($post)
{
	$post = unserialize(rawurldecode($post));
}
else
{
	$post = new Post;
	$post->setAuthor($session->get("login"));
}

switch($currentStep)
{
	// Choose a type
	case 1:
	
	break;
	
	// Save type
	case 2:
		$post->setPostType(intval(Gpc::get("post_type", 0)));
		$link->deleteParam("post_type");
		
	break;
	
	// Save content & title
	case 3 :
		$post->setTitle(Gpc::get("post_title"));
		$post->setContent(Gpc::get("post_content"));
		$link->deleteParam("post_title");
		$link->deleteParam("post_content");
		
	break;
	
	// Save tags
	case 4 :
		for($i=1; $i<=10; $i++)
		{
			$link->deleteParam("meta_tag_name$i");
			$link->deleteParam("meta_tag_value$i");
			
			if($tagName = Gpc::get("meta_tag_name$i"))
			{
				if($tagValue = Gpc::get("meta_tag_value$i"))
				{
					$post->addMetaTag($tagName, $tagValue);
				}
			}
		}
	break;
	
	// Publish
	case 5:
		$post->dbUpdate();
		unset($post);
		$session->delete("post_object");
		$session->delete("post_editing");
		$link->redirectManialink("posts_manage.php");
	break;
	
	// Default
	default: 
	
	
}

if(isset($post))
	$session->set("post_object", rawurlencode(serialize($post)));

////////////////////////////////////////////////////////////////////////////////
// GUI
////////////////////////////////////////////////////////////////////////////////

require_once( APP_PATH . "header.php" );

// Begin navigation
$ui = new Navigation;
if($isEditing)
{
	$ui->title->setText("Edit post");
	$ui->subTitle->setText("Manage content");
}
else
{
	$ui->title->setText("New post");
	$ui->subTitle->setText("Add content");
}
$ui->logo->setSubStyle("Paint");

foreach($steps as $stepId=>$stepName)
{
	if($stepId == $currentStep)
	{
		$style = '$i$ff0';
	}
	else
	{
		$style = '$999';
	}
	
	$ui->addItem();
	$ui->lastItem()->icon->setSubStyle(null);
	$ui->lastItem()->text->setText($style.$stepName);

}

$ui->quitButton->setManialink($link->createLinkArgList("posts.php"));
$ui->draw();
// End navigation

Manialink::beginFrame(-34, 48, 1);
	
	Manialink::beginFrame(49,-5, 1);
		
		switch($currentStep)
		{
			// Choose a type
			case 1:
				$ui = new Panel(80, 80);
				$ui->setHalign("center");
				$ui->title->setText("Post type");
				$ui->draw();
				
				$ui = new Quad(40, 60);
				$ui->setHalign("center");
				$ui->setPosition(0, -10, 1);
				$ui->setSubStyle("BgCardList");
				$ui->draw();
				
				$i = 0;
				
				foreach(PostsStructure::getPostTypes() as $postTypeId=>$postTypeName)
				{
					$style = '$o';
					if($post->getPostType() == $postTypeId)
					{
						$style .= '$ff0';
					}
					
					$link->setParam("post_type", $postTypeId);
					$link->setParam("step", $currentStep+1);
					$linkstr = $link->createLink("posts_post.php");

					Manialink::beginFrame(0, -11-5*$i, 2);
						
						$ui = new Quad(38, 5);
						$ui->setHalign("center");
						$ui->setSubStyle("BgCardSystem");
						$ui->setManialink($linkstr);
						$ui->draw();
						
						$ui = new Label(50);
						$ui->setAlign("center", "center");
						$ui->setPosition(0, -2.5, 1);
						$ui->setTextColor("000");
						$ui->setTextSize(2);
						$ui->setText($style . $postTypeName);
						$ui->draw();
					
					Manialink::endFrame();
					
					$i++;
				}
			break;
			
			// Write content
			case 2:
				$ui = new Panel(80, 80);
				$ui->setHalign("center");
				$ui->title->setText("Write content");
				$ui->draw();
				
				$ui = new Label;
				$ui->setPosition(-36, -7, 1);
				$ui->setStyle("TextRaceMessage");
				$ui->setText("Title");
				$ui->draw();
				
				$ui = new Entry(72);
				$ui->setPosition(-36, -11, 1);
				$ui->setName("title");
				$ui->setDefault($post->getTitle());
				$ui->draw();
				
				$link->setParam("post_title", "title");
				
				$ui = new Label;
				$ui->setPosition(-36, -20, 1);
				$ui->setStyle("TextRaceMessage");
				$ui->setText("Content");
				$ui->draw();
				
				$ui = new Entry(72, 45);
				$ui->setPosition(-36, -24, 1);
				$ui->enableAutoNewLine();
				$ui->setMaxline(13);
				$ui->setName("content");
				$ui->setDefault($post->getContent());
				$ui->draw();
				
				$link->setParam("post_content", "content");
				
				$link->setParam("step", $currentStep+1);
				$linkstr = $link->createLink("posts_post.php");
				
				$ui = new Button;
				$ui->setHalign("center");
				$ui->setPosition(0, -72, 1);
				$ui->setText("Continue");
				$ui->setManialink($linkstr);
				$ui->draw();
				
			break;
			
			// Add tags
			case 3:
				
				$tags = $post->getAllMetaTags();
				
				
				$ui = new Panel(80, 80);
				$ui->setHalign("center");
				$ui->title->setText("Add meta tags");
				$ui->draw();
				
				$ui = new Label;
				$ui->setPosition(-36, -9, 1);
				$ui->setStyle("TextRaceMessage");
				$ui->setText("Meta tag name");
				$ui->draw();
				
				$ui = new Label;
				$ui->setPosition(0, -9, 1);
				$ui->setStyle("TextRaceMessage");
				$ui->setText("Meta tag value");
				$ui->draw();
				
				for($i=1; $i<=10; $i++)
				{
					$name = "";
					$value = "";
					if($tag = current($tags))
					{
						$name = $tag[0];
						$value = $tag[1];
						next($tags);
					}
					
					Manialink::beginFrame(0, -11-5*$i, 1);
					
						$ui = new Entry(34);
						$ui->setPositionX(-36);
						$ui->setName("meta_tag_name$i");
						$ui->setDefault($name);
						$ui->draw();
						
						$link->setParam("meta_tag_name$i", "meta_tag_name$i");
						
						$ui = new Entry(34);
						$ui->setPositionX(0);
						$ui->setName("meta_tag_value$i");
						$ui->setDefault($value);
						$ui->draw();
						
						$link->setParam("meta_tag_value$i", "meta_tag_value$i");
					
					Manialink::endFrame();
				}
				
				$link->setParam("step", $currentStep+1);
				$linkstr = $link->createLink("posts_post.php");
				
				$ui = new Button;
				$ui->setHalign("center");
				$ui->setPosition(0, -72, 1);
				$ui->setText("Continue");
				$ui->setManialink($linkstr);
				$ui->draw();
				
			break;
			
			// Publish
			case 4:
				$ui = new Panel(80, 80);
				$ui->setHalign("center");
				$ui->title->setText("Publish");
				$ui->draw();
				
				$ui = new Label(60);
				$ui->setHalign("center");
				$ui->setPosition(0, -10, 1);
				$ui->setStyle("TextRaceMessage");
				$ui->setText("Your post is ready to be published.");
				$ui->draw();
				
				$link->setParam("step", $currentStep+1);
				$linkstr = $link->createLink("posts_post.php");
				
				$ui = new Button;
				$ui->setHalign("center");
				$ui->setPosition(0, -20, 1);
				$ui->setScale(2);
				$ui->setText("Publish");
				$ui->setManialink($linkstr);
				$ui->draw();
				
			break;
				$ui = new Panel(80, 80);
				$ui->setHalign("center");
				$ui->title->setText("Published");
				$ui->draw();
				
				$ui = new Label(60);
				$ui->setHalign("center");
				$ui->setPosition(0, -10, 1);
				$ui->setStyle("TextRaceMessage");
				$ui->setText("Your post was successfully published !");
				$ui->draw();
			
			// Default
			default:
		}
	
	Manialink::endFrame();

Manialink::endFrame();

require_once( APP_PATH . "footer.php" );

?>