<?php
/**
 * Admin logout
 * @author Maxime Raoust
 * @package admin
 */
 
require_once( dirname(__FILE__) . "/../core.inc.php" );

AdminEngine::checkAuthentication();

$session->delete("admin_authenticated");

RequestEngine::getInstance()->redirectManialink("../index.php");


?>