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
			$addPage = "project_add_edit";
			$confirmPage = "project_confirm";
			$viewPage = "project_view";
			$ListEditPage = "project_list_edit";
			$ViewCost = "project_view_cost";
			$ListView = "project_list_view";
			$ListCost= "project_list_cost";
			$ListViewCost = "project_list_view_cost";
			$ListViewCostMonth = "project_list_view_cost_month";	
			$ListViewCostEx = "project_list_view_cost_ex";	
			$ListViewCostMonthEx = "project_list_view_cost_month_ex";		
			$AddCostInternal = "project_cost_add_internal";
			$AddCostInternalMonth = "project_cost_add_internal_month";
			$AddCostExternal = "project_cost_add_external";
			$AddCostExternalMonth = "project_cost_add_external_month";
			$ImportPrj = "project_import";
			$FormPrj = "project_import_form";
			$PopupCost = "project_popup_cost";
			$PopupCostEx = "project_popup_cost_ex";
			$PopupMonth = "project_popup_month";
			$PopupMonthEx = "project_popup_month_ex";
			$ViewAdjust = "project_viewadjust";
			$ViewAllot = "project_viewallot";
			$ViewScreen = "project_viewscreen";
			$ViewInd = "project_view_ind";
			$EditInd = "project_edit_ind";
			$partyListPage = "project_party_list";
			$partyAddPage = "project_party_add";
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
$GLOBALS["ListEditPage"] = $ListEditPage;
$GLOBALS["ViewCost"] = $ViewCost;
$GLOBALS["ListViewCost"] = $ListViewCost;
$GLOBALS["AddCostInternal"] = $AddCostInternal;
$GLOBALS["AddCostInternalMonth"] = $AddCostInternalMonth;
$GLOBALS["ListViewCostMonth"] = $ListViewCostMonth;
$GLOBALS["ListViewCostEx"] = $ListViewCostEx;
$GLOBALS["AddCostExternal"] = $AddCostExternal;
$GLOBALS["ListViewCostMonthEx"] = $ListViewCostMonthEx;
$GLOBALS["AddCostExternalMonth"] = $AddCostExternalMonth;
$GLOBALS["ImportPrj"] = $ImportPrj;
$GLOBALS["FormPrj"] = $FormPrj;
$GLOBALS["ListView"] = $ListView;
$GLOBALS["ListCost"] = $ListCost;
$GLOBALS["PopupCost"] = $PopupCost;
$GLOBALS["PopupCostEx"] = $PopupCostEx;
$GLOBALS["PopupMonth"] = $PopupMonth;
$GLOBALS["PopupMonthEx"] = $PopupMonthEx;
$GLOBALS["ViewAdjust"] = $ViewAdjust;
$GLOBALS["ViewAllot"] = $ViewAllot;
$GLOBALS["ViewScreen"] = $ViewScreen;
$GLOBALS["ViewInd"] = $ViewInd;
$GLOBALS["EditInd"] = $EditInd;

$GLOBALS["partyListPage"] = $partyListPage;
$GLOBALS["partyAddPage"] = $partyAddPage;
////

?>