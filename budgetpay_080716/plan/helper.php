<?php
class sHelper
{
	var $dpublic;
	var $db;
	var $debug = 0;
	//var $fpublic;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
		$this->dpublic	= new BGPublic();
		//$this->fpublic		= new F_Public();
	}

	/*
	Function Name	:  
	Description			: 
	Parameter			:
	Return Value 		: 
	*/	
	function getFormName($FormId){
		$where = array();
		$where[] = "FormId='".$FormId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select FormName "
				."\n from tblintra_eform_init_form "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/*END*/
	
	/* START ตารางแผนงาน โครงการ กิจกรรม*/
	
	function getPlanItem($BgtYear=0){
		return $this->dpublic->getPlanItem($BgtYear);
	}
	
	function getProjectItem($PItemCode){
		return $this->dpublic->getProjectItem($PItemCode);
	}
	
	function getActivityItem($PrjId){
		return $this->dpublic->getActivityItem($PrjId);
	}
	
	function getYear($Year=0,$ObjYear=0,$tag_attribs='onchange="loadSCT(this.value)"',$lebel='ทั้งหมด'){
		return $this->dpublic->getYear($Year,$ObjYear,$tag_attribs,$lebel);
	}
	
	function getSourceExternal($selected=0,$tag_name='SourceExId',$tag_attribs='',$lebel='ทั้งหมด'){
		return $this->dpublic->getSourceExternal($selected,$tag_name,$tag_attribs,$lebel);
	}
	
	function getExternalYear(){
		return $this->dpublic->getExternalYear();
	}
	
	/* END ตารางแผนงาน โครงการ กิจกรรม*/
	
	function getOrgShortName($BgtYear=0, $OrganizeCode=0){
		return $this->dpublic->getOrgShortName($BgtYear, $OrganizeCode);
	}
	
/*	function getSumPlanBudget($BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CalTfer="Y"){
		return $this->dpublic->getSumPlanBudget($BgtYear,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CalTfer);
	}*/
	
	function getSumPlanBudget($TblCost='',$TblMonth='',$Field='',$CostField='',$BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$SourceExId=0){//งบแผนแผ่นดิน
		return $this->dpublic->getSumPlanBudget($TblCost,$TblMonth,$Field,$CostField,$BgtYear,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$SourceExId);
	}	
	
	function getSumPlanBudget_Inc($BgtYear=0,$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CalTfer=""){

		return $this->dpublic->getSumPlanBudget_Inc($BgtYear,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CalTfer);
	}
	
	function getTotalPay($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CommitStatus="",$FormCode=""){
		return $this->dpublic->getTotalPay($BgtYear,$SourceType,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode,$CommitStatus,$FormCode);
	}
	/*--------------view project--------------*/
	
		/* START  */
	/* Function Name: getProjectDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดโครงการ */
	function getProjectDetail($PrjId=0){
		$where = array();
		if($PrjId){
			$where[] = "t2.PrjId='".$PrjId."'";
		}	
		$where[] = "t1.ActiveStatus='Y'";
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT "
		."\n t1.*, "
		."\n t2.PrjCode, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t2.OrganizeCode, "
		."\n t2.BgtYear, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "	
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "	
		."\n ".$where_r
		;
		//echo "$sql";		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;

	}
	/* END */
	
		/* START  */
	/* Function Name: getIndicator */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของโครงการ*/
	function getIndicatorSelect($PrjDetailId=0){
		$sql = "select t1.PrjIndId,t1.IndicatorName,t1.Value,t1.UnitID,t3.UnitName,t1.IndTypeId "
				."\n from tblbudget_project_indicator as t1 "
				."\n left join tblunit as t3 on t3.UnitID=t1.UnitID "
				."\n where t1.PrjDetailId='".$PrjDetailId."'"
				."\n order by PrjIndId ASC  "
				;
		//echo "<pre>$sql</pre>";	
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */
	
	function getProjectDetailActRecordSet($PrjDetailId=0){
		return $this->dpublic->getProjectDetailActRecordSet($PrjDetailId);
	}
	
	/* 
 	START
	Function Name	: getAllProjectFile
	Description		: เรียกข้อมูลรายการธนาคารของสมาชิกภาคีเครือข่าย
	Parameter		: MouId(ไอดีของตาราง tblmou_project_file)
	Return Value 	: Array List
	*/
	function getProjectFile($PrjDetailId){
		$where 	  = array();
		$where[] ="PrjDetailId='".$PrjDetailId."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_project_file ".$where_r; 
		$this->db->setQuery($sql);
		$rows = $this->db->loadObjectList(); 
		return $rows;
	}	
	/* END */
	
	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjCode="",$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjCode,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	
	function getCostTypeRecordSet($CostTypeId=0){
		return $this->dpublic->getCostTypeRecordSet($CostTypeId);
	}
	
	function getCostItemRecordSet($CostTypeId=0,$LevelId=1,$ParentCode=0,$HasChild=0,$CostItemCode=0){
		return $this->dpublic->getCostItemRecordSet($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	}
	
	/* START  */
	/* Function Name: getItemRequireInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายงบแผ่นดิน *4  */
	function getItemRequireInternal($CostItemCode=0,$PrjActId=0,$PrjCode="",$PrjDetailId=0){
		$where = array();
		if($CostItemCode){
			$where[] = "t1.CostItemCode = '".$CostItemCode."'";
		}
		if($PrjID){
			$where[] = "t2.PrjId = '".$PrjId."'";
		}
		if($PrjActId){
			$where[] = "t1.PrjActId= '".$PrjActId."'";
		}
		
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId= '".$PrjDetailId."'";
		}

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.* "
				."\n from tblbudget_project_activity_cost_internal as t1 "
				."\n left join tblbudget_project_activity as t2 on t2.PrjActId=t1.PrjActId"
				."\n left join tblbudget_project_detail as t3 on t3.PrjDetailId=t2.PrjDetailId"
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();//ltxt::print_r($data);
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getListCostItem */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายงบแผ่นดิน *4  */
	function getListCostItem($CostItemCode=0){
		$where = array();
		$where[] = "CostItemCode = '".$CostItemCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_init_cost_item "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */
	
	function getTotalPrjInternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjCode="",$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostIntId=0){
		return $this->dpublic->getTotalPrjInternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjCode,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostIntId);
	}
	
		/* START  06*/
	/* Function Name: getPItemCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงนโยบายแผนงาน */
	function getPItemCode($PItemCode=0){
		$where = array();
		$where[] = "PItemCode = '".$PItemCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PItemName "
				."\n from tblbudget_init_plan_item "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getOrgName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	function getOrgName($BgtYear=0, $OrganizeCode=0){
		$where = array();
		$where[] = "BgtYear = '".$BgtYear."'";
		$where[] = "OrganizeCode = '".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select OrgName "
				."\n from tblbudget_init_year_org "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/*
	Function Name	: getTaskPerson 
	Description		: เป็นฟังก์ชันสำหรับดึงผู้รับผิดชอบโครงการ
	Parameter		:-
	Return Value 	: Array(loadObjectList) 
	*/		

	function getTaskPerson($PrjId,$view='')
	{
		$where = array();
		
		if($view){
		$where[] = "PP.ResultStatus = '".$view."' ";
		}
		
		//if($PrjCode){
		$where[] = "PP.PrjId = '".$PrjId."' ";
		//}
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "SELECT P.PersonalCode,
					CONCAT(PR.PrefixName,
					P.FirstName,' ',
					P.LastName) as Name,
					PP.ResultStatus,
					PP.PersonId
					FROM
					tblbudget_project_person AS PP
					Inner Join tblpersonal AS P ON PP.PersonalCode = P.PersonalCode
					Inner Join tblpersonal_prefix AS PR ON PR.PrefixId = P.PrefixId "
					."\n ".$where_r;
					
					//where PP.PrjCode='$PrjCode' ";
		//echo "<pre>$sql</pre>";			
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	
	/* END */	
	
	/* START  06*/
	/* Function Name: getListCheck */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลการตรวจสอบ */
	function getListCheck($PrjDetailId){
		$sql="SELECT * FROM tblbudget_project_check where PrjDetailId='".$PrjDetailId."' order by PrjDetailId";
		$this->db->setQuery($sql);
		$data=$this->db->loadObjectList();	//ltxt::print_r($row);
		return $data;
	}
	/* END */
	
	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjCode="",$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjCode,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	
		/*START #F9
	Function Name	: getPItemName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อแผนงาน สช
	Parameter		:
		@$PItemCode = รหัสแผนงาน สช
	Return Value 	: Single(loadResult) 
	*/		
	function getPItemName($PItemCode){
		$where = array();
		$where[] = "PItemCode = '".$PItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PItemName "
				."\n from tblbudget_init_plan_item "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	
	
	function getProjectYearDetail($PrjId){
		$where 	  = array();
		if($PrjId){
			$where[] ="PrjId='".$PrjId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_project ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	
	/* Function Name: getIndTypeName */
	/* Description: เป็นฟังชั่นสำหรับดึงชื่อประเภทตัวชี้วัด
	/* Parameter: */
			/* @IndTypeId 		= รหัสประเภทตัวชี้วัด */
	/* Return Single */
	function  getIndTypeName($IndTypeId){
		$where = array();
		$where[] = "IndTypeId = '".$IndTypeId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select IndTypeName "
				."\n from tblbudget_init_indicator_type  "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	
	
	/* START   */
	/* Function Name: getOrgNameAct */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงานรับผิดชอบกิจกรรม */
	function getOrgNameAct($OrganizeCode=0){
		$where = array();
		$where[] = "OrganizeCode = '".$OrganizeCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select OrgName "
				."\n from tblbudget_init_year_org "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getUnitName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยนับ */
		function getUnitName($UnitId=0){
		$where = array();
		$where[] = "UnitID = '".$UnitId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select UnitName "
				."\n from tblunit "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
		}
	/* END */
	
	function getBGTotalInternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0){
		return $this->dpublic->getBGTotalInternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId);
	}
	
	function getBGTotalExternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0,$SourceExId=0){
		return $this->dpublic->getBGTotalExternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId,$SourceExId);
	}
	
	
	/* START  */
	/* Function Name:  getSourceName */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแหล่งเงิน*/
	function getSourceName(){
		$where = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select SourceExName, SourceExId "
				."\n from tblbudget_init_source_external "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */

	function getTotalPrjExternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostExtId=0){
		return $this->dpublic->getTotalPrjExternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostExtId);
	}
	
		/* START  */
	/* Function Name: getItemRequireExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายเงินนอกงบประมาณ *4  */
	function getItemRequireExternal($CostItemCode=0,$PrjActId=0,$PrjId=0,$PrjDetailId=0,$SourceExId=0){
		$where = array();
		if($CostItemCode){
			$where[] = "t1.CostItemCode = '".$CostItemCode."'";
		}
		if($PrjID){
			$where[] = "t2.PrjId = '".$PrjId."'";
		}
		if($PrjActId){
			$where[] = "t1.PrjActId= '".$PrjActId."'";
		}
		
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId= '".$PrjDetailId."'";
		}
		
		if($SourceExId){
			$where[] = "t1.SourceExId= '".$SourceExId."'";
		}		

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.* "
				."\n from tblbudget_project_activity_cost_external as t1 "
				."\n left join tblbudget_project_activity as t2 on t2.PrjActId=t1.PrjActId"
				."\n left join tblbudget_project_detail as t3 on t3.PrjDetailId=t2.PrjDetailId"
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();//ltxt::print_r($data);
		return $data;
	}
	/* END */






	
	/*--------------END view project--------------*/
	
	
	
	/*--------------view plan--------------*/
	
	function getPlanDetail($PItemCode){
		$where 	  = array();
		if($PItemCode){
			$where[] ="PItemCode='".$PItemCode."'";
		}

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_plan_item".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	
	/*
	Function Name: getPlanLongtermSelect 
	Description		: เป็นฟังก์ชันสำหรับดึงแผนงานต่อเนื่องที่มีการเลือก
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
	*/	
	function getPlanLongtermSelect($PItemCode)
	{
		$sql="select PSelectId,PLongCode from tblbudget_plan_select where PItemCode='$PItemCode' ";
		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		$Arr = array();
		foreach($data as $v){
			$Arr[] = $v->PLongCode;
		}
		return $Arr;
	}	
	/*END*/	

	
	
	/*--------------END view plan--------------*/
	
	
	
	/*--------------view activity--------------*/
	
	
	/* START  */
	/* Function Name: getPrjName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อโครงการ */
	function getPrjName($PrjId=0){
		$where = array();
		$where[] = "PrjId = '".$_REQUEST['PrjId']."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PrjName "
				."\n from tblbudget_project "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
		/* START  */
	/* Function Name:  getActName */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแหล่งเงินนอกงบประมาณ*/
	function getActName($PrjActId=0){
		$where = array();
		$where[] = "PrjActId = '".$_REQUEST['PrjActId']."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PrjActName "
				."\n from tblbudget_project_activity "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
		/* START  */
	/* Function Name: getIndicatorActSelect */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของกิจกรรม*/
	function getIndicatorActSelect($PrjActId=0){
		$sql = "select t1.PrjActIndId,t1.IndicatorName,t1.Value,t1.UnitID,t3.UnitName,t1.IndTypeId "
				."\n from tblbudget_project_activity_indicator as t1 "
				."\n left join tblunit as t3 on t3.UnitID=t1.UnitID "
				."\n where t1.PrjActId='".$PrjActId."'"
				."\n order by PrjActIndId ASC  "
				;
		//echo "<pre>$sql</pre>";	
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */	


	
	/*--------------END view activity--------------*/
	
	
	function getBudgetRemainForm($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0){//งบตัดจ่าย

		return $this->dpublic->getBudgetRemainForm($BgtYear,$SourceType,$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode,$CostTypeId,$CostItemCode);
	}

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
