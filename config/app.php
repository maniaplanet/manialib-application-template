<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 *
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

if(!defined('MANIALIB_APP_PATH'))
{
	exit;
}

$hostname = ManiaLib\Utils\Arrays::get($_SERVER, 'HTTP_HOST');

$application = ManiaLib\Application\Config::getInstance();
$application->namespace = 'ManiaLibDemo';
$application->defaultController = 'Home';

$log = \ManiaLib\Utils\LoggerConfig::getInstance();
$log->prefix = 'manialib';

if($hostname == 'www.example.com')
{
	// Production config

	$application->manialink = 'example';
	$application->URL = 'http://www.example.com/';
	$application->useRewriteRules = true;

	$database = \ManiaLib\Database\Config::getInstance();
	$database->user = 'root';
	$database->password = '';

	// For using the Maniaplanet Web Services
	$webservices = \ManiaLib\WebServices\Config::getInstance();
	$webservices->username = 'your_api_username';
	$webservices->password = 'your_api_password';
}
elseif($hostname == '127.0.0.1')
{
	// Development config

	$application->URL = 'http://127.0.0.1/manialib/';
	$application->debug = true;
}
?>