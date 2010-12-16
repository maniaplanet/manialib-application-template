<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
 */

/** 
 * Helper class for dialogs
 * @package ManiaLib
 * @subpackage MVC
 */ 
class ManiaLib_Application_DialogHelper
{
	/**
	 * @var string 
	 */
	public $className;
	/**
	 * @var string 
	 */
	public $title = 'Dialog';
	/**
	 * @var int 
	 */
	public $height = 50;
	/**
	 * @var int 
	 */
	public $width = 65;
	/**
	 * @var int 
	 */
	public $posX = 0;
	/**
	 * @var int 
	 */
	public $posY = 0;
	/**
	 * @var int 
	 */
	public $posZ = 15;
	/**
	 * @var string 
	 */
	public $buttonLabel = 'Ok';
	/**
	 * @var string 
	 */
	public $buttonManialink;
	/**
	 * @var string 
	 */
	public $button2Label = 'Cancel';
	/**
	 * @var string 
	 */
	public $button2Manialink;
	
	function __construct($dialogClassName = 'ManiaLib_Application_Views_Dialogs_EmptyDialog')
	{
		$this->className = $dialogClassName;
	}
	
}

?>