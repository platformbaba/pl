<link rel="stylesheet" href="<?=CSSPATH?>validationEngine.jquery.css" type="text/css"/>
<script src="<?=JSPATH?>jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=JSPATH?>jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#editFrm").validationEngine({
			validateNonVisibleFields: true,
        	updatePromptsPosition:true
		});
	});
</script>
<!-- CONTENT --> 
<div id="content">
          
<h1><img src="<?php echo IMGPATH; ?>icons/posts.png" alt="" />Editor</h1>
<?php
if(isset($data['aError']) && !empty($data['aError']) && sizeof($_POST)>0){
	foreach($data['aError'] as $error){
?>
<div class="notif error bloc">
	<strong>Error :</strong> <?=$error?>
	<a class="close" href="#"></a>
</div>
<?php	}
}
$sUri="";
if((int)$_GET['id']>0){
	$sUri="&id=".(int)$_GET['id'];
}
?>
<div class="bloc">
    <div class="title"><?=ucwords($_GET['action'])?> Editor</div>
    <div class="content">
	<form action="<?php echo SITEPATH;?>editor?action=<?=$_GET['action']?><?=$sUri?>" enctype="multipart/form-data" method="post" id="editFrm" name="editFrm">
        <div class="input">
            <label for="input1">Username</label>
            <input type="text" id="username" name="username" value="<?=$data['aContent']['username']?>" class="validate[required]"/>
        </div>
        <div class="input">
            <label for="input1">Password</label>
            <input type="password" id="password1" name="password1" value="" class="validate[required]"/>
        </div>
        <div class="input">
            <label for="input1">Confirm Password</label>
            <input type="password" id="password2" name="password2" value="" class="validate[required]"/>
        </div>
        <div class="input">
            <label for="input1">Name</label>
            <input type="text" id="name" name="name" value="<?=$data['aContent']['name']?>" class="validate[required]"/>
        </div>
		<div class="input">
            <label for="input1">Email Id</label>
            <input type="text" id="email" name="email" value="<?=$data['aContent']['emailId']?>" class="validate[required,custom[email]]"/>
        </div>		
        <div class="input">
            <label for="file">Upload a file</label>
            <input type="file" id="file" name="pic" value="<?=$data['aContent']['image']?>" />
			<?php
				if($_GET['action']=='edit'){
			?>
				<div style="width:140px;float:right" class="picture"><a class="zoombox" href="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>"><img alt="" src="<?=TOOLS::getImage(array('img'=>$data['aContent']['image']));?>" style="max-height:100px; max-width:100px;"></a></div>
				<input type="hidden" name="oPic" value="<?=$data['aContent']['image']?>" />
			<?php	
				}
			
			?>
        </div>
		<div class="input">
            <label for="select">Status</label>
            <select name="status" id="select">
                <option value="1" <?=($data['aContent']['status']=="1")?"selected='selected'":""?>><?php echo ucfirst($aConfig['status-options'][1]);?></option>
                <option value="0" <?=($data['aContent']['status']=="0")?"selected='selected'":""?>><?php echo ucfirst($aConfig['status-options'][0]);?></option>
            </select>
        </div>
		<div class="input">
            <label for="select">Role</label>
            <select name="roleId[]" id="select" multiple="multiple" size="5" style=" width:165px;" class="validate[required]">
				<?php
					foreach($data['roleList'] as $rKey=>$rValue){
				?>
		                <option value="<?=$rValue->role_id?>" <?=in_array($rValue->role_id,(array)$data['aContent']['roleId'])?"selected='selected'":""?>><?php echo ucfirst($rValue->role_name);?></option>
				<?php
					}
				?>		
            </select>
        </div>
        <div class="submit">
            <input type="submit" value="Submit"/>
			<input type="button" name="Cancel" value="Cancel" onclick="window.location = '/cms/editor?action=view' " /> 
        </div>
	</form>
    </div>
</div>
</div>