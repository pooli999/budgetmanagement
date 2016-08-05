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
			$tsk->setUploadPath($PathUpload);
			$tsk->Save();
		break;
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;		
		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;
	
		case 'projectlist':
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
		 	$PItemCode = ltxt::getVar( 'PItemCode','post' );
			echo $tsk->getProjectList($BgtYear,$OrganizeCode,$PItemCode);
			exit;
		break;			
		
		case 'projectlistto':
			$BgtYearTo = ltxt::getVar( 'BgtYearTo','post' );
			$OrganizeCodeTo = ltxt::getVar( 'OrganizeCodeTo','post' );
		 	$PItemCodeTo = ltxt::getVar( 'PItemCodeTo','post' );
			echo $tsk->getProjectList($BgtYearTo,$OrganizeCodeTo,$PItemCodeTo,0,'PrjIdTo','onchange="loadActTo(this.value)" style="width:80%"');
			exit;
		break;					
		
		case 'actlist':		
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
			$PrjId = ltxt::getVar( 'PrjId','post' );
			echo $tsk->getActList($BgtYear,$OrganizeCode,$PrjId);
			exit;
		break;		
	
		case 'actlistto':		
			$BgtYearTo = ltxt::getVar( 'BgtYearTo','post' );
			$OrganizeCodeTo = ltxt::getVar( 'OrganizeCodeTo','post' );
			$PrjIdTo = ltxt::getVar( 'PrjIdTo','post' );
			echo $tsk->getActList($BgtYearTo,$OrganizeCodeTo,$PrjIdTo,0,'PrjActCodeTo','onchange="loadbgactto(this.value)" style="width:80%"');
			exit;
		break;	
					
/*		case 'personallist':
			$OrgApprove = ltxt::getVar( 'OrgApprove','post' );
			echo $tsk->getPersonalList($OrgApprove);
			exit;
		break;	*/
		
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

		case 'bgprjto':
			$OrganizeCodeTo = ltxt::getVar( 'OrganizeCodeTo','post' );
			$PrjIdTo = ltxt::getVar( 'PrjIdTo','post' );
		 	$PItemCodeTo = ltxt::getVar( 'PItemCodeTo','post' );
			echo $tsk->getBGPrjTo($OrganizeCodeTo, $PrjIdTo, $PItemCodeTo);
			exit;
		break;	

		case 'bgactto':
			$OrganizeCodeTo = ltxt::getVar( 'OrganizeCodeTo','post' );
			$PrjIdTo = ltxt::getVar( 'PrjIdTo','post' );
		 	$PItemCodeTo = ltxt::getVar( 'PItemCodeTo','post' );
			$PrjActCodeTo = ltxt::getVar( 'PrjActCodeTo','post' );
			echo $tsk->getBGActTo($OrganizeCodeTo, $PrjIdTo, $PItemCodeTo,$PrjActCodeTo);
			exit;
		break;	

		case 'orglist':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getOrgShortNameList($BgtYear);			
			exit;
		break;
		
		case 'orglistto':
		 	$BgtYearTo = ltxt::getVar( 'BgtYearTo','post' );
			echo $tsk->getOrgShortNameListTo($BgtYearTo,0,'OrganizeCodeTo','onchange="loadOrgTo(this.value)"  style="width:80%" ');
			exit;
		break;	
						
		case 'pitemlist':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getPlanItemList($BgtYear,9);
			exit;
		break;	
		
		case 'pitemlistto':
		 	$BgtYearTo = ltxt::getVar( 'BgtYearTo','post' );
			echo $tsk->getPlanItemList($BgtYearTo,9,0,'PItemCodeTo','onchange="loadPrjTo(this.value)" style="width:80%"');
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

		case "cancel":
			$tsk->RedirectPage($listPage);
			$tsk->Cancel();
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

	}

exit;

}
?>
