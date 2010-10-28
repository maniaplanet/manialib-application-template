<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**#@+
 * @ignore
 */
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'GuiTools.class.php' );
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'GuiDefaultStyles.class.php' );
/**#@-*/

/**
 * The GuiComponent is a generic and abstract element that only contains
 * position, size and scale info.
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
abstract class GuiComponent
{
	/**#@+
	 * @ignore
	 */
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $sizeX;
	protected $sizeY;
	protected $scale;
	/**#@-*/
	
	/**
	 * Sets the X position of the element
	 * @param float
	 */
	function setPositionX($posX)
	{
		$this->posX = $posX;
	}
	
	/**
	 * Sets the Y position of the element
	 * @param float
	 */
	function setPositionY($posY)
	{
		$this->posY = $posY;
	}
	
	/**
	 * Sets the Z position of the element
	 * @param float
	 */
	function setPositionZ($posZ)
	{
		$this->posZ = $posZ;
	}
	
	/**
	 * Sets the position of the element
	 * @param float
	 * @param float
	 * @param float
	 */
	function setPosition($posX = 0, $posY = 0, $posZ = 0)
	{
		$this->posX = $posX;
		$this->posY = $posY;
		$this->posZ = $posZ;
	}
	
	/**
	 * Sets the width of the element
	 * @param float
	 */
	function setSizeX($sizeX)
	{
		$this->sizeX = $sizeX;
	}
	
	/**
	 * Sets the height of the element
	 * @param float
	 */
	function setSizeY($sizeY)
	{
		$this->sizeY = $sizeY;
	}
	
	/**
	 * Sets the size of the element
	 * @param float
	 * @param float
	 */
	function setSize($sizeX, $sizeY)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
	}
	
	/**
	 * Sets the scale factor of the element. 1=original size, 2=double size, 0.5
	 * =half size
	 * @param float
	 */
	function setScale($scale)
	{
		$this->scale = $scale;
	}
	
	/**
	 * Returns the X position of the element
	 * @return float
	 */
	function getPosX()
	{
		return $this->posX;
	}
	
	/**
	 * Returns the Y position of the element
	 * @return float
	 */
	function getPosY()
	{
		return $this->posY;
	}
	
	/**
	 * Returns the Z position of the element
	 * @return float
	 */
	function getPosZ()
	{
		return $this->posZ;
	}
	
	/**
	 * Returns the width of the element
	 * @return float
	 */
	function getSizeX()
	{
		return $this->sizeX;
	}
	
	/**
	 * Returns the height of the element
	 * @return float
	 */
	function getSizeY()
	{
		return $this->sizeY;
	}
	
	/**
	 * Returns the scale of the element
	 * @return float
	 */
	function getScale()
	{
		return $this->scale;
	}
}

