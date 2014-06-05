<!--            
    CONTENT 
			--> 
<div id="content">
	<h1><img src="<?php echo IMGPATH; ?>icons/dashboard.png" alt="" />Dashboard</h1>
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

	?>
	
<div class="bloc left">
    <div class="title">
        Total Contents:
    </div>
    <div class="content dashboard">
        <div class="center">
            <a href="<?php echo SITEPATH.'album?action=view'; ?>" class="shortcut" title='Albums'>
                <img src="<?php echo IMGPATH; ?>icons/mAlbum.png" title='Albums' alt='Albums' width="48" height="48" />
                <?php echo $dashboard['total']['albums']; ?> Albums
            </a>
			<a href="<?php echo SITEPATH.'song?action=view'; ?>" class="shortcut" title='Songs'>
                <img src="<?php echo IMGPATH; ?>icons/song_icon.png" title='Songs' alt='Songs' width="48" height="48"/>
                <?php echo $dashboard['total']['songs']; ?> Songs
            </a>
            <a href="<?php echo SITEPATH.'video?action=view'; ?>" class="shortcut" title='Videos'>
                <img src="<?php echo IMGPATH; ?>icons/video.png" title='Videos' alt='Videos' width="48" height="48" />
                <?php echo $dashboard['total']['videos']; ?> Videos
            </a>
			<a href="<?php echo SITEPATH.'image?action=view'; ?>" class="shortcut" title='Images'>
                <img src="<?php echo IMGPATH; ?>icons/wallpaper.png" title='Images' alt='Images' width="48" height="48" />
                <?php echo $dashboard['total']['images']; ?> Images
            </a>
			<a href="<?php echo SITEPATH.'image?action=view'; ?>" class="shortcut" title="Text">
                <img src="<?php echo IMGPATH; ?>icons/text.png" title="Text" alt="Text" width="48" height="48" />
                <?php echo $dashboard['total']['text']; ?> Text
            </a>
            <a href="<?php echo SITEPATH.'text?action=view'; ?>" class="shortcut last" title='Artist'>
                <img src="<?php echo IMGPATH; ?>icons/mArtist.png" title='Artist' alt='Artist' width="48" height="48" />
                <?php echo $dashboard['total']['artist']; ?> Artist
            </a>
            <div class="cb"></div>
        </div>
    </div>
</div>
<?php
$queryStr="";
$titleStr="Today's Contents:";
if(sizeof($dashboard['publish'])>0){
	$dashboard['today']=array();
	$dashboard['today']=$dashboard['publish'];
	$queryStr="&do=publishlist";
	$titleStr="Final Approval Pending Contents:";
}elseif(sizeof($dashboard['legal'])>0){
	$dashboard['today']=array();
	$dashboard['today']=$dashboard['legal'];
	$queryStr="&do=legallist";
	$titleStr="Legal Pending Contents:";
}elseif(sizeof($dashboard['qc'])>0){
	$dashboard['today']=array();
	$dashboard['today']=$dashboard['qc'];
	$queryStr="&do=qclist";
	$titleStr="QC Pending Contents:";
}
?>                
<div class="bloc right">
    <div class="title">
       	<?php echo $titleStr;?> 
    </div>
    <div class="content dashboard">
        <div class="center">
            <a href="<?php echo SITEPATH.'album?action=view'.$queryStr; ?>" class="shortcut" title='Albums'>
                <img src="<?php echo IMGPATH; ?>icons/mAlbum.png" title='Albums' alt='Albums' width="48" height="48" />
                <?php echo $dashboard['today']['albums']; ?> Albums
            </a>
			<a href="<?php echo SITEPATH.'song?action=view'.$queryStr; ?>" class="shortcut" title='Songs'>
                <img src="<?php echo IMGPATH; ?>icons/song_icon.png" title='Songs' alt='Songs' width="48" height="48"/>
                <?php echo $dashboard['today']['songs']; ?> Songs
            </a>
            <a href="<?php echo SITEPATH.'video?action=view'.$queryStr; ?>" class="shortcut" title='Videos'>
                <img src="<?php echo IMGPATH; ?>icons/video.png" title='Videos' alt='Videos' width="48" height="48" />
                <?php echo $dashboard['today']['videos']; ?> Videos
            </a>
            <a href="<?php echo SITEPATH.'image?action=view'.$queryStr; ?>" class="shortcut" title='Images'>
                <img src="<?php echo IMGPATH; ?>icons/wallpaper.png" title='Images' alt='Images' width="48" height="48" />
                <?php echo $dashboard['today']['images']; ?> Images
            </a>
			<a href="<?php echo SITEPATH.'text?action=view'.$queryStr; ?>" class="shortcut" title="Text">
                <img src="<?php echo IMGPATH; ?>icons/text.png" title="Text" alt="Text" width="48" height="48" />
                <?php echo $dashboard['today']['text']; ?> Text
            </a>
			<?php if(sizeof($dashboard['today']['artist'])>0){?>
			<a href="<?php echo SITEPATH.'artist?action=view'; ?>" class="shortcut last" title='Artist'>
                <img src="<?php echo IMGPATH; ?>icons/mArtist.png" title='Artist' alt='Artist' width="48" height="48" />
                <?php echo $dashboard['today']['artist']; ?> Artist
            </a>
			<?php  }?>
            <div class="cb"></div>
        </div>
    </div>
