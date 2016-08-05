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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการตัวชี้วัดทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อตัวชี้วัดเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		
		if($_REQUEST["tsearch"]){
			$where[] = "IndName like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_indicator ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดตัวชี้วัด 
	Parameter		: 
		@IndId	= ID (PK) ของตาราง tblbudget_indicator
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($IndId){
		$where 	  = array();
		if($IndId){
			$where[] ="IndId='".$IndId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_indicator ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F4
	Function Name: getIndName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อตัวชี้วัด 
	Parameter		: 
		@IndId	= ID (PK) ของตาราง tblbudget_indicator
	Return Value 	: single(loadResult) 
	*/	
	function getIndName($IndId){
		$where 	  = array();
		if($IndId){
			$where[] ="IndId='".$IndId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select IndName from tblbudget_indicator ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F5
	Function Name: getOrderList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการตัวชี้วัดขึ้นมาเรียงลำดับ 
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
	*/	
	function getOrderList(){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_indicator ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}	
	/*END*/
	
	function getLastRunningNo(){
		$sql = "select max(Running) "
				."\n from tblbudget_indicator "
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return ($data+1);
	}
	

}
?>
