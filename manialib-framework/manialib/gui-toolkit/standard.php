<?php
/**
 * Manialink GUI API
 * 
 * Standard Gui Library
 * 
 * @author Maxime Raoust
 */

require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'GuiTools.class.php' );
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'styles.php' );

/**
 * Abstract GUI element. Extends that class to create a GUI class
 * @package gui_api
 */
abstract class GuiElement
{
	protected $style;
	protected $subStyle;
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $sizeX;
	protected $sizeY;
	protected $sizeZ;
	protected $scale;
	protected $valign = null;
	protected $halign = null;
	protected $manialink;
	protected $url;
	protected $maniazones;
	protected $bgcolor;
	protected $addPlayerId;
	protected $action;
	protected $actionKey;
	protected $image;
	protected $imageFocus;
	protected $xmlTagName = 'xmltag'; // Redeclare this for each child
	protected $xml;

	function __construct($sx = 20, $sy = 20)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}

	function setPositionX($plop)
	{
		$this->posX = $plop;
	}

	function setPositionY($plop)
	{
		$this->posY = $plop;
	}

	function setPositionZ($plop)
	{
		$this->posZ = $plop;
	}

	function setPosition($px = 0, $py = 0, $pz = 0)
	{
		$this->setPositionX($px);
		$this->setPositionY($py);
		$this->setPositionZ($pz);
	}

	function setSizeX($plop)
	{
		$this->sizeX = $plop;
	}

	function setSizeY($plop)
	{
		$this->sizeY = $plop;
	}

	function setSize($plopx, $plopy)
	{
		$this->setSizeX($plopx);
		$this->setSizeY($plopy);
	}

	function setScale($plop)
	{
		$this->scale = $plop;
	}

	function setStyle($plop)
	{
		$this->style = $plop;
	}

	function setSubStyle($plop)
	{
		$this->subStyle = $plop;
	}

	function setValign($plop)
	{
		$this->valign = $plop;
	}

	function setHalign($plop)
	{
		$this->halign = $plop;
	}

	function setAlign($hplop = null, $vplop = null)
	{
		$this->setHalign($hplop);
		$this->setValign($vplop);
	}

	function setManialink($plop)
	{
		$this->manialink = $plop;
	}

	function setUrl($plop)
	{
		$this->url = $plop;
	}

	function setManiazones($plop)
	{
		$this->maniazones = $plop;
	}

	function addPlayerId()
	{
		$this->addPlayerId = 1;
	}

	function setAction($plop)
	{
		$this->action = $plop;
	}

	function setActionKey($plop)
	{
		$this->actionKey = $plop;
	}

	function setBgcolor($plop)
	{
		$this->bgcolor = $plop;
	}

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

	function getStyle()
	{
		return $this->style;
	}

	function getSubStyle()
	{
		return $this->subStyle;
	}

	function getPosX()
	{
		return $this->posX;
	}

	function getPosY()
	{
		return $this->posY;
	}

	function getPosZ()
	{
		return $this->posZ;
	}
	function getSizeX()
	{
		return $this->sizeX;
	}

	function getSizeY()
	{
		return $this->sizeY;
	}

	function getScale()
	{
		return $this->scale;
	}

	function getHalign()
	{
		return $this->halign;
	}

	function getValign()
	{
		return $this->valign;
	}

	function getManialink()
	{
		return $this->manialink;
	}

	function getManiazones()
	{
		return $this->maniazones;
	}

	function getUrl()
	{
		return $this->url;
	}

	function getAction()
	{
		return $this->action;
	}

	function getActionKey()
	{
		return $this->actionKey;
	}

	function getAddPlayerId()
	{
		return $this->addPlayerId;
	}

	function getBgcolor()
	{
		return $this->bgcolor;
	}

	function getImage()
	{
		return $this->image;
	}

	function getImageFocus()
	{
		return $this->imageFocus;
	}

	/**
	 * Imports links/actions from another Manialink object
	 */
	function addLink(GuiElement $object)
	{
		$this->setManialink($object->getManialink());
		$this->setUrl($object->getUrl());
		$this->setManiazones($object->getManiazones());
		$this->setAction($object->getAction());
		if($object->getAddPlayerId())
		{
			$this->addPlayerId();
		}
	}

	/**
	 * Returns true if a link was set on the object (manialink, maniazone, url,
	 * action)
	 */
	function hasLink()
	{
		return $this->manialink || $this->url || $this->action || $this->maniazones;
	}

	/**
	 * Redeclare this method in children classes to execute code before drawing
	 */
	protected function preFilter()
	{

	}

	/**
	 * Redeclare this method in children classes to execute code after drawing
	 */
	protected function postFilter()
	{

	}

	/**
	 * Saves the object in the Manialink objects stack. 
	 * You shouldn't have to override this method
	 */
	public function save()
	{
		// Optional pre filtering
		$this->preFilter();
		
		// Layout handling
		$layout = end(Manialink::$layoutStack);
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
			if($this->addPlayerId !== null)
				$this->xml->setAttribute('addplayerid', $this->addPlayerId);
			if($this->manialink !== null)
				$this->xml->setAttribute('manialink', $this->manialink);
			if($this->url !== null)
				$this->xml->setAttribute('url', $this->url);
			if($this->maniazones !== null)
				$this->xml->setAttribute('maniazones', $this->maniazones);
	
			// Add action
			if($this->action !== null)
				$this->xml->setAttribute('action', $this->action);
			if($this->actionKey !== null)
				$this->xml->setAttribute('actionkey', $this->actionKey);
	
			// Add images
			if($this->image !== null)
				$this->xml->setAttribute('image', $this->image);
			if($this->imageFocus !== null)
				$this->xml->setAttribute('imagefocus', $this->imageFocus);
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

class Spacer extends GuiElement
{
	protected $xmlTagName = null;
} 

/**
 * Quad
 * @package gui_api
 */
class Quad extends GuiElement
{
	protected $xmlTagName = 'quad';
	protected $style = GUI_QUAD_DEFAULT_STYLE;
	protected $subStyle = GUI_QUAD_DEFAULT_SUBSTYLE;
}

/**
 * Icon 128
 * @package gui_api
 */
class Icon extends Quad
{
	protected $style = GUI_ICON_DEFAULT_STYLE;
	protected $subStyle = GUI_ICON_DEFAULT_SUBSTYLE;

	function __construct($size = 7)
	{
		$this->sizeX = $size;
		$this->sizeY = $size;
	}
}

/**
 * Icon 64
 * @package gui_api
 */
class Icon64 extends Icon
{
	protected $style = GUI_ICON64_DEFAULT_STYLE;
	protected $subStyle = GUI_ICON64_DEFAULT_SUBSTYLE;
}

/**
 * Icon 128x32
 * @package gui_api
 */
class Icon128 extends Icon
{
	protected $style = GUI_ICON32_DEFAULT_STYLE;
	protected $subStyle = GUI_ICON32_DEFAULT_SUBSTYLE;
}

/**
 * Icon medal
 * @package gui_api
 */
class IconMedal extends Icon
{
	protected $style = GUI_ICONMEDAL_DEFAULT_STYLE;
	protected $subStyle = GUI_ICONMEDAL_DEFAULT_SUBSTYLE;
}

/**
 * Include
 * @package gui_api
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
 * @package gui_api
 */
class Format extends GuiElement
{
	protected $xmlTagName = 'format';
	protected $halign = null;
	protected $valign = null;
	protected $posX = null;
	protected $posY = null;
	protected $posZ = null;
	protected $textSize;
	protected $textColor;

	function __construct()
	{
	}

	function setTextSize($plop)
	{
		$this->textSize = $plop;
		$this->setStyle(null);
		$this->setSubStyle(null);
	}

	function setTextColor($plop)
	{
		$this->textColor = $plop;
		$this->setStyle(null);
		$this->setSubStyle(null);
	}

	function getTextSize()
	{
		return $this->textSize;
	}

	function getTextColor()
	{
		return $this->textColor;
	}

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
 * @package gui_api
 */
class Label extends Format
{
	protected $xmlTagName = 'label';
	protected $style = GUI_LABEL_DEFAULT_STYLE;
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $text;
	protected $textid;
	protected $autonewline;
	protected $maxline;

	function __construct($sx = 20, $sy = 0)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}

	function setText($plop)
	{
		$this->text = $plop;
	}

	function setTextid($plop)
	{
		$this->textid = $plop;
	}

	function setMaxline($plop)
	{
		$this->maxline = $plop;
	}

	function enableAutonewline()
	{
		$this->autonewline = 1;
	}

	function getText()
	{
		return $this->text;
	}

	function getTextid()
	{
		return $this->textid;
	}

	function getMaxline()
	{
		return $this->maxline;
	}

	function getAutonewline()
	{
		return $this->autonewline;
	}

	protected function postFilter()
	{
		parent::postFilter();
		if($this->text !== null)
			$this->xml->setAttribute('text', $this->text);
		if($this->textid !== null)
			$this->xml->setAttribute('textid', $this->textid);
		if($this->autonewline !== null)
			$this->xml->setAttribute('autonewline', $this->autonewline);
		if($this->maxline !== null)
			$this->xml->setAttribute('maxline', $this->maxline);
	}
}

/**
 * Entry : input fields
 * @package gui_api
 */
class Entry extends Label
{
	protected $xmlTagName = 'entry';
	protected $style = GUI_ENTRY_DEFAULT_STYLE;
	protected $name;
	protected $defaultValue;

	function __construct($sx = 20, $sy = 3)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}

	function setName($name)
	{
		$this->name = $name;
	}

	function setDefault($value)
	{
		$this->defaultValue = $value;
	}

	function getName()
	{
		return $this->name;
	}

	function getDefault()
	{
		return $this->defaultValue;
	}

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
 * FileEntry : input fields
 * @package gui_api
 */
class FileEntry extends Entry
{
	protected $xmlTagName = 'fileentry';
	protected $folder;

	function __construct($sx = 20, $sy = 3)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}

	function setFolder($folder)
	{
		$this->folder = $folder;
	}

	function getFolder()
	{
		return $this->folder;
	}

	protected function postFilter()
	{
		parent::postFilter();
		if($this->folder !== null)
			$this->xml->setAttribute('folder', $this->folder);
	}
}

