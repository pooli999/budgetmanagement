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
		
		case 'getplanlist':
			$tsk->getPlanItemList();						
			exit;
		break;	
		
		case 'getprjlist':
			$tsk->getProjectList();						
			exit;
		break;	
		
		case 'getprjindlist':
			$tsk->getIndPrjList();						
			exit;
		break;	
		
	}

exit;

}
?>
