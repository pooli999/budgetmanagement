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
		
		case "save":
			$tsk->RedirectPage($mainPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->Save();
		break;
		
		case "savescreen":
			$tsk->RedirectPage($listProjectPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->SaveScreen();
		break;
		
		case "saveallot":
			$tsk->RedirectPage($listProjectPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->SaveAllot();
		break;
		
		case "saveadjust":
			$tsk->RedirectPage($listProjectPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->SaveAdjust();
		break;
						
		case "closesreen":
			$tsk->RedirectPage($mainPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->CloseScreen();
		break;
		
		/*	
		case "changestatus":
			$tsk->RedirectPage($listPage);
			$tsk->changeStatus();
		break;
						
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;		
		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;
		*/
	}

exit;

}
?>
