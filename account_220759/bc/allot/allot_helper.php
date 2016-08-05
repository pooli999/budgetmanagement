<?php

class sHelper
{
	var $dpublic;
	var $db;
	var $debug = 0;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
		$this->dpublic		= new BGPublic();
	}
	
	function getQueryString(){
		$expStr = explode("&",$_SERVER['QUERY_STRING']);
		unset($expStr[0]);
		$impStr = implode("&",$expStr);
		if($impStr){
			$impStr = "&".$impStr;
		}
		return $impStr;
	}

	function getData($table,$field,$value){
		$sql="select * from ".$table." where ".$field." = ".$value."";
		$this->db->setQuery($sql);
		$row = $this->db->loadObjectList();
		return $row;
	}
	
/*	function getMaxScreenLevel(){
		return $this->dpublic->getMaxScreenLevel();
	}*/	
	
	function getScreenByLevel($BgtYear=0,$Level=0){
		return $this->dpublic->getScreenByLevel($BgtYear,$Level);
	}
		
	function getMaxLevel($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->getMaxLevel($BgtYear,$SCTypeId);
	}
		
	function getYear($Year,$ObjYear){
		return $this->dpublic->getYear($Year,$ObjYear);
	}
	
	function  getPrjName($PrjId){
		return $this->dpublic->getPrjName($PrjId);
	}
	
	function getPrjActName($PrjActId){
		return $this->dpublic->getPrjActName($PrjActId);
	}	

	function getOrganizeCode($BgtYear=0, $selected=0,$tag_name='OrganizeCode',$tag_attribs='onchange="getfilterorg()"',$lebel='เลือก'){
		return $this->dpublic->getOrganizeCode($BgtYear, $selected,$tag_name,$tag_attribs,$lebel);
	}

	function getCountSubSCType($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->getCountSubSCType($BgtYear,$SCTypeId);
	}	
	
	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
			return $this->dpublic->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	
	function getSCTypeCurOrg($BgtYear=0,$OrganizeCode=0){
		return $this->dpublic->getSCTypeCurOrg($BgtYear,$OrganizeCode);
	}
	
	function getNextSCType($SCTypeId=0, $ScreenLevel=0){
		return $this->dpublic->getNextSCType($SCTypeId, $ScreenLevel);
	}
	
	function getProjectScreenType($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0){
		return $this->dpublic->getProjectScreenType($BgtYear, $OrganizeCode, $SCTypeId, $ScreenLevel);
	}
	
	function getOrganizeName($OrganizeCode=0){
		return $this->dpublic->getOrganizeName($OrganizeCode);
	}
	

	function getCostTypeRecordSet(){
		return $this->dpublic->getCostTypeRecordSet();
	}
	
	function getCostItemRecordSet($CostTypeId=0,$LevelId=1,$ParentCode=0,$HasChild=0,$CostItemCode=0){
		return $this->dpublic->getCostItemRecordSet($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	}
	
	function getBGAllotInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		return $this->dpublic->getBGAllotInternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$PrjDetailId,$PrjActId,$PrjActCode);
	}	
	

	function getBGTotalInternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0){
		return $this->dpublic->getBGTotalInternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId);
	}	
	
/*	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}*/
	
	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}	
	
	function countScreenLevel($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->countScreenLevel($BgtYear,$SCTypeId);
	}
		
	function getBGAllotExternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){	
		return $this->dpublic->getBGAllotExternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$SourceExId,$PrjDetailId,$PrjActId,$PrjActCode);
	}
	
