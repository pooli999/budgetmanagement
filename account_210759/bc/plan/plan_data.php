<?php
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
			$datas = $get->getDetail($_GET["id"]);
			foreach( $datas as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}

	break;
	
	case $KeyPage."_view":

		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetail($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;
	
	case $KeyPage."_sort":
		$data = $get->getOrderList();
		//ltxt::print_r($data);
	break;
	
	case $KeyPage."_print":
		$list = array();
		$get->getDataList($list);
		
	break;
	
	case $KeyPage."_excel":
		$list = array();
		$get->getDataList($list);
		
	break;
	
	
}
?>