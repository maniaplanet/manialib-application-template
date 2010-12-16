<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

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
class ManiaLibDemo_Services_Shout_Service extends ManiaLib_Services_AbstractService
{
	/**
	 * Get the (10 by default) latest shouts
	 * @return array[ManiaLibDemo_Services_Shout_Shout]
	 */
	function getAll($offset=0, $length=10)
	{
		$result = $this->db->execute(
			'SELECT * '.
			'FROM ManiaLib_Shouts '.
			'ORDER BY datePosted DESC '.
			ManiaLib_Database_Tools::getLimitString($offset, $length));
		$shouts = array();
		{
			while($shout = ManiaLibDemo_Services_Shout_Shout::fromRecordSet($result))
			{
				$shouts[] = $shout;
			}
		}
		return array_reverse($shouts);
	}
	
	function save(ManiaLibDemo_Services_Shout_Shout $shout)
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
			ManiaLib_Database_Tools::getValuesString($values).' '.
			'ON DUPLICATE KEY UPDATE '.
			ManiaLib_Database_Tools::getOnDuplicateKeyUpdateValuesString(array_keys($values)));
			
		if($newShout)
		{
			$shout->id = $this->db->insertID();
		}
	}
}

?>