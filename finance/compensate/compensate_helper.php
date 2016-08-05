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
		//$where[] ="DeleteStatus='N'"; // ไม่มี field นี้

		if($_REQUEST["tsearch"]){
			$where[] = "DocCode like ('%".$_REQUEST["tsearch"]."%')";
		}

		$typapt = $_REQUEST["typapt"];
		if($typapt != ""){ // แสดงรายการที่ยังไม่คืน 1ใช่  2 ไม่ใช่ ค่าว่างแสดงทั้งหมด
			if ($typapt == 1){ // รายการยังไม่คืน
				$where[] = "CompensateId = 0";
			}else if ($typapt == 2){ //รายการที่คืนแล้ว
				$where[] = "CompensateId <> 0";
			}

		}else{
			$where[] = "CompensateId = 0";
		}

		$where[] = "DocStatusId = 7"; //สถานะอนุมัติ
		//$where[] = "cash > 0";// มีการจ่ายเป็นเงินสด
		$where[] = "tblfinance_doccode.FormCode = 'FF009'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$fn1 = "(select t2.PrjName from tblbudget_project_detail as t1 left join tblbudget_project as t2 on t2.PrjId=t1.PrjId where t1.PrjDetailId=tblfinance_doccode.PrjDetailId) as pname";
		$fn2 = "(SELECT CONCAT(tblpersonal_prefix.PrefixName, tblpersonal.FirstName,' ', tblpersonal.LastName) as FullName FROM tblpersonal Inner Join tblpersonal_prefix ON tblpersonal.PrefixId = tblpersonal_prefix.PrefixId WHERE tblpersonal.PersonalCode=tblfinance_doccode.RQPersonalCode) as auser ";
		$sql="select tblfinance_doccode.*,$fn1,$fn2 from tblfinance_doccode ".$where_r."  order by DocCode ASC"; // รายการ eform ที่ อนุมัติ
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
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดธนาคาร
	Parameter		:
		@TypeActId	= ID (PK) ของตาราง tblbudget_init_type_activity
	Return Value 	: Array 1 รายการ (loadSingleObject)
	*/
	function getDetail($BankId){
		$where 	  = array();
		if($BankId){
			$where[] ="BankId='".$BankId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql = "select * from tblbudget_finance_bank ".$where_r;
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
	function getBankName($BankId){
		$where 	  = array();
		if($BankId){
			$where[] ="BankId='".$BankId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql = "select BankName from tblbudget_finance_bank ".$where_r;
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

		$sql="select * from tblbudget_finance_bank ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}
	/*END*/

}
?>