/**
 * Base class for creating GUI elements
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
abstract class GuiElement extends GuiComponent
{
	const USE_ABSOLUTE_URL = null;
	
	/**#@+
	 * @ignore
	 */
	protected $style;
	protected $subStyle;
	protected $valign = null;
	protected $halign = null;
	protected $manialink;
	protected $url;
	protected $maniazone;
	protected $bgcolor;
	protected $addPlayerId;
	protected $action;
	protected $actionKey;
	protected $image;
	protected $imageid;
	protected $imageFocus;
	protected $imageFocusid;
	protected $xmlTagName = 'xmltag'; // Redeclare this for each child
	protected $xml;
	/**#@-*/
	
	/**
	 * Manialink element default constructor. It's common to specify the size of
	 * the element in the constructor.
	 * 
	 * @param float Width of the element
	 * @param float Height of the element
	 */
	function __construct($sizeX = 20, $sizeY = 20)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
	}
	
	/**
	 * Sets the style of the element. See http://fish.stabb.de/styles/ of the
	 * manialink 'example' for more information on Manialink styles.
	 * @param string
	 */
	function setStyle($style)
	{
		$this->style = $style;
	}
	
	/**
	 * Sets the sub-style of the element. See http://fish.stabb.de/styles/ of
	 * the manialink 'example' for more information on Manialink styles.
	 * @param string
	 */
	function setSubStyle($substyle)
	{
		$this->subStyle = $substyle;
	}
	
	/**
	 * Sets the vertical alignment of the element.
	 * @param string Vertical alignment can be either "top", "center" or
	 * "bottom"
	 */
	function setValign($valign)
	{
		$this->valign = $valign;
	}
	
	/**
	 * Sets the horizontal alignment of the element
	 * @param string Horizontal alignement can be eithe "left", "center" or
	 * "right"
	 */
	function setHalign($halign)
	{
		$this->halign = $halign;
	}

	/**
	 * Sets the alignment of the element
	 * @param string Horizontal alignement can be eithe "left", "center" or
	 * "right"
	 * @param string Vertical alignment can be either "top", "center" or
	 * "bottom"
	 */
	function setAlign($halign = null, $valign = null)
	{
		$this->setHalign($halign);
		$this->setValign($valign);
	}

	/**
	 * Sets the Manialink of the element. It works as a hyperlink.
	 * @param string Can be either a short Manialink or an URL pointing to a
	 * Manialink
	 */
	function setManialink($manialink)
	{
		$this->manialink = $manialink;
	}

	/**
	 * Sets the hyperlink of the element
	 * @param string An URL
	 */
	function setUrl($url)
	{
		$this->url = $url;
	}
	
	/**
	 * Sets the Maniazones link of the element
	 * @param string
	 */
	function setManiazone($maniazone)
	{
		$this->maniazone = $maniazone;
	}

	/**
	 * Adds the player information parameters ("playerlogin", "nickname",
	 * "path", "lang") to the URL when you click on the link
	 */
	function addPlayerId()
	{
		$this->addPlayerId = 1;
	}
	
	/**
	 * Sets the action of the element. For example, if you use the action "0" in
	 * the explorer, it closes the explorer when you click on the element.
	 * @param int
	 */
	function setAction($action)
	{
		$this->action = $action;
	}

	/**
	 * Sets the action key associated to the element. Only works on dedicated
	 * servers.
	 * @param int
	 */
	function setActionKey($actionKey)
	{
		$this->actionKey = $actionKey;
	}

	/**
	 * Sets the background color of the element using a 3-digit RGB hexadecimal
	 * value. For example, "fff" is white and "000" is black
	 * @param string 3-digit RGB hexadecimal value
	 */
	function setBgcolor($bgcolor)
	{
		$this->bgcolor = $bgcolor;
	}
	
	/**
	 * Applies an image to the element. If you don't specify the second
	 * parameter, it will look for the image in the path defined by the
	 * APP_IMAGE_DIR_URL constant
	 * @param string The image filename (or URL)
	 * @param string The URL that will be appended to the image. Use null if you
	 * want to specify an absolute URL as first parameter
	 */
	function setImage($image, $absoluteUrl = APP_IMAGE_DIR_URL)
	{
		$this->setStyle(null);
		$this->setSubStyle(null);
		if($absoluteUrl)
		{
			$this->image = $absoluteUrl . $image;
		}
		else
		{
			$this->image = $image;
		}
	}
	
	// FIXME Imageid won't work out of the box with the LangEngine
	/**
	 * Set the image id of the element, used for internationalization
	 */
	function setImageid($imageid)
	{
		$this->setStyle(null);
		$this->setSubStyle(null);
		$this->imageid = $imageid;
	}

	/**
	 * Applies an image to the highlighter state of the element. The second
	 * parameter works just like GuiElement::setImage()
	 * @param string The image filename (or URL)
	 * @param string The URL that will be appended to the image. Use null if you
	 * want to specify an absolute URL as first parameter
	 */
	function setImageFocus($imageFocus, $absoluteUrl = APP_IMAGE_DIR_URL)
	{
		if($absoluteUrl)
		{
			$this->imageFocus = $absoluteUrl . $imageFocus;
		}
		else
		{
			$this->imageFocus = $imageFocus;
		}
	}
	
	/**
	 * Set the image focus id of the element, used for internationalization
	 */
	function setImageFocusid($imageFocusid)
	{
		$this->imageFocusid;
	}
	
	/**
	 * Returns the style of the element
	 * @return string
	 */
	function getStyle()
	{
		return $this->style;
	}

	/**
	 * Returns the substyle of the element
	 * @return string
	 */
	function getSubStyle()
	{
		return $this->subStyle;
	}
	
	/**
	 * Returns the horizontal alignment of the element
	 * @return string
	 */
	function getHalign()
	{
		return $this->halign;
	}
	
	/**
	 * Returns the vertical alignment of the element
	 * @return string
	 */
	function getValign()
	{
		return $this->valign;
	}
	
	/**
	 * Returns the Manialink hyperlink of the element
	 * @return string
	 */
	function getManialink()
	{
		return $this->manialink;
	}
	
	/**
	 * Returns the Maniazones hyperlink of the element
	 * @return string
	 */
	function getManiazone()
	{
		return $this->maniazone;
	}
	
	/**
	 * Returns the hyperlink of the element
	 * @return string
	 */
	function getUrl()
	{
		return $this->url;
	}
	
	/**
	 * Returns the action associated to the element
	 * @return int
	 */
	function getAction()
	{
		return $this->action;
	}

	/**
	 * Returns the action key associated to the element
	 * @return int
	 */
	function getActionKey()
	{
		return $this->actionKey;
	}
	
	/**
	 * Returns whether the elements adds player information parameter to the URL
	 * when it's clicked
	 * @return boolean
	 */
	function getAddPlayerId()
	{
		return $this->addPlayerId;
	}

	/**
	 * Returns the background color of the element
	 * @return string 3-digit RGB hexadecimal value
	 */
	function getBgcolor()
	{
		return $this->bgcolor;
	}
	
	/**
	 * Returns the image placed in the element
	 * @return string The image URL
	 */
	function getImage()
	{
		return $this->image;
	}
	
	function getImageid()
	{
		return $this->imageid;
	}

	/**
	 * Returns the image placed in the element in its highlighted state
	 * @return string The image URL
	 */
	function getImageFocus()
	{
		return $this->imageFocus;
	}
	
	function getImageFocusid()
	{
		return $this->imageFocusid;
	}

	/**
	 * Imports links and actions from another Manialink element
	 * @param GuiElement The source object
	 */
	function addLink(GuiElement $object)
	{
		$this->manialink = $object->getManialink();
		$this->url = $object->getUrl();
		$this->maniazone = $object->getManiazone();
		$this->action = $object->getAction();
		$this->actionKey = $object->getActionKey();
		if($object->getAddPlayerId())
		{
			$this->addPlayerId = 1;
		}
	}

	/**
	 * Returns whether the object has a link or an action (either Manialink,
	 * Maniazones link, hyperlink or action)
	 * @return string
	 */
	function hasLink()
	{
		return $this->manialink || $this->url || $this->action || $this->maniazone;
	}

	/**
	 * Override this method in subclasses to perform some action before
	 * rendering the element
	 * @ignore
	 */
	protected function preFilter()
	{

	}

	/**
	 * Override this method in subclasses to perform some action after rendering
	 * the element
	 * @ignore
	 */
	protected function postFilter()
	{

	}

	/**
	 * Saves the object in the Manialink object stack for further rendering.
	 * Thanks to the use of GuiElement::preFilter() and GuiElement::
	 * postFilter(), you shouldn't have to override this method
	 */
	final function save()
	{
		// Optional pre filtering
		$this->preFilter();
		
		// Layout handling
		$layout = end(Manialink::$parentLayouts);
		if($layout instanceof AbstractLayout)
		{
			$layout->preFilter($this);
			$this->posX += $layout->xIndex;
			$this->posY += $layout->yIndex;
			$this->posZ += $layout->zIndex;
		}
		
		// DOM element creation
		if($this->xmlTagName)
		{
			$this->xml = Manialink::$domDocument->createElement($this->xmlTagName);
			end(Manialink::$parentNodes)->appendChild($this->xml);
			
			// Add pos
			if($this->posX || $this->posY || $this->posZ)
			{
				$this->xml->setAttribute('posn', 
					$this->posX.' '.$this->posY.' '.$this->posZ);
			}
	
			// Add size
			if($this->sizeX || $this->sizeY)
			{
				$this->xml->setAttribute('sizen', $this->sizeX.' '.$this->sizeY);
			}
	
			// Add alignement
			if($this->halign !== null)
				$this->xml->setAttribute('halign', $this->halign);
			if($this->valign !== null)
				$this->xml->setAttribute('valign', $this->valign);
			if($this->scale !== null)
				$this->xml->setAttribute('scale', $this->scale);
	
			// Add styles
			if($this->style !== null)
				$this->xml->setAttribute('style', $this->style);
			if($this->subStyle !== null)
				$this->xml->setAttribute('substyle', $this->subStyle);
			if($this->bgcolor !== null)
				$this->xml->setAttribute('bgcolor', $this->bgcolor);
	
			// Add links
			if($this->addPlayerId !== null && Manialink::$linksEnabled)
				$this->xml->setAttribute('addplayerid', $this->addPlayerId);
			if($this->manialink !== null && Manialink::$linksEnabled)
				$this->xml->setAttribute('manialink', $this->manialink);
			if($this->url !== null && Manialink::$linksEnabled)
				$this->xml->setAttribute('url', $this->url);
			if($this->maniazone !== null && Manialink::$linksEnabled)
				$this->xml->setAttribute('maniazone', $this->maniazone);
	
			// Add action
			if($this->action !== null)
				$this->xml->setAttribute('action', $this->action);
			if($this->actionKey !== null)
				$this->xml->setAttribute('actionkey', $this->actionKey);
	
			// Add images
			if($this->image !== null)
				$this->xml->setAttribute('image', $this->image);
			if($this->imageid !== null)
				$this->xml->setAttribute('imageid', $this->imageid);
			if($this->imageFocus !== null)
				$this->xml->setAttribute('imagefocus', $this->imageFocus);
			if($this->imageFocusid !== null)
				$this->xml->setAttribute('imagefocusid', $this->imageFocusid);	
		}
		
		// Layout post filtering
		if($layout instanceof AbstractLayout)
		{
			$layout->postFilter($this);
		}
		
		// Post filtering
		$this->postFilter();
	}
}

