<?php
#############################################
# 	****Help Document Start Here.****		#
#############################################


/**********************************************
	1: All Autosuggest Array.
**********************************************/

$allAutosuggest_arr = array(
				"query"=>array("mandatory"=>1,"helptext"=>"query to be autosuggested"),
				"n"=>array("mandatory"=>0,"default"=>10,"helptext"=>"no of results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"filter"=>array("mandatory"=>0,"default"=>"All types","helptext"=>"filter to be applied type=0 - audio, type=1 - album , type=2 - artist, type=3 - video" ,"acceptedValues"=>array("type:0","type:1","type:2","type:3")),
				"sortField"=>array("mandatory"=>0,"default"=>"solr relevance","helptext"=>"field to be sorted on "),
				"sortOrder"=>array("mandatory"=>0,"default"=>"desc","helptext"=>"order of sort"),
				"exampleReq"=>"/autosuggest?query=Salman&action=search&n=10&o=10&filter=type:1&type:2",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"acceptedValues"=>array("json","xml","csv")),
				"response"=>array("responce"=>'{"status":1,"data":"{"responseHeader":{"status":0,"QTime":10},"response":{"numFound":21560,"start":0,"docs":[{"q":"Salman Saeed","id":"18399-ART","type":1},{"q":"Salman Khan","id":"7019-ART","type":1}]}}n","error_msg":""}')
);

/**********************************************
	2: Search Audio Array.
**********************************************/

$searchAudio_arr = array(
				"query"=>array("mandatory"=>1,"helptext"=>"query to be searched for song"),
				"n"=>array("mandatory"=>0,"default"=>10,"helptext"=>"no of results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"filter"=>array("mandatory"=>0,"default"=>"All Audio(songs)","helptext"=>"filter to be applied for language,artist,release date,label",
				"acceptedValues"=>array("language:hindi","artist:lata","releasedate:20131001","label:saregama")),
				"sortField"=>array("mandatory"=>0,"default"=>"solr relevance","helptext"=>"field to be sorted on "),
				"sortOrder"=>array("mandatory"=>0,"default"=>"desc","helptext"=>"order of sort"),
				"exampleReq URL"=>"/audio?query=dil&action=search&n=10&o=10&filter=language:hindi&artist:lata+mangeshkar",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"acceptedValues"=>array("json","xml","csv")),
				"response"=>array("responce"=>'data will come here.')
);
/**********************************************
	3: Search Album Array.
**********************************************/
$searchAlbum_arr = array(
				"query"=>array("mandatory"=>1,"helptext"=>"query to be searched for album"),
				"n"=>array("mandatory"=>0,"default"=>10,"helptext"=>"no of results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"filter"=>array("mandatory"=>0,"default"=>"All Albums","helptext"=>"filter to be applied for language,artist,release date,label,broadcast year,grade,show name,album type",
				"acceptedValues"=>array("language:hindi","artist:lata","releasedate:20131001","label:saregama")),
				"sortField"=>array("mandatory"=>0,"default"=>"solr relevance","helptext"=>"field to be sorted on "),
				"sortOrder"=>array("mandatory"=>0,"default"=>"desc","helptext"=>"order of sort"),
				"exampleReq URL"=>"/album?query=dil&action=search&n=10&o=10&filter=language:hindi&artist:lata+mangeshkar",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"acceptedValues"=>array("json","xml","csv")),
				"response"=>array("responce"=>'data will come here.')
);

/**********************************************
	4: Search Artist Array.
**********************************************/

$searchArtist_arr = array(
				"query"=>array("mandatory"=>1,"helptext"=>"query to be searched for artist"),
				"n"=>array("mandatory"=>0,"default"=>10,"helptext"=>"no of results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"filter"=>array("mandatory"=>0,"default"=>"All Artists","helptext"=>"filter to be applied for role,artist name,artist dob,artist gender,artist dod",
				"acceptedValues"=>array("language:hindi","artist_name:lata")),
				"sortField"=>array("mandatory"=>0,"default"=>"solr relevance","helptext"=>"field to be sorted on "),
				"sortOrder"=>array("mandatory"=>0,"default"=>"desc","helptext"=>"order of sort"),
				"exampleReq URL"=>"/artist?query=aamir+khan&action=search&n=10&o=10&filter=language:hindi&artist_role:starcast",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"acceptedValues"=>array("json","xml","csv")),
				"response"=>array("responce"=>'data will come here.')
);
/**********************************************
	5: Search Video Array.
**********************************************/

