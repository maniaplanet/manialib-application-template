<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/** 
 * Helps dealing with uploads from Manialinks
 */ 
final class ManiaLib_Utils_Upload
{
	/**#@+
	 * @ignore
	 */
	const READ_PACKET_SIZE = 8192;
	const UPLOADED_FILE_RIGHTS = 0770;
	protected $uploadPath;
	protected $maxSize;
	protected $uploadedFilename;
	protected $inputFile;
	/**#@-*/
	
	/**
	 * @param string The path where the file will be saved
	 * @param string The maximum file size in bytes
	 */
	function __construct($uploadPath, $maxSize)
	{
		$this->uploadPath = $uploadPath;
		$this->maxSize = $maxSize;
	}
	
	/**
	 * Tries to read the specified file and save it
	 * @param string
	 */
	function uploadFile($filename)
	{
		$this->uploadedFilename = $filename;
		
		// Try to get POST data
		$inputStream = fopen('php://input', 'r');
		$this->inputFile = '' ;
		$streamSize = 0;
		
		while(!feof($inputStream))
		{
			$this->inputFile .= fread($inputStream, self::READ_PACKET_SIZE);
			$streamSize += self::READ_PACKET_SIZE;
			if($streamSize > $this->maxSize)
			{
				fclose($inputStream);
				unset($this->inputFile);
				throw new ManiaLib_Utils_UploadFileTooLargeException;
			}
		}
		fclose($inputStream);

		// Else try to get GET data
  		if($this->inputFile=='' && array_key_exists('input', $_GET)) 
  		{
    		$this->inputFile = $_GET['input'];
  		}
  		
  		// Check for error
  		if($this->inputFile=='')
  		{
  			throw new ManiaLib_Utils_UploadException(
				'Couldn\'t read input file');
  		}
  		if(!file_put_contents(
			$this->uploadPath.$this->uploadedFilename, 
			$this->inputFile))
		{
			throw new ManiaLib_Utils_UploadException(
				'Couldn\'t save input file to '.
				$this->uploadPath.$this->uploadedFilename);
		}
		if(!chmod($this->uploadPath.$this->uploadedFilename, 
			self::UPLOADED_FILE_RIGHTS))
		{
			throw new ManiaLib_Utils_UploadException(
				'Couldn\'t chmod input file at '.
				$this->uploadPath.$this->uploadedFilename);	
		}
	}
	
	/**
	 * Deletes the previously uploaded file
	 */
	function deleteUploadedFile()
	{
		unlink($this->getUploadedFilename());
	}
	
	/**
	 * Returns the complete uploaded file name
	 * @return string
	 */
	function getUploadedFilename()
	{
		return $this->uploadPath.$this->uploadedFilename;
	}
	
	/**
	 * Returns the size of the uploaded file
	 */
	function getUploadedFilesize()
	{
		clearstatcache();
		return filesize($this->getUploadedFilename());
	}
}

/**
 * @package ManiaLib
 * @subpackage Helpers
 * @ignore
 */
class ManiaLib_Utils_UploadException extends Exception {}
/**
 * @package ManiaLib
 * @subpackage Helpers
 * @ignore
 */
class ManiaLib_Utils_UploadFileTooLargeException extends ManiaLib_Utils_UploadException {}
 
?>