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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการแหล่งที่มาของเงินนอกงบประมาณทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อแหล่งที่มาของเงินนอกงบประมาณเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		
		if($_REQUEST["tsearch"]){
			$where[] = "SourceExName like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_source_external ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแหล่งที่มาของเงินนอกงบประมาณ 
	Parameter		: 
		@SourceExId	= ID (PK) ของตาราง tblbudget_init_source_external
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($SourceExId){
		$where 	  = array();
		if($SourceExId){
			$where[] ="SourceExId='".$SourceExId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_source_external ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F4
	Function Name: getSourceExName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อแหล่งที่มาของเงินนอกงบประมาณ 
	Parameter		: 
		@SourceExId	= ID (PK) ของตาราง tblbudget_init_source_external
	Return Value 	: single(loadResult) 
	*/	
	function getSourceExName($SourceExId){
		$where 	  = array();
		if($SourceExId){
			$where[] ="SourceExId='".$SourceExId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select SourceExName from tblbudget_init_source_external ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F5
	Function Name: getOrderList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการแหล่งที่มาของเงินนอกงบประมาณขึ้นมาเรียงลำดับ 
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
	*/	
	function getOrderList(){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_source_external ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}	
	/*END*/

}
?>
