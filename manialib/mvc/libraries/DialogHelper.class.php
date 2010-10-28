<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/** 
 * Helper class for dialogs
 * @package ManiaLib_MVC
 */ 
class DialogHelper
{
	public $controller;
	public $action;
	
	public $title = 'Dialog';
	public $height = 50;
	public $width = 65;
	// TODO add position
	public $buttonLabel = 'Ok';
	public $buttonManialink;
	public $button2Label = 'Cancel';
	public $button2Manialink;
	
	function __construct($controller = 'Dialog', $action = 'emptyDialog')
	{
		$this->controller = $controller;
		$this->action = $action;
	}
	
}

?>