/*	function getBGTotalExternal($BgtYear=0,$OrganizeCode=0,$AllotId=0,$CostTypeId=0,$CostItemCode=0,$ScreenLevel=0,$SCTypeId=0,$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		return $this->dpublic->getBGTotalExternal($BgtYear,$OrganizeCode,$AllotId,$CostTypeId,$CostItemCode,$ScreenLevel,$SCTypeId,$SourceExId,$PrjDetailId,$PrjActId,$PrjActCode);
	}*/
	
	function getBGTotalExternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0,$SourceExId=0){
		return $this->dpublic->getBGTotalExternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId,$SourceExId);
	}	
	
	
	function getScreenLevel($BgtYear=0,$OrganizeCode=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){  
		return $this->dpublic->getScreenLevel($BgtYear,$OrganizeCode,$PrjDetailId,$PrjActId,$PrjActCode);
	}
	
	function getTotalBGAllotInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		return $this->dpublic->getTotalBGAllotInternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$PrjDetailId,$PrjActId,$PrjActCode);
	}
	
	function getTotalBGAllotEnternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		return $this->dpublic->getTotalBGAllotEnternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$SourceExId,$PrjDetailId,$PrjActId,$PrjActCode);
	}	
	
	function getTotalBGIncreaseInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		return $this->dpublic->getTotalBGIncreaseInternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$PrjDetailId,$PrjActId,$PrjActCode);
	}
	
	
	function getTotalBGIncreaseExternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		return $this->dpublic->getTotalBGIncreaseExternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$SourceExId,$PrjDetailId,$PrjActId,$PrjActCode);
	}
	
	
	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	
/*	function getTotalAllotPrj($BgtYear=0,$OrganizeCode=0,$AllotId=0,$CostTypeId=0,$CostItemCode=0,$ScreenLevel=0,$SCTypeId=0,$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		return $this->dpublic->getTotalAllotPrj($BgtYear,$OrganizeCode,$AllotId,$CostTypeId,$CostItemCode,$ScreenLevel,$SCTypeId,$SourceExId,$PrjDetailId,$PrjActId,$PrjActCode);
	}*/
	
	function getTotalAllotPrj($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0,$SourceExId=0){
		return $this->dpublic->getTotalAllotPrj($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId,$SourceExId);
	}
	
/*
	function getCostItemDataSet($CostTypeId=0,$LevelId=1,$ParentCode=0){
		return $this->dpublic->getCostItemDataSet($CostTypeId,$LevelId,$ParentCode);
	}*/
	
	
	/* START #F1 */
	/* Function Name: getProjectScreenType */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการตามขึ้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
		/* @BgtYear	= ปีงบประมาณ */
		/* @OrganizeCode	= 	หน่วยงาน */
		/* @SCTypeId	= ขึ้นตอนการจัดทำงบประมาณ */
		/* @ScreenLevel	= ระดับการกลั่นกรองงบ*/
	/* Return Value : Array(loadObjectList) */

