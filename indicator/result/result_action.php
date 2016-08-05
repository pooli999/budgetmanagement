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
/*		case "changestatus":
			$tsk->RedirectPage($listPage);
			$tsk->changeStatus();
		break;*/
		
		case "save":
			$tsk->RedirectPage($mainPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->Save();
		break;
		
		case "saveprj":
			$tsk->SavePrj();
		break;
					
		case "delete":
			$tsk->RedirectPage($viewactPage);
			$tsk->Delete();
		break;	
		
		case "getincdetail":
			$tsk->getIncDetail();
			exit;
		break;		
		
		case "saveprojectindmonth":
			$tsk->SaveProjectIndMonth();
		break;
		
		case "saveindmonth":
			//$tsk->RedirectPage($listPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->SaveIndMonth();
		break;
		
		/*
		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;*/
		
	}

exit;

}
?>
