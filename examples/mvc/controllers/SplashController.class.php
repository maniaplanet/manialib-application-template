<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

/**
 * Splash screen with "enter" button controller of our ManiaLib demo 
 */
 class SplashController extends ActionController
 {
 	function onConstruct()
	{
		$this->addFilter(new RegisterRequestParametersFilter());
		$this->addFilter(new MoodSelectorFilter());
	}
	
	function index() {}
	
	function enter()
	{
		$this->session->set('splash_screen', 1);
		$this->request->redirectManialink('home', Route::NONE);
	}
 }
 
 ?>