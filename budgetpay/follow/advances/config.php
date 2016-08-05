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
	case "advances":
			$PathUpload = VSROOT.'upload/advances/';
			$startupPage = "startup";
			$actionPage = "advances_action";
			$mainPage = "advances_main";
			$listPage = "advances_list";
			$addPage = "advances_add";
			$confirmPage = "advances_confirm";
			$viewPage = "advances_view";
			$borrowPage = "advances_borrow";
			$confirmBorrowPage = "advances_confirmborrow";		
			$clearPage = "advances_clear";
			$confirmClearPage = "advances_confirmclear";									
			$MenuName = getMenuItem(lurl::dotPage($listPage))->MenuName;
			$RowPerPage = 20;
			$imgWidth = '100';
			$imgHeight = '120'; 
			$usedImage = false;					
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

////

?>