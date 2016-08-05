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
		$where[] ="t1.DeleteStatus='N'";
		$where[] ="t1.EnableStatus='Y'";
		if($_REQUEST["BgtYear"]){
			$where[] = "t1.BgtYear = '".$_REQUEST["BgtYear"]."' ";
		}	
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select t1.*,t2.StatusName,t2.TextColor,t2.Icon from tblintra_eform_transfer AS t1 "
		."\n Inner Join tblintra_eform_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
		."\n".$where_r
		."\n order by t2.DocStatusId ASC, t1.DocDate DESC, t1.DocCode ASC";
		
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	
	/* 
	Function Name: getSumBudget 
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumBudget($DocCode=0,$CostItemCode=0,$CostId=0){
		
		$where = array();
		//if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		//}

/*		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}*/
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($CostId){
			$where[] = "CostId='".$CostId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(Budget) "
				."\n FROM "
				."\n tblintra_eform_transfer_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */

	/* START ตารางแผนงาน โครงการ กิจกรรม*/
	
	function getFormName($FormId){
		return $this->fpublic->getFormName($FormId);
	}
	
	function getPlanItem($BgtYear=0){
		return $this->fpublic->getPlanItem($BgtYear);
	}
	
	function getProjectItem($PItemCode){
		return $this->fpublic->getProjectItem($PItemCode);
	}
	
	function getActivityItem($PrjId){
		return $this->fpublic->getActivityItem($PrjId);
	}
	
	function getYear($Year=0,$ObjYear=0,$tag_attribs='onchange="loadSCT(this.value)"',$lebel='ทั้งหมด'){
		return $this->dpublic->getYear($Year,$ObjYear,$tag_attribs,$lebel);
	}
	
	function getSourceExternal($selected=0,$tag_name='SourceExId',$tag_attribs='onchange="loadPage(this.value)"',$lebel='ทั้งหมด'){
		return $this->fpublic->getSourceExternal($selected,$tag_name,$tag_attribs,$lebel);
	}
	
	function getExternalYear(){
		return $this->fpublic->getExternalYear();
	}
	
	function getOrgShortName($BgtYear=0, $OrganizeCode=0){
		return $this->fpublic->getOrgShortName($BgtYear, $OrganizeCode);
	}
	
	function getSumPlanBudget_Inc($BgtYear=0,$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode=0,$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CalTfer=""){//งบแผนเงินนอก(รวมโอน)

		return $this->fpublic->getSumPlanBudget_Inc($BgtYear,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CalTfer);
	}
	
		function getSumPlanBudget($BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode=0,$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CalTfer=""){//งบแผนแผ่นดิน(รวมโอน)
		return $this->fpublic->getSumPlanBudget($BgtYear,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CalTfer);
	}
	
	function getTferOut($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CommitStatus=""){

		return $this->fpublic->getTferOut($BgtYear,$SourceType,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CommitStatus);
	}
	
	function getTferIn($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode=0,$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CommitStatus=""){

		return $this->fpublic->getTferIn($BgtYear,$SourceType,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CommitStatus);
	}

	/* END ตารางแผนงาน โครงการ กิจกรรม*/
	
	/* START F */
	/* Function Name: getExcel */
	/* Description: เป็นฟังก์ชันสำหรับส่งออกเอกสารเป็น word */
	function getExcel(){
			header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment; filename="report.xls"');
			echo "<html xmlns:o='urn:schemas-microsoft-com:office:office'xmlns:x='urn:schemas-microsoft-com:office:word'xmlns='http://www.w3.org/TR/REC-html40'>" ;
	}	
	/* END */			
	
	
}// end class
?>
