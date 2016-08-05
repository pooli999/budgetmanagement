<?php

$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

switch($KeyPage)
{
	case "allot":
			$startupPage = "startup";			
			$actionPage = "allot_action";
			$mainPage = "allot_main";
			$listRequestPage = "allot_listrequest";
			$nextRequestPage = "allot_nextrequest";
			$editScreenPage = "allot_editscreen";
			$closescreenPage = "allot_closescreen";
			$editAllotPage = "allot_editallot";
			$editAdjustPage = "allot_editadjust";
			$viewProjectPage = "allot_viewproject";
			$viewProjectScreenPage = "allot_viewscreen";
			$viewProjectAllotPage = "allot_viewallot";
			$viewProjectAdjustPage = "allot_viewadjust";
			$listProjectPage = "allot_listproject";
			$listProjectViewPage = "allot_listprojectview";

			$MenuName = getMenuItem(lurl::dotPage($mainPage))->MenuName;
			$RowPerPage = 15;
	break;
	
	
}

// Not Remove //
$GLOBALS["PathUpload"] = $PathUpload;
$GLOBALS["startupPage"] = $startupPage;
$GLOBALS["actionPage"] = $actionPage;
$GLOBALS["mainPage"] = $mainPage;
$GLOBALS["listRequestPage"] = $listRequestPage;
$GLOBALS["nextRequestPage"] = $nextRequestPage;
$GLOBALS["editScreenPage"] = $editScreenPage;
$GLOBALS["closescreenPage"] = $closescreenPage;
$GLOBALS["editAllotPage"] = $editAllotPage;
$GLOBALS["editAdjustPage"] = $editAdjustPage;
$GLOBALS["viewProjectPage"] = $viewProjectPage;
$GLOBALS["viewProjectScreenPage"] = $viewProjectScreenPage;
$GLOBALS["viewProjectAllotPage"] = $viewProjectAllotPage;
$GLOBALS["viewProjectAdjustPage"] = $viewProjectAdjustPage;
$GLOBALS["listProjectPage"] = $listProjectPage;
$GLOBALS["listProjectViewPage"] = $listProjectViewPage;

$GLOBALS["RowPerPage"] = $RowPerPage;
$GLOBALS["MaxUploadSize"] = $MaxUploadSize;
$GLOBALS["versionPage"] = $versionPage;
$GLOBALS["imgWidth"] = $imgWidth;
$GLOBALS["imgHeight"] = $imgHeight;
////

?>