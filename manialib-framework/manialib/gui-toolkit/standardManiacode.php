<?php
/**
 * @author Philippe Melot
 */

/**
  Class ManiacodeComponent
*/
abstract class ManiacodeComponent
{
	protected $xmlTagName;
	protected $xml;
	
	final function save()
	{	
		if ($this->xmlTagName)
		{
			$this->xml = Maniacode::$domDocument->createElement($this->xmlTagName);
			end(Maniacode::$parentNodes)->appendChild($this->xml);
		}
		
		if (isset($this->message))
		{
			$elem  = Maniacode::$domDocument->createElement('message');
			$value = Maniacode::$domDocument->createTextNode($this->message);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->name))
		{
			$elem  = Maniacode::$domDocument->createElement('name');
			$value = Maniacode::$domDocument->createTextNode($this->name);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->url))
		{
			$elem  = Maniacode::$domDocument->createElement('url');
			$value = Maniacode::$domDocument->createTextNode($this->url);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->ip))
		{
			$elem  = Maniacode::$domDocument->createElement('ip');
			$value = Maniacode::$domDocument->createTextNode($this->ip);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->file))
		{
			$elem  = Maniacode::$domDocument->createElement('file');
			$value = Maniacode::$domDocument->createTextNode($this->file);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->link))
		{
			$elem  = Maniacode::$domDocument->createElement('link');
			$value = Maniacode::$domDocument->createTextNode($this->link);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->password))
		{
			$elem  = Maniacode::$domDocument->createElement('password');
			$value = Maniacode::$domDocument->createTextNode($this->password);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->connectionType))
		{
			$elem  = Maniacode::$domDocument->createElement('connection_type');
			$value = Maniacode::$domDocument->createTextNode($this->connectionType);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->login))
		{
			$elem  = Maniacode::$domDocument->createElement('login');
			$value = Maniacode::$domDocument->createTextNode($this->login);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->email))
		{
			$elem  = Maniacode::$domDocument->createElement('email');
			$value = Maniacode::$domDocument->createTextNode($this->email);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->tracks) && is_array($this->tracks) && count($this->tracks))
		{
			foreach ($this->tracks as $track)
			{
				$track->save();
			}
		}
	}
}

/**
  Class fileDownload
*/
abstract class fileDownload extends ManiacodeComponent
{
	protected $name;
	protected $url;
	
	function __construct($name = '', $url  = '')
	{
		$this->name = $name;
		$this->url = $url;
	}
	
	/**
	 * This method sets the Name of the file once download
	 *
	 * @param string $name The name of the file once download
	 * @return void
	 *
	 */
	function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * This method gets the Name of the element
	 *
	 * @return string This return the name of the file once download
	 *
	 */
	function getName()
	{
		return $this->name;
	}
	
	/**
	 * This method sets the url to download the file
	 *
	 * @param string $url The url to download the file
	 * @return void
	 *
	 */
	function setUrl($url)
	{
		$this->url = $url;
	}
	
	/**
	 * This method gets the Url of the element
	 *
	 * @return void
	 *
	 */
	function getUrl()
	{
		return $this->url;
	}
}

/**
  Class InstallTrack
*/
class InstallTrack extends fileDownload
{
	protected $xmlTagName = 'install_track';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

/**
  Class PlayTrack
*/
class PlayTrack extends fileDownload
{
	protected $xmlTagName = 'play_track';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

/**
  Class Track
   Use it only with InstallTrackPack
*/
class Track extends fileDownload
{
	protected $xmlTagName = 'track';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

/**
  Class InstallTrackPack
*/
class InstallTrackPack extends ManiacodeComponent
{
	protected $xmlTagName = 'install_track_pack';
	protected $name;
	protected $tracks = array();
	
	function __construct($name='')
	{
		$this->name = $name;
	}
	
	function setName($name)
	{
		$this->name = $name;
	}
	
	function getName()
	{
		return $this->name;
	}
	
	function addTrack($name = '',  $url = '')
	{
		$this->tracks[] = new Track($name, $url);
	}
	