$searchVideo_arr = array(
				"query"=>array("mandatory"=>1,"helptext"=>"query to be searched for video"),
				"n"=>array("mandatory"=>0,"default"=>10,"helptext"=>"no of results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"filter"=>array("mandatory"=>0,"default"=>"All videos","helptext"=>"filter to be applied for role,video name,language,release date, video duration",
				"acceptedValues"=>array("language:hindi","video_duration:60","release_date:20131011")),
				"sortField"=>array("mandatory"=>0,"default"=>"solr relevance","helptext"=>"field to be sorted on "),
				"sortOrder"=>array("mandatory"=>0,"default"=>"desc","helptext"=>"order of sort"),
				"exampleReq URL"=>"/video?query=aamir+khan+birthday&action=search&n=10&o=10&filter=language:hindi&video_duration:30",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"acceptedValues"=>array("json","xml","csv")),
				"response"=>array("responce"=>'data will come here.')
);
####################################################################

/**********************************************
	1: Search Audio Array From DATABASE.
**********************************************/

$getAudio_arr = array(
				"id"=>array("mandatory"=>1,"helptext"=>"ID to be fetched audio details."),
				"n"=>array("mandatory"=>0,"default"=>1,"helptext"=>"one results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"includes"=>array("albumname","songname","language","label","tempo"),
				"exampleReq URL"=>"/audio?id=1&action=get&n=1&o=0",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"response"=>array("responce"=>'data will come here.'))
					
);

/**********************************************
	2: Search Album Array From DATABASE.
**********************************************/

$getAlbum_arr = array(
				"id"=>array("mandatory"=>1,"helptext"=>"ID to be fetched album details."),
				"n"=>array("mandatory"=>0,"default"=>1,"helptext"=>"one results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"includes"=>array("albumname","songnamelist","language","label","release date"),
				"exampleReq URL"=>"/album?id=1&action=get&n=1&o=0",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"response"=>array("responce"=>'data will come here.'))
					
);

/**********************************************
	3: Search Artist Array From DATABASE.
**********************************************/

$getArtist_arr = array(
				"id"=>array("mandatory"=>1,"helptext"=>"ID to be fetched artist details."),
				"n"=>array("mandatory"=>0,"default"=>1,"helptext"=>"one results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"includes"=>array("artistname","role","artist dob","artist dod"),
				"exampleReq URL"=>"/artist?id=1&action=get&n=1&o=0",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"response"=>array("responce"=>'data will come here.'))
					
);

/**********************************************
	3: Search Video Array From DATABASE.
**********************************************/

$getVideo_arr = array(
				"id"=>array("mandatory"=>1,"helptext"=>"ID to be fetched video details."),
				"n"=>array("mandatory"=>0,"default"=>1,"helptext"=>"one results"),
				"o"=>array("mandatory"=>0,"default"=>0,"helptext"=>"skip intitial results / offset"),
				"includes"=>array("videoname","language","label","release date"),
				"exampleReq URL"=>"/video?id=1&action=get&n=1&o=0",
				"format"=>array("mandatory"=>0,"default"=>"json","helptext"=>"outputformat",
				"response"=>array("responce"=>'data will come here.'))
					
);


$resp_search = array(
		"autosuggest"=>$allAutosuggest_arr,
		"Audio"=>$searchAudio_arr,
		"Album"=>$searchAlbum_arr,
		"Artist"=>$searchArtist_arr,
		"Video"=>$searchVideo_arr
	
		);

$resp_get = array(
		"Audio"=>$getAudio_arr,
		"Album"=>$getAlbum_arr,
		"Artist"=>$getArtist_arr,
		"Video"=>$getVideo_arr
		);


echo json_encode($resp_search);
echo "<br><br>";
echo "----------------------------------";
echo "<br><br>";
echo json_encode($resp_get);







?>