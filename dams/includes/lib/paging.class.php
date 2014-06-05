<?php
final class Paging {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 10;
	public $url = '';
	
	public $arcPg = 0;
	public $arcRowCnt = 20;
	
	//public $text = 'Showing {start} to {end} of {total} ({pages} Pages)';
	public $text = '';
	public $text_first = '|&lt;';
	public $text_last = '&gt;|';
	public $text_next = '&gt;';
	public $text_prev = '&lt;';
	public $style_links = 'links';
	public $style_results = 'results';
	 
	public function render() {
		$total = $this->total;
		
		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}
		
		if (!$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}
		
		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);
		
		$output = '';
		
		if ($page > 1) {
			$output .= ' <a href="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</a> <a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a> ';
    	}

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);
			
				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}
						
				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			if ($start > 1) {
				$output .= ' .... ';
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					//$output .= ' <b>' . $i . '</b> ';
					$output .= ' <a href="' . str_replace('{page}', $i, $this->url) . ' " class="current">' . $i . '</a> ';
				} else {
					$output .= ' <a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a> ';
				}	
			}
							
			if ($end < $num_pages) {
				$output .= ' .... ';
			}
		}
		
   		if ($page < $num_pages) {
			$output .= ' <a href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a> <a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a> ';
		}
		
		$find = array(
			'{start}',
			'{end}',
			'{total}',
			'{pages}'
		);
		
		$replace = array(
			($total) ? (($page - 1) * $limit) + 1 : 0,
			((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
			$total, 
			$num_pages
		);
		
		return ($output ? '<div class="' . $this->style_links . '">' . $output . '</div>' : '') . '<div class="' . $this->style_results . '">' . str_replace($find, $replace, $this->text) . '</div>';
	}
	
	function simpleRender(){
	
		$nextPage = str_replace('{page}',($this->page+1),$this->url);
		$prevPage = "";
		if($this->page > 1){
			$prevPage = str_replace('{page}',($this->page-1),$this->url);
		}
		
		if($this->total < $this->limit)
		$nextPage = str_replace('{page}',$this->page,$this->url)."&arcpg=".($arcPg+1);
			
		if($arcPg)
		$prevPage = str_replace('{page}',$this->page,$this->url)."&arcpg=".($this->arcPg-1);
		
		if($this->arcRowCnt < $this->limit && $this->arcPg){
			$nextPage = '';
		}
		
		$output = ''; 
				
		if($prevPage)
			$output .= "<a href='".$prevPage."'><< Previous</a> ";
						  
		if($nextPage)
			$output .= " | <a href='".$nextPage."'>Next >></a>";
			
		return $output;
	}
}


/* Example To Use
$iLimit = 20;
$oPage = new Page();
$oPage->total = $rowCount['count'];
$oPage->page = $iPage;
$oPage->limit = $iLimit;
$oPage->url = "cms.php?page={page}";
$oPage->text = 'Showing {start} to {end} of {total} ({pages} Pages)';
$oPage->style_links = 'FR w_11';
$oPage->style_results = 'FR w_11 MR10';
$iOffset = (($iPage-1)*$iLimit);
$sShowPaging = $oPage->render();
*/
?>