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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการฝากเงินสดและเช็คทั้งหมด 
	Parameter		:
		@$_REQUEST["tsearch"]	=  ......เมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="tblbudget_finance_deposit.DeleteStatus='N'";
		
	  	if($_REQUEST['tsearch']){
			$tsearch=$_REQUEST['tsearch'];
		}else{
			$tsearch = date('Y-m-d');
		}
		$where[] = "tblbudget_finance_deposit.CreateDate like ('%".$tsearch."%')";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select *,BankName,BookbankType,BookbankNumber from ((tblbudget_finance_deposit  inner join tblbudget_finance_bank on tblbudget_finance_deposit.BankId=tblbudget_finance_bank.BankId) inner join tblbudget_finance_bookbank_type on tblbudget_finance_deposit.BookbankTypeId=tblbudget_finance_bookbank_type.BookbankTypeId) inner join tblbudget_finance_bookbank on tblbudget_finance_deposit.BookbankId=tblbudget_finance_bookbank.BookbankId ".$where_r."  order by tblbudget_finance_deposit.Ordering ASC";
		//echo $sql;
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดฝากเงินสดและเช็ค
	Parameter		: 
		@TypeActId	= ID (PK) ของตาราง tblbudget_finance_deposit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($DepositId){
		$where 	  = array();
		if($DepositId){
			$where[] ="DepositId=".$DepositId;
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql = "select * from tblbudget_finance_deposit ".$where_r;
		//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	 /* START #F4 */
	/* Function Name: getBookbankNumber */
	/* Description: เป็นฟังก์ชันสำหรับดึงเลขที่บัญชี  */
	/* Parameter: */
			/* @BankId		= รหัสธนาคาร */
			/* @BookbankTypeId	 	= ประเภทบัยชี */
	/* Return Value : List Box */

	function getBookbankNumber($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element

		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		
		$bankid = ltxt::getVar( 'bankid','get' );
		
		if($bankid){
		$where[] = "BankId=$bankid";
		}
		$typeid = ltxt::getVar( 'typeid','get' );
		if($typeid){
		$where[] = "BookbankTypeId=$typeid";
		}
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		//echo $where_r;
		$title[] = clssHTML::makeOption(0,$lebel);
		
		if($bankid && $typeid){
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
	/* END */
	
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
	/* Function Name: getBankNameSelect */
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

	 /* START #F8 */
	/* Function Name: getIncomeId */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการประเภทบัญชี  */
	/* Parameter: */
	/* Return Value : List Box */

	function getIncomeId($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		$where[] = "(ReceiveType=1 or ReceiveType=3)";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT IncomeId as value , IncomeId as text "
			 ."\n FROM tblbudget_finance_income "
			 ."\n ".$where_r
			 ."\n order by IncomeId ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
	/* 
	START #F9
	Function Name	: getIncomeDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการรายได้
	Parameter		:
		@$_REQUEST["tsearch"]	=  ......เมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getIncomeDetail(){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		
	  	$IncomeId = ltxt::getVar( 'IncomeId','post' );
		$where[] = "IncomeId=$IncomeId";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="SELECT * "
		."\n FROM tblbudget_finance_income "
		."\n ".$where_r
		."\n order by IncomeId ASC " ;
		//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject();
		
		echo json_encode ($detail);
	}
	/*END*/
	
	/* START #F10 */
	/* Function Name: getIncomeItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลรายการรายได้ตาม DepositId */	
	function getIncomeItemList($DepositId=0){
		
		$where = array();
		//if($DepositId){
			$where[] = "DepositId='".$DepositId."'";
		//}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT * "
				."\n FROM "
				."\n tblbudget_finance_deposit_list "
				."\n ".$where_r
				."\n order by DepositListId ASC "
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */	
	
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
