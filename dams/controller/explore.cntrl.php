<?php
$action = cms::sanitizeVariable( $_GET['action'] );
$action = ($action==''?'view':$action);
$type = cms::sanitizeVariable( $_GET['type'] );
$char = cms::sanitizeVariable( $_GET['char'] );
if( $char == '' ){ $char = 'a';}
$view = 'explore';
$data = array();
switch( $type ){
	case 'label':
		$mLabel=new label();
		$params = array(
					'orderby'=>' ORDER BY label_name ASC',
					'where'=>' AND `status`=1'
					);
		$aLebels = $mLabel->getAllLabels( $params );
		$data['aContent'] = $aLebels;
		$data['type'] = $type;
		$data['sDisplayHead'] = 'Label';
		break;
	
	case 'artist':
		$oArtist=new artist();
		$params = array(
					'orderby'=>' ORDER BY artist_name ASC',
					'where'=>' AND SUBSTR(lower(artist_name),1,1)="'.$char.'"',
					'limit'=>10000
					);
		$aArtists = $oArtist->getAllArtists( $params );
		$data['aContent'] = $aArtists;
		$data['type'] = $type;
		$data['char'] = $char;
		$data['sDisplayHead'] = 'Artist';
		break;
	case 'year':
		$oAlbum=new album();
		$retData = array();
		/*
		$params = array(
					'orderby'=>' ORDER BY title_release_date ASC',
					'where'=>" AND `status`=1 AND (title_release_date!='' AND title_release_date != '0000-00-00 00:00:00' AND title_release_date is not NULL)",
					"limit"=> 80000
					);
		$aAlbums = $oAlbum->getAllAlbums( $params );
		foreach( $aAlbums as $kk=>$val ){
			$title_release_date = substr($val->title_release_date,0,4);
			$title_release_date = (int)$title_release_date;
			if( $title_release_date > 0){
				$$title_release_date++;
			}
			$retData[$title_release_date] = $$title_release_date;
		}
		*/
		
		$disYear = array(
						'1900 - 1909' => " (title_release_date BETWEEN '1900-00-00' AND '1909-12-31') ",
						'1910 - 1919' => " (title_release_date BETWEEN '1910-00-00' AND '1919-12-31') ",
						'1920 - 1929' => " (title_release_date BETWEEN '1920-00-00' AND '1929-12-31') ",
						'1930 - 1939' => " (title_release_date BETWEEN '1930-00-00' AND '1939-12-31') ",
						'1940 - 1949' => " (title_release_date BETWEEN '1940-00-00' AND '1949-12-31') ",
						'1950 - 1954' => " (title_release_date BETWEEN '1950-00-00' AND '1954-12-31') ",
						'1955 - 1959' => " (title_release_date BETWEEN '1955-00-00' AND '1959-12-31') ",
						'1960 - 1964' => " (title_release_date BETWEEN '1960-00-00' AND '1964-12-31') ",
						'1965 - 1969' => " (title_release_date BETWEEN '1965-00-00' AND '1969-12-31') ",
						'1970 - 1974' => " (title_release_date BETWEEN '1970-00-00' AND '1974-12-31') ",
						'1975 - 1979' => " (title_release_date BETWEEN '1975-00-00' AND '1979-12-31') ",
						'1980 - 1984' => " (title_release_date BETWEEN '1980-00-00' AND '1984-12-31') ",
						'1985 - 1989' => " (title_release_date BETWEEN '1985-00-00' AND '1989-12-31') ",
						'1990 - 1994' => " (title_release_date BETWEEN '1990-00-00' AND '1994-12-31') ",
						'1995 - 1999' => " (title_release_date BETWEEN '1995-00-00' AND '1999-12-31') ",
						'2000 - 2004' => " (title_release_date BETWEEN '2000-00-00' AND '2004-12-31') ",
						'2005 - 2009' => " (title_release_date BETWEEN '2005-00-00' AND '2009-12-31') ",
						'2010 - 2014' => " (title_release_date BETWEEN '2010-00-00' AND '2014-12-31') "
						);
		
		foreach( $disYear as $kk=>$vv ){
			$params = array(
							'where'=>' AND '.$vv
						);
			$count = $oAlbum->getTotalCount( $params );
			$retData[$kk] = $count;
		}
		
		$data['aContent'] = $retData;
		$data['type'] = $type;
		$data['sDisplayHead'] = 'Year';
		break;
	case 'genre':
		$oTags=new tags();
		$params = array(
					'orderby'=>' ORDER BY tag_name ASC',
					'where'=>' AND parent_tag_id = 1688 AND `status`=1 ',
					'limit'=>5000
					);
		$aTags = $oTags->getAllTags( $params );
		$data['aContent'] = $aTags;
		$data['type'] = $type;
		$data['sDisplayHead'] = 'Genre';
		break;
}


/* render view */
$oCms->view( $view, $data );