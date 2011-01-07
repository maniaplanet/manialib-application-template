<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Gui\Cards;

/**
 * Panel
 * Very useful! A quad with a title and a title background
 */
class Panel extends \ManiaLib\Gui\Elements\Quad
{
	/**
	 * @var \ManiaLib\Gui\Elements\Label
	 */
	public $title;
	/**
	 * Title background
	 * @var \ManiaLib\Gui\Elements\Quad
	 */
	public $titleBg;
	
	function __construct ($sx=20, $sy=20)
	{	
		$this->sizeX = $sx;
		$this->sizeY = $sy;

		$this->cardElementsHalign = 'center';
		$this->cardElementsPosY = -1;
		
		$titleBgWidth = $sx - 2;
		$titleWidth = $sx - 4;
		
		$this->setStyle(\ManiaLib\Gui\DefaultStyles::Panel_Style);
		$this->setSubStyle(\ManiaLib\Gui\DefaultStyles::Panel_Substyle);
		
		$this->titleBg = new \ManiaLib\Gui\Elements\Quad ($titleBgWidth, 4);
		$this->titleBg->setHalign("center");
		$this->titleBg->setStyle(\ManiaLib\Gui\DefaultStyles::Panel_TitleBg_Style);
		$this->titleBg->setSubStyle(\ManiaLib\Gui\DefaultStyles::Panel_TitleBg_Substyle);
		
		$this->addCardElement($this->titleBg);
		
		$this->title = new \ManiaLib\Gui\Elements\Label ($titleWidth);
		$this->title->setHalign("center");
		$this->title->setPositionY(-0.75);
		$this->title->setStyle(\ManiaLib\Gui\DefaultStyles::Panel_Title_Style);
		
		$this->addCardElement($this->title);
		
	}
	
	function setSizeX($x)
	{
		parent::setSizeX($x);
		$this->titleBg->setSizeX($x-2);
		$this->title->setSizeX($x-4);
	}
}

?>