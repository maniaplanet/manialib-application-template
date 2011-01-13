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

namespace ManiaLib\Application;

/** 
 * Helper class for dialogs
 */ 
class DialogHelper
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
	/**
	 * @var string
	 */
	public $message = '';
	
	function __construct($dialogClassName = '\ManiaLib\Application\Views\Dialogs\OneButton')
	{
		$this->className = $dialogClassName;
	}
	
}

?>