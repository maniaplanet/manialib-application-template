<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\I18n;

/**
 * I18n loader magic: loads the dynamic dicos, put everything in the cache
 */
class Loader extends \ManiaLib\Loader\Loader
{
	static $dico = array();
	
	protected static $instance;
	
	protected $debugPrefix = '[I18N LOADER]';
	
	/**
	 * @return \ManiaLib\I18n\Loader
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
		if(!class_exists('\ManiaLib\I18n\I18n'))
		{
			throw new \Exception(
				'Loaded translations but could not find \ManiaLib\I18n\I18n class');
		}
	}
	
	/**
	 * @return array
	 */
	protected function load()
	{
		$dico = array();
		if(Config::getInstance()->dynamic)
		{
			$files = array();
			foreach(Config::getInstance()->paths as $path)
			{
				$files = array_merge($files, $this->getLangFilesRecursive($path));
			}
			//var_dump($files);
			$dico = array();
			foreach($files as $file)
			{
				if(file_exists($file))
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
		if(file_exists($directoryPath))
		{
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
		}
		return $files;
	}
	
	/**
	 * Parse an XML dictonary
	 * @return array
	 */
	protected function parseDico($file, $dico)
	{	
		$dom = new \DOMDocument;
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