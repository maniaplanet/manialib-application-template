<?php
/**
 * Manialink GUI API
 * 
 * Standard Gui Library
 * 
 * @author Maxime Raoust
 */

/**
 * The manialink class helps creating headers and footers of a manialink page
 * @package gui_api
 */
final class Manialink
{
	protected $type = "default";
	protected $timeout = 0;
	protected $bgcolor = "0cff";
	protected $bgborderx = 0;
	protected $bgbordery = 0;

	/**
	 * Set the type
	 * @param String $type
	 */
	function setType ($type)
	{
		$this->type = $type;
	}

	/**
	 * Set the timeout (0 for dynamic pages)
	 * @param Int $timeout
	 */
	function setTimeout ($timeout)
	{
		$this->timeout = $timeout;
	}

	/**
	 * Set the bg color
	 * @param String $color
	 */
	function setBgColor ($color)
	{
		$this->bgcolor = $color;
	}

	/**
	 * Set the bg X border size
	 * @param Int $size
	 */
	function setBgBorderX ($size)
	{
		$this->bgborderx = $size;
	}

	/**
	 * Set the bg Y border size
	 * @param Int $size
	 */
	function setBgBorderY ($size)
	{
		$this->bgbordery = $size;
	}

	/**
	 * Draw the damn thing
	 */
	function draw()
	{
		header("Content-Type: text/xml; charset=utf-8");
		echo ('<?xml version="1.0" encoding="utf-8"?>'."\n");
		echo ('<manialink>'."\n");
		echo ('<type>'.$this->type.'</type>'."\n");
		echo ('<timeout>'.$this->timeout.'</timeout>'."\n");
		echo ('<background bgcolor="'.$this->bgcolor.'" bgborderx="'.$this->bgborderx.'" bgbordery="'.$this->bgbordery.'" />'."\n");
	}

	/**
	 * Static method to write the footer
	 */
	static function theEnd()
	{
		echo "</manialink>\n";
	}

	/**
	 * Static method to draw a frame (only "posn" coordinates)
	 * If the outbuffer is specified, it will be written in it
	 * @param Int $x
	 * @param Int $y
	 * @param Int $z
	 * @param Mixed &$outputBuffer
	 * @return Mixed
	 */
	static function beginFrame ($x=0, $y=0, $z=0, &$outputBuffer=null)
	{
		$output = "<frame posn=\"$x $y $z\">\n";
		if($outputBuffer !== null)
			$outputBuffer .= $output;
		else
			echo $output;

	}

	/**
	 * Static method to draw a frame and
	 * If the outbuffer is specified, it will be written in it
	 * @param Mixed &$outputBuffer
	 * @return Mixed
	 */
	static function endFrame(&$outputBuffer=null)
	{
		$output = "</frame>\n";
		if($outputBuffer !== null)
			$outputBuffer .= $output;
		else
			echo $output;
	}

	/**
	 * Static method to get the X coordinate of a point in relation to another element
	 * @param Int $posX position of the parent element
	 * @param Int $sizeX Size of the parent element
	 * @param String $halign Halign of the parent element
	 * @param String $newAlign Halign of the to be positioned element
	 * @return Int
	 */
	static function getAlignedPosX ($posX, $sizeX, $halign, $newAlign)
	{
		if($halign==null) $halign="left";
		switch(array($halign, $newAlign))
		{
			case array("center", 	"center") : $factor = 0; 	break;
			case array("center", 	"left") : 	$factor = -0.5; break;
			case array("center", 	"right") : 	$factor = 0.5; 	break;
			case array("left", 		"center") : $factor = 0.5; 	break;
			case array("left", 		"left") : 	$factor = 0; 	break;
			case array("left", 		"right") : 	$factor = 1; 	break;
			case array("right", 	"center") : $factor = -0.5; break;
			case array("right", 	"left") : 	$factor = -1; 	break;
			case array("right", 	"right") : 	$factor = 0; 	break;
		}
		return $posX + $factor*$sizeX;
	}

	/**
	 * Static method to get the Y coordinate of a point in relation to another element
	 * @param Int $posY position of the parent element
	 * @param Int $sizeY Size of the parent element
	 * @param String $valign Valign of the parent element
	 * @param String $newAlign Valign of the to be positioned element
	 * @return Int
	 */
	static function getAlignedPosY ($posY, $sizeY, $valign, $newAlign)
	{
		if($valign=="top" || $valign==null) $valign = "right";
		else if($valign=="bottom") $valign = "left";
		if($newAlign=="top") $newAlign = "right";
		else if($newAlign=="bottom") $newAlign = "left";
		return self::getAlignedPosX ($posY, $sizeY, $valign, $newAlign);
	}

	static function getAlignedPos ($object, $newHalign, $newValign)
	{
		$newPosX = self::getAlignedPosX ($object->getPosX(), $object->getSizeX(), $object->getHalign(), $newHalign);
		$newPosY = self::getAlignedPosY ($object->getPosY(), $object->getSizeY(), $object->getValign(), $newValign);
		return array("x" => $newPosX, "y" => $newPosY);
	}

