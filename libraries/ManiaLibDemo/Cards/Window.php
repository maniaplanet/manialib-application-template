<?php

namespace ManiaLibDemo\Cards;

use ManiaLib\Gui\Elements\Bgs1;
use ManiaLib\Gui\Elements\Frame;
use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Elements\Quad;

class Window extends Frame
{

	/**
	 * @var TextBox
	 */
	public $title;

	/**
	 * @var Box
	 */
	public $content;

	function __construct($sizeX = 100, $sizeY = 50)
	{
		parent::__construct($sizeX, $sizeY);

		$this->title = new TextBox($sizeX, 20);
		$this->title->setRelativeHalign('center');
		$this->title->setHalign('center');
		$this->title->bg->setStyle(Quad::Bgs1);
		$this->title->bg->setSubStyle(Bgs1::BgTitle3);
		$this->title->label->setStyle(Label::TextTitle3);
		$this->add($this->title);

		$this->content = new Box($sizeX - 4, $sizeY - 20);
		$this->content->setRelativeHalign('center');
		$this->content->setHalign('center');
		$this->content->setPosition(0, -20);
		$this->content->bg->setStyle(Quad::Bgs1);
		$this->content->bg->setSubStyle(Bgs1::BgWindow2);
		$this->add($this->content);
	}

	function onResize($oldX, $oldY)
	{
		parent::onResize($oldX, $oldY);
		$this->title->setSizeX($this->sizeX);
		$this->content->setSize($this->sizeX - 4, $this->sizeY - 20);
	}

	function onScale($oldScale)
	{
		parent::onScale($oldScale);
		$this->title->setScale($this->scale);
		$this->content->setScale($this->scale);
	}

}
