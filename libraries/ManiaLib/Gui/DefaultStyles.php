<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Default element styles
 * @ignore
 */
abstract class ManiaLib_Gui_DefaultStyles
{	
	/**#@+
	 * Default styles for the Panel card
	 */
	const Panel_Style = ManiaLib_Gui_Elements_Quad::Bgs1;
	const Panel_Substyle = ManiaLib_Gui_Elements_Bgs1::BgWindow2;
	const Panel_Title_Style = ManiaLib_Gui_Elements_Label::TextTitle3;
	const Panel_TitleBg_Style = ManiaLib_Gui_Elements_Quad::Bgs1;
	const Panel_TitleBg_Substyle = ManiaLib_Gui_Elements_Bgs1::BgTitle3_1;
	/**#@-*/
	
	/**#@+
	 * Default styles for NavigationButton card
	 */
	const NavigationButton_Style = ManiaLib_Gui_Elements_Quad::Bgs1;
	const NavigationButton_Substyle = ManiaLib_Gui_Elements_Bgs1::NavButton;
	const NavigationButton_Text_Style = ManiaLib_Gui_Elements_Label::TextButtonNav;
	const NavigationButton_Selected_Substyle = ManiaLib_Gui_Elements_Bgs1::NavButtonBlink;
	/**#@-*/
	
	/**#@+
	 * Default styles for Navigation card
	 */
	const Navigation_Style = ManiaLib_Gui_Elements_Quad::Bgs1;
	const Navigation_Substyle = ManiaLib_Gui_Elements_Bgs1::BgWindow1;
	const Navigation_Title_Style = ManiaLib_Gui_Elements_Label::TextRankingsBig;
	const Navigation_Subtitle_Style = ManiaLib_Gui_Elements_Label::TextTips;
	const Navigation_TitleBg_Style = ManiaLib_Gui_Elements_Quad::Bgs1;
	const Navigation_TitleBg_Substyle = ManiaLib_Gui_Elements_Bgs1::BgTitlePage;
	/**#@-*/
	
	/**#@+
	 * Default styles for the page navigator 
	 */
	const PageNavigator_ArrowNone_Substyle = ManiaLib_Gui_Elements_Icons64x64_1::StarGold;
	const PageNavigator_ArrowNext_Substyle = ManiaLib_Gui_Elements_Icons64x64_1::ArrowNext;
	const PageNavigator_ArrowPrev_Substyle = ManiaLib_Gui_Elements_Icons64x64_1::ArrowPrev;
	const PageNavigator_ArrowLast_Substyle = ManiaLib_Gui_Elements_Icons64x64_1::ArrowLast;
	const PageNavigator_ArrowFirst_Substyle = ManiaLib_Gui_Elements_Icons64x64_1::ArrowFirst;
	const PageNavigator_ArrowFastNext_Substyle = ManiaLib_Gui_Elements_Icons64x64_1::ArrowFastNext;
	const PageNavigator_ArrowFastPrev_Substyle = ManiaLib_Gui_Elements_Icons64x64_1::ArrowFastPrev;
	/**#@-*/
}

?>