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

namespace ManiaLib\Application;

/**
 * Application config
 */
class Config extends \ManiaLib\Utils\Singleton
{
	public $URL;
	public $manialink;
	public $namespace;
	public $name;
	
	public $langsURL;
	public $imagesURL;
	public $mediaURL;
	
	public $URLSeparator = '_';
	
	public $useRewriteRules = false;
	
	public $defaultController = 'Home';
	public $defaultAction = 'index';
	
	public $maniaLibViewsNS = 'ManiaLib\\Application\\Views\\';
	public $applicationViewsNS;
	
	public $renderer;
	
	public $webapp = false;
	
	function getLangsURL()
	{
		return $this->langsURL?:$this->URL.'langs/';
	}
	
	function getImagesURL()
	{
		return $this->imagesURL?:$this->URL.'images/';
	}
	
	function getMediaURL()
	{
		return $this->mediaURL?:$this->URL.'media/';
	}
	
	function getLinkCreationURL()
	{
		return $this->useRewriteRules ?  
			substr($this->URL, 0, -1) :  $this->URL.'index.php';
	}
	
	function getManiaLibViewsNS()
	{
		return $this->maniaLibViewsNS;
	}
	
	function getApplicationViewsNS()
	{
		return $this->applicationViewsNS?:$this->namespace.'\\Views\\';
	}
	
	function getRenderer()
	{
		if($this->renderer)
		{
			return $this->renderer;
		}
		elseif($this->webapp)
		{
			return 'ManiaLib\\Application\\Rendering\\Smarty';
		}
		else
		{
			return 'ManiaLib\\Application\\Rendering\\Manialink';
		}
	}
}

?>