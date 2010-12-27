<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Filter for the splashscreen feature
 */
class ManiaLib_Application_Splashscreen_Filter extends ManiaLib_Application_AdvancedFilter
{
	const SESSION_VARIABLE = 'splash_screen';
	
	function preFilter()
	{
		if(!$this->session->get(self::SESSION_VARIABLE))
		{
			$this->request->redirectManialink('Splashscreen', ManiaLib_Application_Route::NONE);
		}
	}
}

?>