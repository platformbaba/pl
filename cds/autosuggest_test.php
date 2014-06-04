<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Saregama CDS test solr page</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
<style>
.red{
	 color: #FF0000;
}
.ui-autocomplete-loading {
background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat;
}
#audio { width: 25em; }
</style>

<script type="text/javascript">

SAREGAMA_OFFSET = 1390390195;
var app_id = "SaReGaMa";

function _encrypt(app_id,time){
	time =time - SAREGAMA_OFFSET;
	var lsbs = '';
	for(var i=0;i<=4;i++)
		lsbs+=(((time & (1<<i)) >0 ) ? '1':'0');
	var s = parseInt(lsbs, 2 );
	var start = s%22;
	var bit=new Array(start+5,start+6,start+7,start+8);
	for(var i =0 ;i<bit.length;i++){
		time = time ^ (1<<bit[i]);
	}
	var etime = SGUtils.b64encode(time+'');
	var n =app_id.length;
	var l = app_id.substring(0,n/2); 
	var r = app_id.substring(n/2);
	var iauth = SGUtils.reverse(l+etime+r);
	var final_auth= SGUtils.b64encode(iauth);
	if(final_auth.length%6==0)
		final_auth=SGUtils.reverse(final_auth);
	return final_auth; 
}




/// Utility function
var SGUtils = {

		// private property
		_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

		// public method for encoding
		b64encode : function (input) {
		    var output = "";
		    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		    var i = 0;

		    input = SGUtils._utf8_encode(input);

		    while (i < input.length) {

		        chr1 = input.charCodeAt(i++);
		        chr2 = input.charCodeAt(i++);
		        chr3 = input.charCodeAt(i++);

		        enc1 = chr1 >> 2;
		        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
		        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
		        enc4 = chr3 & 63;

		        if (isNaN(chr2)) {
		            enc3 = enc4 = 64;
		        } else if (isNaN(chr3)) {
		            enc4 = 64;
		        }

		        output = output +
		        this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
		        this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

		    }

		    return output;
		},

		// private method for UTF-8 encoding
		_utf8_encode : function (string) {
		    string = string.replace(/\r\n/g,"\n");
		    var utftext = "";

		    for (var n = 0; n < string.length; n++) {

		        var c = string.charCodeAt(n);

		        if (c < 128) {
		            utftext += String.fromCharCode(c);
		        }
		        else if((c > 127) && (c < 2048)) {
		            utftext += String.fromCharCode((c >> 6) | 192);
		            utftext += String.fromCharCode((c & 63) | 128);
		        }
		        else {
		            utftext += String.fromCharCode((c >> 12) | 224);
		            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
		            utftext += String.fromCharCode((c & 63) | 128);
		        }

		    }

		    return utftext;
		},
		reverse :function (s){
		    return s.split("").reverse().join("");
		},
}

</script>
<script>

String.prototype.replaceAll = function (replaceThis, withThis) {
	   var re = new RegExp(replaceThis,"g"); 
	   return this.replace(re, withThis);
	};
Array.prototype.highlight = function(val){
	val = val.toLowerCase(); 
	vala = val.split(" ");
	for(var i =0; i<this.length ; i++){
		for(var j=0 ; j<val.length ; j++){
			if(vala[j]==this[i].toLowerCase()){
				val = val.replaceAll(vala[j],"<span class='red'>"+vala[j]+"</span>");
			}
		}
	}
	return val;
}

