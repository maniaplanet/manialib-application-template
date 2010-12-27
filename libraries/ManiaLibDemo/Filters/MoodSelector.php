<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 */
class ManiaLibDemo_Filters_MoodSelector extends ManiaLib_Application_AdvancedFilter
{
	const SESSION_VARIABLE = 'backgroundImage';
	const DEFAULT_BACKGROUND = 'qm-clouds.jpg';
	
	function preFilter()
	{
		if($this->request->get('show_mood_selector'))
		{
			$this->request->delete('show_mood_selector');
			
			$dialog = new ManiaLib_Application_DialogHelper('ManiaLibDemo_Views_Dialogs_MoodSelector');
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
			
			$this->request->redirectManialink(Route::CUR, Route::CUR);
		}
		$this->response->backgroundImage = 
			$this->session->get(self::SESSION_VARIABLE, self::DEFAULT_BACKGROUND);
	}
}

?>