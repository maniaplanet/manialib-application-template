<?php
/**
 * @author Maxime Raoust
 */

require_once ('core.inc.php');

$request = RequestEngine::getInstance();
$request->registerReferer();

require_once (APP_WWW_PATH.'header.php');

require_once (APP_WWW_PATH.'navigation.php');

$layout = new FlowLayout(70, 70);
$layout->setMargin(3, 3);

Manialink::beginFrame(-33, 45, 1, $layout);
{
	$layout = new NullLayout(30, 30);
	Manialink::beginFrame(0, 0, 1, $layout);
	{
		////////////////////////////////////////////////////////////////////////
		// ColumnLayout example
		////////////////////////////////////////////////////////////////////////
		
		$ui = new Panel(30, 30);
		$ui->title->setText('ColumnLayout');
		$ui->save();
		
		$layout = new ColumnLayout(30, 30);
		$layout->setMarginHeight(1);
		$layout->setBorder(1, 6);
		
		Manialink::beginFrame(0, 0, 1, $layout);
		{
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
		}
		Manialink::endFrame();
	}
	Manialink::endFrame();
	
	$layout = new NullLayout(30, 30);
	Manialink::beginFrame(0, 0, 1, $layout);
	{
		////////////////////////////////////////////////////////////////////////
		// LineLayout example
		////////////////////////////////////////////////////////////////////////
		
		$ui = new Panel(30, 30);
		$ui->title->setText('LineLayout');
		$ui->save();
		
		$layout = new LineLayout(30, 30);
		$layout->setMarginWidth(1);
		$layout->setBorder(1, 6);
		
		Manialink::beginFrame(0, 0, 1, $layout);
		{
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
		}
		Manialink::endFrame();
	}
	Manialink::endFrame();

	$layout = new NullLayout(30, 30);
	Manialink::beginFrame(0, 0, 1, $layout);
	{
		////////////////////////////////////////////////////////////////////////
		// FlowLayout example
		////////////////////////////////////////////////////////////////////////
		
		$ui = new Panel(30, 30);
		$ui->title->setText('FlowLayout');
		$ui->save();
		
		$layout = new FlowLayout(30, 30);
		$layout->setMargin(1, 1);
		$layout->setBorder(1, 6);
		
		Manialink::beginFrame(0, 0, 1, $layout);
		{
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
			
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
			
			$ui = new Quad(5, 5);
			$ui->save();
			
			$ui = new Quad(5, 5);
			$ui->save();
			
			$ui = new Quad(5, 5);
			$ui->save();
		}
		Manialink::endFrame();
	}
	Manialink::endFrame();

	$layout = new NullLayout(30, 30);
	Manialink::beginFrame(0, 0, 1, $layout);
	{
		////////////////////////////////////////////////////////////////////////
		// FlowLayout example 2
		////////////////////////////////////////////////////////////////////////
		
		$ui = new Panel(30, 30);
		$ui->title->setText('FlowLayout');
		$ui->save();
		
		$layout = new FlowLayout(30, 30);
		$layout->setMargin(1, 1);
		$layout->setBorder(1, 6);
		
		Manialink::beginFrame(0, 0, 1, $layout);
		{
			$ui = new Quad(5, 1);
			$ui->save();
		
			$ui = new Quad(5, 2);
			$ui->save();
		
			$ui = new Quad(5, 3);
			$ui->save();
			
			$ui = new Quad(5, 4);
			$ui->save();
		
			$ui = new Quad(5, 5);
			$ui->save();
		
			$ui = new Quad(1, 5);
			$ui->save();
			
			$ui = new Quad(2, 5);
			$ui->save();
			
			$ui = new Quad(3, 5);
			$ui->save();
			
			$ui = new Quad(4, 5);
			$ui->save();
			
			$ui = new Quad(5, 5);
			$ui->save();
			
			$ui = new Quad(35, 5);
			$ui->save();$ui = new Quad(35, 5);
			$ui->save();
		}
		Manialink::endFrame();
	}
	Manialink::endFrame();
}
Manialink::endFrame();

require_once (APP_WWW_PATH.'footer.php');

?>