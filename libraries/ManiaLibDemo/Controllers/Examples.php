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
class Examples extends \ManiaLib\Application\Controller
{
	protected $defaultAction = 'layouts';
	
	protected function onConstruct()
	{
		$this->addFilter(new \ManiaLib\Application\Tracking\Filter());
		$this->addFilter(new \ManiaLib\Application\Filters\UserAgentCheck());
		$this->addFilter(new \ManiaLib\Application\Filters\RegisterRequestParameters());
		$this->addFilter(new \ManiaLibDemo\Filters\MoodSelector());
		$this->addFilter(new \ManiaLib\Application\Splashscreen\Filter());
	}
	
	function layouts() 
	{
		$this->request->registerReferer();
	}
	
	function tracks() 
	{
		$this->request->registerReferer();
	}
}

?>