<?php
/**
 * @author Maxime Raoust
 */
 
require_once('core.inc.php');

$request = RequestEngine::getInstance();
$request->registerReferer();

require_once(APP_WWW_PATH.'header.php');

require_once(APP_WWW_PATH.'navigation.php');

require_once(APP_WWW_PATH.'footer.php');

?>