<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Gui\Elements;

use ManiaLib\Gui\Component;
use ManiaLib\Gui\Drawable;
use ManiaLib\Gui\Layouts\AbstractLayout;
use ManiaLib\Gui\Manialink;

class Frame extends Component implements Drawable
{

	protected $xml;

	/**
	 * @var AbstractLayout
	 */
	protected $layout;

	/**
	 * @var Component[]
	 */
	protected $children;

	function __construct($sizeX = 0, $sizeY = 0)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
		$this->children = array();
	}

	/**
	 * @return AbstractLayout
	 */
	function getLayout()
	{
		return $this->layout;
	}

	function setLayout(AbstractLayout $layout)
	{
		$this->layout = $layout;
	}

	function onResize($oldX, $oldY)
	{
		if($this->layout instanceof AbstractLayout)
		{
			$this->layout->setSize($this->sizeX, $this->sizeY);
		}
	}

	function onScale($oldScale)
	{
		if($this->layout instanceof AbstractLayout)
		{
			$this->layout->setScale($this->scale);
		}
	}

	function add(Component $component)
	{
		$this->children[] = $component;
	}

	function preFilter()
	{
		
	}

	function postFilter()
	{
		
	}

	function buildXML()
	{
		if(!$this->xml)
		{
			$this->xml = Manialink::createElement('frame');
			$this->getParentNode()->appendChild($this->xml);
		}

		if($this->id !== null) $this->xml->setAttribute('id', $this->id);

		if($this->posX || $this->posY || $this->posZ)
		{
			$this->xml->setAttribute('posn', $this->posX.' '.$this->posY.' '.$this->posZ);
		}
		if($this->scale !== null) $this->xml->setAttribute('scale', $this->scale);
	}

	function getDOMElement()
	{
		return $this->xml;
	}

	final function save()
	{
		if($this->visible === false)
		{
			return;
		}

		$this->preFilter();

		if($this->layout instanceof AbstractLayout)
		{
			$layout = $this->getParentLayout();
			if($layout instanceof AbstractLayout)
			{
				$layout->preFilter($this->layout);
				$layout->updateComponent($this);
			}
		}

		$x = \ManiaLib\Gui\Tools::getAlignedPosX(0, $this->sizeX, $this->getHalign('left'), 'left');
		$y = \ManiaLib\Gui\Tools::getAlignedPosY(0, $this->sizeY, $this->getValign('top'), 'top');

		$this->incPosX($x);
		$this->incPosY($y);

		$this->buildXML();

		foreach($this->children as $child)
		{
			$child->setParentNode($this->xml);
			$child->setParentLayout($this->layout);
			$child->setParentFrame($this);
			$child->incPosZ(0.1);
			if($child instanceof Drawable)
			{
				$child->save();
			}
		}

		if($this->layout instanceof AbstractLayout)
		{
			if($layout instanceof AbstractLayout)
			{
				$layout->postFilter($this->layout);
			}
		}

		$this->postFilter();
	}

}

?>