	static function getAlignPosArray ($array, $newHalign, $newValign)
	{
		$newPosX = self::getAlignedPosX ($array["posX"], $array["sizeX"], $array["halign"], $newHalign);
		$newPosY = self::getAlignedPosY ($array["posY"], $array["sizeY"], $array["valign"], $newValign);
		return array("x" => $newPosX, "y" => $newPosY);
	}
}

/**
 * Generic GUI element
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
	protected $classicPositioning;
	protected $classicSizing;
	protected $action;
	protected $actionKey;
	protected $imageFile;
	protected $imageFocusFile;
	protected $xmlTagName = "xmltag"; // Redeclare this for each child
	protected $xmlTagEnd = "/";
	protected $output = "";
	protected $xml;

	function __construct($sx=20, $sy=20)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}

	function setPositionX ($plop)
	{
		$this->posX = $plop;
	}

	function setPositionY ($plop)
	{
		$this->posY = $plop;
	}

	function setPositionZ ($plop)
	{
		$this->posZ = $plop;
	}

	function setPosition ($px=0, $py=0, $pz=0)
	{
		$this->setPositionX($px);
		$this->setPositionY($py);
		$this->setPositionZ($pz);
	}

	function setSizeX ($plop)
	{
		$this->sizeX = $plop;
	}

	function setSizeY ($plop)
	{
		$this->sizeY = $plop;
	}

	function setSize ($plopx, $plopy)
	{
		$this->setSizeX ($plopx);
		$this->setSizeY ($plopy);
	}

	function setScale ($plop)
	{
		$this->scale = $plop;
	}

	function setStyle ($plop)
	{
		$this->style = $plop;
	}

	function setSubStyle ($plop)
	{
		$this->subStyle = $plop;
	}

	function setValign ($plop)
	{
		$this->valign = $plop;
	}

	function setHalign ($plop)
	{
		$this->halign = $plop;
	}

	function setAlign ($hplop=null, $vplop=null)
	{
		$this->setHalign($hplop);
		$this->setValign($vplop);
	}

	function setManialink ($plop)
	{
		$this->manialink = $plop;
	}

	function setUrl ($plop)
	{
		$this->url = $plop;
	}

	function setManiazones ($plop)
	{
		$this->maniazones = $plop;
	}

	function setBgcolor ($plop)
	{
		$this->bgcolor = $plop;
	}

	function addPlayerId ()
	{
		$this->addPlayerId = 1;
	}

	function enableClassicPositioning ()
	{
		$this->classicPositioning = true;
	}

	function enableClassicSizing ()
	{
		$this->classicSizing = true;
	}

	function setAction ($plop)
	{
		$this->action = $plop;
	}

	function setActionKey ($plop)
	{
		$this->actionKey = $plop;
	}

	function setImage($image, $absoluteUrl=GUI_IMAGE_DIR_URL)
	{
		$this->setStyle(null);
		$this->setSubStyle(null);
		if($absoluteUrl)
			$this->imageFile = $absoluteUrl.$image;
		else
			$this->imageFile = $image;
	}

	function setImageFocus($imageFocus, $absoluteUrl=GUI_IMAGE_DIR_URL)
	{
		if($absoluteUrl)
			$this->imageFocusFile = $absoluteUrl.$imageFocus;
		else
			$this->imageFocusFile = $imageFocus;
	}

	/**
	 * Add links/action from another gui object
	 */
	function addLink($object)
	{
		$this->setManialink($object->manialink);
		$this->setUrl($object->url);
		$this->setManiazones($object->maniazones);
		$this->setAction($object->action);
		if($object->getAddPlayerId())
		{
			$this->addPlayerId();
		}
	}

	function getPosX () 		{return $this->posX; }
	function getPosY () 		{return $this->posY;}
	function getPosZ () 		{return $this->posZ;}
	function getSizeX () 		{return $this->sizeX;}
	function getSizeY () 		{return $this->sizeY;}
	function getHalign () 		{return $this->halign;}
	function getValign () 		{return $this->valign;}
	function getAddPlayerId () 	{return $this->addPlayerId;}
	function getImage () 		{return $this->imageFile;}

	final protected function outputBegin()
	{
		$doc = new DOMDocument;
		$this->xml = $doc->createElement($this->xmlTagName);
	}

	final protected function outputEnd()
	{
		$this->output .= $this->xml->ownerDocument->saveXML($this->xml) . "\n";
	}

	final protected function outputStandard()
	{
		// Add pos
		if($this->posX || $this->posY || $this->posZ)
		{
			if ($this->classicPositioning)
				$this->xml->setAttribute("pos", "$this->posX $this->posY $this->posZ");
			else
				$this->xml->setAttribute("posn", "$this->posX $this->posY $this->posZ");
		}

		// Add size
		if($this->sizeX || $this->sizeY)
		{
			if ($this->classicSizing)
				$this->xml->setAttribute("size", "$this->sizeX $this->sizeY");
			else
				$this->xml->setAttribute("sizen", "$this->sizeX $this->sizeY");
		}

		// Add alignement
		if($this->halign !== null) $this->xml->setAttribute("halign", $this->halign);
		if($this->valign !== null) $this->xml->setAttribute("valign", $this->valign);
		if($this->scale !== null) $this->xml->setAttribute("scale", $this->scale);

		// Add styles
		if($this->style !== null) $this->xml->setAttribute("style", $this->style);
		if($this->subStyle !== null) $this->xml->setAttribute("substyle", $this->subStyle);
		if($this->bgcolor !== null) $this->xml->setAttribute("bgcolor", $this->bgcolor);

		// Add links
		if($this->addPlayerId !== null) $this->xml->setAttribute("addplayerid", $this->addPlayerId);
		if($this->manialink !== null) $this->xml->setAttribute("manialink", $this->manialink);
		if($this->url !== null) $this->xml->setAttribute("url", $this->url);
		if($this->maniazones !== null) $this->xml->setAttribute("maniazones", $this->maniazones);

		// Add action
		if($this->action !== null) $this->xml->setAttribute("action", $this->action);
		if($this->actionKey !== null) $this->xml->setAttribute("actionkey", $this->actionKey);

		// Add images
		if($this->imageFile !== null) $this->xml->setAttribute("image", $this->imageFile);
		if($this->imageFocusFile !== null) $this->xml->setAttribute("imagefocus", $this->imageFocusFile);

	}

	/**
	 * Redeclare this method in children classes to add attributes
	 */
	protected function outputOptional() 
	{

	}

	/**
	 * Redeclare this method in chlidren classes to execute code before drawing
	 */
	protected function outputPreFilter()
	{

	}

	/**
	 * Redeclare this method in children classes to execute code after drawing
	 */
	protected function outputPostFilter() 
	{

	}

	/**
	 * Draw the damn thing ! If the output buffer is specified, the result will
	 * be written in it
	 */
	final function draw(&$outputBuffer=null)
	{
		$this->outputPreFilter();
		$this->outputBegin();
		$this->outputStandard();
		$this->outputOptional();
		$this->outputEnd();
		$this->outputPostFilter();
		
		if($outputBuffer !== null)
		{
			$outputBuffer .= $this->output;
		}
		else
		{
			echo($this->output);
		}
	}
}

