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

namespace ManiaLib\Rest;

if (!function_exists('curl_init')) 
{
	throw new \Exception('ManiaLib\\Rest\\Client needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) 
{
	throw new \Exception('ManiaLib\\Rest\\Client needs the JSON PHP extension.');
}

class Exception extends \Exception {}

/**
 * Lightweight REST client for Web Services.
 * 
 * Requires CURL and JSON extensions
 * 
 * Example:
 * <code>
 * try 
 * {
 *     $client = new \ManiaLib\Rest\Client('user', 'pa55w0rd');
 *     var_dump($client->execute('GET', '/foobar/'));
 *     var_dump($client->execute('POST', '/foobar/', array(
 *         array(
 *             'anInt' => 1,
 *             'aString' => 1,
 *             'anObject' => 1,
 *             'anArray' => 1,
 *         )
 *     )));
 * }
 * catch(\Exception $e)
 * {
 *     var_dump($e);
 * }
 * </code>
 */
class Client
{
	protected $APIURL = 'http://api.maniastudio.com';
	
	protected $username;
	protected $password;
	
	protected $connectionHandle;
	protected $contentType;
	protected $acceptType;
	
	function __construct($username = null, $password = null) 
	{
		$this->setAuth($username, $password);
	}

	function setAuth($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}
	
	function setAPIURL($URL)
	{
		$this->APIURL = $URL;
	}
	
	function execute($verb, $ressource, array $params = array())
	{
		$url = $this->APIURL.$ressource;
		if($verb == 'POST' || $verb == 'PUT')
		{
			 $data = array_pop($params);
			 $data = json_encode($data);
		}
		else
		{
			$data = null;
		}
		if($params)
		{
			array_map('urlencode', $params);
			array_unshift($params, $url);
			$url = call_user_func_array('sprintf', $params);
		}
		
		$header[] = 'Accept: application/json';
		$header[] = 'Content-type: application/json';
		
		$options = array();
		
		switch($verb)
		{
			case 'GET':
				// Nothing to do
				break;
				
			case 'POST':
				$options[CURLOPT_POST] = true;
				$options[CURLOPT_POSTFIELDS] = $data;
				break;
			
			case 'PUT':
				$fh = fopen('php://temp', 'rw');
				fwrite($fh, $data);
				rewind($fh);
				
				$options[CURLOPT_PUT] = true;
				$options[CURLOPT_INFILE] = $fh;
				$options[CURLOPT_INFILESIZE] = strlen($data);
				break;
				
			case 'DELETE':
				$options[CURLOPT_POST] = true;
				$options[CURLOPT_POSTFIELDS] = '';
				$header[] = 'Method: DELETE';
				break;
				
			default:
				throw new Exception('Unsupported HTTP method: '.$verb);
		}
		
		$options[CURLOPT_URL] = $url;
		$options[CURLOPT_HTTPHEADER] = $header;
		$options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
		$options[CURLOPT_USERPWD] = $this->username.':'.$this->password;
		$options[CURLOPT_TIMEOUT] = 2;
		$options[CURLOPT_RETURNTRANSFER] = true;
		
		try 
		{
			$ch = curl_init();
			curl_setopt_array($ch, $options);
			$response = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);
		}
		catch(\Exception $e)
		{
			if($ch)
			{
				curl_close($ch);
			}
			throw $e;
		}
		
		$response = json_decode($response);
		
		if($info['http_code'] == 200)
		{
			return $response;
		}
		else
		{
			if(is_object($response) && property_exists($response, 'message'))
			{
				$message = $response->message;
			}
			else
			{
				$message = 'API error';
			}
			throw new Exception($message, $info['http_code']);
		}
	}
}

?>