<script type="text/javascript">
$(function(){
      $('#uploadfile').uploadify({
        'uploader'    : '<?php echo JSPATH; ?>jquery_uploadify/uploadify.swf',
        'script'      : escape('<?php echo SITEPATH; ?>ajax?action=view&type=uploadify&c=song'),
        'cancelImg'   : '<?php echo JSPATH; ?>jquery_uploadify/cancel.png',
        'multi'       : false,
		'auto'        : true,
		'fileExt'     : '*.mp3',
 	 	'fileDesc'    : 'Audio Files',
		'removeCompleted' : false,
		'scriptData'	 : {'isrc' : '1'},
        'onSelectOnce' : function(event,data) {
			$('#uploadfile').uploadifySettings('scriptData',{'isrc' : $('#isrc').val()});
		},
		'onSelect'    : function(event,ID,fileObj) {
			$('#actions-bar').hide();
    	},
		'onCancel'    : function(event,ID,fileObj,data) {
			$('#audioFilePath').val("");
			$('#FileName').html("").show();
		},
		'onComplete'  : function(event, ID, fileObj, response, data) {
			response = eval('('+response+')');
			//console.log(fileObj);
			//console.log(data);
			//console.log(response);
			if(response.status == 'ERROR'){
				alert(response.msg);
			}else if(response.status == 'OK'){
				$('#audioFilePath').val(response.filepath);
				$('#FileName').html('<a href="<?=MEDIA_SITEPATH_SONG?>'+response.filepath+'" target="_blank">'+response.filename+'</a>').show();
				$('#actions-bar').show();
			}
    	},
		'onError'     : function (event,ID,fileObj,errorObj) {
		  	alert(errorObj.type + ' Error: ' + errorObj.info);
			return false;
		}
      });
});
</script>
<!-- CONTENT -->
<div id="content">
  <h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="Song" />IMI Deployment</h1>
  <?php
	/* To show errorr */
	if( !empty($aError) ){
		$aParam = array(
					'type' => 'error',
					'msg' => $aError,
				 );
		TOOLS::showNotification( $aParam );
	}
?>
  <div class="bloc">
    <div class="title">
      <?=ucfirst($_GET['action'])?>
      Deployment</div>
    <div class="content">
      <form method="post" enctype="multipart/form-data">
        <div class="input">
          <label for="input1">Deployment Name <span class='mandatory'>*</span></label>
          <input type="text" id="deploymentName" name="deploymentName" value="<?=$aContent['deploymentName']?>" />
        </div>
        <div class="submit">
          <input type="submit" value="Submit" name="submitBtn"/>
		  <input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/imi-deployment?action=view' " /> 
        </div>
      </form>
    </div>
  </div>
</div>