/**
 * A blank element, useful to place gaps between elements when using layouts
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Spacer extends GuiElement
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = null;
} 

/**
 * Quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Quad extends GuiElement
{
	/**#@+
	 * Manialink <b>style</b> for the <b>Quad</b> element 
	 */
	const BgRaceScore2        = 'BgRaceScore2';
	const Bgs1                = 'Bgs1';
	const Bgs1InRace          = 'Bgs1InRace';
	const BgsChallengeMedals  = 'BgsChallengeMedals';
	const BgsPlayerCard       = 'BgsPlayerCard';
	const Icons128x128_1      = 'Icons128x128_1';
	const Icons128x32_1       = 'Icons128x32_1';
	const Icons64x64_1        = 'Icons64x64_1';
	const MedalsBig           = 'MedalsBig';
	/**#@-*/
	
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'quad';
	protected $style = GuiDefaultStyles::Quad_Style;
	protected $subStyle = GuiDefaultStyles::Quad_Substyle;
	/**#@-*/
}

/**
 * Icon
 * Should be abstract some day, use classes like "Icons128x128_1" instead
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Icon extends Quad
{
	/**#@+
	 * @ignore
	 */
	protected $style = GuiDefaultStyles::Icon_Style;
	protected $subStyle = GuiDefaultStyles::Icon_Substyle;
	/**#@-*/

	function __construct($size = 7)
	{
		$this->sizeX = $size;
		$this->sizeY = $size;
	}
}

