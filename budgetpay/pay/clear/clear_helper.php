<?php

class sHelper
{
	var $db;
	var $debug = 0;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
	}
	
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
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select t1.*,t2.StatusName,t2.TextColor,t2.Icon from tblintra_eform_advance_clear AS t1 "
				."\n Left Join tblintra_eform_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
				."\n".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	
	
}// end class
?>
