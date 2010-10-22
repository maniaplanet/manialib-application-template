<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

/**
 * Shoutbox controller
 */
class shoutboxController extends ActionController
{
	protected $defaultAction = 'view_shouts';
	
	function onConstruct()
	{
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
	
	function view_shouts($start = 0)
	{
		$this->request->registerReferer();
		
		$shouts = ShoutDAO::getAll($start);
		
		$this->response->shouts = $shouts;
	}
	
	function post_shout($message)
	{
		$this->checkLogin();
		
		$shout = new Shout();
		$shout->login = $this->session->get('login');
		$shout->nickname = $this->session->get('nickname');
		$shout->message = $message;
		ShoutDAO::save($shout);
		
		$this->request->redirectManialinkArgList(Route::CUR, Route::NONE);
	}
}

?>