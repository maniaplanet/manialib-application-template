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

namespace ManiaLib\Application\Splashscreen;

/**
 * Filter for the splashscreen feature
 */
class Filter extends \ManiaLib\Application\AdvancedFilter
{
	const SESSION_VARIABLE = 'splash_screen';
	
	function preFilter()
	{
		if(!$this->session->get(self::SESSION_VARIABLE))
		{
			$this->request->redirectManialink('Splashscreen', \ManiaLib\Application\Route::NONE);
		}
	}
}

?>