<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Challenge card
 * @package gui_api
 */ 
class ChallengeCard extends Quad
{
	public $image;
	public $text;
	public $points;
	public $lockedMessage;
	protected $showArrow = false;
	
	protected $sizeX = 16;
	protected $sizeY = 17;
	protected $medal;
	
	protected $clickable = true;
	protected $clickableMask;
	protected $clickableLock;
	
	function __construct ()
	{
		$this->setStyle("BgsChallengeMedals");
		$this->setSubStyle("BgNotPlayed");
		
		$this->image = new Quad(15, 13.5);
		$this->image->setHalign("center");
		$this->image->setPosition(0, -0.5, 0);
		
		$this->points = new Label(9);
		$this->points->setPosition(-6.5, -10.75, 2);
		
		$this->text = new Label(15);
		$this->text->setPosition(0, -14, 4);
		$this->text->setHalign("center");
		$this->text->setStyle("TextChallengeNameSmall");
		
		$this->lockedMessage = new Label(13);
		$this->lockedMessage->setPosition(0, -1.5, 2);
		$this->lockedMessage->setHalign("center");
		$this->lockedMessage->enableAutoNewLine();
		$this->lockedMessage->setStyle("TextRaceChat");
		
		$this->clickableMask = new Quad($this->sizeX, $this->sizeY);
		$this->clickableMask->setHalign("center");
		$this->clickableMask->setPositionZ(1);
		$this->clickableMask->setStyle("BgsPlayerCard");
		$this->clickableMask->setSubStyle("BgPlayerName");
		
		$this->clickableLock = new Icon(7.5);
		$this->clickableLock->setPosition(8, -14, 2);
		$this->clickableLock->setAlign("right", "bottom");
		$this->clickableLock->setSubStyle("Padlock");
	}
	
	function showArrow($plop = true)
	{
		$this->showArrow = $plop;
	}
	
	function setUnclickable()
	{
		$this->clickable = false;
	}
	
	protected function optionalPreInstructions()
	{
		$this->setPositionZ($this->posZ+3);
		
		if($this->showArrow) 
		{
			$this->setImage("BgsChallengeRace.dds");
		}
	}
	
	protected function optionalInstructions()
	{
		// Algin the title and its bg at the top center of the main quad		
		$arr = Manialink::getAlignedPos ($this, "center", "top");
		$x = $arr["x"];
		$y = $arr["y"];
		
		Manialink::beginFrame($x, $y, $this->posZ-3, $this->outputStream);

			$this->image->draw($this->outputStream);
			$this->points->draw($this->outputStream);		
			
			if(!$this->clickable)
			{
				$this->clickableMask->draw($this->outputStream);
				$this->clickableLock->draw($this->outputStream);
				$this->lockedMessage->draw($this->outputStream);
			}
			
			$this->text->draw($this->outputStream);
	
		Manialink::endFrame($this->outputStream);
	}
}
?>