<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Shoutbox controller
 */
class ShoutboxController extends ActionController
{
	const ANTIFLOOD_DELAY = 30; // 30 seconds between each shout
	
	protected $defaultAction = 'viewShouts';
	
	protected function onConstruct()
	{
		$this->addFilter(new UserAgentCheckFilter());
		$this->addFilter(new RegisterRequestParametersFilter());
		$this->addFilter(new MoodSelectorFilter());
		$this->addFilter(new ForceSplashScreenFilter());
	}
	
	protected function checkLogin()
	{
		if(!$this->session->get('login') || !$this->session->get('nickname'))
		{
			// Login is not saved, you must access this page with addplayerid or equivalent
			// Redirect
			$this->request->redirectManialinkArgList(Route::CUR, Route::NONE);
		}
	}
	
	function viewShouts($start = 0)
	{
		$this->request->registerReferer();
		
		$shouts = ShoutDAO::getAll($start);
		
		$this->response->shouts = $shouts;
	}
	
	function postShout($message)
	{
		$this->checkLogin();
		
		if($lastPost = $this->session->get('shoutLastPost'))
		{
			if(time() - $lastPost < self::ANTIFLOOD_DELAY)
			{
				throw new UserException('You must wait '.self::ANTIFLOOD_DELAY.' seconds between each shout');
			}			
		}
		
		$shout = new Shout();
		$shout->login = $this->session->get('login');
		$shout->nickname = $this->session->get('nickname');
		$shout->message = $message;
		ShoutDAO::save($shout);
		
		$this->session->set('shoutLastPost', time());		
		
		$this->request->redirectManialinkArgList(Route::CUR, Route::NONE);
	}
}

?>