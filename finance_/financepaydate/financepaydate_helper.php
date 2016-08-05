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
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
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
