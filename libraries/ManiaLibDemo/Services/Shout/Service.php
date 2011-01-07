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

namespace ManiaLibDemo\Services\Shout;

/**
 * Shout data access
 * SQL structure:
 * <code>
 * CREATE TABLE IF NOT EXISTS `ManiaLib_Shouts` (
 * `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 * `datePosted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 * `login` varchar(25) NOT NULL,
 * `nickname` varchar(75) NOT NULL,
 * `message` varchar(160) NOT NULL,
 * PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
 * </code>
 */
class Service extends \ManiaLib\Services\AbstractService
{
	/**
	 * Get the (10 by default) latest shouts
	 * @return array[\ManiaLibDemo\Services\Shout\Shout]
	 */
	function getAll($offset=0, $length=10)
	{
		$result = $this->db->execute(
			'SELECT * '.
			'FROM ManiaLib_Shouts '.
			'ORDER BY datePosted DESC '.
			\ManiaLib\Database\Tools::getLimitString($offset, $length));
		$shouts = array();
		{
			while($shout = \ManiaLibDemo\Services\Shout\Shout::fromRecordSet($result))
			{
				$shouts[] = $shout;
			}
		}
		return array_reverse($shouts);
	}
	
	function save(\ManiaLibDemo\Services\Shout\Shout $shout)
	{
		$newShout = $shout->id==null;
		
		$values = array(
			'login' => $this->db->quote($shout->login), 
			'nickname' => $this->db->quote($shout->nickname),
			'message' => $this->db->quote($shout->message));
		
		if(!$newShout)
			$values['id'] = (int)$shout->id;
		
		$result = $this->db->execute(
			'INSERT INTO ManiaLib_Shouts '.
			\ManiaLib\Database\Tools::getValuesString($values).' '.
			'ON DUPLICATE KEY UPDATE '.
			\ManiaLib\Database\Tools::getOnDuplicateKeyUpdateValuesString(array_keys($values)));
			
		if($newShout)
		{
			$shout->id = $this->db->insertID();
		}
	}
}

?>