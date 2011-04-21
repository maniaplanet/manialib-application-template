<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 *
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2382 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-16 12:45:04 +0100 (mer., 16 févr. 2011) $:
 */

namespace ManiaLib\ManiaHome;

/**
 * ManiaLib-integrated client for posting notifications on ManiaHome
 */
class Client
{
	/**
	 * @var \ManiaLib\Rest\Client
	 */
	protected $HTTPClient;

	protected $manialink;

	/**
	 * For each of the three parameters, there are several way of specifying
	 * them. In order of priority:
	 *
	 * - Is it set in the constuctor?
	 *
	 * - Is it set in ManiaLib\ManiaHome\Config (maniahome.xxx directives in
	 *   the config file)?
	 * 
	 * - It it set in the config of ManiaLib (manialib.application,
	 *   restclient.username & restclient.password)?
	 */
	function __construct($manialink=null, $username=null, $password=null)
	{
		$maniahome = Config::getInstance();
		$application = \ManiaLib\Application\Config::getInstance();
		$rest = \ManiaLib\Rest\Config::getInstance();

		if(!$manialink)
		{
			$manialink = $maniahome->manialink ?: $application->manialink;
		}
		if(!$username)
		{
			$username = $maniahome->username ?: $rest->username;
		}
		if(!$password)
		{
			$password = $maniahome->password ?: $rest->password;
		}

		$this->manialink = $manialink;
		$this->HTTPClient = new \ManiaLib\Rest\Client($username, $password);
	}

	/**
	 * Sends a notification to everyone who bookmarked your Manialink
	 * @see http://fish.stabb.de/styles/ For icon styles and substyles
	 * @param string Notification message
	 * @param string Link of the notification
	 * @param string Icon style
	 * @param string Icon substyle
	 */
	public function sendNotificationFromManialink($message, $link=null, $iconStyle = null, $iconSubStyle = null)
	{
		$data = array(
			'senderName' => $this->manialink,
			'message' => $message,
            'receiverName' => null,
            'link' => $link,
			'iconStyle' => $iconStyle,
			'iconSubStyle' => $iconSubStyle,
		);
		
		$this->HTTPClient->execute('POST', '/maniahome/notification/', array($data));
	}

	/**
	 * Sends a public notification to the specified player. His buddies will see
	 * that notification (unless he changed his privacy settings)
	 * @see http://fish.stabb.de/styles/ For icon styles and substyles
	 * @param string Login of the recipient
	 * @param string Notification message
	 * @param string Link of the notification
	 * @param string Icon style
	 * @param string Icon substyle
	 */
	public function sendPublicNotificationToPlayer($playerLogin, $message, $link=null, $iconStyle = null, $iconSubStyle = null)
	{
		$data = array(
			'senderName' => $this->manialink,
			'message' => $message,
            'link' => $link,
			'iconStyle' => $iconStyle,
			'iconSubStyle' => $iconSubStyle,
		);
		$this->HTTPClient->execute('POST', '/maniahome/notification/%s/', array($playerLogin, $data));
	}

	/**
	 * Sends a private notification to the specified player. Only this player will
	 * see the notification.
	 * @see http://fish.stabb.de/styles/ For icon styles and substyles
	 * @param string Login of the recipient
	 * @param string Notification message
	 * @param string Link of the notification
	 */
	public function sendPrivateNotificationToPlayer($playerLogin, $message, $link=null)
	{
		$data = array(
			'senderName' => $this->manialink,
			'message' => $message,
			'link' => $link,
		);
		$this->HTTPClient->execute('POST', '/maniahome/notification/%s/private/', array($playerLogin, $data));
	}
}

?>