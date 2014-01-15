<?php

namespace ManiaLibDemo\Cards;

use ManiaLib\Gui\Elements\Label;

class TextBox extends Box
{

	/**
	 * @var Label
	 */
	public $label;
	public $labelHMargin = 4;
	public $labelVMargin = 4;

	function __construct($sizeX = 100, $sizeY = 50)
	{
		parent::__construct($sizeX, $sizeY);

		$this->label = new Label($sizeX - $this->labelHMargin, $sizeY - $this->labelHMargin);
		$this->label->setRelativeAlign('center', 'center');
		$this->label->setAlign('center', 'center');
		$this->label->setPosition(0, 0, 0.1);
		$this->label->setStyle(null);
		$this->label->setTextColor('000');
		$this->label->setTextSize(4);
		$this->add($this->label);
	}

	function onResize($oldX, $oldY)
	{
		parent::onResize($oldX, $oldY);
		$this->label->setSize($this->sizeX - $this->labelHMargin, $this->sizeY - $this->labelHMargin);
	}

	function onScale($oldScale)
	{
		parent::onScale($oldScale);
		$this->label->setScale($this->scale);
	}

}
