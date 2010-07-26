<?php 
/**
 * @author Maxime Raoust
 */

/**
 * Filter with easy access to Session, Request and Response
 */
abstract class AdvancedFilter implements Filterable
{
	/**
	 * @var RequestEngineMVC
	 */
	protected $request;
	/**
	 * @var SessionEngine
	 */
	protected $session;
	/**
	 * @var ResponseEngine
	 */
	protected $response;
	
	/**
	 * Call the parent constructor when you override it in your filters!
	 */
	function __construct()
	{
		$this->request = RequestEngineMVC::getInstance();
		$this->response = ResponseEngine::getInstance();
		$this->session = SessionEngine::getInstance();
	}
	
	public function preFilter() {}
	public function postFilter() {} 
}

?>