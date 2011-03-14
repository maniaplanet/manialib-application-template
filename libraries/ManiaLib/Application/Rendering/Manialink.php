<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2673 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-25 20:08:02 +0100 (ven., 25 févr. 2011) $:
 */

namespace ManiaLib\Application\Rendering;

class Manialink implements RendererInterface
{
	static function exists($viewName)
	{
		return class_exists($viewName);
	}
	
	static function render($viewName)
	{
		if(!self::exists($viewName))
		{
			throw new ViewNotFoundException('View not found: '.$viewName);
		}
		
		$view = new $viewName();
		$view->display();
		
		if($view instanceof \ManiaLib\Application\Views\Dialogs\DialogInterface)
		{
			\ManiaLib\Gui\Manialink::disableLinks();
		}
	}
	
	static function header()
	{
		header('Content-Type: application/xml');
		header('X-Powered-By: ManiaLib 2');
	}
}

?>