/**
 * Bgs1 quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Bgs1 extends Quad
{
	/**#@+
	 * @ignore
	 */
	protected $style = Quad::Bgs1;
	protected $subStyle = self::BgWindow1;
	/**#@-*/
	
	const BgButtonBig      = 'BgButtonBig';
	const BgButtonSmall    = 'BgButtonSmall';
	const BgButton         = 'BgButton';
	const BgCard           = 'BgCard';
	const BgCard1          = 'BgCard1';
	const BgCard2          = 'BgCard2';
	const BgCard3          = 'BgCard3';
	const BgCardChallenge  = 'BgCardChallenge';
	const BgCardFolder     = 'BgCardFolder';
	const BgCardList       = 'BgCardList';
	const BgCardPlayer     = 'BgCardPlayer';
	const BgCardBuddy	   = 'BgCardBuddy';
	const BgCardSystem     = 'BgCardSystem';
	const BgCardZone       = 'BgCardZone';
	const BgIconBorder     = 'BgIconBorder';
	const BgList           = 'BgList';
	const BgListLine       = 'BgListLine';
	const BgPager          = 'BgPager';
	const BgProgressBar    = 'BgProgressBar';
	const BgSlider         = 'BgSlider';
	const BgTitle2         = 'BgTitle2';
	const BgTitle3         = 'BgTitle3';
	const BgTitle3_1       = 'BgTitle3_1';
	const BgTitle3_2       = 'BgTitle3_2';
	const BgTitle3_3       = 'BgTitle3_3';
	const BgTitle3_4       = 'BgTitle3_4';
	const BgTitlePage      = 'BgTitlePage';
	const BgWindow1        = 'BgWindow1';
	const BgWindow2        = 'BgWindow2';
	const BgWindow3        = 'BgWindow3';
	const NavButtonBlink   = 'NavButtonBlink';
	const NavButton        = 'NavButton';
	const ProgressBarSmall = 'ProgressBarSmall';
	const ProgressBar      = 'ProgressBar';
}

/**
 * Bgs1InRace quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */	
class Bgs1InRace extends Bgs1 
{
	/**
	 * @ignore
	 */
	protected $style = Quad::Bgs1InRace;
}

/**
 * BgRaceScore2 quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */	
class BgRaceScore2 extends Quad
{
	/**#@+
	 * @ignore
	 */
	protected $style = Quad::BgRaceScore2;
	protected $subStyle = self::BgCardServer;
	/**#@-*/
	
	const BgCardServer                = 'BgCardServer';
	const BgScores                    = 'BgScores';
	const CupFinisher                 = 'CupFinisher';
	const CupPotentialFinisher        = 'CupPotentialFinisher';
	const Fame                        = 'Fame';
	const Handle                      = 'Handle';
	const HandleBlue                  = 'HandleBlue';
	const HandleRed                   = 'HandleRed';
	const IsLadderDisabled            = 'IsLadderDisabled';
	const IsLocalPlayer               = 'IsLocalPlayer';
	const LadderRank                  = 'LadderRank';
	const Laps                        = 'Laps';
	const Podium                      = 'Podium';
	const Points                      = 'Points';
	const SandTimer                   = 'SandTimer';
	const ScoreLink                   = 'ScoreLink';
	const ScoreReplay                 = 'ScoreReplay';
	const SendScore                   = 'SendScore';
	const Spectator                   = 'Spectator';
	const Tv                          = 'Tv';
	const Warmup                      = 'Warmup';
}

/**
 * BgsChallengeMedals quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */	
class BgsChallengeMedals extends Quad
{
	/**#@+
	 * @ignore
	 */
	protected $style = Quad::BgsChallengeMedals;
	protected $subStyle = self::BgBronze;
	/**#@-*/
	
	const BgBronze                    = 'BgBronze';
	const BgGold                      = 'BgGold';
	const BgNadeo                     = 'BgNadeo';
	const BgNotPlayed                 = 'BgNotPlayed';
	const BgPlayed                    = 'BgPlayed';
	const BgSilver                    = 'BgSilver';
}

/**
 * BgsPlayerCard quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */	
class BgsPlayerCard extends Quad
{
	/**#@+
	 * @ignore
	 */
	protected $style = Quad::BgsPlayerCard;
	protected $subStyle = self::BgActivePlayerCard;
	/**#@-*/
	
	const BgActivePlayerCard    = 'BgActivePlayerCard';
	const BgActivePlayerName    = 'BgActivePlayerName';
	const BgActivePlayerScore   = 'BgActivePlayerScore';
	const BgCard                = 'BgCard';
	const BgCardSystem          = 'BgCardSystem';
	const BgMediaTracker        = 'BgMediaTracker';
	const BgPlayerCardBig       = 'BgPlayerCardBig';
	const BgPlayerCardSmall     = 'BgPlayerCardSmall';
	const BgPlayerCard          = 'BgPlayerCard';
	const BgPlayerName          = 'BgPlayerName';
	const BgPlayerScore         = 'BgPlayerScore';
	const BgRacePlayerLine      = 'BgRacePlayerLine';
	const BgRacePlayerName      = 'BgRacePlayerName';
	const ProgressBar           = 'ProgressBar';
}

