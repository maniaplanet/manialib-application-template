<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2631 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-24 16:27:12 +0100 (jeu., 24 févr. 2011) $:
 */

namespace ManiaLib\Cache;

interface CacheInterface
{
	function exists($key);
	function fetch($key); 
	function add($key, $value, $ttl=0);
	function delete($key);
	function inc($key);
}

?>