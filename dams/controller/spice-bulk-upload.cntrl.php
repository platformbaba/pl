<?php
ob_start(); 
set_time_limit(0);
ini_set('memory_limit','5120M');
#error_reporting(E_ALL);
/* Define base path of application */
define('PATH', $_SERVER['DOCUMENT_ROOT'].'/cms/');
/* Include config file */
require_once(PATH. 'includes/lib/mysqli.class.php');
require_once(PATH. 'includes/lib/encryption.class.php');
require_once(PATH. 'model/privilegeduser.model.php');
require_once(PATH. 'model/role.model.php');
require_once(PATH. 'includes/config/config.php');
include LIBPATH.'PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once(PATH. 'model/deployment.model.php');
$oDeployment=new deployment();
	if(isset($_POST) && !empty($_POST) && $_POST['submitBulk']=="Bulk Upload" && $_FILES['bulkFile']['name']){
		$fileName=date("YmdHis").".xlsx";
		if(move_uploaded_file($_FILES['bulkFile']['tmp_name'],MEDIA_SEVERPATH_DEPLOY."SpiceBulk/".$fileName)){
			echo "done";
		}else{
			echo "error";
		}
		$inputFileName = MEDIA_READ_SEVERPATH_DEPLOY."SpiceBulk/".$fileName;
		//  Read your Excel workbook
		$postData=array(
					'deploymentName'=>$_FILES['bulkFile']['name'],
					'serviceProvider'=>"SPICE",
					);
		$deploymentId = $oDeployment->saveDeployment( $postData );

		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		
		//  Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
		//  Loop through each row of the worksheet in turn
		for ($row = 2; $row <= $highestRow; $row++){ 
			//  Read a row of data into an array
				 $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                                                        NULL,
                                                                                        TRUE,
                                                                                        FALSE);
				//Insert row data array into your database of choice here
				$dYear=substr(PHPExcel_Style_NumberFormat::toFormattedString(trim($rowData[0][11]), "M/D/YYYY"),-4,4);
				$providers_details = NULL;
				$providers_details = array('TerritoryCode'=>'WW','Pline_Text'=>'Saregama' , 'Pline_Year'=>$dYear,'Cline_Text' =>'Saregama','Cline_Year'=>$dYear,'label'=>'Saregama');
				$providers_details_str=json_encode($providers_details);

				$params=NULL;
				$params = array(
										'songTitle' => trim($rowData[0][2]),
										'language' => trim($rowData[0][1]),
										'album' => ucwords(strtolower(trim($rowData[0][4]))),
										'keyArtist' => trim($rowData[0][5]),
										'musicDirector' => trim($rowData[0][7]),
										'searchKey' => "",
										'keyDirector' => trim($rowData[0][10]),
										'keyProducer' => "",
										'releaseYear' => $dYear,
										'albumYear' => $dYear,
										'genre' => "Bollywood",
										'starcast' => trim($rowData[0][9]),
										'lyricist' => trim($rowData[0][8]),
										'singer' => trim($rowData[0][5]),
										'isrc' => trim($rowData[0][0]),
										'deploymentId' => $deploymentId,
										'contentId' => $row,
										'contentType' => '4',
										'ddId' => "",
										'providerDetails' => $providers_details_str,
				);
				if($rowData[0][0]){
					$deployed = $oDeployment->addToDeployment($params);
				}
			}
			TOOLS::log('Song added to Spice Deployment', 'Edit', '24', (int)$oCms->user->user_id, "Deployment Id: ".$deploymentId."" );
			$updateReady=$oDeployment->updateReady(array('deploymentId'=>$deploymentId,'isReady'=>1));
			header('Location: '.SITEPATH.'spice-deployment?action=edit&id='.$deploymentId.'&do=manage');exit;
	}
?>