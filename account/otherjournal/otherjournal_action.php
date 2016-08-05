<?php
include("config.php");
include($KeyPage."_function.php");

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
		case "savenew":
		//	$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->Savenew();
		break;
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;
		case "saveorder":
			$tsk->RedirectPage($listPage);
			$tsk->SaveOrder();
		break;
		case "findeaccount":
			$tsk->RedirectPage($listPage);
			$tsk->getaccount();
		break;
		case "findeaccountadd":
			$tsk->RedirectPage($listPage);
			$tsk->getaccountadd();
		break;
		case "createautocom":
			$tsk->RedirectPage($listPage);
			$tsk->getautocomp();
		break;
		case "checkaccount":
			$tsk->RedirectPage($listPage);
			$tsk->getcheckaccount();
		break;
		case "findeaccountbank":
			$tsk->RedirectPage($listPage);
			$tsk->getaccountbank();
		break;
		case 'loadpn':
		 	//$LPlanCode = ltxt::getVar( 'bankid','post' )
			$tsk->getPersonalCode("PersonalCode",$tag_attribs,$PersonalCode,"เลือก");
			exit;
		break;
		case 'chkpv':
			$PV = ltxt::getVar( 'PV','post' );
			$opv = ltxt::getVar( 'opv','post' );
			$tsk->getchkpv($PV,$opv);
			exit;
		break;
		case 'loadpv':
			$journalId = ltxt::getVar( 'journalId','get' );
			$mm = ltxt::getVar( 'mm','get' );
			$yy = ltxt::getVar( 'yy','get' );
			$datatypes = "json";
			$tsk->findpvcode($yy,$mm,$journalId,$datatypes);
			exit;
		break;
		case 'loadbbnumber':
		 	//$LPlanCode = ltxt::getVar( 'bankid','post' );
			$tsk->getBookbankNumber("BookbankId",$tag_attribs,$BookbankId,"เลือก","");
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
