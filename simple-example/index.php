<?php
/**
 * @author Maxime Raoust
 */
 
require_once('core.inc.php');

$request = RequestEngine::getInstance();
$request->registerReferer();

require_once('header.php');

require_once('navigation.php');

require_once('footer.php');


?>