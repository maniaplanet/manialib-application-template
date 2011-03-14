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

interface RendererInterface
{
	static function exists($viewName);
	static function render($viewName);
	static function header();
}