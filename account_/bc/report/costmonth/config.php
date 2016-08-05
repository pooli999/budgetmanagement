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
	case "costmonth":
			//$startupPage = "startup";
			$actionPage = "costmonth_action";
			$mainPage = "costmonth_main";
			$addPage = "costmonth_add";
			$confirmPage = "costmonth_confirm";
			$viewPage = "costmonth_view";
			$ListEdit = "costmonth_list_edit";
			$ListView = "costmonth_list_project";
			$AddCostInternal = "costmonth_cost_add_internal";
			$AddCostInternalMonth = "costmonth_cost_add_internal_month";
			$AddCostExternal = "costmonth_cost_add_external";
			$AddCostExternalMonth = "costmonth_cost_add_external_month";
			$MenuName = getMenuItem(lurl::dotPage($mainPage))->MenuName;
			$RowPerPage = 15;
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

$GLOBALS["editPage"] = $editPage;
$GLOBALS["versionPage"] = $versionPage;
$GLOBALS["imgWidth"] = $imgWidth;
$GLOBALS["imgHeight"] = $imgHeight;
$GLOBALS["mainPage"] = $mainPage;
$GLOBALS["ListEdit"] = $ListEdit;
$GLOBALS["ListView"] = $ListView;
$GLOBALS["AddCostInternal"] = $AddCostInternal;
$GLOBALS["AddCostInternalMonth"] = $AddCostInternalMonth;
$GLOBALS["AddCostExternal"] = $AddCostExternal;
$GLOBALS["AddCostExternalMonth"] = $AddCostExternalMonth;
////

?>