/**
 * Icons128x128_1 quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */	
class Icons128x128_1 extends Icon
{
	/**#@+
	 * @ignore
	 */
	protected $style = Quad::Icons128x128_1;
	protected $subStyle = self::Forever;
	/**#@-*/
	
	const Advanced                    = 'Advanced';
	const Back                        = 'Back';
	const BackFocusable               = 'BackFocusable';
	const Beginner                    = 'Beginner';
	const Browse                      = 'Browse';
	const Buddies                     = 'Buddies';
	const Challenge                   = 'Challenge';
	const ChallengeAuthor             = 'ChallengeAuthor';
	const Coppers                     = 'Coppers';
	const Create                      = 'Create';
	const Credits                     = 'Credits';
	const Custom                      = 'Custom';
	const CustomStars                 = 'CustomStars';
	const DefaultIcon                 = 'Default';
	const Download                    = 'Download';
	const Easy                        = 'Easy';
	const Editor                      = 'Editor';
	const Extreme                     = 'Extreme';
	const Forever                     = 'Forever';
	const GhostEditor                 = 'GhostEditor';
	const Hard                        = 'Hard';
	const Hotseat                     = 'Hotseat';
	const Inputs                      = 'Inputs';
	const Invite                      = 'Invite';
	const LadderPoints                = 'LadderPoints';
	const Lan                         = 'Lan';
	const Launch                      = 'Launch';
	const Load                        = 'Load';
	const LoadTrack                   = 'LoadTrack';
	const ManiaZones                  = 'ManiaZones';
	const Manialink                   = 'Manialink';
	const MedalCount                  = 'MedalCount';
	const MediaTracker                = 'MediaTracker';
	const Medium                      = 'Medium';
	const Multiplayer                 = 'Multiplayer';
	const Nations                     = 'Nations';
	const NewTrack                    = 'NewTrack';
	const Options                     = 'Options';
	const Padlock                     = 'Padlock';
	const Paint                       = 'Paint';
	const Platform                    = 'Platform';
	const PlayerPage                  = 'PlayerPage';
	const Profile                     = 'Profile';
	const ProfileAdvanced             = 'ProfileAdvanced';
	const ProfileVehicle              = 'ProfileVehicle';
	const Puzzle                      = 'Puzzle';
	const Quit                        = 'Quit';
	const Race                        = 'Race';
	const Rankings                    = 'Rankings';
	const Rankinks                    = 'Rankinks';
	const Replay                      = 'Replay';
	const Save                        = 'Save';
	const ServersAll                  = 'ServersAll';
	const ServersFavorites            = 'ServersFavorites';
	const ServersSuggested            = 'ServersSuggested';
	const Share                       = 'Share';
	const ShareBlink                  = 'ShareBlink';
	const SkillPoints                 = 'SkillPoints';
	const Solo                        = 'Solo';
	const Statistics                  = 'Statistics';
	const Stunts                      = 'Stunts';
	const United                      = 'United';
	const Upload                      = 'Upload';
	const Vehicles                    = 'Vehicles';
}

/**
 * Icons128x32_1 quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */	
class Icons128x32_1 extends Icon
{
	/**#@+
	 * @ignore
	 */
	protected $style = Quad::Icons128x32_1;
	protected $subStyle = self::RT_Cup;
	/**#@-*/
	
	const RT_Cup                      = 'RT_Cup';
	const RT_Laps                     = 'RT_Laps';
	const RT_Rounds                   = 'RT_Rounds';
	const RT_Stunts                   = 'RT_Stunts';
	const RT_Team                     = 'RT_Team';
	const RT_TimeAttack               = 'RT_TimeAttack';
	const SliderBar                   = 'SliderBar';
	const SliderBar2                  = 'SliderBar2';
	const UrlBg                       = 'UrlBg';
}

/**
 * Icons64x64_1 quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */	
class Icons64x64_1 extends Icon
{
	/**#@+
	 * @ignore
	 */
	protected $style = Quad::Icons64x64_1;
	protected $subStyle = self::GenericButton;
	/**#@-*/
	
