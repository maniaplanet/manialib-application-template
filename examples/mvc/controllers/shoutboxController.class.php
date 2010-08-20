<?php
/**
 * @author Maxime Raoust
 * @copyright NADEO
 */

/**
 * Shoutbox controller
 */
class shoutboxController extends ActionController
{
	protected $defaultAction = 'view_shouts';
	
	function __construct($controllerName)
	{
		parent::__construct($controllerName);
		$this->addFilter(new MoodSelectorFilter());
		$this->addFilter(new RegisterRequestParametersFilter());
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