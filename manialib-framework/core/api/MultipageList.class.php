<?php
/**
 * Multipage helper
 * 
 * @author Maxime Raoust
 */ 

/**
 * This class helps to create multipage lists. Maybe difficult to use at
 * first... Doc should be written about it
 */
class MultipageList
{
	protected $size;
	protected $urlParamName = "page";
	protected $currentPage;
	protected $defaultPage=1;
	protected $perPage = 8;
	protected $pageNumber;
	public $pageNavigator;

	function __construct()
	{
		$this->pageNavigator = new PageNavigator;
		$this->pageNavigator->hideLast();
	}

	function setSize($size)
	{
		$this->size = $size;
		if($this->getCurrentPage() > $this->getPageNumber())
			$this->currentPage = $this->getPageNumber();
	}
	
	function setPerPage($perPage)
	{
		$this->perPage = $perPage;
	}
	
	function setCurrentPage($page)
	{
		$this->currentPage = $page;
	}
	
	function setDefaultPage($page)
	{
		$this->defaultPage = $page;
	}
	
	function setUrlParamName($name)
	{
		$this->urlParamName = $name;
	}
	
	function getCurrentPage()
	{
		if($this->currentPage === null)
		{
			$this->currentPage = (int) RequestEngine::getInstance()->get($this->urlParamName, $this->defaultPage);
		}
		if( $this->currentPage < 1)
		{
			$this->currentPage = 1;
		}
		return $this->currentPage;
		
	}
		
	function getPageNumber()
	{
		if($this->pageNumber === null && $this->perPage)
		{
			$this->pageNumber = ceil($this->size/$this->perPage);
		}
		return $this->pageNumber;
	}
	
	function getLimit()
	{
		$offset = ($this->getCurrentPage()-1)*$this->perPage;
		$length = $this->perPage;
		return array($offset, $length); 
	}
	
	function drawPageNavigator($x, $y, $z, $file=null)
	{
		$request = RequestEngine::getInstance();
		if($this->getPageNumber() > 1)
		{
			$ui = $this->pageNavigator;		
			$ui->setPosition($x, $y, $z);
			$ui->setPageNumber($this->getPageNumber());
			$ui->setPageIndex($this->getCurrentPage());

			if($ui->isLastShown())
			{
				$request->set($this->urlParamName, 1);
				$ui->arrowFirst->setManialink($request->createLink($file));
				
				$request->set($this->urlParamName, $this->getPageNumber());
				$ui->arrowLast->setManialink($request->createLink($file));
			}
			
			if($ui->isFastNextShown())
			{
				$request->set($this->urlParamName, $this->currentPage+5);
				$ui->arrowFastNext->setManialink($request->createLink($file));
				
				$request->set($this->urlParamName, $this->currentPage-5);
				$ui->arrowFastPrev->setManialink($request->createLink($file));
			}
				
			$request->set($this->urlParamName, $this->currentPage+1);
			$ui->arrowNext->setManialink($request->createLink($file));
			
			$request->set($this->urlParamName, $this->currentPage-1);
			$ui->arrowPrev->setManialink($request->createLink($file));
			
			$request->set($this->urlParamName, $this->currentPage);
			
			$ui->save();
		}
	}
}

 
?>