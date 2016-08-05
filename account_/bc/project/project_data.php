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
*/	

	case $KeyPage."_add_edit":
		if( ltxt::getVar( 'PrjDetailId', 'get' ) ){
			$dataPrj = $get->getProjectDetail($_GET["BgtYear"],$_GET["OrganizeCode"],$_GET["SCTypeId"],$_GET["ScreenLevel"],$_GET["PrjId"],$_GET["PrjDetailId"]);
			//ltxt::print_r($dataPrj);
			foreach( $dataPrj[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
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