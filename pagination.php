<?php
class pagination
{
	#---How many previous and next page links we can show
	public $prevNext;

	#---total no of items
	public $totalItems;

	#---Max no of item per page
	public $perPageItemLimit;

	#---Total No of pages
	public $totalPages;

	#---Final Pagination
	public $finalPagination;

	#---limit and offset
	public $limitOffsetForQuery;
	
	#---Get Parameter to carry forward
	public $getParameterArray;

	#---Get variable for page
	public $getVariableForPageNo;
	public function pagination($prevNext=2,$totalItems=0,$perPageItemLimit=5,$getParameterArray=array(""),$getVariableForPageNo="pageno")
	{
		$this->prevNext=$prevNext;
		$this->totalItems=$totalItems;
		$this->perPageItemLimit=$perPageItemLimit;
		if($this->perPageItemLimit>0)
		{
			if($this->totalItems%$this->perPageItemLimit==0)
			{
				$this->totalPages=$this->totalItems/$this->perPageItemLimit;
			}
			else
			{
				$this->totalPages=($this->totalItems/$this->perPageItemLimit)+1;
			}
		}
		else
		{
			$this->totalPages=0;
		}
		$this->getParameterArray=$getParameterArray;
		$this->getVariableForPageNo=$getVariableForPageNo;
		$this->calculatePagination($_GET[$this->getVariableForPageNo]);
		
	}
	public function calculatePagination($currentPage)
	{
		#---Check that current page is greater then total no of Pages
		if($currentPage==0)
		{
			$currentPage=1;
		}

		if($currentPage>0 && $currentPage<=$this->totalPages && $this->totalItems>0)
		{
			$this->limitOffsetForQuery=" limit ".$this->perPageItemLimit." offset ".($currentPage-1)*$this->perPageItemLimit;			
		}
		else
		{
			#----Redirect the page
			$url="";
			foreach($this->getParameterArray as $key=>$value)
			{
				if($_GET[$value]!='' && $value!=$this->getVariableForPageNo)
				{
					if($url=='')
					{
						$url="?".$value."=".$_GET[$value];
					}
					else
					{
						$url.="&".$value."=".$_GET[$value];
					}
				}
			}
			header("Location: http://".$_SERVER[HTTP_HOST].$_SERVER[PHP_SELF].$url);
		}
		$this->makePagination($currentPage);
	}

	public function makePagination($currentPage)
	{
		$showDotsBefore=1;
		if(($currentPage-$this->prevNext)<=2)
		{
			$showDotsBefore=0;
		}
	
		$showDotsAfter=1;
		if(($currentpage+$this->prevNext)>=($this->totalPages-1))
		{
			$showDotsAfter=0;
		}

                $url="";
                foreach($this->getParameterArray as $key=>$value)
                {
	                if($_GET[$value]!='' && $value!=$this->getVariableForPageNo)
                        {
                	        if($url=='')
                        	{
	                        $url="?".$value."=".$_GET[$value];
	                        }
	                        else
	                        {
	                        $url.="&".$value."=".$_GET[$value];
	                        }
                  	}
		}
		if($url=='')
		{
			$url="?".$this->getVariableForPageNo."=";
		}
		else
		{
			$url.="&".$this->getVariableForPageNo."=";
		}
#			$url="http://".$_SERVER[HTTP_HOST].$_SERVER[PHP_SELF].$url;
			
		for($i=1;$i<=$this->totalPages;$i++)
		{
			if($i==1)
			{
				$this->finalPagination.="<a href='".$url.$i."'>".$i."</a>";
			}
			else if($i<$currentPage)
			{
				if($showDotsBefore==1)
				{
					$this->finalPagination.="&nbsp;&nbsp;...&nbsp;&nbsp;";
					$showDotsBefore=0;
					$i=$currentPage-$this->prevNext-1;
				}
				else
				{
					$this->finalPagination.= "&nbsp;&nbsp; ";
					$this->finalPagination.="<a href='".$url.$i."'>".$i."</a>"; 
					$this->finalPagination.="&nbsp;&nbsp;";
				}
			}
			else if($i>($currentPage+$this->prevNext))
			{
                                if($showDotsAfter==1)
                                {
                                        $this->finalPagination.="&nbsp;&nbsp;...&nbsp;&nbsp;";
                                        $showDotsAfter=0;
					$this->finalPagination.="&nbsp;&nbsp; ";
					$this->finalPagination.="<a href='".$url.$this->totalPages."'>".$this->totalPages."</a>";
					$this->finalPagination.=" &nbsp;&nbsp;";
                                }
			}
			else
			{
				$this->finalPagination.="&nbsp;&nbsp; ";
				$this->finalPagination.= "<a href='".$url.$i."'>".$i."</a>";
				$this->finalPagination.=" &nbsp;&nbsp;";
			}
		}
	}
}
