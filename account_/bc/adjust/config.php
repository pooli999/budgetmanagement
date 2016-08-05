<?php
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/finance/style_finance.css'
));

$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

switch($KeyPage)
{
	case "adjust":
			$startupPage = "startup";			
			$actionPage = "adjust_action";
			$mainPage = "adjust_main";
			$listRequestPage = "adjust_listrequest";
			$nextRequestPage = "adjust_nextrequest";
			$editScreenPage = "adjust_editscreen";
			$closescreenPage = "adjust_closescreen";
			$editAllotPage = "adjust_editallot";
			$editAdjustPage = "adjust_editadjust";
			$viewProjectPage = "adjust_viewproject";
			$viewProjectScreenPage = "adjust_viewscreen";
			$viewProjectAllotPage = "adjust_viewallot";
			$viewProjectAdjustPage = "adjust_viewadjust";
			$viewPage = "adjust_view";
			
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
$GLOBALS["viewPage"] = $viewPage;

$GLOBALS["RowPerPage"] = $RowPerPage;
$GLOBALS["MaxUploadSize"] = $MaxUploadSize;
$GLOBALS["versionPage"] = $versionPage;
$GLOBALS["imgWidth"] = $imgWidth;
$GLOBALS["imgHeight"] = $imgHeight;
////

?>