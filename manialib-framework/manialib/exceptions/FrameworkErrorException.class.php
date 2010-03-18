<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Framework error exception, a bit more pratical to use than ErrorException
 * since it extends the framework's base class for exceptions
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
    	$this->optionalMessageLabel = 'Severity';
    	$this->optionalMessageContent = $severity;
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