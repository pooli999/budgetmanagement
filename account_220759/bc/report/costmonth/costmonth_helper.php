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

	function getData($table,$field,$value){
		$sql="select * from ".$table." where ".$field." = ".$value."";
		$this->db->setQuery($sql);
		$row = $this->db->loadObjectList();
		return $row;
	}
	
	function getMaxLevel($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->getMaxLevel($BgtYear,$SCTypeId);
	}
	
	function getScreenByLevel($BgtYear=0,$Level=0){
		return $this->dpublic->getScreenByLevel($BgtYear,$Level);
	}

	
/*	function getMaxScreenLevel(){
		return $this->dpublic->getMaxScreenLevel();
	}*/
		
	function getSCTypeName($SCTypeId=0){	
		return $this->dpublic->getSCTypeName($SCTypeId);
	}
			
	function getYear($Year=0,$ObjYear=0){
		return $this->dpublic->getYear($Year,$ObjYear);
	}
	
	function getBGTotalInternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0){
		return $this->dpublic->getBGTotalInternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId);
	}	
	
	function getBGTotalExternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$SourceExId=0,$AllotId=0){
		return $this->dpublic->getBGTotalExternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$SourceExId,$AllotId);
	}	
	
	function getSCTypeCurOrg($BgtYear=0,$OrganizeCode=0){
		return $this->dpublic->getSCTypeCurOrg($BgtYear,$OrganizeCode);
	}

	function getProjectDetailIndRecordSet($PrjDetailId=0){
		return $this->dpublic->getProjectDetailIndRecordSet($PrjDetailId);
	}

	function getPlanItemList($BgtYear=0,$PGroupId=9,$selected=0,$tag_name='PItemCode',$tag_attribs='onchange="loadPrj(this.value)"',$lebel='เลือก'){

		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "PGroupId='".$PGroupId."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PItemCode as value , PItemName as text "
			 ."\n FROM tblbudget_init_plan_item "
			 ."\n ".$where_r
			 ."\n order by PItemCode ASC "
			  //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getProjectList($BgtYear=0,$PItemCode=0,$OrganizeCode=0,$tag_name='PrjCode',$selected=0,$tag_attribs='',$lebel='เลือก'){

		$where = array();
		
		$where[] = "t1.EnableStatus='Y'";
		$where[] = "t1.DeleteStatus='N'";	
		///if($OrganizeCode){
			//$where[] = " t1.OrganizeCode='".$OrganizeCode."'";
		//}			
		
		if($BgtYear){
			$where[] = " t1.BgtYear='".$BgtYear."' ";
		}
		if($PItemCode){
			$where[] = " t1.PItemCode='".$PItemCode."' ";
		}


		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PrjCode as value , PrjName as text "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_init_plan_item AS t2 ON t1.PItemCode = t2.PItemCode "
				//."\n Inner Join tblorganize AS t3 ON t1.BgtYear = t3.OrgYear AND t1.OrganizeCode = t3.OrganizeCode "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}

	function getOrganizeCode($BgtYear=0,$selected=0,$tag_name='OrganizeCode',$tag_attribs='',$lebel='เลือก'){
		
		$where = array();
		$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT OrganizeCode as value , OrgName as text "
			."\n FROM "
			."\n tblbudget_init_year_org  "
			//."\n Inner Join tblorganize AS t2 ON t1.OrganizeCode = t2.OrganizeCode AND t1.BgtYear = t2.OrgYear "
			."\n ".$where_r
			."\n ORDER BY CONVERT(OrgName USING TIS620) ASC "
			;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}

	function getIndProjectList($IndId=0){
		return $this->dpublic->getIndProjectList($IndId);
	}
	
	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0){
		return $this->dpublic->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId);
	}
	
	function getProjectDetailActRecordSet($PrjDetailId=0){
		return $this->dpublic->getProjectDetailActRecordSet($PrjDetailId);
	}

	function getIndProjectRecordSet($IndId=0){
		return $this->dpublic->getIndProjectRecordSet($IndId);
	}
