<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**  			 
 * Hack: sometimes classes can't be loaded throuh __autoload
 * @ignore
 */
require_once(APP_FRAMEWORK_EXCEPTIONS_PATH.'FrameworkException.class.php');

/**
 * Framework error exception
 * 
 * Thrown when a PHP error occurs. The custom error handler converts all errors
 * into this exception.
 * 
 * A bit more pratical to use than ErrorException since it extends the 
 * framework's base exception class
 */
class FrameworkErrorException extends FrameworkException 
{
	protected $severity;
	
    function __construct ($message, $code, $severity, $filename, $lineno)
    {
    	parent::__construct($message, $code, null, false);
    	$this->file = $filename;
    	$this->line = $lineno;
    	$this->severity = $severity;
    	$this->addOptionalInfo('Severity', $severity);
    	$this->iLog();
    }
    
    /**
     * Returns the severity of the error (See PHP error constants)
     * @return int
     */
    function getSeverity()
    {
    	return $this->severity;
    }
}

?>