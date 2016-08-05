<?php
include("config.php");
include($KeyPage."_function.php");

if($action = ltxt::getVar( 'action','req' )) {

	$tsk = new sFunction();
	switch( strtolower($action) ) {
		
		case "reloadpage":
			if($_REQUEST["redirect_page"] != '') $rpage = $_REQUEST["redirect_page"];
			else $rpage = lurl::dotPage($ownerPage);
			$tsk->Reload($rpage);
		break;
		case "changestatus":
			$tsk->RedirectPage($listPage);
			$tsk->changeStatus();
		break;
		case "save":
			$tsk->RedirectPage($listPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->Save();
		break;
		case "savepay":
			$tsk->RedirectPage($viewPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->SavePay();
		break;		
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;		
		case "cancel":
			$tsk->RedirectPage($listPage);
			$tsk->Cancel();
		break;		
		case "deletepay":
			$tsk->RedirectPage($viewPage);
			$tsk->DeletePay();
		break;			
		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;
		case 'confirmpay':
			include $confirmpayPage.'.php';
			exit;
		break;	
		case 'projectlist':
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
		 	$PItemCode = ltxt::getVar( 'PItemCode','post' );
			echo $tsk->getProjectList($BgtYear,$OrganizeCode,$PItemCode);
			exit;
		break;				
		
		case 'actlist':		
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
			$PrjId = ltxt::getVar( 'PrjId','post' );
			echo $tsk->getActList($BgtYear,$OrganizeCode,$PrjId);
			exit;
		break;		
			
		case 'personallist':
			$BgtYearApprove = ltxt::getVar( 'BgtYearApprove','post' );
			$OrgApprove = ltxt::getVar( 'OrgApprove','post' );
			echo $tsk->getPersonalList($BgtYearApprove,$OrgApprove);
			exit;
		break;	

		case 'bgprj':
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
			$PrjId = ltxt::getVar( 'PrjId','post' );
		 	$PItemCode = ltxt::getVar( 'PItemCode','post' );
			echo $tsk->getBGPrj($OrganizeCode, $PrjId, $PItemCode);
			exit;
		break;	

		case 'bgact':
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
			$PrjId = ltxt::getVar( 'PrjId','post' );
		 	$PItemCode = ltxt::getVar( 'PItemCode','post' );
			$PrjActCode = ltxt::getVar( 'PrjActCode','post' );
			echo $tsk->getBGAct($OrganizeCode, $PrjId, $PItemCode,$PrjActCode);
			exit;
		break;	

		case 'pitemlist':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getPlanItemList($BgtYear,9);
			exit;
		break;	

		case 'orglist':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getOrgShortNameList($BgtYear);			
			exit;
		break;	

		case 'orglistapprove':
		 	$BgtYearApprove = ltxt::getVar( 'BgtYearApprove','post' );
			$OrgApprove = ltxt::getVar( 'OrgApprove','post' );
			echo $tsk->getOrgShortNameListApprove($BgtYearApprove,$OrgApprove);			
			exit;
		break;	

		case 'yearapprove':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getYear(($BgtYear)?$BgtYear:(date("Y")+543),'BgtYearApprove','onchange="loadSCTApprove(this.value)"');			
			exit;
		break;	

		case 'pitemlistsearch':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getPlanItemListSearch($BgtYear,9);
			exit;
		break;	

		case 'projectlistsearch':
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
		 	$PItemCode = ltxt::getVar( 'PItemCode','post' );
			echo $tsk->getProjectListSearch($BgtYear,$PItemCode);
			exit;
		break;				
		
		case 'actlistsearch':		
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$PrjId = ltxt::getVar( 'PrjId','post' );
			echo $tsk->getActListSearch($BgtYear,$PrjId);
			exit;
		break;		
		
		case "approve":
			$tsk->RedirectPage($listPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->Approve();
		break;
		case 'appconfirm':
			include $appconfirmPage.'.php';
			exit;
		break;
		
		case 'cancelconfirm':
			include $cancelconfirmPage.'.php';
			exit;
		break;
			

	}

exit;

}
?>