	const Stereo3D                    = '3DStereo';
	const ArrowBlue                   = 'ArrowBlue';
	const ArrowDown                   = 'ArrowDown';
	const ArrowFastNext               = 'ArrowFastNext';
	const ArrowFastPrev               = 'ArrowFastPrev';
	const ArrowFirst                  = 'ArrowFirst';
	const ArrowGreen                  = 'ArrowGreen';
	const ArrowLast                   = 'ArrowLast';
	const ArrowNext                   = 'ArrowNext';
	const ArrowPrev                   = 'ArrowPrev';
	const ArrowRed                    = 'ArrowRed';
	const ArrowUp                     = 'ArrowUp';
	const Browser                     = 'Browser';
	const Buddy                       = 'Buddy';
	const ButtonLeagues               = 'ButtonLeagues';
	const ButtonPlayers               = 'ButtonPlayers';
	const ButtonServers               = 'ButtonServers';
	const Camera                      = 'Camera';
	const CameraLocal                 = 'CameraLocal';
	const Check                       = 'Check';
	const ClipPause                   = 'ClipPause';
	const ClipPlay                    = 'ClipPlay';
	const ClipRewind                  = 'ClipRewind';
	const Close                       = 'Close';
	const DisplaySettings             = 'DisplaySettings';
	const EmptyIcon                   = 'Empty';
	const Finish                      = 'Finish';
	const FinishGrey                  = 'FinishGrey';
	const First                       = 'First';
	const GenericButton               = 'GenericButton';
	const Green                       = 'Green';
	const IconLeaguesLadder           = 'IconLeaguesLadder';
	const IconPlayers                 = 'IconPlayers';
	const IconPlayersLadder           = 'IconPlayersLadder';
	const IconServers                 = 'IconServers';
	const Inbox                       = 'Inbox';
	const LvlGreen                    = 'LvlGreen';
	const LvlRed                      = 'LvlRed';
	const LvlYellow                   = 'LvlYellow';
	const ManiaLinkHome               = 'ManiaLinkHome';
	const Maximize                    = 'Maximize';
	const MediaAudioDownloading       = 'MediaAudioDownloading';
	const MediaPlay                   = 'MediaPlay';
	const MediaStop                   = 'MediaStop';
	const MediaVideoDownloading       = 'MediaVideoDownloading';
	const Music                       = 'Music';
	const NewMessage                  = 'NewMessage';
	const NotBuddy                    = 'NotBuddy';
	const OfficialRace                = 'OfficialRace';
	const Opponents                   = 'Opponents';
	const Outbox                      = 'Outbox';
	const QuitRace                    = 'QuitRace';
	const RedHigh                     = 'RedHigh';
	const RedLow                      = 'RedLow';
	const Refresh                     = 'Refresh';
	const RestartRace                 = 'RestartRace';
	const Second                      = 'Second';
	const SliderCursor                = 'SliderCursor';
	const SliderCursor2               = 'SliderCursor2';
	const Sound                       = 'Sound';
	const StarGold                    = 'StarGold';
	const StateFavourite              = 'StateFavourite';
	const StatePrivate                = 'StatePrivate';
	const StateSuggested              = 'StateSuggested';
	const TV                          = 'TV';
	const TagTypeBronze               = 'TagTypeBronze';
	const TagTypeGold                 = 'TagTypeGold';
	const TagTypeNadeo                = 'TagTypeNadeo';
	const TagTypeNone                 = 'TagTypeNone';
	const TagTypeSilver               = 'TagTypeSilver';
	const Third                       = 'Third';
	const ToolLeague1                 = 'ToolLeague1';
	const ToolLeague2                 = 'ToolLeague2';
	const ToolLeague3                 = 'ToolLeague3';
	const ToolRoot                    = 'ToolRoot';
	const ToolTree                    = 'ToolTree';
	const ToolUp                      = 'ToolUp';
	const TrackInfo                   = 'TrackInfo';
	const Windowed                    = 'Windowed';
	const YellowHigh                  = 'YellowHigh';
	const YellowLow                   = 'YellowLow';
}

/**
 * MedalsBig quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */	
class MedalsBig extends Icon
{
	/**#@+
	 * @ignore
	 */
	protected $style = Quad::MedalsBig;
	protected $subStyle = self::MedalBronze;
	/**#@-*/
	
	const MedalBronze                 = 'MedalBronze';
	const MedalGold                   = 'MedalGold';
	const MedalGoldPerspective        = 'MedalGoldPerspective';
	const MedalNadeo                  = 'MedalNadeo';
	const MedalNadeoPerspective       = 'MedalNadeoPerspective';
	const MedalSilver                 = 'MedalSilver';
	const MedalSlot                   = 'MedalSlot';
}

/**
 * Icons64x64_1
 * @deprecated Use Icons64x64_1 instead
 * @package ManiaLib
 * @subpackage GUIToolkit
 * @ignore
 */
class Icon64 extends Icon
{
	protected $style = GuiDefaultStyles::Icon64_Style;
	protected $subStyle = GuiDefaultStyles::Icon64_Substyle;
}

/**
 * Icons128x32_1
 * @deprecated Use Icons128x32_1 instead
 * @package ManiaLib
 * @subpackage GUIToolkit
 * @ignore
 */
class Icon128 extends Icon
{
	protected $style = GuiDefaultStyles::Icon128_Style;
	protected $subStyle = GuiDefaultStyles::Icon128_Substyle;
}

/**
 * MedalsBig
 * @deprecated Use MedalsBig instead
 * @package ManiaLib
 * @subpackage GUIToolkit
 * @ignore
 */
class IconMedal extends Icon
{
	protected $style = GuiDefaultStyles::IconMedal_Style;
	protected $subStyle = GuiDefaultStyles::IconMedal_Substyle;
}

