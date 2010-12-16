<?php

class ManiaLibDemo_Controllers_Shoutbox extends ManiaLib_Application_Controller
{
	const ANTIFLOOD_DELAY = 30; // 30 seconds between each shout
	
	protected $defaultAction = 'viewShouts';
	
	protected function onConstruct()
	{
		$this->addFilter(new ManiaLib_Application_Filters_UserAgentCheck());
		$this->addFilter(new ManiaLib_Application_Filters_RegisterRequestParameters());
		$this->addFilter(new ManiaLibDemo_Filters_MoodSelector());
		$this->addFilter(new ManiaLibDemo_Filters_SplashScreen());
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
		
		$shoutService = new ManiaLibDemo_Services_Shout_Service();
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
				throw new ManiaLib_Application_UserException(
					'You must wait '.self::ANTIFLOOD_DELAY.' seconds between each shout');
			}			
		}
		
		$shoutService = new ManiaLibDemo_Services_Shout_Service();
		
		$shout = new ManiaLibDemo_Services_Shout_Shout();
		$shout->login = $this->session->get('login');
		$shout->nickname = $this->session->get('nickname');
		$shout->message = $message;
		$shoutService->save($shout);
		
		$this->session->set('shoutLastPost', time());		
		
		$this->request->redirectManialinkArgList(Route::CUR, Route::NONE);
	}
	
}


?>