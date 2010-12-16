<?php 

/**
 * ManiaLib_Application_Filterable implentation with access to Session, Request and Response
 * @see ManiaLib_Application_Filterable
 */
abstract class ManiaLib_Application_AdvancedFilter implements ManiaLib_Application_Filterable
{
	/**
	 * @var ManiaLib_Application_Request
	 */
	protected $request;
	/**
	 * @var ManiaLib_Application_Session
	 */
	protected $session;
	/**
	 * @var ManiaLib_Application_Response
	 */
	protected $response;
	
	/**
	 * Call the parent constructor when you override it in your filters!
	 */
	function __construct()
	{
		$this->request = ManiaLib_Application_Request::getInstance();
		$this->response = ManiaLib_Application_Response::getInstance();
		$this->session = ManiaLib_Application_Session::getInstance();
	}
	
	public function preFilter() {}
	public function postFilter() {} 
}

?>