<?php

$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

switch($KeyPage)
{
	case "report3":
			$startupPage = "startup";			
			$actionPage = "report3_action";
			$mainPage = "report3_main";
			$addPage = "report3_add";
			$addMonthPage = "report3_addmonth";
			$viewactPage = "report3_viewact";
			$viewMonthActPage = "report3_viewmonthact";
			$viewPage = "report3_view";
			$resultPage = "report3_project";
			$resultMonthPage = "report3_projectmonth";
		
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