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

use ManiaLib\Gui\Elements\Frame;

/*
 * Yep it should extend both Frame and Quad but eh!
 */
class Frame3d extends Frame
{
	protected $xmlTagName = 'frame3d';

	const Back = 'Back';
	const NavButton = 'NavButton';
	const Window2 = 'Window2';
	const Window3 = 'Window3';
	const TitlePage = 'TitlePage';
	const Title2 = 'Title2';
	const Title3 = 'Title3';
	const Title3_1 = 'Title3_1';
	const Title3_2 = 'Title3_2';
	const Title3_3 = 'Title3_3';
	const Title3_4 = 'Title3_4';
	const Title3_5 = 'Title3_5';
	const Titlelogo = 'Titlelogo';

	protected $style = \ManiaLib\Gui\Elements\Bgs1::Bgs1;
	protected $subStyle = \ManiaLib\Gui\Elements\Bgs1::BgTitle3_2;
	protected $style3d = self::Title3_3;

	protected $manialink;

	function __construct($sizeX, $sizeY)
	{
		parent::__construct($sizeX, $sizeY);

		$this->halign = 'left';
		$this->valign = 'top';
	}

	function setManialink($manialink)
	{
		$this->manialink = $manialink;
	}

	function buildXML()
	{
		parent::buildXML();

		if($this->style !== null) $this->xml->setAttribute('style', $this->style);
		if($this->subStyle !== null) $this->xml->setAttribute('substyle', $this->subStyle);
		if($this->style3d !== null) $this->xml->setAttribute('style3d', $this->style3d);

		if($this->sizeX || $this->sizeY)
		{
			$this->xml->setAttribute('sizen', $this->sizeX.' '.$this->sizeY);
		}

		// Add alignement
		if($this->halign !== null) $this->xml->setAttribute('halign', $this->halign);
		if($this->valign !== null) $this->xml->setAttribute('valign', $this->valign);

		if ($this->manialink !== null) $this->xml->setAttribute('manialink', $this->manialink);
	}
}
?>