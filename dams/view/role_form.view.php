<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Roles</h1>
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
    <div class="title"><?=ucfirst($_GET['action'])?> Role</div>
    <div class="content">
	<form method="post">
        <div class="input">
            <label for="input1">Role Name</label>
            <input type="text" id="roleName" name="roleName" value="<?=$aContent['roleName']?>" />
        </div>
        
		<div class="input">
            <label for="select">Status</label>
            
			<select name="status" id="select">
                <?php
					foreach($status_options as $k=>$status){
						$selStr = ($aContent['status']=="1")?"selected='selected'":"";
						echo '<option value="'.$k.'" '.$selStr.' >'.$status.'</option>';
					}
				?>
            </select>
        </div>
        <div class="submit">
            <input type="submit" value="Submit" name="submitBtn"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/role?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>