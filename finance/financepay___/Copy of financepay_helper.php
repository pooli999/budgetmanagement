<?php

class sHelper
{
	var $db;
	var $debug = 0;
	/* 
	START #F1
	Function Name		: sHelper 
	Description			: เป็นฟังก์ชันสำหรับติดต่อฐานข้อมูล
	Parameter			: -
	Return Value 		: -
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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการธนาคารทั้งหมด 
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อธนาคารเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="DocStatusId >= 7"; // 7 คืออนุมัติ
		$where[] ="PaymentStatus = 'N'"; // ยังไม่จ่ายเงิน
		if($_REQUEST["PersonalCode"]){
			$where[] = "RQPersonalCode like ('%".$_REQUEST["PersonalCode"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		//$fn1 = "(select BankName from tblbudget_finance_bank where tblbudget_finance_bank.BankId = tblbudget_finance_bookbank.BankId) as BankName";
		//$fn2 = "(select BookbankType from tblbudget_finance_bookbank_type where tblbudget_finance_bookbank_type.BookbankTypeId = tblbudget_finance_bookbank.BookbankTypeId) as BookbankType";
		$sql="select * from tblfinance_doccode ".$where_r."  order by CodeId DESC";

		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดธนาคาร 
	Parameter		: 
		@TypeActId	= ID (PK) ของตาราง tblbudget_init_type_activity
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($BookbankId){
		$where 	  = array();
		if($BookbankId){
			$where[] ="BookbankId='".$BookbankId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql = "select * from tblbudget_finance_bookbank ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F4
	Function Name: getTypeActName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อธนาคาร
	Parameter		: 
		@BankId	= ID (PK) ของตาราง tblbudget_finance_bank
	Return Value 	: single(loadResult) 
	*/	
	function getBookbankNumber($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		
		$bankid = ltxt::getVar( 'bankid','get' );
		if($bankid){
			$where[] = "BankId=$bankid";
		}
		/*$typeid = ltxt::getVar( 'typeid','get' );
		if($typeid){
		$where[] = "BookbankTypeId=$typeid";
		}*/
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	//	echo $where_r;
		$title[] = clssHTML::makeOption(0,$lebel);
		if($bankid){
			$sql="SELECT BookbankId as value , BookbankNumber as text "
				 ."\n FROM tblbudget_finance_bookbank "
				 ."\n ".$where_r
				 ."\n order by BookbankId ASC " ;
				 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
				
			//echo "<pre>$sql;</pre>";
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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการธนาคารขึ้นมาเรียงลำดับ 
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
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
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการธนาคาร  */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getBankNameSelect($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
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
	
	 /* START #F7 */
	/* Function Name: getBankNameSelect */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการประเภทบัญชี  */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getBookbankType($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT BookbankTypeId as value , BookbankType as text "
			 ."\n FROM tblbudget_finance_bookbank_type "
			 ."\n ".$where_r
			 ."\n order by BookbankType ASC " ;
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
	/* Function Name: getPlanItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการธนาคาร  */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getPersonalCode($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		//$where[] = "EnableStatus='Y'";
		$where[] ="DocStatusId >= 7"; // 7 คืออนุมัติ
		$where[] ="PaymentStatus = 'N'"; // ยังไม่จ่ายเงิน
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

				$sql="SELECT distinct RQPersonalCode as value , CONCAT(tblpersonal_prefix.PrefixName, tblpersonal.FirstName,' ',tblpersonal.LastName) as text "
			 ."\n FROM tblfinance_doccode inner join (tblpersonal Inner Join tblpersonal_prefix ON tblpersonal.PrefixId = tblpersonal_prefix.PrefixId) on  tblfinance_doccode.RQPersonalCode = tblpersonal.PersonalCode"
			 ."\n ".$where_r
			 ."\n order by text ASC " ;
			 /*$sql="SELECT distinct RQPersonalCode as value , CONCAT(nh_in_partner_prefix.PtnPrefixTH, nh_in_partner.PtnFname,' ',nh_in_partner.PtnSname) as text "
			 ."\n FROM tblfinance_doccode inner join (nh_in_partner Inner Join nh_in_partner_prefix ON nh_in_partner.PrefixUid = nh_in_partner_prefix.PrefixUid) on  tblfinance_doccode.RQPersonalCode = nh_in_partner.PartnerCode"
			 ."\n ".$where_r
			 ."\n order by text ASC " ;
			 echo $sql;*/
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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการธนาคารทั้งหมด 
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อธนาคารเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList2(&$list,$limit=20){
		$where 	  = array();
		//$where[] ="DocStatusId >= 7"; // 7 คืออนุมัติ
		
		if($_REQUEST["PersonalCode"]){
		//	$where[] = "RQPersonalCode like ('%".$_REQUEST["PersonalCode"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		//$fn1 = "(select BankName from tblbudget_finance_bank where tblbudget_finance_bank.BankId = tblbudget_finance_bookbank.BankId) as BankName";
		//$fn2 = "(select BookbankType from tblbudget_finance_bookbank_type where tblbudget_finance_bookbank_type.BookbankTypeId = tblbudget_finance_bookbank.BookbankTypeId) as BookbankType";
		$sql="select * from tblfinance_payment ".$where_r."  order by PaymentId DESC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$tList2 = $this->db->loadDataSet();
		return $tList2;
	}
	/*END*/
	/* 
	START #F9
	Function Name	: getIncomeDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการรายได้
	Parameter		:
		@$_REQUEST["tsearch"]	=  ......เมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getPartnerCodeDetail(){
		$where 	  = array();
		//$where[] ="DeleteStatus='N'";
		
	  	$PartnerCode = ltxt::getVar( 'PartnerCode','post' );
		$where[] = "nh_in_partner.PartnerCode='$PartnerCode'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="SELECT * "
		."\n FROM nh_in_partner inner join nh_in_partner_detail on nh_in_partner.PartnerCode = nh_in_partner_detail.PartnerCode"
		."\n ".$where_r
		."\n order by nh_in_partner.PartnerCode ASC " ;

		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject();
		
		echo json_encode ($detail);
	}
	/*END*/
	/* 
	START #F9
	Function Name	: getIncomeDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการรายได้
	Parameter		:
		@$_REQUEST["tsearch"]	=  ......เมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getPaymentData(){
		$where 	  = array();
		//$where[] ="DeleteStatus='N'";
		
	  	$PaymentId = ltxt::getVar( 'PaymentId','post' );
		$where[] = "tblfinance_payment_comp.PaymentId='$PaymentId'";
		$where[] = "nh_in_partner_detail.PartnerId <>0";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="SELECT distinct  nh_in_partner.PartnerCode ,tblfinance_payment_comp.PaymentCompId,tblfinance_payment_comp.PaymentId,tblfinance_payment_comp.PartnerCode,tblfinance_payment_comp.CashValue,tblfinance_payment_comp.Tax,tblfinance_payment_comp.TaxW,AddressDetail,Soi,Road,DistrictCode,SubDistrictCode,ProvinceCode,PtnPrefixTH,PtnFname,PtnSname,TaxIdent "
		."\n FROM tblfinance_payment_comp inner join (nh_in_partner inner join nh_in_partner_detail on nh_in_partner.PartnerCode = nh_in_partner_detail.PartnerCode inner join nh_in_partner_prefix on nh_in_partner.PrefixUid=nh_in_partner_prefix.PrefixUid) on tblfinance_payment_comp.PartnerCode=nh_in_partner.PartnerCode "
		."\n ".$where_r;
	//	."\n order by nh_in_partner.PartnerCode ASC " ;
		//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();
		echo json_encode ($detail);
	}
	/*END*/
	
	/* 
	START #F9
	Function Name	: getIncomeDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการรายได้
	Parameter		:
		@$_REQUEST["tsearch"]	=  ......เมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getPaymentList(){
		$where 	  = array();
		//$where[] ="DeleteStatus='N'";
		
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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการรายได้
	Parameter		:
		@$_REQUEST["tsearch"]	=  ......เมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getPaymentMethods(){
		$where 	  = array();
		//$where[] ="DeleteStatus='N'";
		
	  	$PaymentCompId = ltxt::getVar( 'PaymentCompId','post' );
		$where[] = "tblfinance_payment_methods.PaymentCompId='$PaymentCompId'";
		//$where[] = "nh_in_partner_detail.PartnerId <>0";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT tblfinance_payment_methods.PaymentType,tblfinance_payment_methods.BankId,tblbudget_finance_bank.BankName,tblfinance_payment_methods.BookbankId,tblbudget_finance_bookbank.BookbankNumber,tblfinance_payment_methods.PaymentNumber,tblfinance_payment_methods.PaymentValue "
		."\n FROM  tblfinance_payment_methods inner join (tblbudget_finance_bookbank inner join tblbudget_finance_bank on tblbudget_finance_bookbank.BankId=tblbudget_finance_bank.BankId) on tblfinance_payment_methods.BookbankId = tblbudget_finance_bookbank.BookbankId"
		."\n ".$where_r;
	//	."\n order by nh_in_partner.PartnerCode ASC " ;

		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();
		
		echo json_encode ($detail);
	}
	/*END*/
	/* START #F11  */
	/* Function Name: getBookbankNumberData */
	/* Description: เป็นฟังก์ชันสำหรับดึงเลขที่บัญชี */
	function getBookbankNumberData($BookbankId=0){
		$where = array();
		$where[] = "BookbankId = ".$BookbankId;
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select BookbankNumber "
				."\n from tblbudget_finance_bookbank "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */

	
}
?>
