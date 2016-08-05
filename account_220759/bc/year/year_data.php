<?php
include("config.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

$get = new sHelper();
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];

switch( strtolower($modData) ) {
	
	case $KeyPage."_add":
		$datas = array();
		//$get->dataSet($datas);	
		$get->dataSet( $datas,0 );		
		
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = array();
			$get->getDetail( $detail );
			foreach( $detail[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;
	
	case $KeyPage."_view":
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = array();
			$get->getDetail( $detail );
			foreach( $detail[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}		
	break;
	
	case $KeyPage."_close":
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = array();
			$get->getDetail( $detail );
			foreach( $detail[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}		
	break;	
/*		
	case $KeyPage."_main":
		//$list = array();
		$get->getYearList($list);
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