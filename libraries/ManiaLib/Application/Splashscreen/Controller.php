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

namespace ManiaLib\Application\Splashscreen;

/**
 * Base controller for the splash screen feature
 * Extends this controller in your app
 * 
 * Controller name should be "[..]_Controllers_Splashscreen"
 */
abstract class Controller extends \ManiaLib\Application\Controller
{
	protected function onConstruct()
	{
		$this->addFilter(new \ManiaLib\Application\Filters\UserAgentCheck());
		$this->addFilter(new \ManiaLib\Application\Filters\RegisterRequestParameters());
	}
	
	function index() 
	{
		$manialink = $this->request->createLink(\ManiaLib\Application\Route::CUR, 'enter');
		
		$this->response->enterManialink = $manialink;
	}
	
	function enter()
	{
		$this->session->set(\ManiaLib\Application\Splashscreen\Filter::SESSION_VARIABLE, 1);
		$this->request->redirectManialink(\ManiaLib\Application\Route::NONE, \ManiaLib\Application\Route::NONE);
	}
}
 
?>