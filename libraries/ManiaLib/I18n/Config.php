<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * I18n conf
 */
class ManiaLib_I18n_Config extends ManiaLib_Config_Configurable
{
	public $paths = array();
	public $dynamic = false;
	
	protected function validate()
	{
		if(!in_array(LANGS_DIR, $this->paths))
		{
			$this->paths[] = LANGS_DIR;
		}
	}
}


?>