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
			$this->currentPage = Gpc::getInt($this->urlParamName, $this->defaultPage);
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
		$link = LinkEngine::getInstance();
		if($this->getPageNumber() > 1)
		{
			$ui = $this->pageNavigator;		
			$ui->setPosition($x, $y, $z);
			$ui->setPageNumber($this->getPageNumber());
			$ui->setPageIndex($this->getCurrentPage());

			if($ui->isLastShown())
			{
				$link->setParam($this->urlParamName, 1);
				$ui->arrowFirst->setManialink($link->createLink($file));
				
				$link->setParam($this->urlParamName, $this->getPageNumber());
				$ui->arrowLast->setManialink($link->createLink($file));
			}
			
			if($ui->isFastNextShown())
			{
				$link->setParam($this->urlParamName, $this->currentPage+5);
				$ui->arrowFastNext->setManialink($link->createLink($file));
				
				$link->setParam($this->urlParamName, $this->currentPage-5);
				$ui->arrowFastPrev->setManialink($link->createLink($file));
			}
				
			$link->setParam($this->urlParamName, $this->currentPage+1);
			$ui->arrowNext->setManialink($link->createLink($file));
			
			$link->setParam($this->urlParamName, $this->currentPage-1);
			$ui->arrowPrev->setManialink($link->createLink($file));
			
			$link->setParam($this->urlParamName, $this->currentPage);
			
			$ui->draw();
		}
	}
}

 
?>