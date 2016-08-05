<?php
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

$noImage = '../../images/noimage.png';

switch($KeyPage)
{

	default :
			$PathUpload = VSROOT.'upload/';
			$startupPage = "startup";
			$actionPage = "action";
			$listPage = "list";
			$addPage = "add";
			$confirmPage = "confirm";
			$viewPage = "view";
			$MenuName = getMenuItem(lurl::dotPage($listPage))->MenuName;
			$imgWidth = '120';
			$imgHeight = '80';
	break ;
	
}

// Not Remove //
$GLOBALS["PathUpload"] = $PathUpload;
$GLOBALS["startupPage"] = $startupPage;
$GLOBALS["actionPage"] = $actionPage;
$GLOBALS["listPage"] = $listPage;
$GLOBALS["addPage"] = $addPage;
$GLOBALS["confirmPage"] = $confirmPage;
$GLOBALS["viewPage"] = $viewPage;
$GLOBALS["LogModule"] = $MenuName;
////
$GLOBALS["personalYear"] = $personalYear;
?>