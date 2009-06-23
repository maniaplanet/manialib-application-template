<?php
/**
 * Manialink GUI API
 * 
 * API entry point : include this file in your scripts
 * 
 * @author Maxime Raoust
 */

/**
 * Image web directory URL
 */
define("GUI_IMAGE_DIR_URL", APP_URL . "images/" );

/**
 * Includes
 */
require_once( dirname(__FILE__) . "/lib/sgl.php" );
require_once( dirname(__FILE__) . "/styles/styles.php" );  

/**
 * Autoload function for cards
 */
function autoload_gui($className)
{
	if(file_exists( dirname(__FILE__) . "/cards/$className.class.php" ))
	{
		require_once( dirname(__FILE__) . "/cards/$className.class.php" );
	}
}

/**
 * If __autoload() is already defined in your app, it must be explicitly
 * registerd in the SPL autoload stack : spl_autoload_register ("__autoload");
 */
spl_autoload_register("autoload_gui");

?>