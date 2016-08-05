<?php

$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

switch($KeyPage)
{
	case "report2":
			$startupPage = "startup";			
			$actionPage = "report2_action";
			$mainPage = "report2_main";
			$addPage = "report2_add";
			$addMonthPage = "report2_addmonth";
			$viewactPage = "report2_viewact";
			$viewMonthActPage = "report2_viewmonthact";
			$viewPage = "report2_view";
			$resultPage = "report2_project";
			$resultMonthPage = "report2_projectmonth";
		
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