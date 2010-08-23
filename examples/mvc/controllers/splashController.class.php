<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

/**
 * Splash screen with "enter" button controller of our ManiaLib demo 
 */
 class splashController extends ActionController
 {
 	function __construct($controllerName)
	{
		parent::__construct($controllerName);
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