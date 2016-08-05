<?php
include("config.php");
$get = new sHelper();
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];

switch( strtolower($modData) ) {
	
	case $KeyPage."_print_general":
	case $KeyPage."_print_generalcost":
	case $KeyPage."_word_general":

		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailGeneral('tblintra_eform_formal_general','DocId',$_GET["id"]);
			//ltxt::print_r($detail);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
	break;	
	
	case $KeyPage."_print_generalpay":
	case $KeyPage."_word_generalpay":
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailGeneral('tblintra_eform_formal_general_pay','GerPayId',$_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
	break;	
	
	case $KeyPage."_print_os":
	case $KeyPage."_word_os":
	
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailOs($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;		
	
	case $KeyPage."_print_mou":
	case $KeyPage."_word_mou":
	
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailMou($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;		
	
	
	case $KeyPage."_print_mat2":
	case $KeyPage."_print_mat3":
	case $KeyPage."_word_mat2":
	case $KeyPage."_word_mat3":
	
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailMat($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;
	
	case $KeyPage."_print_matpay":
	case $KeyPage."_word_matpay":
	
		if( ltxt::getVar( 'id', 'get' ) ){
			$detailpay = $get->getDetailMatPay($_GET["id"]);
			foreach( $detailpay as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;			
			
	case $KeyPage."_print_urgent":
	case $KeyPage."_word_urgent":
	case $KeyPage."_print_mat1":
	case $KeyPage."_word_mat1":
	
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailUrgent($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;			

	case $KeyPage."_print_transfer":
	case $KeyPage."_word_transfer":
	
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailTransfer($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;		

	case $KeyPage."_print_advances1":
	case $KeyPage."_word_advances1":
	case $KeyPage."_print_advances2":
	case $KeyPage."_word_advances2":	
/*	case $KeyPage."_print_contract":
	case $KeyPage."_print_advancesclear":
	case $KeyPage."_print_advancesclear":
	case $KeyPage."_word_clear":*/

		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetail($_GET["id"]);
			//ltxt::print_r($detail);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;	
	
	case $KeyPage."_print_advancesclear":

		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailGeneral('tblintra_eform_advance_clear','ClearId',$_GET["id"]);
			//ltxt::print_r($detail);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;		
	
	case $KeyPage."_print_advancespay":

		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailGeneral('tblintra_eform_advance_pay','PayId',$_GET["id"]);
			//ltxt::print_r($detail);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;		
	
	case $KeyPage."_print_training":
	case $KeyPage."_word_training":
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailTraining($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;	
	
	case $KeyPage."_print_pay":
	case $KeyPage."_word_pay":
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailPay($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;	
	
	case $KeyPage."_print_meeting1":
	case $KeyPage."_word_meeting1":
	case $KeyPage."_print_meeting2":
	case $KeyPage."_word_meeting2":
	
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailMeeting($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
		
	break;
		
	case $KeyPage."_print_meeting3":
	case $KeyPage."_word_meeting3":
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailMeetingPay($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}		
	break;
	
	case $KeyPage."_print_ot":
	case $KeyPage."_word_ot":
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailOt($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
	break;		
	
	case $KeyPage."_print_otpay":
	case $KeyPage."_word_otpay":
		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = $get->getDetailOtPay($_GET["id"]);
			foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
	break;		
	

}//end 
?>