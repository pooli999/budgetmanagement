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
				
		$where[] = "t1.CreateBy = '".$_SESSION["Session_UserId"]."' ";
		$where[] ="t1.DeleteStatus='N'";
		$where[] ="t1.EnableStatus='Y'";

		if($_REQUEST["StartDate"] != "" && $_REQUEST["EndDate"] != ""){
			$where[] = "t1.DocDate  Between '".$_REQUEST["StartDate"]."'  And  '".$_REQUEST["EndDate"]."'  ";
		}else if($_REQUEST["StartDate"] != "" && $_REQUEST["EndDate"] == ""){
			$where[] = "t1.DocDate  in ('".$_REQUEST["StartDate"]."')   ";
		}else if($_REQUEST["StartDate"] == "" && $_REQUEST["EndDate"] != ""){
			$where[] = "t1.DocDate  in ('".$_REQUEST["EndDate"]."')   ";
		}
		
		if($_REQUEST["BgtYear"]){
			$where[] = "t1.BgtYear = '".$_REQUEST["BgtYear"]."' ";
		}	
				
		if($_REQUEST["PItemCode"]){
			$where[] = "t1.PItemCode = '".$_REQUEST["PItemCode"]."' ";
		}		

		if($_REQUEST["PrjId"]){
			$where[] = "t1.PrjId = '".$_REQUEST["PrjId"]."' ";
		}	
			
		if($_REQUEST["PrjActCode"]){
			$where[] = "t1.PrjActCode = '".$_REQUEST["PrjActCode"]."' ";
		}		
			
		if($_REQUEST["DocCode"]){
			$where[] = "t1.DocCode like ('%".$_REQUEST["DocCode"]."%')";
		}
		
		// หางบประมาณรวม
		//$totalCostlist = $this->getSumCost($_REQUEST["DocCode"],$_REQUEST["PrjActCode"],0,0);
		
		if($_REQUEST["DocOperator"] == ">" && !empty($totalCostlist)){
			$where[] = "t1.Budget > '".$totalCostlist."' ";
		}else if($_REQUEST["DocOperator"] == "<" && !empty($totalCostlist)){
			$where[] = "t1.Budget < '".$totalCostlist."' ";
		}else if(!empty($totalCostlist)){
			$where[] = "t1.Budget = '".$totalCostlist."' ";
		}
		
		if(!empty($_REQUEST["SourceType"]) and  $_REQUEST["SourceType"] != 'undefined'){
			$where[] = "t1.SourceType = '".$_REQUEST["SourceType"]."' ";
		}
		
		if($_REQUEST["SourceExId"]){
			$where[] = "t1.SourceExId = '".$_REQUEST["SourceExId"]."' ";
		}		
		
/*		if($_REQUEST["FormId"]){
			$where[] = "t1.FormId = '".$_REQUEST["FormId"]."' ";
		}	*/		
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select t1.*,t2.StatusName,t2.TextColor,t2.Icon from tblintra_eform_formal_ot AS t1 "
		."\n Inner Join tblintra_eform_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
		."\n".$where_r
		."\n order by t2.DocStatusId ASC, t1.DocDate DESC, t1.DocCode ASC";
		
		//echo "<pre>".$sql."</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
		
	}
	/*END*/
	
	
}// end class
?>
