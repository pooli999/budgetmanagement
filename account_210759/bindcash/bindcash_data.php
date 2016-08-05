<?php
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
		
	case $KeyPage."_list":
		$list = array();
		$get->getDataList($list,$RowPerPage);
		
	break;
	
	case $KeyPage."_add":

		if( ltxt::getVar( 'id', 'get' ) ){
			$datas = $get->getDetail($_GET["id"],$_GET["IncomeTypeAcId"]);
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
	break;
		
}
?>