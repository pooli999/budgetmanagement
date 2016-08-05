<?php
include("config.php");
include("function.php");

if($action = ltxt::getVar( 'action','req' )) {

	$tsk = new sFunction();
	switch( strtolower($action) ) {
		
		case "check":
			$tsk->Check();
		break;	
		case "approve":
			$tsk->Approve();
		break;	
		
			
	}

exit;

}
?>
