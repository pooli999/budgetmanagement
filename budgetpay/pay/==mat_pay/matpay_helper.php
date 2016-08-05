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
		$where[] ="t1.DeleteStatus='N'";
		$where[] ="t1.EnableStatus='Y'";
		//$where[] ="t1.DocumentId in (11) ";
		
		if($_REQUEST["tsearch"]){
			$where[] = "t1.Topic like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select t1.*,t2.StatusName,t2.TextColor,t2.Icon from tblintra_eform_formal_pay AS t1 "
		."\n Inner Join tblintra_eform_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
		."\n".$where_r
		."\n order by t2.DocStatusId ASC, t1.DocDate DESC, t1.DocCode ASC";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	
	
}
?>
