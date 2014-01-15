<?php

namespace ManiaLibDemo\Views\Home;

use ManiaLib\Application\View;
use ManiaLibDemo\Cards\Window;

class Index extends View
{

	function display()
	{
		$ui = new Window(150, 70);
		$ui->setAlign('center', 'center');
		$ui->title->label->setText('Hello world');
		$ui->save();

	}

}

?>