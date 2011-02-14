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

namespace ManiaLibDemo\Controllers;

/**
 */
class Home extends \ManiaLib\Application\Controller
{
	protected $defaultAction = 'about';
	
	protected function onConstruct()
	{
		$this->addFilter(new \ManiaLib\Application\Tracking\Filter());
		$this->addFilter(new \ManiaLib\Application\Filters\UserAgentCheck());
		$this->addFilter(new \ManiaLib\Application\Filters\RegisterRequestParameters());
		$this->addFilter(new \ManiaLibDemo\Filters\MoodSelector());
		//$this->addFilter(new \ManiaLib\Application\Splashscreen\Filter());
	}
	
	function about() 
	{
		$this->request->registerReferer();
	}
	
	function features() 
	{
		$this->request->registerReferer();
	}
	
	function download() 
	{
		$this->request->registerReferer();
	}
	
	function showcase() 
	{
		$this->request->registerReferer();
	}
}


?>