////
	function getProjectDetailCheckRecordSet($PrjDetailId=0){
		return $this->dpublic->getProjectDetailCheckRecordSet($PrjDetailId);
	}
	//////	
	function getCostTypeRecordSet($CostTypeId=0){
		return $this->dpublic->getCostTypeRecordSet($CostTypeId);
	}
	
	function getCostItemRecordSet($CostTypeId=0,$LevelId=1,$ParentCode=0,$HasChild=0,$CostItemCode=0){
		return $this->dpublic->getCostItemRecordSet($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	}

	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}

	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}

	function getCountSubSCType($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->getCountSubSCType($BgtYear,$SCTypeId);
	}

	function getTotalAllotPrj($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0,$SourceExId=0){	
		return $this->dpublic->getTotalAllotPrj($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId,$SourceExId);
	}
	
	
/***************************************************************************************************************/
	/* START  */
	/* Function Name: getOrgName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	function getOrgName($BgtYear=0,$OrganizeCode=0){
		$where = array();
		$where[] = "t1.OrgYear='".$BgtYear."'";
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT concat(t1.OrgName,' (',t1.OrgShortName,')') "
			 ."\n FROM tblorganize as t1 "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START 02 */
	/* Function Name: getOrgShortName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	function getOrgShortName($BgtYear=0, $OrganizeCode=0){
		$where = array();
		$where[] = "OrgYear = '".$BgtYear."'";
		$where[] = "OrganizeCode = '".$OrganizeCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select OrgShortName "
				."\n from tblstructure_operation "
				."\n ".$where_r
				;
		//echo $sql;		
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */

	


	/* START 04 */
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
		."\n inner Join tblbudget_project_check as t2 on t3.PrjDetailId = t1.PrjDetailId "				
		."\n ".$where_r
		;
		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;	

	}
	/* END */

	/* START  F05*/
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
		
		if($_REQUEST["BgtYear"]){
			$where[] = "t4.BgtYear= '".$_REQUEST["BgtYear"]."'";
		}
		if($_REQUEST["PItemCode"]){
			$where[] = "t4.PItemCode= '".$_REQUEST["PItemCode"]."'";
		}
		$where[] = "t3.ActiveStatus = 'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.* "
				."\n from tblbudget_project_activity_cost_internal as t1 "
				."\n left join tblbudget_project_activity as t2 on t2.PrjActId=t1.PrjActId"
				."\n left join tblbudget_project_detail as t3 on t3.PrjDetailId=t2.PrjDetailId"
				."\n left join tblbudget_project as t4 on t4.PrjCode=t3.PrjCode"
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();//ltxt::print_r($data);
		return $data;
	}
	/* END */
	
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

	/* START  07 */
	/* Function Name: getActName */
	/* Description: เป็นฟังก์ชันสำหรับดึงกิจกรรม */
		function getActName($PrjDetailId=0,$selected=0,$tag_name='PrjActId',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
		$where = array();
		$where[] = "PrjDetailId = '".$PrjDetailId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PrjActId as value , PrjActName as text "
			."\n from tblbudget_project_activity "
			."\n ".$where_r
			 ;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}

	/* END */

	/* START 08 */
	/* Function Name: getAct */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายงบแผ่นดิน *4  */
	function getAct($CostItemCode=0,$PrjActId=0,$PrjId=0,$PrjDetailId=0){
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
		$sql = "select t1.PrjActId "
				."\n from tblbudget_project_activity_cost_internal as t1 "
				."\n left join tblbudget_project_activity as t2 on t2.PrjActId=t1.PrjActId"
				."\n left join tblbudget_project_detail as t3 on t3.PrjDetailId=t2.PrjDetailId"
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START  09 */
	/* Function Name: getCostDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงกิจกรรม */
		function getCostDetail($PrjActId=0,$selected=0,$tag_name='CostIntId',$tag_attribs='onchange="loadCost(this.value)"',$lebel='เลือก'){
		$where = array();
		$where[] = "PrjActId = '".$PrjActId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostIntId as value,Detail as text "
			."\n from tblbudget_project_activity_cost_internal "
			."\n ".$where_r
			;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
}
	/* END */

	/* START 10 */
	/* Function Name: getChkNo */
	/* Description: เป็นฟังก์ชันสำหรับดึงรอบการตรวจสอบโครงการ */
	function getChkNo($PrjDetailId=0){
		$where = array();
		$where[] = "PrjDetailId = '".$PrjDetailId."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(ChkNo) "
				."\n from tblbudget_project_check "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START 11 */
	/* Function Name: getMaxChk */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลการตรวจสอบโครงการล่าสุด */
	/* Parameter: */
			/* @PrjDetailId	= รหัสโครงการแต่ละชุดขั้นตอนฯ */
	/* Return Value : Array(loadObjectList) */
	function getMaxChk($PrjDetailId){
		$where = array();
		$where[] = "PrjDetailId='".$PrjDetailId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT max(ChkNo) "
				."\n FROM "
				."\n tblbudget_project_check "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
		
	}
	/* END */
	
	/* START 12 */
	/* Function Name: getdate */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลการตรวจสอบโครงการล่าสุด */
	/* Parameter: */
			/* @PrjDetailId	= รหัสโครงการแต่ละชุดขั้นตอนฯ */
	/* Return Value : Array(loadObjectList) */
	function getdate($PrjDetailId){
		$ChkNo=$this->getMaxChk($PrjDetailId);
		$where = array();
		$where[] = "PrjDetailId='".$PrjDetailId."'";
		$where[] = "ChkNo='".$ChkNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CreateDate "
				."\n FROM "
				."\n tblbudget_project_check "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
		
	}
	/* END */
	

	/* START  14 */
	/* Function Name: getCostDetailEx */
	/* Description: เป็นฟังก์ชันสำหรับดึงกิจกรรม */
		function getCostDetailEx($PrjActId=0,$SourceExId=0,$selected=0,$tag_name='CostExtId',$tag_attribs='onchange="loadCost(this.value)"',$lebel='เลือก'){
		$where = array();
		$where[] = "PrjActId = '".$PrjActId."'";
		$where[] = "SourceExId = '".$_REQUEST['SourceExId']."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostExtId as value,Detail as text "
			."\n from tblbudget_project_activity_cost_external "
			."\n ".$where_r
			;
			
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
}
	/* END */

/***************************************************************************************************************/

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
	/* Function Name: getUnit */
	/* Description: เป็นฟังก์ชันสำหรับดึงหน่วยนับ */
		function getUnit($selected=0,$tag_name='UnitID',$tag_attribs='',$lebel='เลือก'){
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select UnitID as value,UnitName as text "
			."\n from tblunit "
			."\n ".$where_r
			;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
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
	
	/* START  */
	/* Function Name: getStatus */
	/* Description: เป็นฟังก์ชันสำหรับดึงสถานะ */
	function getStatus($PrjId=0){
		$where = array();
		$where[] = "t2.PrjId = '".$PrjId."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.StatusName "
				."\n from tblbudget_init_status as t1 "
				."\n left join tblbudget_project_detail as t2 on t2.StatusId=t1.StatusId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */

	/* START  */
	/* Function Name: getOrganizeCode2 */
	/* Description: เป็นฟังก์ชันสำหรับเลือกหน่วยงานแสดงรายการกิจกรรม */
	function getOrganizeCode2($BgtYear=0,$selected=0,$tag_name='Organize[]',$tag_attribs='',$lebel='เลือก'){
		$where = array();
		$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.OrganizeCode as value , t2.OrgName as text "
			."\n FROM "
			."\n tblbudget_init_year_org AS t1 "
			."\n Inner Join tblorganize AS t2 ON t1.OrganizeCode = t2.OrganizeCode AND t1.BgtYear = t2.OrgYear "
			."\n ".$where_r
			;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		return clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */

	/* START  */
	/* Function Name: getRecordActivity */
	/* Description: เป็นฟังก์ชันสำหรับแสดงรายการกิจกรรม */
	function getRecordActivity($i){
		$html .= '<div id="div'.$i.'">';
		$html .= '<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">';
		$html .= '<tr>';
		$html .= '<td style="text-align: center; width:120px; vertical-align:top;">';
		$CId = 'PrjActStart'.$i;
		$html .= InputCalendar_text(array("name"=>'PrjActStart[]',"id"=>$CId,"value"=>''));
		$html .= '</td>';
		$html .= '<td style="text-align: center; width:120px; vertical-align:top;" >';
		$CId = 'PrjActEnd'.$i;
		$html .= InputCalendar_text(array("name"=>'PrjActEnd[]',"id"=>$CId,"value"=>''));
		$html .= '</td>';
		$html .= '<td width="600"><input type="text" name="PrjActName['.$i.']" id="PrjActName'.$i.'" style="width:400px;" /></td>';
		$html .= '<td width="230">'.$this->getOrganizeCode2($_REQUEST["BgtYear"],0,'Organize['.$i.']').'</td>';
		$html .= '<td style="width: 210px;"><a href="javascript:void(0)" onclick="if(JQ(\'#act div\').length > 1){ JQ(\'#div'.$i.'\').remove(); JQ(\'#h-ct_index\').val(parseInt(JQ(\'#h-ct_index\').val())-1);}" class="ico delete">ลบทิ้ง</a></td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		echo $html;
	}
	/* END */
	
	/* START  */
	/* Function Name: getActivity */
	/* Description: เป็นฟังก์ชันสำหรับดึงกิจกรรมโครงการ */
	function getActivity($PrjDetailId=0){
		$where = array();
		$where[] = "PrjDetailId = '".$PrjDetailId."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_project_activity "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */

	/* START  */
	/* Function Name: getActivitySource */
	/* Description: เป็นฟังก์ชันสำหรับดึงกิจกรรมโครงการ */
	function getActivitySource($PrjActId=0){
		$where = array();
		$where[] = "PrjActId = '".$PrjActId."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_project_activity_cost_external "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */


	
	/* START  */
	/* Function Name: getDetailPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการ */
	function getDetailPrj($PrjId=0){
		$where = array();
		$where[] = "PrjId = '".$_REQUEST['PrjId']."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_project "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */

	/* START  */
	/* Function Name:  getSourceExName */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแหล่งเงินนอกงบประมาณ*/
	function getSourceExName($SourceExId=0){
		$where = array();
		$where[] = "SourceExId = '".$_REQUEST['SourceExId']."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select SourceExName "
				."\n from tblbudget_init_source_external "
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
	/* Function Name: getActivityDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดกิจกรรมโครงการ */
	function getActivityDetail($PrjDetailId=0,$PrjActId=0){
		$where = array();
		$where[] = "t2.PrjDetailId = '".$_REQUEST['PrjDetailId']."'";
		if($PrjActId){
			$where[] = "t1.PrjActId = '".$_REQUEST['PrjActId']."'";
		}
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.*,t2.PrjId,t3.PrjName,t3.BgtYear,t3.PItemCode  "
				."\n from tblbudget_project_activity as t1 "
				."\n left join tblbudget_project_detail as t2 on t2.PrjDetailId=t1.PrjDetailId "
				."\n left join tblbudget_project as t3 on t3.PrjId=t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */

	/* START  */
	/* Function Name: getCostItemDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดรายการค่าใช้จ่าย */
	function getCostItemDetail($CostItemCode=0){
		$where = array();
		$where[] = "CostItemCode = '".$_REQUEST['CostItemCode']."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

		$sql = "select t1.*,t2.CostTypeName "
				."\n from tblbudget_init_cost_item as t1 "
				."\n left join tblbudget_init_cost_type as t2 on t2.CostTypeId=t1.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getCostName */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่าย */
	function getCostName($ParentCode=0){
		$where = array();
		$where[] = "CostItemCode = '".$_REQUEST['ParentCode']."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostName "
				."\n from tblbudget_init_cost_item "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
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
	/* Function Name: getListCostMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายแจงรายเดือน */
		function getCostMonth($CostIntId=0,$MonthNo=0){
		$where = array();
		$where[] = "CostIntId = '".$_REQUEST["CostIntId"]."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select Budget "
				."\n from tblbudget_project_activity_cost_internal_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql); 
		$data = $this->db->loadResult();
		return $data;
		}
	/* END */

	/* START  */
	/* Function Name: getListCostMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายแจงรายเดือน */
		function getListCostMonth($CostIntId=0,$MonthNo=0){
		$where = array();
		$where[] = "CostIntId = '".$CostIntId."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select Budget "
				."\n from tblbudget_project_activity_cost_internal_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql); 
		$data = $this->db->loadResult();
		return $data;
		}
	/* END */

	/* START  */
	/* Function Name: getCost */
	/* Description: เป็นฟังก์ชันสำหรับดึงงบประมาณที่ได้รับจัดสรร  */
	function getCost($CostIntId=0){
		$where = array();
		$where[] = "CostIntId = '".$CostIntId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select SumCost "
				."\n from tblbudget_project_activity_cost_internal "
				."\n ".$where_r
				;
		$this->db->setQuery($sql); 
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */

	/* START  */
	/* Function Name: getCostEx */
	/* Description: เป็นฟังก์ชันสำหรับดึงงบประมาณที่ได้รับจัดสรรรายไตรมาส  */
	function getCostEx($CostExtId=0){
		$where = array();
		$where[] = "CostExtId = '".$CostExtId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select SumCost "
				."\n from tblbudget_project_activity_cost_external "
				."\n ".$where_r
				;
		$this->db->setQuery($sql); 
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getListCostMonthEx */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายแจงรายเดือน */
		function getCostMonthEx($CostExtId=0,$MonthNo=0){
		$where = array();
		$where[] = "CostExtId = '".$CostExtId."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select Budget "
				."\n from tblbudget_project_activity_cost_external_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql); //echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();
		return $data;
		}
	/* END */

	/* START  */
	/* Function Name: getProjectScreenType */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการตามขึ้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
		/* @BgtYear	= ปีงบประมาณ */
		/* @OrganizeCode	= 	หน่วยงาน */
		/* @SCTypeId	= ขึ้นตอนการจัดทำงบประมาณ */
		/* @ScreenLevel	= ระดับการกลั่นกรองงบ*/
	/* Return Value : Array(loadObjectList) */

	function getProjectScreenType($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0){
		
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
		."\n t2.OrganizeCode as OrganizeCodePrj, "
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
		//$datas = $this->db->loadDataset();
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	/* END */
	
	/* START  */
	/* Function Name: getProjectScreenType */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการตามขึ้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
		/* @BgtYear	= ปีงบประมาณ */
		/* @OrganizeCode	= 	หน่วยงาน */
		/* @SCTypeId	= ขึ้นตอนการจัดทำงบประมาณ */
		/* @ScreenLevel	= ระดับการกลั่นกรองงบ*/
	/* Return Value : Array(loadObjectList) */

	function getDataSetProjectScreenType($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0){
		
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
		."\n t2.OrganizeCode as OrganizeCodePrj, "
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
		$datas = $this->db->loadDataset();
		return $datas;

	}
	/* END */
	
	/* START  */
	/* Function Name: getProjectDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดโครงการ */
	function getProjectDetail($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0, $PrjId=0,$PrjDetailId=0){
		
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
		."\n t2.OrganizeCode, "
		."\n t2.BgtYear, "
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
		//echo "$sql";		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();//ltxt::print_r($data);
		return $data;

	}
	/* END */	
	
	function getTotalPrjInternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostIntId=0){
		return $this->dpublic->getTotalPrjInternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostIntId);
	}
	
	function getTotalPrjExternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostExtId=0){
		return $this->dpublic->getTotalPrjExternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostExtId);
	}


	/* START  */
	/* Function Name: getSCType */
	/* Description: เป็นฟังก์ชั่นสำหรับดึงขั้นตอนการจัดทำงบประมาณโครงการ */
		function getSCType($selected=null,$tag_name='SCTypeId[]',$tag_attribs='',$lebel='เลือก'){
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select SCTypeId as value,SCTypeName as text "
			."\n from tblbudget_init_screen_type "
			."\n ".$where_r
			;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		}
	/* END */

	/* START  */
	/* Function Name: getScreen */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการกลั่นกรอง */
		//function getScreen($selected=null,$tag_name='ScreenId[]',$tag_attribs='',$lebel='เลือก'){
		function getScreen($SCTypeId=2,$selected=0,$tag_name='ScreenId[]',$tag_attribs='onchange="getfilterscreen()"',$lebel='เลือก'){
		$where = array();
		//$where[] = "SCTypeId = '".$SCTypeId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select ScreenId as value,ScreenName as text "
			."\n from tblbudget_init_screen_item "
			."\n ".$where_r
			;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		}
	/* END */
	
	/* START  */
	/* Function Name: getImport */
	/* Description: เป็นฟังก์ชันสำหรับคัดลอกโครงการ */

		function getImport(){
			header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment; filename="project_import_form.php"');
			echo "$FormPrj" ;
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
	
	
	/* START #F */
	/* Function Name: getSCTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getSCTypeRecordSet(){
		
		$where = array();
		
		//$where[] = "SCTypeId in(1,2,3)";
		
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
	}*/	
	
	
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
	
	
	/* START  F */
	/* Function Name: getOrgList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการชื่อหน่วยงาน */
	function getOrgList($BgtYear=0){
		$where = array();
		
		if($BgtYear){
		$where[] = "BgtYear = '".$BgtYear."'";
		}

		//$where[] = "OrganizeCode = '".$OrganizeCode."'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_init_year_org "
				."\n ".$where_r
				;
		//echo "$sql";
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */	
	
	
	
/* START #F49 */
	/* Function Name: getTotalPrjInternalX4Act */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณกิจกรรมตามหน่วยงาน ตาราง X4ช่อง(งบแผ่นดิน) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjInternalX4Act($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t3.OrganizeCode='".$OrganizeCode."'";
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
	/* Function Name: getTotalPrjExternalX4Act */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณกิจกรรมตามหน่วยงาน ตาราง X4ช่อง(เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjExternalX4Act($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t3.OrganizeCode='".$OrganizeCode."'";
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
	
	
	/* START #F */
	/* Function Name: getTotalPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ+เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */	

	function getTotalPrjAct($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		$BgtYear = ($BgtYear)?$BgtYear:(date("Y")+543);
		$BGInt		= $this->getTotalPrjInternalX4Act($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$BGExt		= $this->getTotalPrjExternalX4Act($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		
		$BGTotal	= $BGInt+$BGExt;
		return $BGTotal;
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

	/* START  */
	/* Function Name:  getActName */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแหล่งเงินนอกงบประมาณ*/
	function getActNamePop($PrjActId=0){
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

	/* START #F */
	/* Function Name: getMaxLevel */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
/*	function getMaxLevel($BgtYear=0){
		
		$where = array();
		$where[] = " BgtYear='".$BgtYear."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT count(ScreenId) as max "
				."\n FROM "
				."\n tblbudget_init_screen_item "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
*/	/* END */	

	/* START #F */
	/* Function Name: getScreenByLevel */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
/*	function getScreenByLevel($BgtYear=0,$Level){
		
		$where = array();
		$where[] = " BgtYear='".$BgtYear."'";
		$where[] = "ScreenLevel='".$Level."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT ScreenId as ScreenId2, ScreenLevel as ScreenLevel2 ,ScreenName as ScreenName2 "
				."\n FROM "
				."\n tblbudget_init_screen_item "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}*/
	/* END */

	function countScreenLevel($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->countScreenLevel($BgtYear,$SCTypeId);
	}	
	


	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อระดับการกลั่นกลอง  */
	/* Parameter: */
			/* @ScreenLevel	= ระดับการกลั่นกลอง */
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
	function getScreenRecordSet($BgtYear=0){
		return $this->dpublic->getScreenRecordSet($BgtYear);
	}
	
	function getCurProcess($BgtYear=0,$OrganizeCode=0){
		return $this->dpublic->getCurProcess($BgtYear,$OrganizeCode);
	}
	
	function getTotalBGAllotInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$PrjDetailId=0,$PrjActId=0,$PrjActCode=0,$PrjId=0){
		return $this->dpublic->getTotalBGAllotInternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$PrjDetailId,$PrjActId,$PrjActCode,$PrjId);
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
		//$selected = ($selected)?$selected:(date("Y")+543);
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
