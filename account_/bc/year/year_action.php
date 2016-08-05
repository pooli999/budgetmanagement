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
					
		case "delete":
			$tsk->RedirectPage($mainPage);
			$tsk->Delete();
		break;		
		
		case "closeyear":
			$tsk->RedirectPage($mainPage);
			$tsk->CloseYear();
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
