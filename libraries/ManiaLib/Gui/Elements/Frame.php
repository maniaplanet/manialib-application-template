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

class Frame extends \ManiaLib\Gui\Component implements \ManiaLib\Gui\Drawable
{

	protected $xml;

	/**
	 * @var \ManiaLib\Gui\Layouts\AbstractLayout
	 */
	protected $layout;

	/**
	 * @var \ManiaLib\Gui\Drawable[]
	 */
	protected $children;

	function __construct($sizeX = 0, $sizeY = 0)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
		$this->layout = new \ManiaLib\Gui\Layouts\Spacer($sizeX, $sizeY);
		$this->children = array();
	}

	/**
	 * @return \ManiaLib\Gui\Layouts\AbstractLayout
	 */
	function getLayout()
	{
		return $this->layout;
	}

	function setLayout(\ManiaLib\Gui\Layouts\AbstractLayout $layout)
	{
		$this->layout = $layout;
	}

	function onResize($oldX, $oldY)
	{
		$this->layout->setSize($this->sizeX, $this->sizeY);
	}

	function onScale($oldScale)
	{
		$this->layout->setScale($this->scale);
	}

	function add(\ManiaLib\Gui\Drawable $drawable)
	{
		$this->children[] = $drawable;
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
			$this->xml = \ManiaLib\Gui\Manialink::createElement('frame');
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

		$layout = $this->getParentLayout();
		if($layout instanceof Layouts\AbstractLayout)
		{
			$layout->preFilter($this);
			$layout->updateComponent($this);
		}

		$this->buildXML();

		foreach($this->children as $child)
		{
			$child->save();
		}

		if($layout instanceof Layouts\AbstractLayout)
		{
			$layout->postFilter($this);
		}

		$this->postFilter();
	}

}

?>