/**
 * Quad
 * @package gui_api
 */
class Quad extends GuiElement
{
	protected $xmlTagName = "quad";
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

	function __construct($size=7)
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
 * Format
 * @package gui_api
 */
class Format extends GuiElement
{
	protected $xmlTagName = "format";
	protected $halign = null;
	protected $valign = null;

	protected $textSize;
	protected $textColor;

	function __construct ()
	{
	}

	function setTextSize($plop)
	{
		$this->textSize=$plop;
		$this->setStyle(null);
		$this->setSubStyle(null);
	}

	function setTextColor($plop)
	{
		$this->textColor=$plop;
		$this->setStyle(null);
		$this->setSubStyle(null);
	}

	function outputOptional()
	{
		if($this->textSize !== null) $this->xml->setAttribute("textsize", $this->textSize);
		if($this->textColor !== null) $this->xml->setAttribute("textcolor", $this->textColor);
	}
}

/**
 * Label
 * @package gui_api
 */
class Label extends Format
{
	protected $xmlTagName = "label";
	protected $style = GUI_LABEL_DEFAULT_STYLE;

	protected $textSize;
	protected $textColor;

	protected $text;
	protected $textid;
	protected $autoNewLine;
	protected $maxline;

	function __construct ($sx = 20)
	{
		$this->sizeX = $sx;
		$this->sizeY = 0;
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

	function enableAutoNewLine()
	{
		$this->autoNewLine = 1;
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

	function outputOptional()
	{
		parent::outputOptional();
		if($this->text !== null) $this->xml->setAttribute("text", $this->text);
		if($this->textid !== null) $this->xml->setAttribute("textid", $this->textid);
		if($this->autoNewLine !== null) $this->xml->setAttribute("autonewline", $this->autoNewLine);
		if($this->maxline !== null) $this->xml->setAttribute("maxline", $this->maxline);
	}
}

/**
 * Entry : input fields
 * @package gui_api
 */
class Entry extends Label
{
	protected $xmlTagName = "entry";
	protected $style = GUI_ENTRY_DEFAULT_STYLE;
	protected $name;
	protected $defaultValue;

	function __construct ($sx = 20, $sy=3)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}

	function setName ($plop)
	{
		$this->name = $plop;
	}

	function setDefault ($plop)
	{
		$this->defaultValue = $plop;
	}

	function outputOptional()
	{
		parent::outputOptional();
		if($this->name !== null) $this->xml->setAttribute("name", $this->name);
		if($this->defaultValue !== null) $this->xml->setAttribute("default", $this->defaultValue);
	}
}

/**
 * FileEntry : input fields
 * @package gui_api
 */
class FileEntry extends Entry
{
	protected $xmlTagName = "fileentry";
	protected $folder;

	function __construct ($sx = 20, $sy=3)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}

	function setFolder($plop)
	{
		$this->folder = $plop;
	}

	function outputOptional()
	{
		parent::outputOptional();
		if($this->folder !== null) $this->xml->setAttribute("folder", $this->folder);
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
?>