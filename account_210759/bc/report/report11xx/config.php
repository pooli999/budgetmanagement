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
	case "report11":
			//$startupPage = "startup";
			$actionPage = "report11_action";
			$MenuName = getMenuItem(lurl::dotPage($mainPage))->MenuName;
			$RowPerPage = 15;
	break;

}

// Not Remove //
$GLOBALS["PathUpload"] = $PathUpload;
$GLOBALS["startupPage"] = $startupPage;
$GLOBALS["actionPage"] = $actionPage;
$GLOBALS["RowPerPage"] = $RowPerPage;
$GLOBALS["MaxUploadSize"] = $MaxUploadSize;

////

?>