</div>

<div class="cb"></div>
<?php if( !empty($dashboard['upcoming']) ){ ?>
<div class="bloc">
    <div class="title">
        Upcoming Releases
    </div>
    <div class="content" >
        <?php foreach( $dashboard['upcoming']['albums'] as $kkk=>$album ){ 
				$albumTypeStr = TOOLS::getAlbumTypeText( array('album_type'=>$album->album_type) );				
				$re_dt= explode('-',$album->title_release_date);
		?>
		<a href="<?php echo SITEPATH.'album?action=view&id='.$album->album_id.'&isPlane=1&do=details'; ?>" class="shortcut fancybox fancybox.iframe" style='vertical-align:top;' title="Click to view this Album">
            <img src="<?php echo IMGPATH; ?>icons/mAlbum.png" title='Albums' alt='Albums' width="48" height="48" />
            <?php echo $album->album_name.'<br/><br/>Release On '.$re_dt[2]."-".$re_dt[1]."-".$re_dt[0].'<br /><br />'.$albumTypeStr; ?> 
        </a>
		<?php } ?>
    <div class="cb"></div>
    </div>
</div>
<?php } ?>
<div class="cb"></div>
<?php if( !empty($dashboard['legal_catalouge']) ){ ?>
<div class="bloc">
    <div class="title">
        Catalogues Expire ( Before One Week Alert ) 
    </div>
    <div class="content" >
        <?php 
		
		foreach( $dashboard['legal_catalouge']['catalouge'] as $kkk=>$catalogue ){ 
		?>

		<a href="<?=SITEPATH.'catalogue?action=view&id='.$catalogue->catalogue_id.'&isPlane=1&do=details&catelouge_name='.urlencode($catalogue->catalogue_name);?>" class="shortcut fancybox fancybox.iframe" style='vertical-align:top;' title="Click to view this Catalouge Rights">
            <img src="<?php echo IMGPATH; ?>icons/catalogue.png" title='Catalouge' alt='Catalouge' width="48" height="48" />
            <?=$catalogue->catalogue_name.'<br/><br/>Expire Date '.date('d-M-Y',strtotime($catalogue->expiry_date)).'<br /><br />'; //.$albumTypeStr; ?> 
        </a>
		<?php } ?>
    <div class="cb"></div>
    </div>
</div>
<?php } ?>
<div class="cb"></div>
<?php if( !empty($dashboard['legal']) ){ 
?>
<div class="bloc">
    <div class="title">
        Expire Albums ( Before One Week Alert ) 
    </div>
    <div class="content" >
        <?php 
		$i=0;  
		foreach( $dashboard['legal']['albums'] as $kkk=>$album ){ 
				$albumTypeStr = TOOLS::getAlbumTypeText( array('album_type'=>$album->album_type) );
		?>
		<a href="<?php echo SITEPATH.'album?action=view&id='.$album->album_id.'&isPlane=1&do=rights&album_name='.urlencode($album->album_name);?>" class="shortcut fancybox fancybox.iframe" style='vertical-align:top;' title="Click to view this Album Rights">
            <img src="<?php echo IMGPATH; ?>icons/mAlbum.png" title='Albums' alt='Albums' width="48" height="48" />
            <?php echo $album->album_name.'<br/><br/>Expire Date <br/>'.date('d-M-Y',strtotime($dashboard['legal']['albums_expire'][$i])).'<br /><br />'.$albumTypeStr; ?> 
        </a>
		<?php $i++; } ?>
    <div class="cb"></div>
    </div>
</div>
<?php } ?>
<?php 
	echo CALENDAR::showCalendar(); 
?>
</div>
<!--            
    CONTENT End 
			--> 