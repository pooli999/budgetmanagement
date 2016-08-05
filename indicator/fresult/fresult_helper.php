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
	

	function getYear($Year,$ObjYear){
		return $this->dpublic->getYear($Year,$ObjYear);
	}

	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0){
		return $this->dpublic->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId);
	}
	
	function getOrganizeName($OrganizeCode=0){
		return $this->dpublic->getOrganizeName($OrganizeCode);
	}

	function getProjectDetailActRecordSet($PrjDetailId=0){
		$where = array();
		if($PrjDetailId){
			$where[] = "PrjDetailId='".$PrjDetailId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT * "
				."\n FROM "
				."\n tblbudget_project_activity "
				."\n ".$where_r
				."\n order by PrjActId ASC "
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	
	function getCostTypeRecordSet($CostTypeId=0){
		return $this->dpublic->getCostTypeRecordSet($CostTypeId);
	}

	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	
	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	
	function getCostItemRecordSet($CostTypeId=0,$LevelId=1,$ParentCode=0,$HasChild=0,$CostItemCode=0){
		return $this->dpublic->getCostItemRecordSet($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	}
	
	function getProjectDetailCheckRecordSet($PrjDetailId=0){
		return $this->dpublic->getProjectDetailCheckRecordSet($PrjDetailId);
	}	
	
	function getTotalPrjInternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostIntId=0){
		return $this->dpublic->getTotalPrjInternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostIntId);
	}	
	
	function getTotalPrjExternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostExtId=0){
		return $this->dpublic->getTotalPrjExternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostExtId);
	}	
	
	/* START 01 */
	/* Function Name: getProjectScreenType */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการตามปีงบประมาณของหน่วยงาน */
	/* Parameter: -*/
	/* Return Value : Array(loadObjectList) */

	function getProjectSCType($BgtYear=0, $PersonalCode=0,$PItemCode=0){
		
		$where = array();
		
		//$where[] = "t4.PersonalCode='".$PersonalCode."'";
	//	$where[] = "t4.ResultStatus='Y' ";
		
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
	
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}	

		//$where[] = "t1.SCTypeId in(2)";
		$where[] = "t1.ActiveStatus ='Y' ";
		if($PItemCode){
			$where[] = "t2.PItemCode='".$PItemCode."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT "
		."\n t1.StatusId, "
		."\n t1.PrjDetailId, "
		."\n t1.SCTypeId, "
		."\n t1.ScreenLevel, "
		."\n t2.*, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		//."\n inner Join tblbudget_project_person as t4 on t4.PrjId = t2.PrjId "				
		."\n ".$where_r
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
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
				."\n t1.*, "	
				."\n t1.OrganizeCode AS ActOrganizeCode, "	
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
	
	/* START #F04 */
	/* Function Name:  */
	/* Description:  */
	/* Parameter: */
	/* Return Value : Single(loadResult) */
	function getPrjName($PrjId=0){
				
		$where = array();
		
		$where[] = "t1.PrjId='".$PrjId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.PrjName"
		."\n FROM "
		."\n tblbudget_project AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */		


	/* START #F04 */
	/* Function Name:  */
	/* Description:  */
	/* Parameter: */
	/* Return Value : Single(loadResult) */
	function getPrjActName($PrjActId=0){
				
		$where = array();
		
		$where[] = "t1.PrjActId='".$PrjActId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.PrjActName"
		."\n FROM "
		."\n tblbudget_project_activity AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */		


function getLinkFiles($ResultId)
	{
		$sql = "SELECT * FROM tblbudget_project_activity_fresult_file where ResultId='$ResultId' ";
		$this->db->setQuery($sql);
		$detail = $this->db->loadObjectList(); 
		$Arr = array();
		foreach($detail as $val){
			$Arr[] = $val->DocId;
		}
		if($Arr){
			return @implode(",",$Arr);
		}else{
			return '';	
		}
	}


	/* START #F04 */
	/* Function Name:  */
	/* Description:  */
	/* Parameter: */
	function getActivityResult($PrjActId=0, $PrjDetailId=0,$ResultId=0){
				
		$where = array();
		
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}			
		
		if($PrjActId){
			$where[] = "t1.PrjActId='".$PrjActId."'";
		}	
		
		if($ResultId){
			$where[] = "t1.ResultId='".$ResultId."'";
		}	
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.* "
		."\n FROM "
		."\n tblbudget_project_activity_result AS t1  "
		."\n ".$where_r
		;
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */		

	/* START #F04 */
	/* Function Name:  */
	/* Description:  */
	/* Parameter: */
	function getResultDetail($PrjActCode=0,$MonthNo=0){
		$where = array();
		$where[] = "t1.PrjActCode='".$PrjActCode."'";
		$where[] = "t1.MonthNo='".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT t1.* "
		."\n FROM "
		."\n tblbudget_project_activity_result AS t1  "
		."\n ".$where_r
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */		



	/* START  */
	/* Function Name: getProjectDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดโครงการ */
	function getProjectDetail($PrjActId){
		$where = array();
		$where[] = "t1.PrjActId='".$PrjActId."'";
		if(count($where)){
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.*,t1.OrganizeCode as OrganizeCodeAct,t3.PrjId,t3.PrjCode,t3.PrjName,t3.PItemCode,t3.PrjMethods,t3.OrganizeCode,t3.BgtYear "
				."\n from "
				."\n tblbudget_project_activity as t1 "
				."\n left join tblbudget_project_detail as t2 on t2.PrjDetailId=t1.PrjDetailId "
				."\n left join tblbudget_project as t3 on t3.PrjId=t2.PrjId "
				."\n ".$where_r
				;
		/*$sql="SELECT "
		."\n t1.PrjDetailId, "
		."\n t1.SCTypeId, "
		."\n t1.ScreenLevel, "
		."\n t2.PrjId, "
		."\n t2.PrjCode, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t2.PrjMethods, "
		."\n t2.OrganizeCode, "
		."\n t2.BgtYear, "
		."\n t3.PrjActId, "
		."\n t3.PrjActCode, "
		."\n t3.PrjActName, "
		."\n t3.StartDate, "
		."\n t3.EndDate, "
		."\n t3.OrganizeCode as OrganizeCodeAct "
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n Inner Join tblbudget_project_activity AS t3 ON t1.PrjDetailId = t3.PrjDetailId "				
		."\n ".$where_r
		;*/
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
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
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
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

	/* START  03 */
	/* Function Name: getOrgNameAct */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงานรับผิดชอบกิจกรรม */
	function getOrgNameAct($OrganizeCode=0){
		$where = array();
		$where[] = "OrganizeCode = '".$OrganizeCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select OrgName "
				."\n from tblorganize "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
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

	/* Function Name: getItemRequireInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายงบแผ่นดิน *4  */
	function getItemRequireInternal($CostItemCode=0,$PrjActId=0,$PrjId=0,$PrjDetailId=0){
		$where = array();
		if($CostItemCode){
			$where[] = "t1.CostItemCode = '".$CostItemCode."'";
		}
		if($PrjId){
			$where[] = "t3.PrjId = '".$PrjId."'";
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
	/* Function Name: getItemRequireExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายเงินนอกงบประมาณ *4  */
	function getItemRequireExternal($CostItemCode=0,$PrjActId=0,$PrjId=0,$PrjDetailId=0,$SourceExId=0){
		$where = array();
		if($CostItemCode){
			$where[] = "t1.CostItemCode = '".$CostItemCode."'";
		}
		if($PrjId){
			$where[] = "t3.PrjId = '".$PrjId."'";
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
		."\n ".$where_r
		;
		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;	

	}
	/* END */

	function getProgrees($PrjActId=0,$PrjDetailId=0){
		$where = array();
		$where[] = "PrjActId = '".$PrjActId."'";
		$where[] = "PrjDetailId = '".$PrjDetailId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MAX(Progress) AS result  "
				."\n from tblbudget_project_activity_result "
				."\n ".$where_r
				."\n order by ResultId desc limit 1 "
				;
				
		//echo "<pre>$sql</pre>";				
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;	
	}

	/*
	Function Name : getUpdateDate
	Description : เป็นฟังก์ชันสำหรับดึงวันที่ล่าสุด
	*/
	function getUpdateDate($PrjActCode=0){
		$where = array();
		$where[] = "PrjActCode = '".$PrjActCode."'";
		//$where[] = "PrjDetailId = '".$PrjDetailId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select UpdateDate  "
				."\n from tblbudget_project_activity_result "
				."\n ".$where_r
				."\n order by UpdateDate desc limit 1 "
				;
				
		//echo "<pre>$sql</pre>";				
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;	
	
	}
	// end


	/* START  */
	/* Function Name: getIndicator */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของกิจกรรม*/
	function getIndicatorActSelect($PrjActId=0){
		$sql = "select t1.PrjActIndId,t1.IndicatorName,t1.Value,t1.UnitID,t3.UnitName "
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
	
	function getPersonResult($PersonalCode,$PrjId){
		$where = array();
		$where[] = "PersonalCode = '".$PersonalCode."'";
		$where[] = "PrjId = '".$PrjId."'";
		$where[] = "ResultStatus = 'Y' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select count(PersonalCode)  "
				."\n from tblbudget_project_person "
				."\n ".$where_r
				;
				
		//echo "<pre>$sql</pre>";				
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;	

	}
	
		/* 
	START #F2
	Function Name	: getDataList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการแผนงาน
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อแผนงานเมื่อกรอกข้อมูลค้นหา
		@$_REQUEST["BgtYear"]	=	ปีงบประมาณ
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
		$where[] ="PGroupId=12 ";
		
		
/*		if($_REQUEST["tsearch"]){
			$where[] = "PrjName like ('%".$_REQUEST["tsearch"]."%')";
		}*/
		
		if($_REQUEST["BgtYear"]){
			$where[] = "BgtYear='".$_REQUEST["BgtYear"]."'";
		}else{
			$BgtYear = date("Y")+543;
			$where[] = "BgtYear='".$BgtYear."'";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_plan_item ".$where_r."  order by CONVERT(PItemCode USING TIS620) ASC ";
		//$sql="select * from tblbudget_init_plan_item ".$where_r."  order by CONVERT(`PItemName` USING TIS620) ASC ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}
	/*END*/
	
	function getProjectView($PrjDetailId){
		$where = array();
		$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		if(count($where)){
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.*,t2.* "
				."\n from "
				."\n tblbudget_project_detail as t1 "
				."\n left join tblbudget_project as t2 on t2.PrjId=t1.PrjId "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;

	}
	/* END */
	
	function getProjectIndicator($PrjDetailId=0,$PrjIndId=0){
		$where = array();
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjIndId){
			$where[] = "t1.PrjIndId='".$PrjIndId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
		."\n t1.* "
		."\n FROM "
		."\n tblbudget_project_indicator AS t1 "
		."\n ".$where_r
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	/* END */
	
	function getMonthTargetPlan($PrjIndId,$MonthNo){
		$where = array();
		$where[] = "PrjIndId = '".$PrjIndId."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MonthTargetPlan "
				."\n from tblbudget_project_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getMonthTargetResult($IndicatorCode,$MonthNo){
		$where = array();
		$where[] = "IndicatorCode = '".$IndicatorCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MonthTargetResult "
				."\n from tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getProjectList($PItemCode){
		$where = array();
		$where[] = "t2.PItemCode='".$PItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT "
		."\n t1.*, "
		."\n t2.*, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		//."\n inner Join tblbudget_project_person as t4 on t4.PrjId = t2.PrjId "				
		."\n ".$where_r
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	
	function getPlanDetail($PItemCode){
		$where 	  = array();
		$where[] = "PItemCode='".$PItemCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql = "select * "
				."\n from tblbudget_init_plan_item "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;
	}
	/*END*/
	
	function getLPlanName($LPlanCode){
		$where 	  = array();
		$where[] ="t1.LPlanCode='".$LPlanCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT concat(t2.PLongName,' --> ',t1.LPlanName) "
				."\n FROM "
				."\n tblbudget_longterm_plan as t1 "
				."\n left join tblbudget_longterm as t2 on t2.PLongCode=t1.PLongCode "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	
	function getPurposeItem($PItemCode){
		$where 	  = array();
		$where[] ="PItemCode='".$PItemCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT * "
				."\n FROM "
				."\n tblbudget_init_plan_item_purpose "
				."\n ".$where_r
				."\n order by PurposeCode asc"
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	function getPlanIndicator($PItemCode,$PIndId=0){
		$where = array();
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PIndId){
			$where[] = "t1.PIndId='".$PIndId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
		."\n t1.* "
		."\n FROM "
		."\n tblbudget_init_plan_item_indicator AS t1 "
		."\n ".$where_r
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	
	function getSumProgressAmass($PrjCode,$MonthNo){
		$where = array();
		$where[] = "PrjCode = '".$PrjCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select sum(ProgressAmass) "
				."\n from tblbudget_project_activity_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getMaxMonth($PrjActCode){
		$where = array();
		$where[] = "PrjActCode = '".$PrjActCode."'";
		$where[] = "ProgressAmass > '0'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(MonthNo) "
				."\n from tblbudget_project_activity_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$data = $this->db->loadResult();//echo $data;
		return $data;
	}
	
	function getSumActProgress($PrjActCode,$MonthNo){
		$where = array();
		$where[] = "PrjActCode = '".$PrjActCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select Progress "
				."\n from tblbudget_project_activity_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getSumActProgressAmass($PrjActCode,$MonthNo){
		$where = array();
		$where[] = "PrjActCode = '".$PrjActCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select ProgressAmass "
				."\n from tblbudget_project_activity_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getMonthShortNameTH($MonthNo){
		$where = array();
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MonthShortNameTH "
				."\n from tblbudget_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
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
			 ."\n FROM tblbudget_project "
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


	

	
	
	
}//end class
?>
