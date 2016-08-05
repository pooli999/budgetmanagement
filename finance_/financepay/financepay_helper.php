<?php

class sHelper
{
	var $db;
	var $debug = 0;
	/*
	START #F1
	Function Name		: sHelper
	Description			:

	*/
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
	}
	/*END*/

	/*
	START #F2
	Function Name	: getDataList
	Description		:

	*/
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="DocStatusId >= 7"; // อนุมัติ
		$ptyep = $_REQUEST["ptyep"];

		if($_REQUEST["PersonalCode"]){
			if ($ptyep == "1"){
				$where[] = "PartnerCode like ('%".$_REQUEST["PersonalCode"]."%')"; // รหัสภาคี
			}else{
				$where[] = "RQPersonalCode like ('%".$_REQUEST["PersonalCode"]."%')"; // รหัสภาคี
			}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

			$fn2 = '(select sum(CastValue) from tblfinance_payment_list_detail where tblfinance_payment_list_detail.DocCode = tblfinance_doccode.DocCode) as sumb';
			$sql="select tblfinance_doccode.* ,$fn2 from tblfinance_doccode ".$where_r."  order by CodeId DESC";
			//echo $sql;
			$this->db->setQuery($sql);
			$this->db->limit = $limit;
			$list = $this->db->loadDataSet();
			return $list;
		}


	}
	/*END*/



	/*
	START #F4
	Function Name: getBookbankNumber สรา้ง combo บัญชีธนาคาร

	*/
	function getBookbankNumber($tag_name,$tag_attribs,$selected,$lebel,$CtrBankId){//$tag_name:ª×èÍ element,$tag_attribs:attrib,$selected:¤èÒ·ÕèµéÍ§¡ÒÃãËéáÊ´§,$lebel: title ¢Í§ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if ($CtrBankId != ""){
			$bankid = $CtrBankId;
		}else{
			$bankid = ltxt::getVar( 'bankid','get' );
		}

		if($bankid){
			$where[] = "BankId=$bankid";
		}
		$selected = ltxt::getVar( 'sel1','get' );

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

		$title[] = clssHTML::makeOption(0,$lebel);
		if($bankid){
			$sql="SELECT BookbankId as value , BookbankNumber as text "
				 ."\n FROM tblbudget_finance_bookbank "
				 ."\n ".$where_r
				 ."\n order by BookbankId ASC " ;

			$this->db->setQuery($sql);
			$datas = $this->db->loadObjectList();
			$datas = array_merge($title,$datas);
		}else{
			$datas = $title;
		}

		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );

	}
	/*END*/

	/*
	START #F5
	Function Name: getOrderList
	Description		:
	*/
	function getOrderList(){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql="select * from tblbudget_finance_bookbank ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}
	/*END*/

	 /* START #F6 */
	/* Function Name: getPlanItemList */
	/* Description: สร้าง combo ะนาคาร */


	function getBankNameSelect($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ª×èÍ element,$tag_attribs:attrib,$selected:¤èÒ·ÕèµéÍ§¡ÒÃãËéáÊ´§,$lebel: title ¢Í§ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

		$sql="SELECT BankId as value , BankName as text "
			 ."\n FROM tblbudget_finance_bank "
			 ."\n ".$where_r
			 ."\n order by BankName ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "

		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );

	}
	/* END */


	 /* START #F6 */
	/* Function Name: getPersonalCode */
	/* Description: à»ç¹¿Ñ§¡ìªÑ¹ÊÓËÃÑº´Ö§ÃÒÂ¡ÒÃ¸¹Ò¤ÒÃ  */


	function getPersonalCode($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ª×èÍ element,$tag_attribs:attrib,$selected:¤èÒ·ÕèµéÍ§¡ÒÃãËéáÊ´§,$lebel: title ¢Í§ element
		$where = array();
		//$where[] = "EnableStatus='Y'";
		$where[] ="DocStatusId >= 7"; // 7 ¤×ÍÍ¹ØÁÑµÔ
		//$where[] ="PaymentStatus = 'N'"; // ÂÑ§äÁè¨èÒÂà§Ô¹
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$ptyep = ltxt::getVar( 'ptyep','get' );
				if ($ptyep == "2"){
				$sql="SELECT distinct RQPersonalCode as value , CONCAT(tblpersonal_prefix.PrefixName, tblpersonal.FirstName,' ',tblpersonal.LastName) as text "
			 ."\n FROM tblfinance_doccode inner join (tblpersonal Inner Join tblpersonal_prefix ON tblpersonal.PrefixId = tblpersonal_prefix.PrefixId) on  tblfinance_doccode.RQPersonalCode = tblpersonal.PersonalCode ";
	//	$sql="SELECT distinct nh_in_partner.PartnerCode as value , CONCAT(nh_in_partner_prefix.PtnPrefixTH, nh_in_partner.PtnFname,' ',nh_in_partner.PtnSname) as text "
	//		 ."\n FROM tblfinance_doccode inner join (nh_in_partner inner join nh_in_partner_prefix on nh_in_partner.PrefixUid=nh_in_partner_prefix.PrefixUid) on  tblfinance_doccode.PartnerCode = nh_in_partner.PartnerCode"
				}else{
					$sql="SELECT distinct nh_in_partner.PartnerCode as value , CONCAT(IFNULL(nh_in_partner_prefix.PtnPrefixTH,''), IFNULL(nh_in_partner.PtnFname,''),' ',IFNULL(nh_in_partner.PtnSname,'')) as text "
				 ."\n FROM tblfinance_doccode inner join (nh_in_partner left join nh_in_partner_prefix on nh_in_partner.PrefixUid=nh_in_partner_prefix.PrefixUid) on  tblfinance_doccode.PartnerCode = nh_in_partner.PartnerCode ";

				}
				$sql = $sql.$where_r." order by text ASC " ;
			// echo $sql;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );

	}
	/* END */
	/*
	START #F2
	Function Name	: getDataList
	Description		: à»ç¹¿Ñ§¡ìªÑ¹ÊÓËÃÑº´Ö§ÃÒÂ¡ÒÃ¸¹Ò¤ÒÃ·Ñé§ËÁ´
	*/
	function getDataList2(&$list,$limit=20){ // ตารางจ่ายเงิน
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="AcSource='0'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$fn1 = '(select PaymentValue from tblfinance_payment_methods where tblfinance_payment_methods.PaymentId = tblfinance_payment.PaymentId) as pvalue';
		$fn2 = '(select ChequeMakeDate from tblfinance_payment_methods where tblfinance_payment_methods.PaymentId = tblfinance_payment.PaymentId) as ChequeMakeDate';
		$fn3 = '(select PaymentNumber from tblfinance_payment_methods where tblfinance_payment_methods.PaymentId = tblfinance_payment.PaymentId) as PaymentNumber';
		$fn4 = '(select ChequePayDate from tblfinance_payment_comp where tblfinance_payment_comp.PaymentId = tblfinance_payment.PaymentId) as ChequePayDate';

		$sql="select tblfinance_payment.*,$fn1,$fn2,$fn3,$fn4 from tblfinance_payment ".$where_r."  order by PaymentId DESC";
		//echo $sql;
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$tList2 = $this->db->loadDataSet();
		return $tList2;
	}
	/*END*/

	function getDataList3($PaymentId){
		$where 	  = array();
		$where[] ="PaymentId=".$PaymentId;
		$where[] ="DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select * from tblfinance_payment_list ".$where_r." ";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$tList2 = $this->db->loadDataSet();
		return $tList2;
	}
	/*END*/
	/*
	START #F9
	Function Name	: getIncomeDetail
	Description		: à»ç¹¿Ñ§¡ìªÑ¹ÊÓËÃÑº´Ö§ÃÒÂ¡ÒÃÃÒÂä´é

	*/
	function getPartnerCodeDetail(){
		$where 	  = array();
		//$where[] ="DeleteStatus='N'";

	  	$PartnerCode = ltxt::getVar( 'PartnerCode','post' );//PersonalCode or  PartnerCode
		$ptyep = ltxt::getVar( 'ptyep','post' );

		if ($ptyep =="1" ){
			$sql="SELECT * FROM nh_in_partner where PartnerCode='$PartnerCode' ";
		}else{
			$sql="SELECT *  FROM tblpersonal  where PersonalCode='$PartnerCode' ";
		}
		//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject();

		echo json_encode ($detail);
	}
	/*END*/
	/*
	START #F9
	Function Name	: getIncomeDetail
	Description		: à»ç¹¿Ñ§¡ìªÑ¹ÊÓËÃÑº´Ö§ÃÒÂ¡ÒÃÃÒÂä´é
	*/
	function getPaymentData(){
		$where 	  = array();
		$where[] ="tblfinance_payment_comp.DeleteStatus='N'";

	  	$PaymentId = ltxt::getVar( 'PaymentId','post' );
		$where[] = "tblfinance_payment_comp.PaymentId=$PaymentId";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql = "select PType from tblfinance_payment_comp where tblfinance_payment_comp.PaymentId = ".$PaymentId;
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list2 = $this->db->loadDataSet();
		if($list2["rows"]){
			 foreach($list2["rows"] as $r1 ) {
				$PType= $r1->PType;// ภายนอก ภายใน
			}
		}
		if ($PType == 1){
			$sql="SELECT tblfinance_payment_comp.CalTex,tblfinance_payment_comp.TaxType,tblfinance_payment_comp.PType,nh_in_partner.PartnerId as pnid,nh_in_partner.address_long ,nh_in_partner.PartnerCode  as pcode,tblfinance_payment_comp.PaymentCompId,tblfinance_payment_comp.PaymentId,tblfinance_payment_comp.PartnerCode,tblfinance_payment_comp.CashValue,tblfinance_payment_comp.Tax,tblfinance_payment_comp.TaxW,CONCAT(IFNULL(nh_in_partner_prefix.PtnPrefixTH,''), IFNULL(nh_in_partner.PtnFname,''),' ',IFNULL(nh_in_partner.PtnSname,'')) as pname ,TaxIdent ,tblfinance_payment_comp.ChequePayDate,tblfinance_payment_comp.ChequeOrCash"
		."\n FROM tblfinance_payment_comp inner join (nh_in_partner left join nh_in_partner_prefix on nh_in_partner.PrefixUid=nh_in_partner_prefix.PrefixUid) on tblfinance_payment_comp.PartnerCode=nh_in_partner.PartnerCode "
		."\n ".$where_r;
		}else{
			$sql="SELECT tblfinance_payment_comp.CalTex,tblfinance_payment_comp.TaxType,tblfinance_payment_comp.PType,tblpersonal.PersonalId as pnid,tblpersonal.address_long ,tblpersonal.PersonalCode  as pcode,tblfinance_payment_comp.PaymentCompId,tblfinance_payment_comp.PaymentId,tblfinance_payment_comp.PartnerCode,tblfinance_payment_comp.CashValue,tblfinance_payment_comp.Tax,tblfinance_payment_comp.TaxW,CONCAT(IFNULL(tblpersonal_prefix.PrefixName,''), IFNULL(tblpersonal.FirstName,''),' ',IFNULL(tblpersonal.LastName,'')) as pname ,TaxIdent ,tblfinance_payment_comp.ChequePayDate,tblfinance_payment_comp.ChequeOrCash"
		."\n FROM tblfinance_payment_comp inner join (tblpersonal left join tblpersonal_prefix on tblpersonal.PrefixId= tblpersonal_prefix.PrefixId) on tblfinance_payment_comp.PartnerCode=tblpersonal.PersonalCode "
		."\n ".$where_r;
		}
		//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();
		echo json_encode ($detail);
	}
	/*END*/

	/*
	START #F9
	Function Name	: getIncomeDetail
	Description		: à»ç¹¿Ñ§¡ìªÑ¹ÊÓËÃÑº´Ö§ÃÒÂ¡ÒÃÃÒÂä´é
	Parameter		:
		@$_REQUEST["tsearch"]	=  ......àÁ×èÍ¡ÃÍ¡¢éÍÁÙÅ¤é¹ËÒ
	Return Value 	: Array(loadDataSet)
	*/
	function getPaymentList(){
		$where 	  = array();
		$where[] ="tblfinance_payment_list.DeleteStatus='N'";

	  	$PaymentId = ltxt::getVar( 'PaymentId','post' );
		$where[] = "tblfinance_payment_list.PaymentId='$PaymentId'";
		//$where[] = "nh_in_partner_detail.PartnerId <>0";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql="SELECT * "
		."\n FROM  tblfinance_doccode inner join tblfinance_payment_list on tblfinance_doccode.DocCode = tblfinance_payment_list.DocCode"
		."\n ".$where_r;
	//	."\n order by nh_in_partner.PartnerCode ASC " ;

		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();

		echo json_encode ($detail);
	}
	/*END*/



	/*
	START #F9
	Function Name	: getIncomeDetail
	Description		:

	*/
	function getPaymentMethods(){
		$where 	  = array();
		$where[] ="tblfinance_payment_methods.DeleteStatus='N'";

	  	$PaymentCompId = ltxt::getVar( 'PaymentCompId','post' );
		$where[] = "tblfinance_payment_methods.PaymentCompId='$PaymentCompId'";
		//$where[] = "nh_in_partner_detail.PartnerId <>0";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT tblfinance_payment_methods.PaymentType,tblfinance_payment_methods.BankId,tblbudget_finance_bank.BankName,tblfinance_payment_methods.BookbankId,tblbudget_finance_bookbank.BookbankNumber,tblfinance_payment_methods.PaymentNumber,tblfinance_payment_methods.PaymentValue,tblfinance_payment_methods.ChequeMakeDate "
		."\n FROM  tblfinance_payment_methods inner join (tblbudget_finance_bookbank inner join tblbudget_finance_bank on tblbudget_finance_bookbank.BankId=tblbudget_finance_bank.BankId) on tblfinance_payment_methods.BookbankId = tblbudget_finance_bookbank.BookbankId"
		."\n ".$where_r;
	//	."\n order by nh_in_partner.PartnerCode ASC " ;

		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();

		echo json_encode ($detail);
	}
	/*END*/

	function getEformdetail(){
		$doccode = ltxt::getVar( 'doccode','post' );
		$formcode = ltxt::getVar( 'formcode','post' );

		if ($formcode == "FC002" || $formcode == "FF004A" || $formcode == "FF004B" || $formcode == "FF005A" || $formcode == "FF005B" || $formcode == "FF006A" || $formcode == "FF006B"){
			$tbla = "tblfinance_form_chain_cost";
		}
		if ($formcode == "FP001" || $formcode == "FC001" || $formcode == "FF001" || $formcode == "FF003" || $formcode == "FH001" || $formcode == "FH002" || $formcode == "FP002" || $formcode == "FF002"){
			$tbla = "tblfinance_form_hold_cost";
		}

		if ($formcode == "FF009" || $formcode == "FP003" || $formcode == "FH004" || $formcode == "FP004"){
			$tbla = "tblfinance_form_pay_cost";
		}

		if ($formcode == "FF007" || $formcode == "FF008" || $formcode == "FF010" || $formcode == "FC003"){
			$tbla = "tblfinance_form_paybr_cost";
		}

		$where 	  = array();
		$where[] ="DocCode='".$doccode."'";

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$fn2 = '(select sum(tblfinance_payment_list_detail.CastValue) as aaa from tblfinance_payment_list_detail where tblfinance_payment_list_detail.DocCode = '.$tbla.'.DocCode and tblfinance_payment_list_detail.CostItemCode = '.$tbla.'.CostItemCode and tblfinance_payment_list_detail.DeleteStatus="N") as suma';
		$fn1 = "(select CostName from tblbudget_init_cost_item where tblbudget_init_cost_item.CostItemCode = ".$tbla.".CostItemCode) as itemname";
		$sql = "select $tbla.* ,$fn1 ,$fn2 from ".$tbla." ".$where_r;
	//	echo $sql ;
		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();

		echo json_encode ($detail);
	}
	/*END*/
	function getEformdetailvalue(){
		$doccode = ltxt::getVar( 'doccode','post' );
		$formcode = ltxt::getVar( 'formcode','post' );
		$costitemcode = ltxt::getVar( 'costitemcode','post' );
		$PaymentId = ltxt::getVar( 'PaymentId','post' );
		$where 	  = array();
		$where[] ="DocCode='".$doccode."'";
		$where[] ="CostItemCode='".$costitemcode."'";
		$where[] ="PaymentId='".$PaymentId."'";

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		//$sql = "select distinct(CostItemCode)as CostItemCode from ".$tbla." ".$where_r;
		$sql = "select * from tblfinance_payment_list_detail ".$where_r;
		//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();
		echo json_encode ($detail);
	}
	/*END*/

}
?>
