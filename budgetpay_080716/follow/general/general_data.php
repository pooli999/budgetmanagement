<?php
include("config.php");
$get = new sHelper();
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];

switch( strtolower($modData) ) {

	case $KeyPage."_list":
		$list = array();
		$get->getDataList($list,$RowPerPage);
		
	break;
	
}
?>