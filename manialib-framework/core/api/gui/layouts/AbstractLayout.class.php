<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Abstract class for defining layout managers
 * @package gui_api
 */
abstract class AbstractLayout extends GuiElement
{
	protected $items;
	protected $xIndex;
	protected $yIndex;
	protected $marginWidth;
	protected $marginHeight;
	protected $borderWidth;
	protected $borderHeight;

	// TODO Support scaling
	// TODO Support aligning
	// TODO Support overflow on/off

	/**
	 * Either you can pass a reference to a GuiElement in the constructor
	 * and it will set the size & position, or you can specify the size 
	 * in the constructor as with most of GuiElement classes
	 */
	function __construct()
	{
		$args = func_get_args();
		if (isset ($args[0]))
		{
			// If a GuiElement is passed as 1st parameter
			if ($args[0] instanceof GuiElement)
			{
				$this->sizeX = $args[0]->getSizeX();
				$this->sizeY = $args[0]->getSizeY();
				$this->posX = $args[0]->getPosX();
				$this->posY = $args[0]->getPosY();
				$this->posZ = $args[0]->getPosZ() + 1;
			}
			else
			{
				// If a numeric is passed as 1st paramater
				if (is_numeric($args[0]))
				{
					$this->sizeX = $args[0];
				}
				// If a numeric is passed as 2nd parameter
				if (isset ($args[1]) && is_numeric($args[1]))
				{
					$this->sizeY = $args[1];
				}
				$this->posX = 0;
				$this->posY = 0;
				$this->posZ = 0;
			}
		}
		$this->marginWidth = 0;
		$this->marginHeight = 0;
		$this->borderHeight = 0;
		$this->borderWidth = 0;
		$this->items = array ();
	}

	public function setMarginWidth($marginWidth)
	{
		$this->marginWidth = $marginWidth;
	}

	public function setMarginHeight($marginHeight)
	{
		$this->marginHeight = $marginHeight;
	}

	public function setMargin($marginWidth = 0, $marginHeight = 0)
	{
		$this->marginWidth = $marginWidth;
		$this->marginHeight = $marginHeight;
	}

	public function getMarginWidth()
	{
		return $this->marginWidth;
	}

	public function getMarginHeight()
	{
		return $this->marginHeight;
	}

	public function setBorderWidth($borderWidth)
	{
		$this->borderWidth = $borderWidth;
	}

	public function setBorderHeight($borderHeight)
	{
		$this->borderHeight = $borderHeight;
	}

	public function setBorder($borderWidth = 0, $borderHeight = 0)
	{
		$this->borderWidth = $borderWidth;
		$this->borderHeight = $borderHeight;
	}

	public function getBorderWidth()
	{
		return $this->borderWidth;
	}

	public function getBorderHeight()
	{
		return $this->borderHeight;
	}

	public function add(GuiElement $item)
	{
		array_push($this->items, $item);
	}

	// TODO Improve the gap system
	/**
	 * Add a gap between an element and the next one.
	 * The gap direction depends on the layout
	 */
	public function addGap($size)
	{
		$ui = new Quad($size, $size);
		$ui->setStyle(null);
		$ui->setSubStyle(null);
		$this->add($ui);
	}

	/**
	 * Render the layout and all its elements
	 */
	public function save()
	{
		$this->xIndex += $this->borderWidth;
		$this->yIndex -= $this->borderHeight;

		Manialink::beginFrame($this->posX, $this->posY, $this->posZ);
		foreach ($this->items as $item)
		{
			$item->setPosition($this->xIndex, $this->yIndex, 1);
			$this->updateLayout($item);
			$item->save();
		}
		Manialink::endFrame();
	}

	/**
	 * This method is called after each rendering of a GUI item. 
	 * Override it to define the layout behaviour. 
	 */
	abstract protected function updateLayout(GuiElement $item);

}
?>