<?php

include("config.php");
	
include("deposit_function.php");
if($action = ltxt::getVar( 'action','req' )) {

	$tsk = new sFunction();
	//echo $listPage;
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
		case "saveorder":
			$tsk->RedirectPage($listPage);
			$tsk->SaveOrder();
		break;	
		case 'loadbbnumber':
		 	//$LPlanCode = ltxt::getVar( 'bankid','post' );
			$tsk->getBookbankNumber("BookbankId",$tag_attribs,$BookbankId,"เลือก");						
			exit;
		break;
		case 'loadincomedetail':
		 	//$LPlanCode = ltxt::getVar( 'bankid','post' );
			$tsk->getIncomeDetail();						
			exit;
		break;		
/*		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;*/
		
	}

exit;

}
?>
