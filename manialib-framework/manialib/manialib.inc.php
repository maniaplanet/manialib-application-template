<?php
/**
 * FRAMEWORK ENTRY POINT
 * 
 * This file is part of ManiaLib.
 *  
 * ManiaLib  is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 * 
 * ManiaLib is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ManiaLib.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Maxime Raoust
 * @package Manialib
 */

ob_start();

// Framework includes. The classes will be loaded through the __autoload() function
require_once( dirname(__FILE__).'/config.default.php' );
require_once( dirname(__FILE__).'/settings.php' );
require_once( APP_FRAMEWORK_PATH.'utils.php' );

require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'Manialink.class.php' );

// Date config
date_default_timezone_set(DEFAULT_TIMEZONE);

// Error handler
error_reporting(E_ALL);
set_error_handler(array('ErrorHandling', 'manialinkHandler'));
set_exception_handler(array('ErrorHandling', 'exceptionHandler'));

?>