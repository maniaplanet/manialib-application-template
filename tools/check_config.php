<?php 

define('APP_PATH', dirname(__FILE__).'/../');

require_once APP_PATH.'libraries/autoload.php';

\ManiaLib\Config\Loader::getInstance()->testLoad();


?>