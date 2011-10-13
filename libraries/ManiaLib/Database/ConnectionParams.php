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

namespace ManiaLib\Database;

/**
 * Database connections params
 */
class ConnectionParams
{
	/**
	 * Human readeable identifier of the connection, to use with the factory.
	 * For example "server01" so you can use Connection::factory("server01")
	 * to retrieve a connection with the params from that object.
	 * @var string
	 */
	public $id;

	/**
	 * Hostname
	 * @var string
	 */
	public $host;

	/**
	 * MySQL username
	 * @var string
	 */
	public $user;

	/**
	 * MySQL password
	 * @var string
	 */
	public $password;

	/**
	 * Default database to select
	 * @var string
	 */
	public $database;

	/**
	 * Connection charset
	 * @var string
	 */
	public $charset = 'utf8';

	/**
	 * Whether to use an SSL connection
	 * @var bool
	 */
	public $ssl = false;
}

?>