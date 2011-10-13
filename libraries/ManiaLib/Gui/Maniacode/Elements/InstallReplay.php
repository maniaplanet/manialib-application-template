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

namespace ManiaLib\Gui\Maniacode\Elements;

/**
 * Install replay
 */
class InstallReplay extends \ManiaLib\Gui\Maniacode\Elements\FileDownload
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'install_replay';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}


?>