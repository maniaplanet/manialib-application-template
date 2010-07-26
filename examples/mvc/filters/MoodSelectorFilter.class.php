<?php
/**
 * @author Maxime Raoust
 * @copyright NADEO
 */

class MoodSelectorFilter extends AdvancedFilter
{
	function preFilter()
	{
		if($this->request->get('show_mood_selector'))
		{
			$this->request->delete('show_mood_selector');
			
			$this->response->registerDialog('dialogs', 'mood_selector_dialog');
			
			$this->response->dialogTitle = 'Select a mood';
			$this->response->dialogButtonManialink = 
				$this->request->createLink(Route::CUR, Route::CUR);
		}
		elseif($mood = $this->request->get('select_mood'))
		{
			$this->request->delete('select_mood');
			
			switch($mood)
			{
				case 'sm':
					$this->session->set('backgroundImage', 'sm-clouds.jpg');
					break;
					
				case 'qm':
					$this->session->set('backgroundImage', 'qm-clouds.jpg');
					break;
					
				case 'tm':
					$this->session->set('backgroundImage', 'tm-clouds.jpg');
					break;
					
				case 'mp':
					$this->session->set('backgroundImage', 'maniaplanet-clouds.jpg');
					break;
			}
			
			$this->request->redirectManialink(Route::CUR, Route::CUR);
		}
		$this->response->backgroundImage = 
			$this->session->get('backgroundImage', 'qm-clouds.jpg');
	}
}

?>