/*	function getProjectScreenType($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0){
		
		$where = array();
		
		if($_REQUEST["BgtYear"]){
			$where[] = "t2.BgtYear='".$_REQUEST["BgtYear"]."'";
		}

		if($_REQUEST["OrganizeCode"]){
			$where[] = "t2.OrganizeCode='".$_REQUEST["OrganizeCode"]."'";
		}		
		
		if($_REQUEST["SCTypeId"]){
			$where[] = "t1.SCTypeId='".$_REQUEST["SCTypeId"]."'";
		}
		
		if($_REQUEST["ScreenLevel"]){
			$where[] = "t1.ScreenLevel='".$_REQUEST["ScreenLevel"]."'";
		}	
		
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT "
		."\n t1.StatusId, "
		."\n t1.PrjDetailId, "
		."\n t2.PrjId, "
		."\n t2.PrjCode, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		."\n ".$where_r
		;
		
		//echo $sql;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;	

	}*/
	/* END */
	
		/* START #F2 */
	/* Function Name: getCheckStatusProject */
	/* Description: เป็นฟังก์ชันสำหรับตรวจสอบสถานะโครงการ = 4 (ผ่านการตรวจสอบ) */
	/* Parameter: */
		/* @BgtYear	= ปีงบประมาณ */
		/* @OrganizeCode	= 	หน่วยงาน */
		/* @SCTypeId	= ขึ้นตอนการจัดทำงบประมาณ */
		/* @ScreenLevel	= ระดับการกลั่นกรองงบ*/
	/* Return Value : single(loadResult) */

	function getCheckStatusProject($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0){
		
		$where = array();
		
		if($_REQUEST["BgtYear"]){
			$where[] = "t2.BgtYear='".$_REQUEST["BgtYear"]."'";
		}

		if($_REQUEST["OrganizeCode"]){
			$where[] = "t2.OrganizeCode='".$_REQUEST["OrganizeCode"]."'";
		}		
		
		if($_REQUEST["SCTypeId"]){
			$where[] = "t1.SCTypeId='".$_REQUEST["SCTypeId"]."'";
		}
		
		if($_REQUEST["ScreenLevel"]){
			$where[] = "t1.ScreenLevel='".$_REQUEST["ScreenLevel"]."'";
		}	
		
		$where[] = "t1.StatusId= 4 ";
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT "
		."\n count(t1.StatusId) "
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		."\n ".$where_r
		;
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;		
	}
	/* END */
	
	/* START #F3 */
	/* Function Name: getSCTypeName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อขั้นตอนการจัดทำงบประมาณ  */
	/* Parameter: */
			/* @SCTypeId	= ID ขั้นตอนการจัดทำงบประมาณ */
	/* Return Value : Single(loadResult) */
	function getSCTypeName($SCTypeId=0){
		
		//$SCTypeId = ($_REQUEST["SCTypeId"])?$_REQUEST["SCTypeId"]:$SCTypeId;		
		
		$where = array();
		
		$where[] = "t1.SCTypeId='".$SCTypeId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.SCTypeName"
		."\n FROM "
		."\n tblbudget_init_screen_type AS t1  "
		."\n ".$where_r
		;
		//echo $sql;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	
	
/*	function getSCTypeName($SCTypeId=0){	
		return $this->dpublic->getSCTypeName($SCTypeId);
	}*/	
	
	/* START #F4 */
	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อระดับการกลั่นกรอง  */
	/* Parameter: */
			/* @ScreenLevel	= ระดับการกลั่นกรอง */
	/* Return Value : Single(loadResult) */
	function getScreenName($ScreenLevel=0){
		
		//$ScreenLevel = ($_REQUEST["ScreenLevel"])?$_REQUEST["ScreenLevel"]:$ScreenLevel;		
		
		$where = array();
		
		$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.ScreenName"
		."\n FROM "
		."\n tblbudget_init_screen_item AS t1  "
		."\n ".$where_r
		;
		//echo $sql;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	
	
	
	/* START #F5 */
	/* Function Name: getAllotDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดข้อมูลกลั่นกรอง */
	/* Parameter: */
	/* @BgtYear	= ปีงบประมาณ */
	/* Return Value : single(loadResult) */
	function getAllotDetail($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}		
		
		if($PrjActId){
			$where[] = "t1.PrjActId='".$PrjActId."'";
		}	
		
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}	
							
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT  t1.* "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */	
	
	function getPrjList($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0){
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT  t2.*  "
					."\n FROM "
					."\n tblbudget_project as t1 "
					."\n Inner join tblbudget_project_detail as t2 on t2.PrjId=t1.PrjId "
					/*."\n Inner join tblbudget_project_activity as t3 on t3.PrjDetailId=t2.PrjDetailId "
					."\n Inner join tblbudget_project_activity_cost_external as t4 on t4.PrjActId=t3.PrjActId "
					."\n Inner join tblbudget_project_activity_cost_external_month as t5 on t5.CostExtId=t4.CostExtId "
					."\n Inner join tblbudget_project_activity_cost_internal as t6 on t6.PrjActId=t3.PrjActId "
					."\n Inner join tblbudget_project_activity_cost_internal_month as t7 on t7.CostIntId=t6.CostIntId "*/
					."\n ".$where_r
				;
				
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	
	function getPrjActList($PrjDetailId=0,$BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0){
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($PrjDetailId){
			$where[] = "t3.PrjDetailId='".$PrjDetailId."'";
		}
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT  t3.*  "
					."\n FROM "
					."\n tblbudget_project as t1 "
					."\n Inner join tblbudget_project_detail as t2 on t2.PrjId=t1.PrjId "
					."\n Inner join tblbudget_project_activity as t3 on t3.PrjDetailId=t2.PrjDetailId "
					/*."\n Inner join tblbudget_project_activity_cost_external as t4 on t4.PrjActId=t3.PrjActId "
					."\n Inner join tblbudget_project_activity_cost_external_month as t5 on t5.CostExtId=t4.CostExtId "
					."\n Inner join tblbudget_project_activity_cost_internal as t6 on t6.PrjActId=t3.PrjActId "
					."\n Inner join tblbudget_project_activity_cost_internal_month as t7 on t7.CostIntId=t6.CostIntId "*/
					."\n ".$where_r
				;
				
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	
	
	
	function getPrjX4InternalList($PrjActId=0,$BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0){
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($PrjActId){
			$where[] = "t4.PrjActId='".$PrjActId."'";
		}
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT  t4.*  "
					."\n FROM "
					."\n tblbudget_project as t1 "
					."\n Inner join tblbudget_project_detail as t2 on t2.PrjId=t1.PrjId "
					."\n Inner join tblbudget_project_activity as t3 on t3.PrjDetailId=t2.PrjDetailId "
					."\n Inner join tblbudget_project_activity_cost_internal as t4 on t4.PrjActId=t3.PrjActId "
					//."\n Inner join tblbudget_project_activity_cost_internal_month as t7 on t7.CostIntId=t6.CostIntId "*/
					."\n ".$where_r
				;
				
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	
	
	function getListInternalMonth($CostIntId=0,$BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0){
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($CostIntId){
			$where[] = "t5.CostIntId='".$CostIntId."'";
		}
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT  t5.*  "
					."\n FROM "
					."\n tblbudget_project as t1 "
					."\n Inner join tblbudget_project_detail as t2 on t2.PrjId=t1.PrjId "
					."\n Inner join tblbudget_project_activity as t3 on t3.PrjDetailId=t2.PrjDetailId "
					."\n Inner join tblbudget_project_activity_cost_internal as t4 on t4.PrjActId=t3.PrjActId "
					."\n Inner join tblbudget_project_activity_cost_internal_month as t5 on t5.CostIntId=t4.CostIntId "
					."\n ".$where_r
				;
				
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	
	
	
	function getPrjX4ExnternalList($PrjActId=0,$BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0){
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($PrjActId){
			$where[] = "t4.PrjActId='".$PrjActId."'";
		}
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT  t4.*  "
					."\n FROM "
					."\n tblbudget_project as t1 "
					."\n Inner join tblbudget_project_detail as t2 on t2.PrjId=t1.PrjId "
					."\n Inner join tblbudget_project_activity as t3 on t3.PrjDetailId=t2.PrjDetailId "
					."\n Inner join tblbudget_project_activity_cost_external as t4 on t4.PrjActId=t3.PrjActId "
					."\n ".$where_r
				;
				
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}	
	
	
	function getListExternalMonth($CostExtId=0,$BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0){
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($CostExtId){
			$where[] = "t5.CostExtId='".$CostExtId."'";
		}
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT  t5.*  "
					."\n FROM "
					."\n tblbudget_project as t1 "
					."\n Inner join tblbudget_project_detail as t2 on t2.PrjId=t1.PrjId "
					."\n Inner join tblbudget_project_activity as t3 on t3.PrjDetailId=t2.PrjDetailId "
					."\n Inner join tblbudget_project_activity_cost_external as t4 on t4.PrjActId=t3.PrjActId "
					."\n Inner join tblbudget_project_activity_cost_external_month as t5 on t5.CostExtId=t4.CostExtId "
					."\n ".$where_r
				;
				
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}	
	
	
	/* START  */
	/* Function Name:  getSourceExName */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแหล่งเงิน*/
	function getSourceExName(){
		$where = array();
		$where[] = "EnableStatus='Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select SourceExId,SourceExName "
				."\n from tblbudget_init_source_external "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */
	
	
	#######################  ดึงรายละเอียดโครงการ  #########################
	
	/* START  */
	/* Function Name: getProjectDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดโครงการ */
	function getProjectDetail($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0, $PrjId=0,$PrjDetailId=0){
		
/*		echo "<br>SCTypeId=".$SCTypeId;
		echo "<br>ScreenLevel=".$ScreenLevel;
		echo "<br><br>";*/
		
		$where = array();
		
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}

		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}		
		
		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}	
		
		if($PrjId){
		$where[] = "t1.PrjId='".$PrjId."'";
		}	
		
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
		."\n t2.BgtYear, "
		."\n t2.OrganizeCode, "
		."\n t3.StatusId as StatusProject, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "			
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "
		."\n ".$where_r
		;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;

	}
	/* END */
	
	/* START  */
	/* Function Name: getOrgName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	function getOrgName($BgtYear=0,$OrganizeCode=0){
		$where = array();
		$where[] = "OrgYear = '".$BgtYear."'";
		$OrganizeCode = ($_REQUEST['OrganizeCode'])?$_REQUEST['OrganizeCode']:$OrganizeCode;
		$where[] = "OrganizeCode = '".$OrganizeCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select OrgName "
				."\n from tblorganize "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getIndicator */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัด*/

	function getIndicator($PrjDetailId=0){
		$sql = "select t1.*,t2.IndName,t3.UnitName "
				."\n from tblbudget_project_indicator as t1 "
				."\n left join tblbudget_init_indicator as t2 on t2.IndId=t1.IndId "
				."\n left join tblunit as t3 on t3.UnitID=t1.UnitId "
				."\n where t1.PrjDetailId='".$PrjDetailId."'"
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */
	
	function getProjectDetailActRecordSet($PrjDetailId=0){
		return $this->dpublic->getProjectDetailActRecordSet($PrjDetailId);
	}	




	/* START  */
	/* Function Name: getStatusChk */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการตามขึ้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
		/* @BgtYear	= ปีงบประมาณ */
		/* @OrganizeCode	= 	หน่วยงาน */
		/* @SCTypeId	= ขึ้นตอนการจัดทำงบประมาณ */
		/* @ScreenLevel	= ระดับการกลั่นกรองงบ*/
	/* Return Value : Array(loadObjectList) */

	function getStatusChk($PrjDetailId=0){
		
		$where = array();
		
		if($_REQUEST["PrjDetailId"]){
			$where[] = "t1.PrjDetailId='".$_REQUEST["PrjDetailId"]."'";
		}		
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT "
		."\n t1.StatusId, "
		."\n t2.StatusName, "
		."\n t2.TextColor, "
		."\n t2.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n inner Join tblbudget_init_status as t2 on t2.StatusId = t1.StatusId "		
		."\n ".$where_r
		;
		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;	

	}
	/* END */

	/* START  */
	/* Function Name: getListCostItem */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายงบแผ่นดิน *4  */
	function getListCostItem($CostItemCode=0){
		$where = array();
		$where[] = "CostItemCode = '".$_REQUEST['CostItemCode']."'";
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

	
	/* START  */
	/* Function Name: getItemRequireInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายงบแผ่นดิน *4  */
	function getItemRequireInternal($CostItemCode=0,$PrjActId=0,$PrjId=0,$PrjDetailId=0){
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

	/* START #F */
	/* Function Name: getSCTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getSCTypeRecordSet(){
		
		$where = array();
		
		$where[] = "SCTypeId in(2,3,4)";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT SCTypeId, SCTypeName, SCTypeName2 "
				."\n FROM "
				."\n tblbudget_init_screen_type "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */

	
	/* START 01 */
	/* Function Name: getProjectSCType */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการตามปีงบประมาณของหน่วยงาน */
	/* Parameter: -*/
	/* Return Value : Array(loadObjectList) */
	
	//ดึงโครงการตาม  SCTypeId ปัจจุบันของมัน
	function getProjectSCType($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0){
		
		$where = array();
		
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
	
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}

		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}		
		
		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}	
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}					
				
		//$where[] = "t1.SCTypeId in(4,5)";
		//$where[] = "t1.ActiveStatus ='Y' ";

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT "
		."\n t1.StatusId, "
		."\n t1.PrjDetailId, "
		."\n t1.SCTypeId, "
		."\n t1.ScreenLevel, "
		."\n t2.OrganizeCode, "
		."\n t2.PrjId, "
		."\n t2.PrjCode, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		."\n ".$where_r
		."\n order by t1.PrjCode  "
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();//ltxt::print_r($datas);
		return $datas;

	}
	
	//ดึงโครงการตาม SCTypeId ก่อนหน้า
	/*function getProjectSCType($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0,$PrjId=0){
		
			//นับระดับการกลั่นกรองงบ
			$maxScreenLevel = $this->getMaxLevel($BgtYear,$SCTypeId);
			//echo "maxScreenLevel=".$maxScreenLevel."<br>";

			if(($SCTypeId == 2 || $SCTypeId == 4 ) && $ScreenLevel == 1){
				$SCTypeIdbg = $SCTypeId-1;
				$ScreenLevelbg = 0;
				//echo "SCTypeIdbg=".$SCTypeIdbg."<br>";
				//echo "ScreenLevelbg=".$ScreenLevelbg."<br>";
				
			}else if(($SCTypeId == 2 || $SCTypeId == 4 ) && $ScreenLevel > 1 && $ScreenLevel <= $maxScreenLevel){
				$SCTypeIdbg = $SCTypeId;
				$ScreenLevelbg = $ScreenLevel-1;	
				//echo "SCTypeIdbg=".$SCTypeIdbg."<br>";
				//echo "ScreenLevelbg=".$ScreenLevelbg."<br>";
						
			}else if($SCTypeId == 3){
				$SCTypeIdbg = $SCTypeId-1;
				//นับระดับการกลั่นกรองงบ
				$maxScreenLevel = $this->getMaxLevel($BgtYear,$SCTypeIdbg);
				$ScreenLevelbg = $maxScreenLevel;	
			}
		
		
		$where = array();
		
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
	
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}

		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}		
		
		if($SCTypeIdbg){
			$where[] = "t1.SCTypeId='".$SCTypeIdbg."'";
		}	
		
		if($ScreenLevelbg){
			$where[] = "t1.ScreenLevel='".$ScreenLevelbg."'";
		}					
				
		//$where[] = "t1.SCTypeId in(4,5)";
		//$where[] = "t1.ActiveStatus ='Y' ";

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT "
		."\n t1.StatusId, "
		."\n t1.PrjDetailId, "
		."\n t1.SCTypeId, "
		."\n t1.ScreenLevel, "
		."\n t2.OrganizeCode, "
		."\n t2.PrjId, "
		."\n t2.PrjCode, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		."\n ".$where_r
		;
		echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}*/
	/* END */
	
	/* START 02 */
	/* Function Name: getOrgShortName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	function getOrgShortName($BgtYear=0, $OrganizeCode=0){
		$where = array();
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}		
		$where[] = "OrgYear = '".$BgtYear."'";
		$where[] = "OrganizeCode='".$OrganizeCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select OrgShortName "
				."\n from tblorganize "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */

	/* START 03 */
	/* Function Name: getActivity */
	/* Description: เป็นฟังก์ชันสำหรับดึงกิจกรรมโครงการ */
	function getActivity($PrjDetailId=0,$PrjActId=0,$PrjId=0,$OrgCode=0,$BgtYear=0){
		$where = array();
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}	
		
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId = '".$PrjDetailId."'";
		}	
		
		if($PrjActId){
			$where[] = "t1.PrjActId = '".$PrjActId."'";
		}		
		
		if($PrjId){
			$where[] = "t3.PrjId = '".$PrjId."'";
		}	
		
		if($OrgCode){
			$where[] = "t3.OrganizeCode = '".$OrgCode."'";
		}	
		
		if($BgtYear){
			$where[] = "t3.BgtYear = '".$BgtYear."'";
		}	
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
				$sql="SELECT "
				."\n t1.PrjActId, "	
				."\n t1.PrjActCode, "	
				."\n t1.OrganizeCode AS ActOrganizeCode, "	
				."\n t1.PrjActName, "	
				."\n t1.PrjDetailId, "	
				."\n t3.BgtYear, "	
				."\n t3.PrjName, "	
				."\n t3.OrganizeCode AS PrjOrganizeCode "	
				."\n from tblbudget_project_activity AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2  ON t1.PrjDetailId = t2.PrjDetailId"
				."\n Inner Join tblbudget_project AS t3 ON t2.PrjId = t3.PrjId "
				//."\n Inner Join tblbudget_project_activity_cost_internal AS t4 ON t1.PrjActId = t4.PrjActId "
				//."\n Inner Join tblbudget_project_activity_cost_external AS t5 ON t1.PrjActId = t5.PrjActId "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */

		
	/* START  */
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
	/* Function Name: getTaskPerson */
	/* Description: เป็นฟังก์ชันสำหรับดึงผู้รับผิดชอบโครงการ */	
/*	function getTaskPerson($PrjDetailId)
	{
		$sql = "SELECT P.PersonalCode,
					CONCAT(PR.PrefixName,
					P.FirstName,' ',
					P.LastName) as Name 
					FROM
					tblbudget_project_person AS PP
					Inner Join tblpersonal AS P ON PP.PersonalCode = P.PersonalCode
					Inner Join tblpersonal_prefix AS PR ON PR.PrefixId = P.PrefixId 
					where PP.PrjDetailId='$PrjDetailId' ";
		//echo "<pre>$sql</pre>";			
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	
*/	/* END */



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

	
	/* START  */
	/* Function Name: getIndicator */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของโครงการ*/
	function getIndicatorSelect($PrjDetailId=0){
		$sql = "select t1.*,t3.UnitName "
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
	
	
	/* START  */
	/* Function Name: getSCRName */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณปัจจุบันของแต่ละหน่วยงาน  */
	/* Parameter: */
			/* @BgtYear			= ปีงบประมาณ */
			/* @OrganizeCode 	= รหัสหน่วยงาน */
	/* Return Value : Array(loadObjectList) */
	function getSCRName($BgtYear=0,$OrganizeCode=0){
		
		$where = array();
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n t1.ScreenLevel,t3.ScreenName "
				."\n FROM "
				."\n tblbudget_init_year_org AS t1 "
				."\n Inner Join tblbudget_init_screen_type AS t2 ON t1.SCTypeId = t2.SCTypeId "
				."\n Inner Join tblbudget_init_screen_item AS t3 ON t3.ScreenLevel = t1.ScreenLevel "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	

/* START #F49 */
	/* Function Name: getTotalPrjInternalX4Main */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjInternalX4Main($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjId){
			$where[] = "t1.PrjId='".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		
		$where[] = "t2.StatusId != 5 ";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t4.SumCost)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_internal AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n ".$where_r
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START #F50 */
	/* Function Name: getTotalPrjExternalX4Main */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjExternalX4Main($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjId){
			$where[] = "t1.PrjId='".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if($SourceExId){
			$where[] = "t4.SourceExId='".$SourceExId."'";
		}
		
		$where[] = "t2.StatusId != 5 ";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t4.SumCost)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_external AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n Inner Join tblbudget_init_source_external AS t8 ON t8.SourceExId = t4.SourceExId "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}

	/* END */
	
	/* START #F51 */
	/* Function Name: getTotalPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ+เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */	

	function getTotalPrjMain($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		$BgtYear = ($BgtYear)?$BgtYear:(date("Y")+543);
		$BGInt		= $this->getTotalPrjInternalX4Main($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$BGExt		= $this->getTotalPrjExternalX4Main($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		
		$BGTotal	= $BGInt+$BGExt;
		return $BGTotal;
	}
	/* END */		
	
	function getTotalPrjInternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostIntId=0){
		return $this->dpublic->getTotalPrjInternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostIntId);
	}
	
	function getTotalPrjExternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostExtId=0){
		return $this->dpublic->getTotalPrjExternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostExtId);
	}
	
	
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
	/* Function Name: getIndicator */
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
	
	
	///--------------------------------------------------------------------------------------------------------------
	/* START #F9 */
	/* Function Name: getScreenRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงระดับการกลั่นกรองงบแต่ละปีงบประมาณ  */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getScreenRecordSet($BgtYear=0){
		$where = array();
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.EnableStatus='Y'";
		$where[] = "t1.DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.ScreenId, t1.ScreenLevel ,t1.ScreenName,t1.SCTypeId,t2.SCTypeName "
				."\n FROM "
				."\n tblbudget_init_screen_item as t1 "
				."\n left join tblbudget_init_screen_type as t2 on t2.SCTypeId=t1.SCTypeId "
				."\n ".$where_r
				."\n order by t1.ScreenLevel "
				;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}

	/* END */
	
	/* START #F9 */
	/* Function Name: getAllotList */
	/* Description: เป็นฟังก์ชันสำหรับดึงระดับการกลั่นกรองงบแต่ละปีงบประมาณ  */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getAllotList($BgtYear=0){
		$where = array();
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.EnableStatus='Y'";
		$where[] = "t1.DeleteStatus<>'Y'";
		$where[] = "t1.Allot='Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.ScreenId, t1.ScreenLevel ,t1.ScreenName,t1.SCTypeId,t2.SCTypeName "
				."\n FROM "
				."\n tblbudget_init_screen_item as t1 "
				."\n left join tblbudget_init_screen_type as t2 on t2.SCTypeId=t1.SCTypeId "
				."\n ".$where_r
				."\n order by t1.ScreenLevel "
				;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}

	/* END */
	
	function getCurProcess($BgtYear=0,$OrganizeCode=0){
		return $this->dpublic->getCurProcess($BgtYear,$OrganizeCode);
	}
	
	function getListScreenLevel($BgtYear=0){
		return $this->dpublic->getListScreenLevel($BgtYear);
	}
	
	function getNameByScreen($BgtYear=0,$ScreenLevel=0,$SCTypeId=0,$countScreenLevel=0){
		return $this->dpublic->getNameByScreen($BgtYear,$ScreenLevel,$SCTypeId,$countScreenLevel);
	}
	
	function getSourceNamePrj($PrjId){
		return $this->dpublic->getSourceNamePrj($PrjId);
	}
	
	function getOrgNameAct($BgtYear=0,$OrganizeCode=0){
		return $this->dpublic->getOrgNameAct($BgtYear,$OrganizeCode);
	}
	
	function getListCheck($PrjDetailId){
		return $this->dpublic->getListCheck($PrjDetailId);
	}

	///--------------------------------------------------------------------------------------------------------------
	function getTypeActName($TypeActCode){
		$where = array();
		$where[] = "TypeActCode = '".$TypeActCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select TypeActName  "
				."\n from tblbudget_init_type_activity "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult(); 
		return $data;
		
	}
	
	function getYearProject($selected=0,$tag_name='BgtYear',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
		$selected = ($selected)?$selected:(date("Y")+543);
		$where = array();
		$where[] = "BgtYear <> ' '";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(BgtYear)as value , BgtYear as text "
			 ."\n FROM tblbudget_init_screen_item "
			 ."\n ".$where_r
			 ."\n order by BgtYear desc"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}





	
}// end class
?>
