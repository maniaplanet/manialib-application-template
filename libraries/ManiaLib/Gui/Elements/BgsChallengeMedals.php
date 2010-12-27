<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * BgsChallengeMedals quad
 */	
class ManiaLib_Gui_Elements_BgsChallengeMedals extends ManiaLib_Gui_Elements_Quad
{
	/**#@+
	 * @ignore
	 */
	protected $style = ManiaLib_Gui_Elements_Quad::BgsChallengeMedals;
	protected $subStyle = self::BgBronze;
	/**#@-*/
	
	const BgBronze                    = 'BgBronze';
	const BgGold                      = 'BgGold';
	const BgNadeo                     = 'BgNadeo';
	const BgNotPlayed                 = 'BgNotPlayed';
	const BgPlayed                    = 'BgPlayed';
	const BgSilver                    = 'BgSilver';
}

?>