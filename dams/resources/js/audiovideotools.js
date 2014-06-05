/**********************************/
/*This js for audio/video tools	*/
/********************************/
	
	function insertAfter(newElement,targetElement) {
		var parent = targetElement.parentNode;
		if(parent.lastchild == targetElement) {
			parent.appendChild(newElement);
		} else {
			parent.insertBefore(newElement, targetElement.nextSibling);
		}
	}

	function changeDispTime(secs){
		secs = parseInt(secs);
		var mins = parseInt(secs / 60) ;
		var secs = parseInt(secs % 60) ;
		return  mins +" : "+ secs ;
	}
	
	
	function getCheckedRadio(radio_group) {
	
	 for (var i = 0; i < radio_group.length; i++) {
			var button = radio_group[i];
			if (button.checked) {
				return button.value;
			}
		}
		return undefined;
	}
	
	
	function audioVideoEditor(ele){
		
		var vidEle  = document.getElementById(ele);
		var videoSrc ;
		var videoWidth ;
		var videoHeight ; 
		var showFrom = true;
		var showTo = true;
		var loadVideoBeforeEditing = true;
		var autoPlayVideo = false ;
		var allowPlaySelection = true;
		var allowLoopSelection = true;
		
		this.setVideoSrc = function(src){
			videoSrc = src;
		}
		
		this.getVideoSrc = function(src){
			return videoSrc;
		}
		
		
		this.getVideoWidth = function(width){
			return videoWidth ;
		}
		
		this.setVideoWidth = function(width){
			videoWidth = width;
		}
		
		this.edit = function(){
			if(autoPlayVideo){
				vidEle.setAttribute("autoplay" , true);
			}
			if(loadVideoBeforeEditing){
				vidEle.setAttribute("preload" , "auto");
			}
			
			var div = document.createElement("div");
			div.id ="tt";
			
			div.innerHTML = '<div id="msg"> </div><table border="0"> '
			+ '<tr> ' 
			+ '<td>Edit from time<input type="radio" name="rtime" value="from"/> </td>' 
			+ '<td>Edit to time<input type="radio" name="rtime" value="to"/></td>' 
			+ '<td>Clear<input id="cls" type="radio" name="rtime" value="cls" checked/> </td>' 
			+ '</tr>' 
			+ '<tr>' 
			+ '<td><input class="inoutTextPlay"  id="fromTime" name="fromTime" type="text"  onchange="changeDispTime(this,dfromTime);" value=0 /> <input class="inoutTextPlay" id="dfromTime" type="text" value=0 /></td>' 
			+ '<td><input class="inoutTextPlay"  id="toTime" name="toTime" type="text" onchange="changeDispTime(this,dtoTime);" value=0 /> <input class="inoutTextPlay" id="dtoTime" type="text" value=0 /> </td>' 
			+ '<td><input class="btnPlMedium" id="playSel" type="button" value="Play Selection"/><input type="checkbox" id="loop">loop</input></td>' 
			+ '</tr>' 
			+ '<table>' ;
	
			insertAfter(div,vidEle);
			var timeIntervel = setInterval(timeChecker,100);
			var playButton = document.getElementById("playSel");
			playButton.addEventListener("click",playButtonControls);
		}
		
		
/*********************************************/
/*Geting Start/End Time Here*/
/*********************************************/
		this.getFromTime = function(){
		
			return document.getElementById("fromTime").value;
		}
		
		
		
		this.getToTime = function(){
		
			return document.getElementById("toTime").value;
		}
/*********************************************/
/*END*/
/*********************************************/
		
		var playingSelectionFlag = false;
		
		var timeChecker = function(){
			
			if(!playingSelectionFlag){
				var checkedValue = getCheckedRadio(document.getElementsByName("rtime"));
				
				var textBox = null;
				var dtextBox = null ; 
				if(checkedValue == "to"){
					textBox = document.getElementById("toTime");
					dtextBox = document.getElementById("dtoTime");
				}else if(checkedValue == "from"){
					textBox = document.getElementById("fromTime");
					dtextBox = document.getElementById("dfromTime");
				}else{
					return ;
				}
				textBox.value = vidEle.currentTime ; 
				dtextBox.value = changeDispTime(vidEle.currentTime);
			}else{
				// playing selection
				var _tt = document.getElementById("toTime").value;
				if (vidEle.currentTime >= _tt) {
					vidEle.pause();
					var loop = document.getElementById("loop").checked ;
					if(loop){
						vidEle.currentTime = document.getElementById("fromTime").value;
						vidEle.play();
					}else{
						playingSelectionFlag = false;
						document.getElementById("playSel").value="Play Selection";
					}
				}else{
					vidEle.play();
				}
			}
		}
		
		
		
		var playButtonControls = function(e){
				// toggle button
				
				document.getElementById("cls").checked = true;
				vidEle.pause();
				var _ct = parseFloat(document.getElementById("fromTime").value);
				var _tt = parseFloat(document.getElementById("toTime").value);
				if(_ct < _tt ){
					
					document.getElementById("msg").innerHTML = "";
					if(this.value == "Play Selection" ){
						
						vidEle.currentTime = _ct ;
						playingSelectionFlag = true ;
						this.value = "Stop" ; 
					}else{
						playingSelectionFlag = false;
						this.value = "Play Selection";
					}
				}else{
					playingSelectionFlag = false;
					document.getElementById("msg").innerHTML = " From time should be lesser than to time";
				}
		}
	
	}
	