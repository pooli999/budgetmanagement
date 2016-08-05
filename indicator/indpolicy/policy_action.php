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
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->Save();
		break;
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;
		case "saveind":
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->SaveInd();
		break;
		case "saveindmonth":
			//$tsk->RedirectPage($listPage);
			//$tsk->setUploadPath($PathUpload);
			$tsk->SaveIndMonth();
		break;
		case "deleteind":
			$tsk->RedirectPage($indicatorListPage);
			$tsk->DeleteInd();
		break;		
	
		case "saveorder":
			$tsk->RedirectPage($indicatorListPage);
			$tsk->SaveOrder();
		break;
				
		/*	case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;*/
		
		case 'getoldcode':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$PItemCode = ltxt::getVar( 'PItemCode','post' );
			$data =  $tsk->getMapPItemCode($BgtYear,$PItemCode);		
			//ltxt::print_r($datarefer);
			if($data ){
				foreach( $data  as $k=>$v){ ${$k} = $v;}	
				//echo $Detail.'---'.$Location.'---'.$StartDate.'---'.$EndDate.'---'.$AmountPerson.'---'.$BgtYear.'---'.$OrganizeCode.'---'.$PItemId.'---'.$PrjId.'---'.$PrjActCode.'---'.$SourceType.'---'.$SourceExId;
				echo $PItemCode;
			
			}
			exit;
		break;	
				
		case 'mainplanlist':
		 	$PLongCode = ltxt::getVar( 'PLongCode','post' );
			$tsk->getMainPlanList($PLongCode);						
			exit;
		break;	
		
	}

exit;

}
?>