/**
 * Include
 * Manialink include tag, used to include another Manialink file inside a Manialink
 * Use the setUrl() method
 * Manialink::redirectManialink() is a shortcut
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class IncludeManialink extends GuiElement
{
	function __construct()
	{
	}

	protected $xmlTagName = 'include';
	protected $halign = null;
	protected $valign = null;
	protected $posX = null;
	protected $posY = null;
	protected $posZ = null;
}

/**
 * Format
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Format extends GuiElement
{
	/**#@+
	 * Manialink <b>styles</b> for the <b>Format</b> element and its children 
	 */
	const TextButtonBig               = 'TextButtonBig';
	const TextButtonMedium            = 'TextButtonMedium';
	const TextButtonNav               = 'TextButtonNav';
	const TextButtonSmall             = 'TextButtonSmall';
	const TextCardInfoSmall           = 'TextCardInfoSmall';
	const TextCardMedium              = 'TextCardMedium';
	const TextCardRaceRank            = 'TextCardRaceRank';
	const TextCardScores2             = 'TextCardScores2';
	const TextCardSmallScores2        = 'TextCardSmallScores2';
	const TextCardSmallScores2Rank    = 'TextCardSmallScores2Rank';
	const TextChallengeNameMedal      = 'TextChallengeNameMedal';
	const TextChallengeNameMedalNone  = 'TextChallengeNameMedalNone';
	const TextChallengeNameMedium     = 'TextChallengeNameMedium';
	const TextChallengeNameSmall      = 'TextChallengeNameSmall';
	const TextCongratsBig             = 'TextCongratsBig';
	const TextCredits                 = 'TextCredits';
	const TextCreditsTitle            = 'TextCreditsTitle';
	const TextInfoMedium              = 'TextInfoMedium';
	const TextInfoSmall               = 'TextInfoSmall';
	const TextPlayerCardName          = 'TextPlayerCardName';
	const TextRaceChat                = 'TextRaceChat';
	const TextRaceChrono              = 'TextRaceChrono';
	const TextRaceChronoError         = 'TextRaceChronoError';
	const TextRaceChronoWarning       = 'TextRaceChronoWarning';
	const TextRaceMessage             = 'TextRaceMessage';
	const TextRaceStaticSmall         = 'TextRaceStaticSmall';
	const TextRaceValueSmall          = 'TextRaceValueSmall';
	const TextRankingsBig             = 'TextRankingsBig';
	const TextStaticMedium            = 'TextStaticMedium';
	const TextStaticSmall             = 'TextStaticSmall';
	const TextSubTitle1               = 'TextSubTitle1';
	const TextSubTitle2               = 'TextSubTitle2';
	const TextTips                    = 'TextTips';
	const TextTitle1                  = 'TextTitle1';
	const TextTitle2                  = 'TextTitle2';
	const TextTitle3                  = 'TextTitle3';
	const TextTitle2Blink             = 'TextTitle2Blink';
	const TextTitleError              = 'TextTitleError';
	const TextValueBig                = 'TextValueBig';
	const TextValueMedium             = 'TextValueMedium';
	const TextValueSmall              = 'TextValueSmall';
	/**#@-*/
	
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'format';
	protected $halign = null;
	protected $valign = null;
	protected $posX = null;
	protected $posY = null;
	protected $posZ = null;
	protected $style = null;
	protected $subStyle = null;
	protected $textSize;
	protected $textColor;
	/**#@-*/

	function __construct() {}
	
	/**
	 * Sets the text size
	 * @param int
	 */
	function setTextSize($textsize)
	{
		$this->textSize = $textsize;
		$this->setStyle(null);
		$this->setSubStyle(null);
	}
	
	/**
	 * Sets the text color
	 * @param string 3-digit RGB hexadecimal value
	 */
	function setTextColor($textcolor)
	{
		$this->textColor = $textcolor;
		$this->setStyle(null);
		$this->setSubStyle(null);
	}
	
	/**
	 * Returns the text size
	 * @return int
	 */
	function getTextSize()
	{
		return $this->textSize;
	}

	/**
	 * Returns the text color
	 * @return string 3-digit RGB hexadecimal value
	 */
	function getTextColor()
	{
		return $this->textColor;
	}

	/**
	 * @ignore
	 */
	protected function postFilter()
	{
		if($this->textSize !== null)
			$this->xml->setAttribute('textsize', $this->textSize);
		if($this->textColor !== null)
			$this->xml->setAttribute('textcolor', $this->textColor);
	}
}

/**
 * Label
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Label extends Format
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'label';
	protected $style = GuiDefaultStyles::Label_Style;
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $text;
	protected $textid;
	protected $autonewline;
	protected $maxline;
	/**#@-*/
	
	function __construct($sizeX = 20, $sizeY = 3)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
	}
	
	/**
	 * Sets the text
	 * @param string
	 */
	function setText($text)
	{
		$this->text = $text;
	}
	
	/**
	 * Sets the text Id for use with Manialink dictionaries
	 */
	function setTextid($textid)
	{
		$this->textid = $textid;
	}
	
	/**
	 * Sets the maximum number of lines to display
	 * @param int
	 */
	function setMaxline($maxline)
	{
		$this->maxline = $maxline;
	}
	
	/**
	 * Enables wraping the text into several lines if the line is too short
	 */
	function enableAutonewline()
	{
		$this->autonewline = 1;
	}
	
	/**
	 * Returns the text
	 * @return string
	 */
	function getText()
	{
		return $this->text;
	}
	
	/**
	 * Returns the text Id
	 * @return string
	 */
	function getTextid()
	{
		return $this->textid;
	}
	
	/**
	 * Returns the maximum number of lines to display
	 * @return int
	 */
	function getMaxline()
	{
		return $this->maxline;
	}
	
	/**
	 * Returns whether word wrapping is enabled
	 * @return boolean
	 */
	function getAutonewline()
	{
		return $this->autonewline;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		parent::postFilter();
		if($this->text !== null)
		{
			if(Manialink::$linksEnabled)
				$this->xml->setAttribute('text', $this->text);
			else
				$this->xml->setAttribute('text', TMStrings::stripLinks($this->text));
		}	
		if($this->textid !== null)
		{
			if(Manialink::$linksEnabled)
				$this->xml->setAttribute('textid', $this->textid);
			else
				$this->xml->setAttribute('textid', TMStrings::stripLinks($this->textid));
		}
		if($this->autonewline !== null)
			$this->xml->setAttribute('autonewline', $this->autonewline);
		if($this->maxline !== null)
			$this->xml->setAttribute('maxline', $this->maxline);
	}
}

