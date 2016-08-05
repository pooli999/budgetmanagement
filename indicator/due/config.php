<?php

$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

switch($KeyPage)
{
	case "due":
			$startupPage = "startup";			
			$actionPage = "due_action";
			$listPage = "due_list";
			$addPage = "due_add";
			$closePage = "due_close";
			$viewPage = "due_view";
		
			$MenuName = getMenuItem(lurl::dotPage($listPage))->MenuName;
			$RowPerPage = 15;
	break;
	
	
}

// Not Remove //
$GLOBALS["PathUpload"] = $PathUpload;
$GLOBALS["startupPage"] = $startupPage;
$GLOBALS["actionPage"] = $actionPage;
$GLOBALS["listPage"] = $listPage;
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