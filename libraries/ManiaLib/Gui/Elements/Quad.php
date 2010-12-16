<?php

/**
 * ManiaLib_Gui_Elements_Quad
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class ManiaLib_Gui_Elements_Quad extends ManiaLib_Gui_Element
{
	/**#@+
	 * Manialink <b>style</b> for the <b>ManiaLib_Gui_Elements_Quad</b> element 
	 */
	const BgRaceScore2        = 'BgRaceScore2';
	const Bgs1                = 'Bgs1';
	const Bgs1InRace          = 'Bgs1InRace';
	const BgsChallengeMedals  = 'BgsChallengeMedals';
	const BgsPlayerCard       = 'BgsPlayerCard';
	const Icons128x128_1      = 'Icons128x128_1';
	const Icons128x32_1       = 'Icons128x32_1';
	const Icons64x64_1        = 'Icons64x64_1';
	const MedalsBig           = 'MedalsBig';
	/**#@-*/
	
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'quad';
	protected $style = self::Bgs1;
	protected $subStyle = ManiaLib_Gui_Elements_Bgs1::BgWindow2;
	/**#@-*/
}

?>