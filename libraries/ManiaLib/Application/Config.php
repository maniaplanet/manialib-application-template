<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Application config
 */
class ManiaLib_Application_Config extends ManiaLib_Config_Configurable
{
	/**
	 * @var Manialib_Application_Tracking_Config
	 */
	public $tracking;
	
	public $URL;
	public $manialink;
	public $namespace;
	public $name;
	
	public $publicURL;
	/**
	 * @deprecated
	 */
	public $dicosURL;
	public $langsURL;
	public $imagesURL;
	public $mediaURL;
	
	public $URLSeparator = '_';
	
	public $useRewriteRules = false;
	
	public $defaultController = 'Home';
	public $defaultAction = 'index';
	
	function __construct()
	{
		$this->loadNestedConfig(array(
			'tracking' => 'Manialib_Application_Tracking_Config',
		));
	}
	
	protected function validate()
	{
		$this->checkExists('URL');
		$this->checkExists('manialink');
		$this->checkExists('namespace');
		$this->setDefault('publicURL', $this->URL.'public/');
		$this->setDefault('dicosURL', $this->publicURL.'langs/');
		$this->setDefault('langsURL', $this->publicURL.'langs/');
		$this->setDefault('imagesURL', $this->publicURL.'images/');
		$this->setDefault('mediaURL', $this->publicURL.'media/');
	}
}

?>