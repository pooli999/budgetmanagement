<?php
include("config.php");
include($KeyPage."_function.php");
if($action = ltxt::getVar( 'action','req' )) {

	$tsk = new sFunction();
	switch( strtolower($action) ) {
		case "reloadpage":
			if($_REQUEST["redirect_page"] != '') $rpage = $_REQUEST["redirect_page"];
			else $rpage = lurl::dotPage($listPage);
			$tsk->Reload($rpage);
		break;
		
		case "changestatus":
			$tsk->RedirectPage($listPage);
			$tsk->changeStatus();
		break;
		
		case "save":
			$tsk->RedirectPage	($ListEditPage);
			$tsk->Save();
		break;
		
		case "sent":
			$tsk->RedirectPage	($ListEditPage);
			$tsk->Sent();
		break;
		
		case "delete":
			$tsk->RedirectPage	($ListEditPage);
			$tsk->Delete();
		break;
		
		case "cancel":
			$tsk->RedirectPage	($ListEditPage);
			$tsk->Cancel();
		break;

		case "savecostin":
			$tsk->RedirectPage($addPage);
			$tsk->saveCostInternal();
		break;

		case "savecostex":
			$tsk->RedirectPage($addPage);
			$tsk->saveCostExternal();
		break;

		case "savecostmonth":
			$tsk->RedirectPage($addPage);
			$tsk->saveCostMonth();
		break;

		case "savecostmonthex":
			$tsk->RedirectPage($addPage);
			$tsk->saveCostMonthEx();
		break;

		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;		
		
		case 'getImport' :
			$Import = ltxt::getVar($Import);
			include_once $Import.'.php' ;
			exit ;
		break ;
			
			default :
				echo 'NO OPERATION TRIGERED';
			break ;

		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;
		
		case "getOrganizeCode":
			$tsk->getOrganizeCode();
		break;		
/****************************************************************************************/		
		case "saveapprove":
			$tsk->RedirectPage	($ListEdit);
			$tsk->saveApprove();
		break;

	
/****************************************************************************************/	
	}
exit;

}
?>
