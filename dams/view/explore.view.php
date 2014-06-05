<!--            
    CONTENT 
			--> 
<div id="content" style='background:#F7F7F7;'>
	<h1><img src="<?php echo IMGPATH; ?>icons/explore.png" alt="" />Explore by <strong style='color:#308ccb'><?=$sDisplayHead?></strong></h1>
	<?php
		/* To show errorr */
		if( !empty($aError) ){
			$aParam = array(
						'type' => 'error',
						'msg' => $aError,
					 );
			TOOLS::showNotification( $aParam );
		}

		/* To show success */
		if( !empty($aSuccess) ){
			$aParam = array(
						'type' => 'success',
						'msg' => $aSuccess,
					 );
			TOOLS::showNotification( $aParam );
		}

if( $type == 'label' ){
?>
<div class="boxContainer MT30">
	<h2 class="titleHead">Labels</h2>
	<div class="boxContDesc twoCol clearfix">
		<?php if( !empty($aContent) ){ 
		foreach( $aContent as $kk=>$vv ){
		?>
		<div class="col">
			<div class="pad5"><a href="<?php echo SITEPATH.'album?srcLbl='.$vv->label_id.'&submitBtn=Search'?>" style='color:#6D6D6D;'><?php echo $vv->label_name?></a></div>
		</div>
		<?php } } ?>
	</div>
</div>
<?php


}else if( $type == 'year' ){


?>
<div class="boxContainer MT30">
	<h2 class="titleHead"></h2>
	<div class="boxContDesc threeCol clearfix">
	<?php if( !empty($aContent) ){ 
	foreach( $aContent as $kk=>$vv ){
		$kkArr = explode('-',$kk);	
		$srcSrtDate = (int)$kkArr[0].'-01-01';
		$srcEndDate = (int)$kkArr[1].'-12-31';	
		
	?>
		<div class="col">
			<div class='subBHead'><?=$kk?></div>
			<div class="pad5"><a href="<?php echo SITEPATH.'album?srcSrtDate='.$srcSrtDate.'&srcEndDate='.$srcEndDate.'&submitBtn=Search'?>" style='color:#6D6D6D;'><?php echo ($vv>1?' Albums ('.$vv.')':' Album ('.$vv.')'); ?></a></div>
		</div>
	<?php } } ?>
	</div>
</div>
<?php


}else if( $type == 'genre' ){


?>
<div class="boxContainer MT30">
<?php 
if( !empty($aContent) ){ 
	$tmpChar = ''; $cnt=0; $ttcnt =count($aContent);
	foreach( $aContent as $kk=>$vv ){ $cnt++;
		$genreName = trim($vv->tag_name);
		$genreNameChar = strtoupper(substr($genreName, 0, 1));
		
		if( $genreNameChar!=$tmpChar && $tmpChar!=''){
			echo '</div>';
		}
		if( $genreNameChar!=$tmpChar || $tmpChar==''){
			$tmpChar=$genreNameChar;
		?>
	<h2 class="titleHead"><?=$genreNameChar?></h2>
	<div class="boxContDesc twoCol clearfix">
		<?php
			}
		?>
		<div class="col">
			<div class="pad5"><a href="<?php echo SITEPATH.'song?srcTag=1688&srcRtTag='.$genreName.'&autosuggesttag_hddn='.$vv->tag_id.'&submitBtn=Search'?>" style='color:#6D6D6D;'><?php echo $genreName; ?></a></div>
		</div>
	<?php 
			if( $cnt==count($aContent) ){
				echo '</div>';
			}
	}
}
?>
</div>
<?php


}else if( $type=='artist' ){

if( !empty($aContent) ){
	$totalCount = count($aContent);
}
?>
<div class="boxContainer MT30">
	<h2 class="titleHead">
		<span class='FL'><?=strtoupper($char)?> ( <?=$totalCount?> )</span>
		<span class='FR MR10'># 
		<?php 
		foreach( range('a', 'z') as $letter ){
			$greyCss = '';
			if( $char != $letter ){ $greyCss='color:#A7A7A7!important;font-weight:normal;'; }
			echo '   <a href="'.SITEPATH.'explore?action=view&type=artist&char='.$letter.'" style="margin-left:5px!important; '.$greyCss.'" >'.strtoupper($letter).'</a>';
		} 
		?>
		</span>
		<br class='clearfix' />
	</h2>
	<div class="boxContDesc threeCol clearfix">
		<?php if( !empty($aContent) ){ 
		foreach( $aContent as $kk=>$vv ){
		?>
		<div class="col">
			<div class="pad5"><a href="<?php echo SITEPATH.'artist?action=view&isPlane=1&id='.$vv->artist_id.'&do=details'; ?>" class="fancybox fancybox.iframe" style='color:#6D6D6D;'><?php echo $vv->artist_name?></a></div>
		</div>
		<?php } } ?>
	</div>
</div>
<?php


}


?>	

</div>
<!--            
    CONTENT End 
			--> 