Array.prototype.tostring = function(){
	
	var str = '';
	for(var i =0; i<this.length ; i++){
		str=str+" , "+this[i];
	}
	return str;
}
$(function() {

$( "#audio" ).autocomplete({
		source: function( request, response ) {
		$.ajax({
		url: "/cds/audio?action=search&actiontype=autosuggest",
		data: {
		query: request.term,
		auth:encodeURIComponent(_encrypt(app_id,Math.floor((new Date().getTime()-new Date().getTimezoneOffset()*60)/1000)))
		},
		success: function( data ) {
			try{
				data = jQuery.parseJSON(data);
			}catch(e){
				
			}
			response( $.map( data.response.docs, function( item ) {
			return {
					label: item.name,
					value: item.name
					}
				}));
			}
		});
	},
minLength: 2,
open: function() {
	$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
},
close: function() {
	$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
}
});

$( "#album" ).autocomplete({
	source: function( request, response ) {
	$.ajax({
	url: "/cds/album?action=search&actiontype=autosuggest",
	data: {
	query: request.term,
	auth:encodeURIComponent(_encrypt(app_id,Math.floor((new Date().getTime()-new Date().getTimezoneOffset()*60)/1000)))
	},
	success: function( data ) {
		try{
			data = jQuery.parseJSON(data);
		}catch(e){
			
		}
		response( $.map( data.response.docs, function( item ) {
		return {
				label: item.name,
				value: item.name
				}
			}));
		}
	});
},
minLength: 2,
open: function() {
$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
},
close: function() {
$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
}
});



$( "#artist" ).autocomplete({
	source: function( request, response ) {
	$.ajax({
	url: "/cds/artist?action=search&actiontype=autosuggest",
	data: {
	query: request.term,
	auth:encodeURIComponent(_encrypt("SaReGaMa",Math.floor((new Date().getTime()-new Date().getTimezoneOffset()*60)/1000)))
	},
	success: function( data ) {
		try{
			data = jQuery.parseJSON(data);
		}catch(e){
			
		}
		response( $.map( data.response.docs, function( item ) {
		return {
				label: item.name,
				value: item.name
				}
			}));
		}
	});
},
minLength: 2,
open: function() {
$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
},
close: function() {
$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
}
});

});
</script>
<script>
$(document).ready(function(){

	$('#baudio').click(function (){
		var val = $.trim($('#audio').val());
		if(val!=''){
			var app_id = "SaReGaMa";// app_id provided to you
			var d = new Date();// make sure the system is in sync with UTC time else get time from time servers
			var time = Math.ceil((d.getTime()-d.getTimezoneOffset()*60)/1000);
			var auth = encodeURIComponent(_encrypt(app_id,time));
			$.post( "/cds/audio?action=search&limit=49&query="+val+"&auth="+auth, function( data ) {
				try{
					data = jQuery.parseJSON(data);
				}catch(e){
					
				}
				if(data.response.numFound>0)
					displayAudio(data.response.docs,val);		
				else{
					$('#display').html("No Results Found");
				}					
			});
		}
	});
	
	$('#balbum').click(function (){
		var val = $('#album').val();
		if(val!=''){
			var app_id = "SaReGaMa";// app_id provided to you
			var d = new Date();// make sure the system is in sync with UTC time else get time from time servers
			var time = Math.floor((d.getTime()-d.getTimezoneOffset()*60)/1000);
			var auth = encodeURIComponent(_encrypt(app_id,time));
			$.post( "/cds/album?action=search&limit=49&query="+val+"&auth="+auth, function( data ) {
				try{
					data = jQuery.parseJSON(data);
				}catch(e){
					
				}
				if(data.response.numFound>0)
					displayAlbum(data.response.docs,val);	
				else{
					$('#display').html("No Results Found");
				}						
			});
		}
	});
	
	$('#bartist').click(function (){
		var val = $('#artist').val();
		if(val!=''){
			var app_id = "SaReGaMa";// app_id provided to you
			var d = new Date();// make sure the system is in sync with UTC time else get time from time servers
			var time = Math.floor((d.getTime()-d.getTimezoneOffset()*60)/1000);
			var auth = encodeURIComponent(_encrypt(app_id,time));
			$.post( "/cds/artist?action=search&limit=49&query="+val+"&auth="+auth, function( data ) {
				try{
					data = jQuery.parseJSON(data);
				}catch(e){
					
				}
				if(data.response.numFound>0){
					displayArtist(data.response.docs,val);	
				}else{
					$('#display').html("No Results Found");
				}					
			});
		}
	});

	function displayAudio(data,val){
		
		var tokens = val.split(" ");
		var html = "<table border=1> <th> Song Name</th> <th> Song Artists</th> <th> Song Albums</th>";
		for(var i =0 ; i<data.length;i++){
			html=html+"<tr>";
			html = html+ '<td>' +tokens.highlight(data[i].name) +'</td>';
			if(data[i].artists)
				html = html+ '<td>' +tokens.highlight(data[i].artists.tostring()) +'</td>';
			else
				html = html+ '<td>&nbsp</td>';
			if(data[i].albums)
				html = html+ '<td>' +tokens.highlight(data[i].albums.tostring()) +'</td>';
			else
				html = html+ '<td>&nbsp</td>';
			html=html+"</tr>";
		}
		html=html+"</table>";
		$('#display').html(html);

	}

	function displayAlbum(data,val){
		
		var tokens = val.split(" ");
		var html = "<table border=1> <th> Album Name</th> <th> Album Artists</th>";
		for(var i =0 ; i<data.length;i++){
			html=html+"<tr>";
			html = html+ '<td>' +tokens.highlight(data[i].name) +'</td>';
			if(data[i].artists)
				html = html+ '<td>' +tokens.highlight(data[i].artists.tostring()) +'</td>';
			else
				html = html+ '<td>&nbsp</td>';
			html=html+"</tr>";
		}
		html=html+"</table>";
		$('#display').html(html);

	}

	function displayArtist(data,val){
		
		var tokens = val.split(" ");
		var html = "<table border=1> <th> Artist Name</th> ";
		for(var i =0 ; i<data.length;i++){
			html=html+"<tr>";
			html = html+ '<td>' +tokens.highlight(data[i].name) +'</td>';
			html=html+"</tr>";
		}
		html=html+"</table>";
		$('#display').html(html);

	}
});




</script>



</script>
</head>
<body>
<div class="ui-widget">
	Auto Suggest for Audio
<input id="audio">
<button id='baudio'>Submit</button>
</div>

<div class="ui-widget">
	Auto Suggest for Album
<input id="album">
<button id='balbum'>Submit</button>
</div>

<div class="ui-widget">
	Auto Suggest for Artist
<input id="artist">
<button id='bartist'>Submit</button>
</div>
<br><br><br><br><br>
<div id=display>
	
</div>


</body>
</html>