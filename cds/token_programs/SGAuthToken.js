<script>

SAREGAMA_OFFSET = 1390390195;
var app_id = "SaReGaMa";";// app_id provided to you
var d = new Date();// make sure the system is in sync with UTC time else get time from time servers
var time = Math.floor((d.getTime()-d.getTimezoneOffset()*60)/1000);
alert(_encrypt(app_id,time));

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