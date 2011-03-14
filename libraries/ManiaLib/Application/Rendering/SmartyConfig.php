<?php 
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2728 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-03 18:29:51 +0100 (jeu., 03 mars 2011) $:
 */

namespace ManiaLib\Application\Rendering;

class SmartyConfig extends \ManiaLib\Utils\Singleton
{
	public $templatePath;
	public $compilePath;
	public $cachePath;
	public $configPath;
	
	protected function __construct()
	{
		$this->templatePath = realpath(APP_PATH.'ressources').DIRECTORY_SEPARATOR;
		$this->compilePath = realpath(APP_PATH.'templates_c').DIRECTORY_SEPARATOR;
		$this->cachePath = realpath(APP_PATH.'cache').DIRECTORY_SEPARATOR;
		$this->configPath = realpath( APP_PATH.'config').DIRECTORY_SEPARATOR;
	}
}


?>