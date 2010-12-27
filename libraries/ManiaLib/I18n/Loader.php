<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * I18n loader magic: loads the dynamic dicos, put everything in the cache
 */
class ManiaLib_I18n_Loader extends ManiaLib_Loader_Loader
{
	static $dico = array();
	
	protected static $instance;
	
	protected $debugPrefix = '[I18N LOADER]';
	
	/**
	 * @return ManiaLib_I18n_Loader
	 */
	static function getInstance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	protected function postLoad()
	{
		self::$dico = $this->data;
		if(!class_exists('ManiaLib_I18n_I18n'))
		{
			throw new Exception(
				'Loaded translations but could not find ManiaLib_I18n_I18n class');
		}
	}
	
	/**
	 * @return array
	 */
	protected function load()
	{
		$dico = array();
		if(ManiaLib_Config_Loader::$config && ManiaLib_Config_Loader::$config->i18n)
		{
			if(ManiaLib_Config_Loader::$config->i18n->dynamic)
			{
				$files = array();
				foreach(ManiaLib_Config_Loader::$config->i18n->paths as $path)
				{
					$files = array_merge($files, $this->getLangFilesRecursive($path));
				}
				//var_dump($files);
				$dico = array();
				foreach($files as $file)
				{
					$dico = $this->parseDico($file, $dico);
				}
			}
		}
		return $dico;
	}
	
	/**
	 * Recursively get filenames
	 * @return array
	 */
	protected function getLangFilesRecursive($directoryPath)
	{
		$files = array();
		if ($handle = opendir($directoryPath))
		{
			while (false !== ($file = readdir($handle)))
			{
				if(substr($file, 0, 1)=='.')
				{
					continue;
				}
				elseif(is_dir($directoryPath.'/'.$file))
				{
					$files = array_merge(
						$files, 
						$this->getLangFilesRecursive($directoryPath.'/'.$file));
				}
				elseif(substr($file, -4)=='.xml')
				{
					$files[] = $directoryPath.'/'.$file;
				}
			}
			closedir($handle);
		}
		return $files;
	}
	
	/**
	 * Parse an XML dictonary
	 * @return array
	 */
	protected function parseDico($file, $dico)
	{	
		$dom = new DomDocument;
		$dom->load($file);
		$languages = $dom->getElementsByTagName("language");
		foreach($languages as $language)
		{
			if($language->hasAttribute("id"))
			{
				$lang = $language->getAttribute("id");
				foreach($language->childNodes as $word)
				{
					if($word->nodeType == XML_ELEMENT_NODE)
					{
						$dico[$lang][$word->nodeName] = (string) $word->nodeValue;
					}
				}
			}
		}
		return $dico;
	}
}

?>