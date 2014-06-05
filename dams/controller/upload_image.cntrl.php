<?php 
//this is common controller to upload image          
$action = cms::sanitizeVariable( $_GET['action'] ); 
$action = ($action==''?'view':$action); 
$cType = cms::sanitizeVariable( $_GET['c'] );
$do = cms::sanitizeVariable($_GET['do']);
global $aConfig;
$view = 'upload_image';
$oImage = new image();
if($action="view"){
	if($do=="suggest"){
		$view = 'image_suggest';
		$srcImage = cms::sanitizeVariable( $_GET['srcImage'] );
		$srcImgType  = 1;
		$srcImgType	 = (int)$_GET['srcImgType'];
		$where		 = '';
		if( $srcImage != '' ){
			$where .= ' AND image_name like "'.$oMysqli->secure($srcImage).'%"';
		}
		if( $srcImgType>0 ){ $where .= ' AND image_type&'.$srcImgType.' ='.$srcImgType.' '; }
		
		$data['aSearch']['srcImage'] 	= $srcImage;
		$data['aSearch']['srcImgType'] 	= $srcImgType;
		/* Search Param end */
		
		/* Show Image as List Start */
		$limit	= 5;
		$page	= (int)$_GET['page'];
		$start	= ( $page>0 ? (($page-1)*$limit) : 0 );
		$params = array(
					'limit'	  => $limit,  
					'orderby' => 'ORDER BY insert_date DESC',  
					'start'   => $start,  
					'where'	  => $where,
				  );
		
		$data['aContent'] = $oImage->getAllImages( $params );
		#echo $oImage;
		/* Pagination Start */
		$oPage = new Paging();
		$oPage->total = $oImage->getTotalCount( $params );
		$oPage->page = $page;
		$oPage->limit = $limit;
		$oPage->url = "upload_image?action=view&isPlane=1&cType=".$_GET['cType']."&cId=".$_GET['cId']."&place=oPic&do=suggest&srcImage=$srcImage&srcCType=$srcCType&srcImgType=$srcImgType&page={page}";
		$iOffset = (($page-1)*$limit);
		$data['sPaging'] = $oPage->render();
		$data['image_type']  = TOOLS::getImageTypes();
		$oCms->view( $view, $data );
		exit();
	}
	$aError=array();
	if(!empty($_POST)){
		$srcImage="";
		$srcTitle=cms::sanitizeVariable($_POST['srcTitle']);
		$srcDesc=cms::sanitizeVariable($_POST['srcDesc']);
		if($srcTitle==""){
			$aError[] = "Please enter Image Title.";
		}	
		if($_FILES['srcImage']['name']!=""){
			$ret = TOOLS::saveImage($_FILES['srcImage']);
			if($ret['error']){
				$aError[]= $ret['error'];
			}else{
				$srcImage =	$ret['image'];
			}	
		}else{
			$aError[]="Please upload proper Image.";
		}
		$data['aContent']=array('srcTitle' => $srcTitle , 'srcDesc' => $srcDesc );
		$data['aError']=$aError;
		if($srcImage && empty($aError)){
		$params = array(
			'imageName' 	=> $srcTitle, 
			'imageDesc' 	=> $srcDesc, 
			'imageType' 	=> 1, 
			'imageFile'     => $srcImage,
			'status' 		=> 1, 
		  );
		$aData = $oImage->saveImage( $params );
		if($aData){
			?>
				<script type="text/javascript">parent.cms.setImage({'imageVal':'<?=$srcImage?>','imagePath':'<?=TOOLS::getImage(array('img'=>$srcImage));?>','place':'<?=$_GET['place']?>','imageId':'<?=$aData?>'});</script>
			<?php  
			} 
		}			
	}		
}
$oCms->view( $view, $data );