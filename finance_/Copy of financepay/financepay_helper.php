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
	function getBookbankNumber($BookbankId){
		$where 	  = array();
		if($BankId){
			$where[] ="BookbankId='".$BookbankId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select BookbankNumber from tblbudget_finance_bookbank ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
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
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

				$sql="SELECT distinct RQPersonalCode as value , CONCAT(tblpersonal_prefix.PrefixName, tblpersonal.FirstName,' ',tblpersonal.LastName) as text "
			 ."\n FROM tblfinance_doccode inner join (tblpersonal Inner Join tblpersonal_prefix ON tblpersonal.PrefixId = tblpersonal_prefix.PrefixId) on  tblfinance_doccode.RQPersonalCode = tblpersonal.PersonalCode"
			 ."\n ".$where_r
			 ."\n order by text ASC " ;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
}
?>
