<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

class ForceSplashScreenFilter extends AdvancedFilter
{
	function preFilter()
	{
		if(!$this->session->get('splash_screen'))
		{
			$this->request->redirectManialink('splash', Route::NONE);
		}
	}
}

?>