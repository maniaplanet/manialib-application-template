<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

class ManiaLibDemo_Filters_SplashScreen extends ManiaLib_Application_AdvancedFilter
{
	function preFilter()
	{
		if(!$this->session->get(ManiaLibDemo_Controllers_Splash::SESSION_VARIABLE))
		{
			$this->request->redirectManialink('Splash', ManiaLib_Application_Route::NONE);
		}
	}
}

?>