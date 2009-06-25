<?php
/**
 * Include this file on every page to load the core. Here you can instanciate
 * your objects and include your libraries.
 * 
 * @author Maxime Raoust
 */
 
require_once( "core/inc.php" );


if($playerLogin = Gpc::get("playerlogin"))
{
	$session->set("login", $playerLogin);
}

$link = LinkEngine::getInstance();

$link->registerProtectedParam("playerlogin");

$link->registerGlobalParam("login");
$link->registerGlobalParam("nickname");
$link->registerGlobalParam("path");
$link->registerGlobalParam("lang");

?>