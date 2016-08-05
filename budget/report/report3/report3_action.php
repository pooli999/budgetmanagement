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
		case 'getsteplist':
		 	//$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$tsk->getStepList();						
			exit;
		break;		
		case 'getplanlist':
		 	//$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$tsk->getPlanItemList();						
			exit;
		break;	
		case 'getorglist':
		 	//$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$tsk->getOrgList();						
			exit;
		break;			
		case 'getsourcelist':
		 	//$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$tsk->getSourceExternal();						
			exit;
		break;		
		case 'getprjlist':
		 	//$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$tsk->getProjectList();						
			exit;
		break;	
		case 'getprjactlist':
		 	//$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$tsk->getProjectActList();						
			exit;
		break;	
				
	}

exit;

}
?>
