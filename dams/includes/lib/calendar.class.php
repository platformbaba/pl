<?php
/***************************************
* PHP Calendar Script
* Date: 05-10-2012
* Amit Kumar
***************************************/
class calendar{
	
	/*
	Will returns calendar
	@param : mm_yyyy - month_year
			 events - array			
	*/
	public static function showCalendar( array $a = array() ){
		$calendarHtml = '';
		
		if(isset($a['mm_yyyy']) && $a['mm_yyyy']!= ''){
			$mm_yyyy = $a['mm_yyyy']; // Actual Date should be in mm_yyyy format
		}else{
			$mm_yyyy = date("m_Y"); // Actual Date should be in mm_yyyy format
			//$mm_yyyy = '11_2013';
		}
		
		$mm_yyyyArr = explode("_",$mm_yyyy);
		$mm = (int)$mm_yyyyArr[0];
		$yyyy = (int)$mm_yyyyArr[1];
		
		$oEvent = new event();
		$aEventsCalender = 	$oEvent->getEventByCalender( $yyyy, $mm );
		//echo "<pre/>";
		//print_r( $aEventsCalender );		
		
		#### Config Variable Donot Change
		$aMonths			= array(1=>"january",2=>"february",3=>"march",4=>"april",5=>"may",6=>"june",7=>"july",8=>"august",9=>"september",10=>"october",11=>"november",12=>"december");
		$aDays				= array("monday"=>1,"tuesday"=>2,"wednesday"=>3,"thursday"=>4,"friday"=>5,"saturday"=>6,"sunday"=>7);
		$aDaysinmonth		= array(1=>31,2=>28,3=>31,4=>30,5=>31,6=>30,7=>31,8=>31,9=>30,10=>31,11=>30,12=>31);
		$isLeapYear			= date("L", mktime(0, 0, 0, $mm  , 1, $yyyy));
		$firstDayOfMonth 	= strtolower(date("l", mktime(0, 0, 0, $mm  , 1, $yyyy)));
		$nextMonth 			= strtolower(date("m_Y", mktime(0, 0, 0, $mm+1  , 1, $yyyy)));
		$preMonth			= strtolower(date("m_Y", mktime(0, 0, 0, $mm-1  , 1, $yyyy)));
		
		$nextMonthDis 		= trim(date("F Y", mktime(0, 0, 0, $mm+1  , 1, $yyyy)));
		$preMonthDis		= trim(date("F Y", mktime(0, 0, 0, $mm-1  , 1, $yyyy)));

		if($isLeapYear){
			##### For Leap Year
			$aDaysinmonth[2]=29;
		}
		$firstDayOfMonthId = $aDays[$firstDayOfMonth];
		$totalDaysInMonth = $aDaysinmonth[$mm];
		$totalLoopCount = ($totalDaysInMonth+$firstDayOfMonthId);
		
		$calendarHtml .= '<div class="bloc calendar">
								<div class="title">
									<a href="javascript:void(0);" onclick="cms.showPhpCal(\''.$preMonth.'\')"; class="prev" title="'.$preMonthDis.'"></a>
									'.ucfirst($aMonths[$mm]).' '.$yyyy.'
									<a href="javascript:void(0);" onclick="cms.showPhpCal(\''.$nextMonth.'\')"; class="next" title="'.$nextMonthDis.'"></a>
								</div>';
		
		$calendarHtml .= '<div class="content">
							<table>
								<thead> 
									<tr>';
										foreach($aDays as $day=>$val){ 
											$calendarHtml .= '<th>'.$day.'</th>';
										}
		$calendarHtml .= '</tr></thead><tbody>'; 
				
		$todayDate =1;
		for($i=1;$i<$totalLoopCount;$i++){
			if(($i-1)%7==0){
				$calendarHtml .= '<tr>';
				$counter = 0;
			}

			$disDate = "";
			if($i>=$firstDayOfMonthId){
				$disDate = $todayDate;
				$todayDate++;
			}
			$counter++;
						
			$todayClass = '';
						
			$todayFullDate = $yyyy."-".$mm."-".$disDate;
			$eventStr = '';
			$eventStrTmp = '';
			//echo " >>> ".$todayFullDate;
			if( !empty($aEventsCalender) && array_key_exists($todayFullDate, $aEventsCalender) ){
				$ccc = 0;
				$eventStr .= '<ul class="events" >'; 
					
					
					$eventStrTmp = '<div id="lclick_'.$disDate.'" style="border: 1px solid black; padding: 5px; width: 282px; max-height: 300px; overflow:auto; background-color: white; position: absolute; z-index: 998; display: none; margin-top: -128px; margin-left: -145px;text-align:left;"><img src="'.IMGPATH.'icon_close.png" alt="Close" onclick="jQuery(\'#lclick_'.$disDate.'\').hide();" style="float:right;cursor:pointer"/>
					<p>'.date("F j, Y,", strtotime($todayFullDate)).'</p>';
					
					foreach( $aEventsCalender[$todayFullDate] as $kkk => $vvv ){
						$eventStrTmp .= '<p><a href="'.$vvv['view_url'].'" class="fancybox fancybox.iframe"><span style="font-weight:bold;" >'.$vvv['event_name'].',</span></a> <a href="'.$vvv['view_url'].'" class="fancybox fancybox.iframe" title="View Events Details">'.$vvv['dis_type'].'</a>, '.$vvv['language'].'</p>';
						
						$ccc++; 
						if( $ccc < 3 ){ 
							$eventStr .= '<li><a href="'.$vvv['view_url'].'" class="fancybox fancybox.iframe"><span>'.$vvv['event_name'].'</span></a><a href="'.$vvv['view_url'].'" class="fancybox fancybox.iframe" title="View Events Details">'.$vvv['dis_type'].' </a></li>'; 
						}
					}
					$eventStrTmp .= '</div>';
					
					//$eventStr .= $eventStrTmp;
				$eventStr .= '</ul>'; 
				$todayClass = ' class="event" ';
			}
			if(date("Y-n-j") == $yyyy."-".$mm."-".$disDate){
				$todayClass = ' class="today" ';
			}
			
			$viewAllStr = '';
			if( $eventStrTmp != '' ){ $viewAllStr = 'onMouseOver="jQuery(\'#lclick_'.$disDate.'\').show();" onMouseOut="jQuery(\'#lclick_'.$disDate.'\').hide();"'; }
			
			$calendarHtml .= '<td style="height:100px;" '.$todayClass.' '.$viewAllStr.'><div class="day">'.$disDate.'</div>'. $eventStrTmp.'</td>';
			
			
			if(($i)%7==0 || $i==($totalLoopCount-1)){
				if($counter < 7){
					for($k=$counter; $k<7; $k++){
						$calendarHtml .= "<td></td>";
					}
				}
				$calendarHtml .= "</tr>";
			}

		} // for
		$calendarHtml .= '</tbody></table></div></div>';		
		
		$returnHTML = $calendarHtml;
		
		if( !$a['ajax'] ){
			$returnHTML = '<h1><img src="'.IMGPATH.'icons/calendar.png" alt="" />Calendar</h1>
							<div id="showCalender">'.$calendarHtml.'</div>';
		}
		
		return $returnHTML;
	} /* showCalendar */

} /* calendar */