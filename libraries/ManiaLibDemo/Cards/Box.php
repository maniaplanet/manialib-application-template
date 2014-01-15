<?php

namespace ManiaLibDemo\Cards;

use ManiaLib\Gui\Elements\Frame;
use ManiaLib\Gui\Elements\Quad;
use ManiaLib\Gui\Layouts\Spacer;

class Box extends Frame
{

	/**
	 * @var Quad
	 */
	public $bg;

	function __construct($sizeX = 100, $sizeY = 50)
	{
		parent::__construct($sizeX, $sizeY);

		$this->layout = new Spacer($sizeX, $sizeY);

		$this->bg = new Quad($sizeX, $sizeY);
		$this->add($this->bg);
	}

	function onResize($oldX, $oldY)
	{
		parent::onResize($oldX, $oldY);
		$this->bg->setSize($this->sizeX, $this->sizeY);
	}

	function onScale($oldScale)
	{
		parent::onScale($oldScale);
		$this->bg->setScale($this->scale);
	}

}
