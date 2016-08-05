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
		case "saveperson":
			$tsk->RedirectPage($listPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->SavePerson();
		break;		
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;
		case 'pitemlist':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getPlanItemList($BgtYear);
			exit;
		break;	
		case 'orglist':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getOrgShortNameList($BgtYear);
			exit;
		break;				
		case 'projectlist':
		 	$PItemCode = ltxt::getVar( 'PItemCode','post' );
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
			$tsk->getProjectList($BgtYear,$PItemCode,$OrganizeCode,'OldPrjId',0);						
			exit;
		break;	

		case 'getoldcode':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$PItemCode = ltxt::getVar( 'PItemCode','post' );
			$PrjCode = ltxt::getVar( 'PrjCode','post' );
			$data =  $tsk->getMapCode($BgtYear,$PItemCode,$PrjCode);		
			//ltxt::print_r($datarefer);
			if($data ){
				foreach( $data  as $k=>$v){ ${$k} = $v;}	
				//echo $Detail.'---'.$Location.'---'.$StartDate.'---'.$EndDate.'---'.$AmountPerson.'---'.$BgtYear.'---'.$OrganizeCode.'---'.$PItemCode.'---'.$PrjId.'---'.$PrjActCode.'---'.$SourceType.'---'.$SourceExId;
				echo $PrjCode;
			
			}
			exit;
		break;	
		
		case 'mainplanlist':
		 	$PLongCode = ltxt::getVar( 'PLongCode','post' );
			$tsk->getMainPlanList($PLongCode);						
			exit;
		break;		
		
		case 'mainprojectlist':
		 	$LPlanCode = ltxt::getVar( 'LPlanCode','post' );
			$tsk->getMainProjectList($LPlanCode);						
			exit;
		break;			

		case "savemass":
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->SaveMass();
		break;


/*		
		case "saveorder":
			$tsk->RedirectPage($sortPage);
			$tsk->SaveOrder();
		break;
				
		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;*/
		
	}

exit;

}
?>