	function getLastInsert()
	{
		return end($this->tracks);
	}
}

/**
  Class InstallReplay
*/
class InstallReplay extends fileDownload
{
	protected $xmlTagName = 'install_replay';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

/**
  Class ViewReplay
*/
class ViewReplay extends fileDownload
{
	protected $xmlTagName = 'view_replay';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

/**
  Class PlayReplay
*/
class PlayReplay extends fileDownload
{
	protected $xmlTagName = 'play_replay';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

/**
  Class InstallSkin
*/
class InstallSkin extends fileDownload
{
	protected $xmlTagName = 'install_skin';
	protected $file;
	
	function __construc($name='', $file='', $url='')
	{
		parent::__construct($name, $url);
		$this->setFile($file);
	}
	
	/**
	 * This method sets the path to install the skin
	 *
	 * @param string $file The path to the skin
	 * @return void 
	 *
	 */
	public function setFile($file)
	{
		$this->file = $file;
	}
	
	/**
	 * This method gets the path to install the skin
	 *
	 * @return string The path to the skin
	 *
	 */
	public function getFile()
	{
		return $this->file;
	}
}

/**
  Class GetSkin
*/
class GetSkin extends InstallSkin
{
	protected $xmlTagName = 'get_skin';
	
	function __construct($name='', $file='', $url='')
	{
		parent::__construct($name, $file, $url);
	}
}

/**
  Class ShowMessage
*/
class ShowMessage extends ManiacodeComponent
{
	protected $xmlTagName = 'show_message';
	protected $message;
	
	function __construct($message = 'This is a default message provided by Manialib')
	{
		$this->setMessage($message);
	}
	
	function setMessage($message)
	{
		$this->message = $message;
	}
	
	function getMessage()
	{
		return $this->message;
	}
}

/**
  Class GotoLink
*/
class GotoLink extends ManiacodeComponent
{
	protected $xmlTagName = 'goto';
	protected $link;
	
	function __construct($link = 'manialib')
	{
		$this->setLink($link);
	}
	
	function setLink($link)
	{
		$this->link = $link;
	}
	
	function getLink()
	{
		return $this->link;
	}
}

/**
  Class JoinServer
   Join 
*/
class JoinServer extends ManiacodeComponent
{
	/**
	 * Connection type value
	 */
	const PLAY = 1;
	const SPEC = 2;
	const REFEREE = 3;
	
	protected $xmlTagName = 'join_server';
	protected $ip;
	protected $password;
	protected $connectionType;
	
	function __construct($ip = '192.168.0.1', $password = '', $connectionType = self::PLAY)
	{
		$this->ip = $ip;
		$this->password = $password;
		$this->connectionType = $connectionType;
	}
	
	function setIp($ip)
	{
		$this->ip = $ip;
	}
	
	function getIp()
	{
		return $this->ip;
	}
	
	protected function setPassword($password)
	{
		$this->setPassword = $password;
	}
	
	protected function getPassword()
	{
		return $this->password;
	}
	
	protected function setConnectionType($connection)
	{
		$this->connectionType = $connection;
	}
	
	protected function getConnectionType()
	{
		return $this->connectionType;
	}
}

/**
  Class AddBuddy
*/
class AddBuddy extends ManiacodeComponent
{
	protected $xmlTagName = 'add_buddy';
	protected $login;
	
	function __construct($login)
	{
		$this->login = $login;
	}
	
	function setLogin($login)
	{
		$this->login = $login;
	}
	
	function getLogin()
	{
		return $this->login;
	}
}

/**
  Class InviteBuddy
*/
class InviteBuddy
{
	protected $xmlTagName = 'invite_buddy';
	protected $email;
	
	function __construct($email = '')
	{
		$this->email = $email;
	}
	
	function setEmail($email)
	{
		$this->email = $email;
	}
	
	function getEmail()
	{
		return $this->email;
	}
}

/**
  Class AddFavorite
*/
class AddFavorite extends AddBuddy
{
	protected $xmlTagName = 'add_favorite';
	
	function __construct($login)
	{
		parent::__construct($login);
	}
}
?>