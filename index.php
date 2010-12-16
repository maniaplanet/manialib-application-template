<?php

// Hacks
define('APP_PATH', dirname(__FILE__).'/');
define('LANGS_DIR', APP_PATH.'public/langs/');
define('LOGS_SUBDIR', APP_PATH.'logs/');

require_once 'libraries/autoload.php';

ManiaLib_Application_Bootstrapper::run(dirname(__FILE__).'/config/app.ini');

?>