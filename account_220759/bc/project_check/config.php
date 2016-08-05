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
	case "project":
			//$startupPage = "startup";
			$actionPage = "project_action";
			$mainPage = "project_main";
			$addPage = "project_add";
			$confirmPage = "project_confirm";
			$viewPage = "project_view";
			$ListEdit = "project_list_edit";
			$ListView = "project_list_project";
			$AddCostInternal = "project_cost_add_internal";
			$AddCostInternalMonth = "project_cost_add_internal_month";
			$AddCostExternal = "project_cost_add_external";
			$AddCostExternalMonth = "project_cost_add_external_month";
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