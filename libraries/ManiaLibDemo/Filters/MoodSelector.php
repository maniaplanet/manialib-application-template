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

namespace ManiaLibDemo\Filters;

/**
 */
class MoodSelector extends \ManiaLib\Application\AdvancedFilter
{
	const SESSION_VARIABLE = 'backgroundImage';
	const DEFAULT_BACKGROUND = 'qm-clouds.jpg';
	
	function preFilter()
	{
		if($this->request->get('show_mood_selector'))
		{
			$this->request->delete('show_mood_selector');
			
			$dialog = new \ManiaLib\Application\DialogHelper('\ManiaLibDemo\Views\Dialogs\MoodSelector');
			$this->response->registerDialog($dialog);
		}
		elseif($mood = $this->request->get('select_mood'))
		{
			$this->request->delete('select_mood');
			
			switch($mood)
			{
				case 'sm':
					$this->session->set(self::SESSION_VARIABLE, 'sm-clouds.jpg');
					break;
					
				case 'qm':
					$this->session->set(self::SESSION_VARIABLE, 'qm-clouds.jpg');
					break;
					
				case 'tm':
					$this->session->set(self::SESSION_VARIABLE, 'tm-clouds.jpg');
					break;
					
				case 'mp':
					$this->session->set(self::SESSION_VARIABLE, 'maniaplanet-clouds.jpg');
					break;
			}
			
			$this->request->redirectManialink(\ManiaLib\Application\Route::CUR, \ManiaLib\Application\Route::CUR);
		}
		$this->response->backgroundImage = 
			$this->session->get(self::SESSION_VARIABLE, self::DEFAULT_BACKGROUND);
	}
}

?>