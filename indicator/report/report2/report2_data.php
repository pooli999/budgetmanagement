<?php
include("config.php");
$get = new sHelper();
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
switch( strtolower($modData) ) {
		
/*	case $KeyPage."_list":
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
	case $KeyPage."_viewact":

		if( ltxt::getVar( 'PrjActId', 'get' ) ){
			$detail = array();
			$get->getDetailAct( $detail );
			foreach( $detail[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;
*/
}
?>