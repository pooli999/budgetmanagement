<?php
include("config.php");
$get = new sHelper();
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];

switch( strtolower($modData) ) {
		
	case $KeyPage."_list":
		$list = array();
		$get->getDataList($list);
		
	break;
	case $KeyPage."_add":

		if( ltxt::getVar( 'id', 'get' ) ){
			$datas = array();
			$get->getDetail( $datas );
			foreach( $datas[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}

	break;
	case $KeyPage."_view":

		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = array();
			$get->getDetail( $detail );
			foreach( $detail[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;

}
?>