/**
 * Buttons
 * @package gui_api
 */
class Button extends Label
{
	protected $subStyle = null;
	protected $style = GUI_BUTTON_DEFAULT_STLE;
}

/**
 * Music
 * @package gui_api
 */
class Music extends GuiElement
{
	protected $xmlTagName = 'music';
	protected $halign = null;
	protected $valign = null;
	protected $posX = null;
	protected $posY = null;
	protected $posZ = null;
	protected $data;

	function __construct()
	{
	}

	function setData($filename, $relativePath = APP_URL)
	{
		if($relativePath)
		{
			$this->data = $relativePath . $filename;
		}
		else
		{
			$this->data = $filename;
		}
	}

	function getData()
	{
		return $this->data;
	}

	protected function postFilter()
	{
		if($this->data !== null)
			$this->xml->setAttribute('data', $this->data);
	}
}

/**
 * Audio player
 * @package gui_api
 */
class Audio extends Music
{
	protected $xmlTagName = 'music';
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $play;
	protected $looping = 0;

	function autoPlay()
	{
		$this->play = 1;
	}

	function enableLooping()
	{
		$this->looping = 1;
	}

	function getAutoPlay()
	{
		return $this->play;
	}

	function getLooping()
	{
		return $this->looping;
	}

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
 * @package gui_api
 */
class Video extends Audio
{
	protected $xmlTagName = 'video';

	function __construct($sx = 32, $sy = 24)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}
}
?>