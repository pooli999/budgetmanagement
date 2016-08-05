<?php

class sHelper
{
	var $dpublic;
	var $db;
	var $debug = 0;
	var $fpublic;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
		$this->dpublic	= new BGPublic();
		$this->fpublic		= new F_Public();
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
		$_REQUEST["BgtYear"] = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		if($_REQUEST["BgtYear"]){
			$where[] = "t1.BgtYear = '".$_REQUEST["BgtYear"]."' ";
		}	
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select t1.*,t2.StatusName,t2.TextColor,t2.Icon "
				."\n  from tblfinance_doccode AS t1"
				."\n Inner Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
				."\n".$where_r
				."\n order by t1.CodeId desc "
				;
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	function getYear($Year=0,$ObjYear=0,$tag_attribs='onchange="loadSCT(this.value)"',$lebel='ทั้งหมด'){
		return $this->dpublic->getYear($Year,$ObjYear,$tag_attribs,$lebel);
	}
	
	
	
}// end class
?>
