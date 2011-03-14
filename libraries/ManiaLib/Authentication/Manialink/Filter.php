<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2778 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-04 15:55:34 +0100 (ven., 04 mars 2011) $:
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
		
		$params = $this->request->getAll();
		$params['authentication'] = 1;
		$params[Dispatcher::PATH_INFO_OVERRIDE_PARAM] = Dispatcher::getInstance()->getPathInfo();
		
		$redirect = 
			$ml.(strstr($ml, '?') ? '&' : '?').
			http_build_query($params, '', '&');
		
		$this->request->redirectManialinkAbsolute($redirect);
		return;
	}
}
?>