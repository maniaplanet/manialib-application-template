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

/**#@+
 * Includes
 */
require_once( dirname(__FILE__) . "/standard_library/Manialink.class.php" );
require_once( dirname(__FILE__) . "/standard_library/sgl.php" );
require_once( dirname(__FILE__) . "/styles/styles.php" );
/**#@-*/

?>