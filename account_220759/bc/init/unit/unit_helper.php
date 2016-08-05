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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการหน่วยนับทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อหน่วยนับเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		
		if($_REQUEST["tsearch"]){
			$where[] = "UnitName like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblunit ".$where_r."  order by CONVERT(`UnitName` USING TIS620) ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($UnitID){
		$where 	  = array();
		if($UnitID){
			$where[] ="UnitID='".$UnitID."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblunit ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F
	Function Name: getUnitName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: single(loadResult) 
	*/	
	function getUnitName($UnitID){
		$where 	  = array();
		if($UnitID){
			$where[] ="UnitID='".$UnitID."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select UnitName from tblunit ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/

}
?>
