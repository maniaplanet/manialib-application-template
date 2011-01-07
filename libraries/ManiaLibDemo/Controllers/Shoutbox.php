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
class Shoutbox extends \ManiaLib\Application\Controller
{
	const ANTIFLOOD_DELAY = 30; // 30 seconds between each shout
	
	protected $defaultAction = 'viewShouts';
	
	protected function onConstruct()
	{
		$this->addFilter(new \ManiaLib\Application\Tracking\Filter());
		$this->addFilter(new \ManiaLib\Application\Filters\UserAgentCheck());
		$this->addFilter(new \ManiaLib\Application\Filters\RegisterRequestParameters());
		$this->addFilter(new \ManiaLibDemo\Filters\MoodSelector());
		$this->addFilter(new \ManiaLib\Application\Splashscreen\Filter());
	}
	
	protected function checkLogin()
	{
		if(!$this->session->get('login') || !$this->session->get('nickname'))
		{
			// Login is not saved, you must access this page with addplayerid or equivalent
			// Redirect
			$this->request->redirectManialinkArgList(\ManiaLib\Application\Route::CUR, \ManiaLib\Application\Route::NONE);
		}
	}
	
	function viewShouts($start = 0)
	{
		$this->request->registerReferer();
		
		$shoutService = new \ManiaLibDemo\Services\Shout\Service();
		$shouts = $shoutService->getAll($start);
		
		$this->response->shouts = $shouts;
	}
	
	function postShout($message)
	{
		$this->checkLogin();
		
		if($lastPost = $this->session->get('shoutLastPost'))
		{
			if(time() - $lastPost < self::ANTIFLOOD_DELAY)
			{
				throw new \ManiaLib\Application\UserException(
					'You must wait '.self::ANTIFLOOD_DELAY.' seconds between each shout');
			}			
		}
		
		$shoutService = new \ManiaLibDemo\Services\Shout\Service();
		
		$shout = new \ManiaLibDemo\Services\Shout\Shout();
		$shout->login = $this->session->get('login');
		$shout->nickname = $this->session->get('nickname');
		$shout->message = $message;
		$shoutService->save($shout);
		
		$this->session->set('shoutLastPost', time());		
		
		$this->request->redirectManialinkArgList(\ManiaLib\Application\Route::CUR, \ManiaLib\Application\Route::NONE);
	}
	
}


?>