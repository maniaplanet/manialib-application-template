<?php

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('home', 'navigation');

// We create a FlowLayout to place elements in a grid
$layout = new FlowLayout(80, 80);
$layout->setMargin(2,2);

// Then we apply this layout to a new Frame.
Manialink::beginFrame(-16, 40, 1, $layout);
{
	// We loop to create 16 "dummy" ChallengeCard
	for($i=0; $i < 16; $i++)
	{
		$manialink = $request->createLink('example1.php');
		
		$ui = new ChallengeCard;
		$ui->bgImage->setStyle(null);
		$ui->bgImage->setBgcolor('ccc');
		$ui->text->setText('My track');
		$ui->setManialink($manialink);
		$ui->save();
	}
}
Manialink::endFrame();

?>