/**
 * Entry
 * Input field for Manialinks
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Entry extends Label
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'entry';
	protected $style = GuiDefaultStyles::Entry_Style;
	protected $name;
	protected $defaultValue;
	/**#@-*/
	
	/**
	 * Sets the name of the entry. Will be used as the parameter name in the URL
	 * when submitting the page
	 * @param string
	 */
	function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Sets the default value of the entry
	 * @param mixed
	 */
	function setDefault($value)
	{
		$this->defaultValue = $value;
	}
	
	/**
	 * Returns the name of the entry
	 * @return string
	 */
	function getName()
	{
		return $this->name;
	}
	
	/**
	 * Returns the default value of the entry
	 * @return mixed
	 */
	function getDefault()
	{
		return $this->defaultValue;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		parent::postFilter();
		if($this->name !== null)
			$this->xml->setAttribute('name', $this->name);
		if($this->defaultValue !== null)
			$this->xml->setAttribute('default', $this->defaultValue);
	}
}

/**
 * FileEntry
 * File input field for Manialinks
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class FileEntry extends Entry
{
	/**#@+
	 * @ignore 
	 */
	protected $xmlTagName = 'fileentry';
	protected $folder;
	/**#@-*/
	
	/**
	 * Sets the default folder
	 * @param string
	 */
	function setFolder($folder)
	{
		$this->folder = $folder;
	}

	/**
	 * Returns the default folder
	 * @return string
	 */
	function getFolder()
	{
		return $this->folder;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		parent::postFilter();
		if($this->folder !== null)
			$this->xml->setAttribute('folder', $this->folder);
	}
}

/**
 * Button
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Button extends Label
{
	const CardButttonMedium       = 'CardButtonMedium';
	const CardButttonMediumWide   = 'CardButtonMediumWide';
	const CardButtonSmallWide     = 'CardButtonSmallWide';
	const CardButtonSmall         = 'CardButtonSmall';
	
	/**#@+
	 * @ignore 
	 */
	protected $subStyle = null;
	protected $style = GuiDefaultStyles::Button_Style;
	/**#@-*/
	
	function __construct($sizeX = 25, $sizeY = 3)
	{
		parent::__construct($sizeX, $sizeY);		
	}
}

/**
 * Music
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Music extends GuiElement
{
	/**#@+
	 * @ignore 
	 */
	protected $xmlTagName = 'music';
	protected $halign = null;
	protected $valign = null;
	protected $posX = null;
	protected $posY = null;
	protected $posZ = null;
	protected $data;
	/**#@-*/
	
	function __construct()
	{
	}
	
	/**
	 * Sets the data to play. If you don't specify the second parameter, it will
	 * look for the image in the path defined by the APP_DATA_DIR_URL constant
	 * @param string The image filename (or URL)
	 * @param string The URL that will be appended to the image. Use null if you
	 * want to specify an absolute URL as first parameter
	 */
	function setData($filename, $absoluteUrl = APP_DATA_DIR_URL)
	{
		if($absoluteUrl)
		{
			$this->data = $absoluteUrl . $filename;
		}
		else
		{
			$this->data = $filename;
		}
	}
	
	/**
	 * Returns the data URL
	 * @return string
	 */
	function getData()
	{
		return $this->data;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		if($this->data !== null)
			$this->xml->setAttribute('data', $this->data);
	}
}

/**
 * Audio player
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Audio extends Music
{
	/**#@+
	 * @ignore 
	 */
	protected $xmlTagName = 'music';
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $play;
	protected $looping = 0;
	/**#@-*/

	/**
	 * Autoplay the data when it's done loading
	 */
	function autoPlay()
	{
		$this->play = 1;
	}

	/**
	 * Loop when the end of the data is reached
	 */
	function enableLooping()
	{
		$this->looping = 1;
	}

	/**
	 * Returns whether auto playing is enabled
	 * @return boolean
	 */
	function getAutoPlay()
	{
		return $this->play;
	}

	/**
	 * Returns whether looping is enabled
	 * @return boolean
	 */
	function getLooping()
	{
		return $this->looping;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		parent::postFilter();
		if($this->play !== null)
			$this->xml->setAttribute('play', $this->play);
		if($this->looping !== null)
			$this->xml->setAttribute('looping', $this->looping);
	}
}

/**
 * Video
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class Video extends Audio
{
	/**
	 * @ignore 
	 */
	protected $xmlTagName = 'video';

	function __construct($sx = 32, $sy = 24)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}
}
?>