<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2382 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-16 12:45:04 +0100 (mer., 16 févr. 2011) $:
 */

namespace ManiaLib\ManiaHome;

use ManiaLib\Gui\Manialink;

class BookmarkButtonView extends \ManiaLib\Application\View
{
	protected $position = array();
	protected $includeURL;
	
	protected function onConstruct()
	{
		// It's kind of business logic so it should not be in a view
		// But it helps reducing dependencies...
		$config = Config::getInstance();
		
		$params['name'] = $config->name ?: $config->manialink;
		$params['url'] = $config->manialink;
		if($config->bannerURL)
		{
			$params['picture'] = $config->bannerURL;
		}
		$this->includeURL = 'http://maniahome.trackmania.com/add.php?'.http_build_query($params);
		
		$this->position = array($config->buttonPosX, $config->buttonPosY, $config->buttonPosZ);
	}
	
	function display()
	{
		Manialink::beginFrame($this->position[0], $this->position[1], $this->position[2]);
		Manialink::includeManialink($this->includeURL);
		Manialink::endFrame();
	}
}

?>