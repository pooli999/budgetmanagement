<?php

$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

switch($KeyPage)
{
	case "year":
			$startupPage = "startup";			
			$actionPage = "year_action";
			$mainPage = "year_main";
			$addPage = "year_add";
			$closePage = "year_close";
			$viewPage = "year_view";
		
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
$GLOBALS["closePage"] = $closePage;
$GLOBALS["viewPage"] = $viewPage;

$GLOBALS["RowPerPage"] = $RowPerPage;
$GLOBALS["MaxUploadSize"] = $MaxUploadSize;
$GLOBALS["versionPage"] = $versionPage;
$GLOBALS["imgWidth"] = $imgWidth;
$GLOBALS["imgHeight"] = $imgHeight;
////

?>