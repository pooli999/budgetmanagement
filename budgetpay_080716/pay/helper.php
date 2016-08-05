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
		$this->dpublic		= new BGPublic();
		$this->fpublic		= new F_Public();
	}

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
	
/*	function getPay($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode=0,$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CommitStatus="",$FormId=0){//งบตัดจ่าย(CommitStatus=N/รอตัดจ่าย ,Y/ตัดจ่ายแล้ว)
		return $this->fpublic->getPay($BgtYear,$SourceType,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CommitStatus,$FormId);
	}
	
	function getSumPlanBudget($BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode=0,$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CalTfer=""){//งบแผนแผ่นดิน(รวมโอน)
		return $this->fpublic->getSumPlanBudget($BgtYear,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CalTfer);
	}*/
	
	function getSumPlanBudget($TblCost='',$TblMonth='',$Field='',$CostField='',$BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$SourceExId=0){//งบแผนแผ่นดิน
		return $this->fpublic->getSumPlanBudget($TblCost,$TblMonth,$Field,$CostField,$BgtYear,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$SourceExId);
	}

	function getChain($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$FormCode=0){
		return $this->fpublic->getChain($BgtYear,$SourceType,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$FormCode);
	}

	function getPay($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CommitStatus="",$FormCode=0){
		return $this->fpublic->getPay($BgtYear,$SourceType,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CommitStatus,$FormCode);
	}

/*	function getAmountDoc($tablename,$BgtYear=0,$DocStatusId=0,$SourceType="",$SourceExId=0){
		return $this->fpublic->getAmountDoc($tablename,$BgtYear,$DocStatusId,$SourceType,$SourceExId);
	}*/
	
	function getAmountDoc($tablename,$BgtYear=0,$DocStatusId=0,$SourceType="",$SourceExId=0,$FormCode=0){
		return $this->fpublic->getAmountDoc($tablename,$BgtYear,$DocStatusId,$SourceType,$SourceExId,$FormCode);
	}
	
	/* END ตารางแผนงาน โครงการ กิจกรรม*/

	/*
	Function Name	:	getFromList
	Description		: 	เป็นฟังก์ชันสำหรับดึงรายการแบบฟอร์มทั้งหมดตามหน้าที่ของแบบฟอร์ม
	Parameter		: 
	Return Value 	: 
	*/	
	function getFromList($Type=''){
		$where = array();
		//$where[] = " FormCode like '".$Type."%' ";
		
		$where[] = " FormCode in (".$Type.") ";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select * "
				."\n from tblintra_eform_init_form"
				."\n".$where_r
				."order by FormCode asc "
				;
		$this->db->setQuery($sql); //echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/*END*/

	/* START F */
	/* Function Name: getExcel */
	/* Description: เป็นฟังก์ชันสำหรับส่งออกเอกสารเป็น word */
	function getExcel(){
			header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment; filename="report.xls"');
			echo "<html xmlns:o='urn:schemas-microsoft-com:office:office'xmlns:x='urn:schemas-microsoft-com:office:word'xmlns='http://www.w3.org/TR/REC-html40'>" ;
	}	
	/* END */		
	
}
?>
