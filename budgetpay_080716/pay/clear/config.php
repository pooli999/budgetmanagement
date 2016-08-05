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
	case "clear":
			$PathUpload = VSROOT.'upload/advances/';
			$startupPage = "startup";
			$actionPage = "clear_action";
			$mainPage = "clear_main";
			$listPage = "clear_list";
			$addPage = "clear_add";
			$confirmPage = "clear_confirm";
			$viewPage = "clear_view";
			$borrowPage = "clear_borrow";
			$confirmBorrowPage = "clear_confirmborrow";		
			$clearPage = "clear_clear";
			$confirmClearPage = "clear_confirmclear";									
			$MenuName = getMenuItem(lurl::dotPage($listPage))->MenuName;
			$RowPerPage = 20;
			$imgWidth = '100';
			$imgHeight = '120'; 
			$usedImage = false;			
			
			$cancelPage = "clear_cancel";
			$cancelconfirmPage = "clear_cancelconfirm";		
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
$GLOBALS["borrowPage"] = $borrowPage;
$GLOBALS["confirmBorrowPage"] = $confirmBorrowPage;
$GLOBALS["RowPerPage"] = $RowPerPage;
$GLOBALS["MaxUploadSize"] = $MaxUploadSize;
$GLOBALS["imgWidth"] = $imgWidth;
$GLOBALS["imgHeight"] = $imgHeight;
$GLOBALS["clearPage"] = $clearPage;
$GLOBALS["confirmClearPage"] = $confirmClearPage;

$GLOBALS["cancelPage"] = $cancelPage;
$GLOBALS["cancelconfirmPage"] = $cancelconfirmPage;

////

?>