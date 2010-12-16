<?php

class ManiaLib_Application_Config extends ManiaLib_Config_Configurable
{
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