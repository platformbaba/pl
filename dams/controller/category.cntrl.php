<?php
$view = 'category_list';

$action = cms::sanitizeVariable( $_GET['action'] );
if( $action == 'add' || $action == 'edit' ){
	/* Form */
	$view = 'category_form';
}

if( !empty($_POST) ){
	$ret = $oTools->saveImage($_FILES['uploadedfile']);
	print_r($ret);
}


/* render view */
//$oCms->view( $view, $data );
?>
<form enctype="multipart/form-data" method="POST" action=''>
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
Choose a file to upload: <input name="uploadedfile" type="file" /><br />
<input type="submit" value="Upload File" />
</form>