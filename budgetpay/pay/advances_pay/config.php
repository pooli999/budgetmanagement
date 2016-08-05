<?php
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/finance/style_finance.css'
));

$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];
//$noImage = '../../images/noimage.png';


switch($KeyPage)
{
	case "apay":
			$PathUpload = VSROOT.'upload/apay/';
			$startupPage = "startup";
			$actionPage = "apay_action";
			$mainPage = "apay_main";
			$listPage = "apay_list";
			$addPage = "apay_add";
			$confirmPage = "apay_confirm";
			$viewPage = "apay_view";
			$MenuName = getMenuItem(lurl::dotPage($listPage))->MenuName;
			$RowPerPage = 20;
			$imgWidth = '100';
			$imgHeight = '120'; 
			$usedImage = false;					
			
			$appPage = "apay_approve";
			$appconfirmPage = "apay_appconfirm";
			
			$cancelPage = "apay_cancel";
			$cancelconfirmPage = "apay_cancelconfirm";
	break;
	
	
}

// Not Remove //
$GLOBALS["PathUpload"] = $PathUpload;
$GLOBALS["startupPage"] = $startupPage;
$GLOBALS["actionPage"] = $actionPage;
$GLOBALS["listPage"] = $listPage;
$GLOBALS["addPage"] = $addPage;
$GLOBALS["confirmPage"] = $confirmPage;
$GLOBALS["viewPage"] = $viewPage;
$GLOBALS["RowPerPage"] = $RowPerPage;
$GLOBALS["MaxUploadSize"] = $MaxUploadSize;
$GLOBALS["imgWidth"] = $imgWidth;
$GLOBALS["imgHeight"] = $imgHeight;

$GLOBALS["appPage"] = $appPage;
$GLOBALS["appconfirmPage"] = $appconfirmPage;

$GLOBALS["cancelPage"] = $cancelPage;
$GLOBALS["cancelconfirmPage"] = $cancelconfirmPage;
////

?>