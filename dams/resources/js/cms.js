var SITEPATH='/cms/';
var cms = {
	
	resetForm:function(frm){
		document.getElementById(frm).reset();
	},
	clearHiddenField:function( field, hiddenField ){
		
		if( document.getElementById(field).value == '' ){
			document.getElementById(hiddenField).value = '';
		}
	},
	/* CAll to load next/pre month calendar */
	showPhpCal:function( mm_yyyy ){
		jQuery.getJSON(SITEPATH+'ajax?action=view&type=calendar&query='+escape(mm_yyyy)+'', function(data) {
			if(data['error'] == undefined) {
                jQuery('#showCalender').html(data['content']);
            }
        });
	},
	/* ajax call */
	ajaxCall:function( obj ){
		var r = confirm("Are you ready?");
		if (r == true){
			var url=obj.url;
			var container=obj.container;
			var msg=obj.msg;
			jQuery('#'+container).html("<img src='"+SITEPATH+"resources/img/loader.gif' style='margin-left: 20px;'/>");
			jQuery.getJSON(url, function(data) {
				 if(data==1){
					jQuery('#'+container).html('<span style="margin-left: 20px;color:green;">'+msg+'</span>');	 
				 }else{
					jQuery('#'+container).html('<span style="margin-left: 20px;color:red;">'+data+'</span>');
				 }
			});
		}
	},
	/* play Songs */
	playSongPreview:function( aFile, type ){
		var player = '<audio id="audiox3" style="width: 150px;" src="'+aFile+'" controls="controls" autoplay="autoplay"><source src="'+aFile+'" type="audio/wav"><object data="'+aFile+'" height="50"><embed src="'+aFile+'" height="50">Sorry, your browser does not support.</object></audio>';
		
		if( type == 'lhs' ){
			jQuery('#lhsPlayerPreview').html(player);
		}else if( type == 'top' ){
			jQuery('#topPlayerPreview').html(player);
		}
		return false;
	},
	/* Use to delete/publish/unpublish contents */
	callAction:function(obj){
		if(obj.action !='' && obj.id != '' && obj.model != ''){
			//var isConfirm = confirm("Do you want to "+obj.action+" this record?");
			var isConfirm = confirm("Are you sure?");
			if(isConfirm){ 
				$('#contentId').val(obj.id);
				$('#contentAction').val(obj.action);
				$('#contentModel').val(obj.model);
				actionFrm.submit();
			}	
		}
	},

	/* Use to Multi delete/publish/unpublish contents */
	callMultiAction:function(act){
		if( act != '' ){
			var isConfirm = confirm("Do you want to "+act+" all selected records?");
			if(isConfirm){ 
				actFrm.submit();
			}	
		}
	},
	
	
	/* Show Error Msg */ 
	showErrMsg:function(div, msg, type){
		alert(msg);
	},

	/* To get value from div */
	getVal:function(div){
		return $.trim($('#'+div).val());
	},

	/* To get attr value from div */
	getAttrVal:function(div,attr){
		return $.trim($('#'+div).attr(attr));
	},
	/* To get attr value from div */
	setTheme:function(obj){
		$.cookie("cTheme", obj.cTheme, { expires : 365 });
		window.location.reload();
	},
	/*search box autosuggest*/
	srchartist:function(obj, entityid, entitytype){		
		$('#noteId').show();
		$('#'+entityid).show();		
		$('#'+entityid).html('<option>Loading...</option>');
        jQuery.getJSON(SITEPATH+'ajax?action=view&type='+entitytype+'&query='+escape(obj.value)+'', function(data) {
			if(data['error'] == undefined) {
                var options = "";
                for(x in data['option']) {
                    options += "<option value=\""+x+"\">"+data['option'][x]+"</option>";
                }
                jQuery('#'+entityid).html(options);
            }
        });
    },
	getDetails:function(obj,inputField,displayBox,dropdownId){
		var swaps='';
		var dataId='';
		var sData='';
		dataId = $("#"+inputField).val();
		sData = $("#"+inputField+"sData").val();
		swaps = $("#"+displayBox).html();	
		
		for(i=0;i<obj.length;i++){
			if(obj.options[i].selected){
				if(dataId.indexOf(","+obj.options[i].value+",")==-1){

						swaps += "<span id='"+dropdownId+"_"+obj.options[i].value+"'><a href='javascript:void(0);' title='Double Click to Remove' ondblclick=\"cms.removeData("+obj.options[i].value+",'"+inputField+"','"+dropdownId+"')\">"+obj.options[i].text+"</a><br></span>";				
						dataId += obj.options[i].value+',';
						sData += obj.options[i].value+':'+obj.options[i].text+'|';
				}			
			}
		}
		$("#"+inputField).val(dataId);
		$("#"+inputField+"sData").val(sData);
		$("#"+displayBox).html(swaps);
	},
	removeData:function(id,inputField,dropdownId){
		spanId = dropdownId+"_"+id;
		$("#"+dropdownId+" option").each(function(){
		  if ($(this).val() == id)
			$(this).attr("selected",false);
		});
	
		$("#"+spanId).remove();
		var dataId='';
		dataId=$("#"+inputField).val();	
		data = dataId.split(',');
		var swap='';
		for(i=0;i<data.length;i++){
			if(data[i]!=id && data[i]!=''){
				swap += data[i]+",";			
			}
		}
		$("#"+inputField).val(swap);
	},

	/* close fancy box*/
	closeFancybox:function(){
		$(".fancybox-close").trigger( "click" );	
	},
	/* upload image  */
	setImage:function(obj){
		this.closeFancybox();
		$("#"+obj.place,parent.document.body).val(obj.imageVal);
		$("#"+obj.place+"Img",parent.document.body).attr("src",obj.imagePath);
		$("#"+obj.place+"Zoombox",parent.document.body).attr("href",obj.imagePath);
		$("#"+obj.place+"ImageId",parent.document.body).val(obj.imageId);
	},
	addToPlaylist:function(obj){
		var isConfirm = confirm("Are you sure?");
		if(isConfirm){
			var playlistId=obj.playlistId;
			var songId=obj.songId;
			var ctype=obj.ctype;
			if(ctype==4){ c="Song"; }else if(ctype==15){ c="Video";}else if(ctype==17){c="Image";}
			if(songId=="multi"){
				songId="";	
				var isChecked="0";
				$("input.checkBoxCls").filter("input:checked").each(function (i, ob) { 												   
					songId += $(ob).val()+",";
					isChecked="1";
				});	
			}
			if(isChecked=="0"){
				alert("Please select atleast one "+c+"!");	
				return false;
			}
			if(playlistId!="" && songId!=""){
				$.post( SITEPATH+"ajax?action=view&type=addtoplaylist", { playlistId : playlistId,songId : $.trim(songId) ,ctype:ctype }, function( data ) {
					if(data==1){
						//alert(c+" added to playlist!");	
						$(".fancybox-close").trigger( "click" );
					}
				});
			}
		}
	},
	setRawFile:function(obj){
		this.closeFancybox();
		$("#rawFile",parent.document.body).html(obj.rFile);
		$("#rawFileVal",parent.document.body).val(obj.rawFile);
	},
	/* To validate Form */
	validateField:function(div, msg, type){
	if(type == 'email'){
		var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
		if(emailPattern.test(getVal(div)) == false){
			this.showErrMsg(div, msg, type);
			return false;
		}else{
			return true;
		}
	}else if(type == 'number'){
		var phonePattern = /^[0-9]+$/;
		if(phonePattern.test(getVal(div)) == false){
			this.showErrMsg(div, msg, type);
			return false;
		}else{
			return true;
		}
	}else if(type == 'checkbox'){
		var chk = false;
		$("input:checkbox[id='"+div+"']").each(function(){ 
			 if(this.checked) { chk = true; }
		});
		if(chk){
			return true;
		}else{
			showErrMsg(div, msg, type);
			return false;
		}
	}else if(type == 'radio'){
		if($('#'+div).is(':checked')){
			return true;
		}else{
			this.showErrMsg(div, msg, type);
			return false;
		}
	}else {
		
		if(this.getVal(div) == '' || this.getVal(div) == this.getAttrVal(div,'data-name') ){
			this.showErrMsg(div, msg, type);
			return false;		
		}else{
			return true;
		}
	}
}
}