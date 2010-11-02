<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

class MoodSelectorFilter extends AdvancedFilter
{
	function preFilter()
	{
		if($this->request->get('show_mood_selector'))
		{
			$this->request->delete('show_mood_selector');
			$dialog = new DialogHelper('Dialogs', 'moodSelector');
			$this->response->registerDialog($dialog);
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