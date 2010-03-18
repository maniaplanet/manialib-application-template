<?php
/**
 * @author Maxime Raoust
 */
 
require_once('core.inc.php');

$request = RequestEngine::getInstance();
$request->registerReferer();

require_once('header.php');

require_once('navigation.php');

try
{
	throw new FrameworkException;
}
catch(Exception $e)
{
	FrameworkException::handle($e);
}

require_once('footer.php');

?>