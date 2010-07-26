<?php
/**
 * @author Maxime Raoust
 */

/**
 * Route class, only contains const used by the RequestEngineMVC
 */
abstract class Route
{
	/**
	 * Use current
	 */
	const CUR = -1;
	/**
	 * Use default
	 */
	const DEF = -2;
	/**
	 * Don't use anything
	 */
	const NONE = -3;
}

?>