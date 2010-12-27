<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Challenge card
 * Just like challenge cards that can be found when you browse TrackMania's campaigns
 */ 
class ManiaLib_Gui_Cards_Challenge extends ManiaLib_Gui_Elements_Quad
{
	/**
	 * @var ManiaLib_Gui_Elements_Quad
	 */
	public $bgImage;
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $text;
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $points;
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $lockedMessage;
	
	/**#@+
	 * @ignore
	 */
	protected $showArrow = false;
	protected $sizeX = 16;
	protected $sizeY = 17;
	protected $medal;
	protected $clickable = true;
	protected $clickableMask;
	protected $clickableLock;
	/**#@-*/
	
	function __construct ()
	{
		$this->cardElementsPosZ = -3;
		$this->cardElementsHalign = 'center';
		
		$this->setStyle(ManiaLib_Gui_Elements_Quad::BgsChallengeMedals);
		$this->setSubStyle(ManiaLib_Gui_Elements_BgsChallengeMedals::BgNotPlayed);
		
		$this->bgImage = new ManiaLib_Gui_Elements_Quad(15, 13.5);
		$this->bgImage->setHalign("center");
		$this->bgImage->setPosition(0, -0.5, 0);
		$this->addCardElement($this->bgImage);
		
		$this->points = new ManiaLib_Gui_Elements_Label(9);
		$this->points->setPosition(-6.5, -10.75, 2);
		$this->addCardElement($this->points);
		
		$this->text = new ManiaLib_Gui_Elements_Label(15);
		$this->text->setPosition(0, -14, 4);
		$this->text->setHalign("center");
		$this->text->setStyle(ManiaLib_Gui_Elements_Label::TextChallengeNameSmall);
		$this->addCardElement($this->text);
		
		$this->lockedMessage = new ManiaLib_Gui_Elements_Label(13);
		$this->lockedMessage->setPosition(0, -1.5, 2);
		$this->lockedMessage->setHalign("center");
		$this->lockedMessage->enableAutonewline();
		$this->lockedMessage->setStyle(ManiaLib_Gui_Elements_Label::TextRaceChat);
		
		$this->clickableMask = new ManiaLib_Gui_Elements_Quad($this->sizeX, $this->sizeY);
		$this->clickableMask->setHalign("center");
		$this->clickableMask->setPositionZ(1);
		$this->clickableMask->setStyle(ManiaLib_Gui_Elements_Quad::BgsPlayerCard);
		$this->clickableMask->setSubStyle(ManiaLib_Gui_Elements_BgsPlayerCard::BgPlayerName);
		
		$this->clickableLock = new ManiaLib_Gui_Elements_Icon(7.5);
		$this->clickableLock->setPosition(8, -14, 2);
		$this->clickableLock->setAlign("right", "bottom");
		$this->clickableLock->setSubStyle(ManiaLib_Gui_Elements_Icons128x128_1::Padlock);
	}
	
	/**
	 * Whether to show the blue arrow above the challenge icon
	 * @param boolean
	 */
	function showArrow($show = true)
	{
		$this->showArrow = $show;
	}
	
	/**
	 * Sets the element un-clickable, dims the challenge icon and displays a
	 * lock icon
	 */
	function setUnclickable()
	{
		$this->clickable = false;
	}
	
	/**
	 * @ignore
	 */
	protected function preFilter()
	{
		$this->setPositionZ($this->posZ+3);
		
		if($this->showArrow) 
		{
			$this->setImage("BgsChallengeRace.dds");
		}
		
		if(!$this->clickable)
		{
			$this->addCardElement($this->clickableMask);
			$this->addCardElement($this->clickableLock);
			$this->addCardElement($this->lockedMessage);
		}
	}
}

?>