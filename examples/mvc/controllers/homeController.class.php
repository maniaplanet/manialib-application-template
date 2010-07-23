<?php

class homeController extends ActionController
{
	function index() 
	{
		$this->request->redirectManialink(null, 'about');
	}
	
	function about() {}
	
	function features() {}
	
	function download() {}
	
	function showcase() {}	
}

?>