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
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;	
		case "cancel":
			$tsk->RedirectPage($listPage);
			$tsk->Cancel();
		break;				
		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;
		case 'projectlist':
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
		 	$PItemCode = ltxt::getVar( 'PItemCode','post' );
			$PrjId = ltxt::getVar( 'PrjId','post' );
			echo $tsk->getProjectList($BgtYear,$OrganizeCode,$PItemCode,$PrjId);
			exit;
		break;				
		case 'actlist':		
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
			$PrjId = ltxt::getVar( 'PrjId','post' );
			$PrjActCode = ltxt::getVar( 'PrjActCode','post' );
			echo $tsk->getActList($BgtYear,$OrganizeCode,$PrjId,$PrjActCode);
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
		case 'countdate':
		 	//$start = Date2DB(ltxt::getVar( 'start','post' ));
			$start = ltxt::getVar( 'start','post' );
			$end = ltxt::getVar( 'end','post' );
			echo $tsk->getdays($start,$end);
			exit;
		break;	
		case 'doclist':
		 	$DocumentId = ltxt::getVar( 'DocumentId','post' );
			echo $tsk->getEFormCode($DocumentId);			
			exit;
		break;			
		case 'detailcoderefer':
		 	$DocCodeRefer = ltxt::getVar( 'DocCodeRefer','post' );
			$datarefer =  $tsk->getDetailCodeRefer($DocCodeRefer);		
			//ltxt::print_r($datarefer);
			if($datarefer){
				foreach( $datarefer as $k=>$v){ ${$k} = $v;}	
				echo $Detail.'---'.$Location.'---'.$StartDate.'---'.$EndDate.'---'.$AmountPerson.'---'.$BgtYear.'---'.$OrganizeCode.'---'.$PItemCode.'---'.$PrjId.'---'.$PrjActCode.'---'.$SourceType.'---'.$SourceExId;
			}
			exit;
		break;	
		case 'orglistapprove':
		 	$BgtYearApprove = ltxt::getVar( 'BgtYearApprove','post' );
			$OrgApprove = ltxt::getVar( 'OrgApprove','post' );
			echo $tsk->getOrgShortNameListApprove($BgtYearApprove,$OrgApprove);			
			exit;
		break;	
		case 'personallist':
			$BgtYearApprove = ltxt::getVar( 'BgtYearApprove','post' );
			$OrgApprove = ltxt::getVar( 'OrgApprove','post' );
			echo $tsk->getPersonalList($BgtYearApprove,$OrgApprove);
			exit;
		break;	
		case 'yearapprove':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getYear(($BgtYear)?$BgtYear:(date("Y")+543),'BgtYearApprove','onchange="loadSCTApprove(this.value)"');			
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


	}

exit;

}
?>
