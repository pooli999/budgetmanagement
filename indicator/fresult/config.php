<?php

$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

switch($KeyPage)
{
	case "fresult":
			$startupPage = "startup";			
			$actionPage = "fresult_action";
			$mainPage = "fresult_main";
			$addPage = "fresult_add";
			$addMonthPage = "fresult_addmonth";
			$viewactPage = "fresult_viewact";
			$viewMonthActPage = "fresult_viewmonthact";
			$viewPage = "fresult_view";
			$resultPage = "fresult_project";
			$resultMonthPage = "fresult_projectmonth";
		
			$MenuName = getMenuItem(lurl::dotPage($mainPage))->MenuName;
			$RowPerPage = 15;
	break;
	
	
}

// Not Remove //
$GLOBALS["PathUpload"] = $PathUpload;
$GLOBALS["startupPage"] = $startupPage;
$GLOBALS["actionPage"] = $actionPage;
$GLOBALS["mainPage"] = $mainPage;
$GLOBALS["addPage"] = $addPage;
$GLOBALS["addMonthPage"] = $addMonthPage;
$GLOBALS["viewactPage"] = $viewactPage;
$GLOBALS["viewMonthActPage"] = $viewMonthActPage;
$GLOBALS["viewPage"] = $viewPage;
$GLOBALS["resultPage"] = $resultPage;
$GLOBALS["resultMonthPage"] = $resultMonthPage;

$GLOBALS["RowPerPage"] = $RowPerPage;
$GLOBALS["MaxUploadSize"] = $MaxUploadSize;
$GLOBALS["versionPage"] = $versionPage;
$GLOBALS["imgWidth"] = $imgWidth;
$GLOBALS["imgHeight"] = $imgHeight;
////

?>