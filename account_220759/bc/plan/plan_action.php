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
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->Save();
		break;
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;		
/*		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;*/
		
		case "saveorder":
			$tsk->RedirectPage($listPage);
			$tsk->SaveOrder();
		break;
		
		case "saveproject":
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->SaveProject();
		break;
		
		case "saveind":
			$tsk->SaveInd();
		break;
		
		case "saveindyear":
			$tsk->SaveIndYear();
		break;
		
		case 'getindname':
			$tsk->getIndName();						
			exit;
		break;		
				
	}

exit;

}
?>
