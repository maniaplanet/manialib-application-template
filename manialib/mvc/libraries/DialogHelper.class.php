<?php 

class DialogHelper
{
	public $controller;
	public $action;
	
	public $title = 'Dialog';
	public $height = 65;
	public $width = 50;
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