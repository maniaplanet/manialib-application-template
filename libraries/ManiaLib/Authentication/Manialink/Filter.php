<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 3324 $:
 * @author      $Author: svn $:
 * @date        $Date: 2011-04-06 17:21:28 +0200 (mer., 06 avr. 2011) $:
 */

namespace ManiaLib\Authentication\Manialink;

use ManiaLib\Application\Dispatcher;
use ManiaLib\Application\Route;

/**
 * Authentication filter
 * Register this filter in your controller, and all the actions will require 
 * authentication using the Manialink Authentication System developped by NADEO
 * @see \ManiaLib\Authentication\Manialink\Authentication 
 */
class Filter extends \ManiaLib\Authentication\AbstractFilter
{
	protected function redirectToLogin()
	{
		$ml = \ManiaLib\Application\Config::getInstance()->manialink;
		$config = \ManiaLib\Authentication\Config::getInstance();

		$pathinfo = Dispatcher::getInstance()->getPathInfo();
		$params = $this->request->getAll();
		$params['authentication'] = 1;
		if($pathinfo && $pathinfo != '/')
		{
			$params[Dispatcher::PATH_INFO_OVERRIDE_PARAM] = $pathinfo;
		}
		
		$redirect = 
			$ml.(strstr($ml, '?') ? '&' : '?').
			http_build_query($params, '', '&');
		
		$this->request->redirectManialinkAbsolute($redirect);
		return;
	}
}
?>