<?php
/**
 * Include this file on every page to load the framework. Here you can
 * instanciate your objects and include your libraries.
 * 
 * @author Maxime Raoust
 */

require_once( dirname(__FILE__).'/config.php' );
require_once( dirname(__FILE__).'/manialib/manialib.inc.php' );

$request = RequestEngine::getInstance();

if($playerLogin = $request->get("playerlogin"))
{
	$session->set("login", $playerLogin);
}

$request->registerProtectedParam("playerlogin");
$request->registerGlobalParam("login");
$request->registerGlobalParam("nickname");
$request->registerGlobalParam("path");
$request->registerGlobalParam("lang");

?>