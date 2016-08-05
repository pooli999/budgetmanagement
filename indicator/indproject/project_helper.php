<?php

class sHelper
{
	var $dpublic;
	var $db;
	var $debug = 0;
	function sHelper(){
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
	
	function getSCTypeRecordSet(){
		return $this->dpublic->getSCTypeRecordSet();
	}
	
	function getSCTypeName($SCTypeId=0){	
		return $this->dpublic->getSCTypeName($SCTypeId);
	}
	
	function countScreenLevel($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->countScreenLevel($BgtYear,$SCTypeId);
	}	
	
/*	function getMaxScreenLevel(){
		return $this->dpublic->getMaxScreenLevel();
	}*/
		
		
	function getMaxLevel($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->getMaxLevel($BgtYear,$SCTypeId);
	}
	
	function getScreenByLevel($BgtYear=0,$Level=0){
		return $this->dpublic->getScreenByLevel($BgtYear,$Level);
	}
	

	function getYear($Year=0,$ObjYear=0){
		return $this->dpublic->getYear($Year,$ObjYear);
	}
	
	function getBGTotalInternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0){
		return $this->dpublic->getBGTotalInternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId);
	}

	function getBGTotalExternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0,$SourceExId=0){
		return $this->dpublic->getBGTotalExternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId,$SourceExId);
	}
	
	function getTotalAllotPrj($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0,$SourceExId=0){	
		return $this->dpublic->getTotalAllotPrj($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId,$SourceExId);
	}	
	
	function getSCTypeCurOrg($BgtYear=0,$OrganizeCode=0){
		return $this->dpublic->getSCTypeCurOrg($BgtYear,$OrganizeCode);
	}

	function getProjectDetailIndRecordSet($PrjDetailId=0){
		return $this->dpublic->getProjectDetailIndRecordSet($PrjDetailId);
	}

	function getPlanItemList($BgtYear=0,$OrganizeCode=0,$PGroupId=9,$selected=0,$tag_name='PItemCode',$tag_attribs='onchange="loadPrj(this.value)"',$lebel='เลือก'){

		$where = array();
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.PGroupId='".$PGroupId."'";
		$where[] = "t1.EnableStatus='Y'";
		$where[] = "t1.DeleteStatus<>'Y'";
		$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.PItemCode)as value , t1.PItemName as text "
			 ."\n FROM tblbudget_init_plan_item as t1 "
			 ."\n inner join tblbudget_project as t2 on t2.PItemCode=t1.PItemCode"
			 ."\n ".$where_r
			 ."\n order by t1.PItemCode ASC "
			  //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
/*	function getProjectList($BgtYear=0,$PItemCode=0,$OrganizeCode=0,$tag_name='PrjId',$selected=0,$tag_attribs='style="width:500px;"',$lebel='เลือก'){
		return $this->dpublic->getProjectList($BgtYear,$PItemCode,$OrganizeCode,$tag_name,$selected,$tag_attribs,$lebel);
	}*/

	function getOrganizeCode($BgtYear=0, $selected=0,$tag_name='OrganizeCode',$tag_attribs='onchange="getfilterorg()"',$lebel='เลือก'){
		return $this->dpublic->getOrganizeCode($BgtYear, $selected,$tag_name,$tag_attribs,$lebel);
	}

	function getIndProjectList($IndId=0){
		return $this->dpublic->getIndProjectList($IndId);
	}
	
/*	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0){
		return $this->dpublic->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId);
	}*/
	
	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	
	function getProjectDetailActRecordSet($PrjDetailId=0){
		return $this->dpublic->getProjectDetailActRecordSet($PrjDetailId);
	}

	function getIndProjectRecordSet($IndId=0){
		return $this->dpublic->getIndProjectRecordSet($IndId);
	}

	function getProjectDetailCheckRecordSet($IndId=0){
		return $this->dpublic->getProjectDetailCheckRecordSet($IndId);
	}
		
	function getCostTypeRecordSet($CostTypeId=0){
		return $this->dpublic->getCostTypeRecordSet($CostTypeId);
	}
	
	function getCostItemRecordSet($CostTypeId=0,$LevelId=1,$ParentCode=0,$HasChild=0,$CostItemCode=0){
		return $this->dpublic->getCostItemRecordSet($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	}


	/* START #F5 */
	/* Function Name: getCostItemRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: */
			/* @CostTypeId	= รหัสหมวดงบประมาณ */
			/* @LevelId	 	 	= รหัสระดับรายการ */
			/* @ParentCode 		= รหัสรายการ Parent */
	/* Return Value : Array(loadObjectList) */
	function getCostItemActivity($PrjActId){
		
		$where = array();
		$where[] = "t1.PrjActId='".$PrjActId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.CostItemCode) as CostItemCode,t2.CostName "
			 ."\n FROM tblbudget_project_activity_cost_internal as t1 "
			 ."\n left join tblbudget_init_cost_item as t2 on t2.CostItemCode=t1.CostItemCode "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql); //echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	

	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}

	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	
	function getScreenLevel($BgtYear=0,$OrganizeCode=0){
		return $this->dpublic->getScreenLevel($BgtYear,$OrganizeCode);
	}
	
	function getOrganizeName($OrganizeCode=0){
		return $this->dpublic->getOrganizeName($OrganizeCode);
	}
	function getTotalBGAllotInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$PrjDetailId=0,$PrjActId=0,$PrjActCode=0,$PrjId=0){
		return $this->dpublic->getTotalBGAllotInternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$PrjDetailId,$PrjActId,$PrjActCode,$PrjId);
	}
	function getBGAllotInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getBGAllotInternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}	
	function getBGAllotExternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0){	
		return $this->dpublic->getBGAllotExternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$SourceExId);
	}
	function getTotalBGIncreaseInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalBGIncreaseInternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}
	function getTotalBGAllotEnternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0){
		return $this->dpublic->getTotalBGAllotEnternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$SourceExId);
	}	
	function getTotalBGIncreaseExternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0){
		return $this->dpublic->getTotalBGIncreaseExternal($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$SourceExId);
	}

	function getCountSubSCType($BgtYear=0,$SCTypeId=0){
		return $this->dpublic->getCountSubSCType($BgtYear,$SCTypeId);
	}
	
/*	function getOrgName($BgtYear=0,$OrganizeCode=0){
		$where = array();
		$where[] = "t1.OrgYear='".$BgtYear."'";
		$where[] = "t1.OrgRound='".$this->getMaxRound($BgtYear)."'";
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT concat(t1.OrgName,' (',t1.OrgShortName,')') "
			 ."\n FROM tblstructure_operation as t1 "
			 ."\n left join tblstructure_operation_round as t2 on t2.RoundCode=t1.OrgRoundCode "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}
*/
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
	/* Function Name: getPrjCodeName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อโครงการ */
	function getPrjCodeName($PrjCode=0){
		$where = array();
		$where[] = "PrjCode = '".$PrjCode."'";
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
/*		function getUnit($selected=0,$tag_name='UnitID',$tag_attribs='',$lebel='เลือก'){
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
		}*/
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
	
	/* START  */
	/* Function Name: getIndicator */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของกิจกรรม*/
	function getIndicatorActSelect($PrjActId=0,$PrjActIndId=0){
		$where = array();
		$where[] ="t1.PrjActId='".$PrjActId."'";
		if($PrjActIndId){
			$where[] ="t1.PrjActIndId='".$PrjActIndId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.PrjActIndId,t1.IndicatorName,t1.Value,t1.UnitID,t3.UnitName,t1.IndTypeId,t2.IndTypeName "
				."\n from tblbudget_project_activity_indicator as t1 "
				."\n left join tblbudget_init_indicator_type as t2 on t2.IndTypeId=t1.IndTypeId "
				."\n left join tblunit as t3 on t3.UnitID=t1.UnitID "
				 ."\n ".$where_r
				."\n order by t1.PrjActIndId ASC  "
				;
		//echo "<pre>$sql</pre>";	
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */	
	
	/* START F*/
	/* Function Name: getUnitList */
	/* Description: เป็นฟังชั่นสำหรับดึงรายการหน่วยนับเป็น List Box 
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getUnitList($selected=0,$tag_name='UnitID[]',$tag_attribs='',$lebel='เลือก'){
		$where = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT UnitID as value , UnitName as text "
			 ."\n FROM tblunit "
			 ."\n ".$where_r
			 ."\n order by CONVERT(`UnitName` USING TIS620) ASC"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}		
	/* END */	

	
	
	/* START #F */
	/* Function Name: getIndicator */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัด  */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getIndicator($selected=0,$tag_name='IndId[]',$tag_attribs='style="width:95%"',$lebel='เลือก'){

		$where = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT IndId as value , IndName as text "
			 ."\n FROM tblbudget_init_indicator "
			 ."\n ".$where_r
			 ."\n order by CONVERT(`IndName` USING TIS620) ASC "
			 ;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
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
/*	function getOrganizeCode2($BgtYear=0,$selected=0,$tag_name='Organize[]',$tag_attribs='style="width:95%"',$lebel='เลือก'){
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
		
	}*/
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
		$where[] = "PrjDetailId = '".$_REQUEST['PrjDetailId']."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_project_activity "
				."\n ".$where_r
				;
		
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */
	
	/* START  */
	/* Function Name: getDetailPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการ */
	function getDetailPrj($PrjId=0,$PrjDetailId=0){
		$where = array();
		if($PrjId){
			$where[] = "t1.PrjId = '".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId = '".$PrjDetailId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.*,t2.* "
				."\n from tblbudget_project as t1 "
				."\n left join tblbudget_project_detail as t2 on t2.PrjId=t1.PrjId"
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
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
		$where[] = "t1.PrjActId = '".$_REQUEST['PrjActId']."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.*,t2.PrjId,t3.PrjName,t3.PrjCode,t3.BgtYear,t3.PItemCode,t3.OrganizeCode,t2.StartDate,t2.EndDate  "
				."\n from tblbudget_project_activity as t1 "
				."\n left join tblbudget_project_detail as t2 on t2.PrjDetailId=t1.PrjDetailId "
				."\n left join tblbudget_project as t3 on t3.PrjId=t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
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
		$where[] = "CostItemCode = '".$ParentCode."'";
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
		$sql = "select * "
				."\n from tblbudget_project_activity_cost_internal "
				."\n ".$where_r
				;
		$this->db->setQuery($sql); 
		$data = $this->db->loadObjectList();
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
		$sql = "select * "
				."\n from tblbudget_project_activity_cost_external "
				."\n ".$where_r
				;
		$this->db->setQuery($sql); //echo $sql;
		$data = $this->db->loadObjectList();
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
		
		if($_REQUEST["BgtYear"]){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}

		if($_REQUEST["OrganizeCode"]){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}		
		
		if($_REQUEST["SCTypeId"]){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($_REQUEST["ScreenLevel"]){
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
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		."\n ".$where_r
		."\n order by t2.PrjCode "
		//."\n order by t1.PrjDetailId desc "
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		//$datas = $this->db->loadDataset();
		$datas = $this->db->loadObjectList();
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
		
		/*if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}	*/
		
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
	
	function getTotalPrjInternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostIntId=0){
		return $this->dpublic->getTotalPrjInternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostIntId);
	}
	
	function getTotalPrjExternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostExtId=0){
		return $this->dpublic->getTotalPrjExternalMonth($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$MonthNo,$CostExtId);
	}


	/* START  */
	/* Function Name: getSCType */
	/* Description: เป็นฟังก์ชั่นสำหรับดึงขั้นตอนการจัดทำงบประมาณโครงการ */
		function getSCType($selected=0,$tag_name='SCTypeId',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
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
		function getScreen($selected=0,$tag_name='ScreenLevel',$tag_attribs='onchange="getfilterScr()"',$lebel='เลือก'){
		$where = array();
		$where[] = "ScreenLevel = '".$_REQUEST["ScreenLevel"]."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select ScreenLevel as value,ScreenName as text "
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
	
	/* START #F5 */
	/* Function Name: getAllotDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดข้อมูลกลั่นกรอง */
	/* Parameter: */
	/* @BgtYear	= ปีงบประมาณ */
	/* Return Value : single(loadResult) */
	function getAllotDetail($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0){
		
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
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT  t1.* "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
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
	
	
	/* START #F4 */
	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อระดับการกลั่นกรอง  */
	/* Parameter: */
			/* @ScreenLevel	= ระดับการกลั่นกรอง */
	/* Return Value : Single(loadResult) */
	function getScreenName($selected=0,$tag_name='ScreenLevel',$tag_attribs='onchange="getfilterscr()"',$lebel='เลือก'){
		$where = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.ScreenLevel as value , t1.ScreenName as text"
		."\n FROM "
		."\n tblbudget_init_screen_item AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	/* END */	
	function getLinkFiles($PrjDetailId)
	{
		$sql = "SELECT * FROM tblbudget_project_file where PrjDetailId='$PrjDetailId'  order by PrjFileId ASC ";
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
	
	/* START  */
	/* Function Name: getItemInternalPopup */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายงบแผ่นดิน *4  */
	function getItemInternalPopup($CostItemCode=0){
		$where = array();
		$where[] = "CostItemCode = '".$CostItemCode."'";		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.* "
				."\n from tblbudget_project_activity_cost_internal as t1 "
				."\n left join tblbudget_project_activity as t2 on t2.PrjActId=t1.PrjActId"
				."\n left join tblbudget_project_detail as t3 on t3.PrjDetailId=t2.PrjDetailId"
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadObjectList();//ltxt::print_r($data);
		return $data;
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





	
/*	  21-01-2555

function getTaskPerson($PrjDetailId)
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
	*/


	/* START  */
	/* Function Name: getCheckStepOrg */
	/* Description: เป็นฟังก์ชันสำหรับตรวจสอบว่าปิดขั้นตอนแล้วหรือไม่  */
	/* Parameter: */
			/* @BgtYear			= ปีงบประมาณ */
			/* @OrganizeCode 	= รหัสหน่วยงาน */
			/* @SCTypeId 	= ขั้นตอนการกลั่นกรองงบ */
			/* @ScreenLevel 	= ระดับการกลั่นกรองงบ */
	/* Return Value : single(loadResult) */
	function getCheckStepOrg($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0){
		$sql = "select CloseStep from tblbudget_init_year_org where BgtYear='$BgtYear' and OrganizeCode='$OrganizeCode' and SCTypeId='$SCTypeId' and ScreenLevel='$ScreenLevel' ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadResult(); 
		return $list;

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
	
	
	function getMaxRound($BgtYear){
		$where = array();
		$where[] = "Year = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(Round) "
				."\n from tblstructure_operation_round"
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	
	/* START 7 */
	/* Function Name: getOrgShortNameList */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	function getOrgShortNameList($BgtYear=0,$selected=0,$tag_attribs='style="width:100px;"',$tag_name='Organize[]',$lebel='เลือก'){
		
		$where = array();

		if($BgtYear == ""){
			$BgtYear = date("Y")+543;
		}
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t2.OrgYear='".$BgtYear."'";
		//$where[] = "t3.Round='".$this->getMaxRound($BgtYear)."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.OrganizeCode as value , t2.OrgShortName as text "
			 ."\n FROM tblbudget_init_year_org as t1 "
			 ."\n left join tblorganize as t2 on t2.OrganizeCode=t1.OrganizeCode "
			 //."\n left join tblstructure_operation_round as t3 on t3.RoundCode=t2.OrgRoundCode "
			 ."\n ".$where_r
			 ;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	/* END */			
	
	/* START #F */
	/* Function Name: getSCTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
/*	function getSCTypeRecordSet(){
		
		$where = array();
		
		$where[] = "SCTypeId in(1,2,3)";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT SCTypeId, SCTypeName, SCTypeName2 "
				."\n FROM "
				."\n tblbudget_init_screen_type "
				."\n ".$where_r
				;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
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
		if(empty($BgtYear)){
			$BgtYear = date("Y")+543;
		}		
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
	
	/* START #F */
	/* Function Name: getMaxLevel */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
/*	function getMaxLevel($BgtYear=0){
		
		$where = array();
		
		if(empty($BgtYear)){
			$BgtYear = date("Y")+543;
		}		
		$where[] = " BgtYear='".$BgtYear."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		
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
		
	}*/
	/* END */	
	
	/* START #F9 */
	/* Function Name: getScreenRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงระดับการกลั่นกรองงบแต่ละปีงบประมาณ  */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
/*	function getScreenRecordSet($BgtYear=0){
		
		$where = array();
		if(empty($BgtYear)){
			$BgtYear = date("Y")+543;
		}
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT ScreenId, ScreenLevel ,ScreenName "
				."\n FROM "
				."\n tblbudget_init_screen_item "
				."\n ".$where_r
				."\n order by ScreenLevel "
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}*/
	/* END */
	
	

/* START #F49 */
	/* Function Name: getCostPrjInternalX4 */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */

/*
	function getCostPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
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
			$where[] = "t3.PrjActId ='".$PrjActId."'";
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
			$where[] = "t6.CostItemCode not in(".$CostItemCode.")";
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
				
		echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}


*/

	function getCostPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
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
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($CostItemCode){
			$where[] = "t3.PrjActId ='".$PrjActId."'";
			$where[] = "t6.CostItemCode not in(".$CostItemCode.")";
		}else{
			$where[] = "t3.PrjActId in(SELECT  PrjActId  FROM tblbudget_project_activity  WHERE PrjDetailId='$PrjDetailId' AND  PrjActId != '$PrjActId' ) ";
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
	/* Function Name: getCostPrjExternalX4 */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getCostPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
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
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($CostItemCode){
			$where[] = "t3.PrjActId ='".$PrjActId."'";
			$where[] = "t6.CostItemCode not in(".$CostItemCode.")";
		}else{
			$where[] = "t3.PrjActId in(SELECT  PrjActId  FROM tblbudget_project_activity  WHERE PrjDetailId='$PrjDetailId' AND  PrjActId != '$PrjActId' ) ";
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

	/* END */
	
	


	/* START #F57 */
	/* Function Name: getImpParentCode */
	/* Description: เป็นฟังก์ชันสำหรับ CostItemCode มาต่อเป็นรูปแบบ Array */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getImpParentCode($CostItemCode){
		$where = array();
		$where[] = "ParentCode='".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostItemCode "
				."\n from tblbudget_init_cost_item "
				."\n ".$where_r
				."\n or ParentCode in( "
					."\n select CostItemCode "
				   	."\n from tblbudget_init_cost_item "
				  	."\n ".$where_r
				."\n ) "
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$data = $this->db->loadResultArray();
		$datas = implode(",",$data);
		return $datas;
	}
	/* END */

	/* START  */
	/* Function Name: getActivityResult */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลการปฏิบัติงานประจำปี ประจำโครงการ */
	function getActivityResult($PrjDetailId=0){
		$where = array();
		$where[] = "PrjDetailId = '".$PrjDetailId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_project_activity_result "
				."\n ".$where_r
				;
		
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */


	/* START  */
	/* Function Name: getActivityResult */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการงบแผ่นดิน */
	function getActivityIn($PrjActId=0){
		$where = array();
		$where[] = "PrjActId = '".$PrjActId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_project_activity_cost_internal "
				."\n ".$where_r
				;
		
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */
	
	/* START  */
	/* Function Name: getActivityEx */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการเงินนอก */
	function getActivityEx($PrjActId=0){
		$where = array();
		$where[] = "PrjActId = '".$PrjActId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_project_activity_cost_external "
				."\n ".$where_r
				;
		
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */	


	/* START  */
	/* Function Name: getActivityResult */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการแจงรายเดือนของงบแผ่นดิน */
	function getActivityInMonth($CostIntId=0){
		$where = array();
		$where[] = "CostIntId = '".$CostIntId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_project_activity_cost_internal_month "
				."\n ".$where_r
				;
		
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */

	/* START  */
	/* Function Name: getItemRequireInternalPopup */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายงบแผ่นดิน *4  */
	function getItemRequireInternalPopup($CostItemCode=0,$PrjActId=0,$PrjId=0,$PrjDetailId=0,$CostTypeId=0,$SCTypeId=0,$ScreenLevel=0,$BgtYear=0,$OrganizeCode=0){
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
		
		if($SCTypeId){
			$where[] = "t3.SCTypeId= '".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t3.ScreenLevel= '".$ScreenLevel."'";
		}		
	
		if($BgtYear){
			$where[] = "t4.BgtYear= '".$BgtYear."'";
		}	
		
		if($OrganizeCode){
			$where[] = "t4.OrganizeCode= '".$OrganizeCode."'";
		}							

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.* "
				."\n from tblbudget_project_activity_cost_internal as t1 "
				."\n left join tblbudget_project_activity as t2 on t2.PrjActId=t1.PrjActId"
				."\n left join tblbudget_project_detail as t3 on t3.PrjDetailId=t2.PrjDetailId"
				."\n left join tblbudget_project as t4 on t4.PrjId=t3.PrjId"				
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();//ltxt::print_r($data);
		return $data;
	}
	/* END */

	/* START  */
	/* Function Name: getItemRequireExternalPopup */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายเงินนอกงบประมาณ *4  */
	function getItemRequireExternalPopup($CostItemCode=0,$PrjActId=0,$PrjId=0,$PrjDetailId=0,$SourceExId=0,$CostTypeId=0,$SCTypeId=0,$ScreenLevel=0,$BgtYear=0,$OrganizeCode=0){
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

		if($SCTypeId){
			$where[] = "t3.SCTypeId= '".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t3.ScreenLevel= '".$ScreenLevel."'";
		}		
	
		if($BgtYear){
			$where[] = "t4.BgtYear= '".$BgtYear."'";
		}	
		
		if($OrganizeCode){
			$where[] = "t4.OrganizeCode= '".$OrganizeCode."'";
		}	

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select t1.* "
				."\n from tblbudget_project_activity_cost_external as t1 "
				."\n left join tblbudget_project_activity as t2 on t2.PrjActId=t1.PrjActId"
				."\n left join tblbudget_project_detail as t3 on t3.PrjDetailId=t2.PrjDetailId"
				."\n left join tblbudget_project as t4 on t4.PrjId=t3.PrjId"			
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();//ltxt::print_r($data);
		return $data;
	}
	/* END */

	/* START #F54 */
	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อระดับการกลั่นกลอง  */
	/* Parameter: */
			/* @ScreenLevel	= ระดับการกลั่นกลอง */
	/* Return Value : Single(loadResult) */
	function getScreenName2($ScreenLevel=0){
		
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

	/* START #F20 */
	/* Function Name: getProjectList */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการประจำปี */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getProjectList($BgtYear=0,$PItemCode=0,$OrganizeCode=0,$tag_name='PrjId',$selected=0,$tag_attribs='onchange="loadPerson(this.value)" style="width:98%"',$lebel='เลือก'){

		$useProject = $this->getUseProject($BgtYear,$PItemCode,$OrganizeCode);
	
		$where = array();
		
		$where[] = " t1.EnableStatus='Y'";
		$where[] = " t1.DeleteStatus='N'";	
		$where[] = " t1.OrganizeCode='".$OrganizeCode."' ";	
		
		if($_REQUEST["PrjDetailId"] == "" && $useProject != ""){
			$where[] = " t1.PrjId not in(".$useProject.")";			
		}
	
		if($BgtYear){
			$where[] = " t1.BgtYear='".$BgtYear."' ";
		}
		$where[] = " t1.PItemCode='".$PItemCode."' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT t1.PrjId as value , t1.PrjName as text "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Left Join tblbudget_init_plan_item AS t2 ON t1.PItemCode = t2.PItemCode "
				."\n Left Join tblorganize AS t3 ON  t1.OrganizeCode = t3.OrganizeCode "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	/* END */

	/* START #F57 */
	/* Function Name: getUseProject */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการโครงการที่ถูกใช้ไปแล้วเป็นรูปแบบ Array */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getUseProject($BgtYear=0,$PItemCode=0,$OrganizeCode=0){
	
		$where = array();
		$where[] = " t2.EnableStatus='Y'";
		$where[] = " t2.DeleteStatus='N'";	
		$where[] = "t2.BgtYear='".$BgtYear."'";
		$where[] = "t2.PItemCode='".$PItemCode."'";
		$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.PrjId"
		."\n FROM "
		."\n tblbudget_project_detail AS t1  "
		."\n LEFT JOIN tblbudget_project AS t2 ON  t1.PrjId = t2.PrjId "
		."\n ".$where_r
		;		
		
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$data = $this->db->loadResultArray();
		$datas = implode(",",$data);
		return $datas;
		
	}
	/* END */

	/* Function Name: getPersonList */
	/* Description: เป็นฟังก์ชันสำหรับแสดงรายการผู้รับผิดชอบโครงการ */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getPersonList($PrjId=0){

   	$TaskPerson = $this->getTaskPerson($PrjId); 
	
	echo  '<tr>
	<th valign="top">ผู้รับผิดชอบโครงการ</th>
   <td class="require">&nbsp;</td>
   <td >	
	';
   echo "<ul>";
   foreach($TaskPerson as $rRName){
   		foreach($rRName as $k=>$v){
			${$k} = $v;
		}
		echo "<li>";
		echo $Name;
		if($ResultStatus == 'Y'){echo " (ผู้รายงาน)";}
		echo "</li>";
   }
   echo "</ul>";
	echo '
	</td>
 </tr>
	';

	}
	/* END */

	/*
	Function Name	: getTaskPerson 
	Description		: เป็นฟังก์ชันสำหรับดึงผู้รับผิดชอบโครงการ
	Parameter		:-
	Return Value 	: Array(loadObjectList) 
	*/		

	function getTaskPerson($PrjId,$view=''){
		$where = array();
		if($view){
		$where[] = "PP.ResultStatus = '".$view."' ";
		}
		$where[] = "PP.PrjId = '".$PrjId."' ";
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
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	
	/* END */	

	/* Function Name: getIndTypeNameList */
	/* Description: เป็นฟังชั่นสำหรับดึงรายการประเภทตัวชี้วัดเป็น List Box 
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getIndTypeNameList($selected=0,$tag_name='IndTypeId[]',$tag_attribs='style="width:95%"',$lebel='เลือก'){
		$where = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT IndTypeId as value , IndTypeName as text "
			 ."\n FROM tblbudget_init_indicator_type "
			 ."\n ".$where_r
			 ."\n order by Ordering ASC"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}	
	/* END */	
	
	/* Function Name: getTypeActNameList */
	/* Description: เป็นฟังชั่นสำหรับดึงรายการประเภทตัวชี้วัดเป็น List Box 
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getTypeActNameList($selected=0,$tag_name='TypeActCode[]',$tag_attribs='style="width:95%"',$lebel='เลือก'){
		$where = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT TypeActCode as value , TypeActName as text "
			 ."\n FROM tblbudget_init_type_activity "
			 ."\n ".$where_r
			 ."\n order by Ordering ASC"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
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

	/*
	Function Name	: getPrjActCode
	Description		: เป็นฟังก์ชันสำหรับดึง PrjActCode ของล่าสุด
	Parameter		:
		@$PrjId = รหัสโครงการ
	Return Value 	: Single(loadResult) 
	*/		
	function getPrjActCode($PrjId){
		$where = array();
		$where[] = "t2.PrjId = '".$PrjId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select DISTINCT  PrjActCode "
				."\n from tblbudget_project_activity as t1 "
				."\n left join tblbudget_project_detail as t2 on t1.PrjDetailId = t2.PrjDetailId "
				."\n ".$where_r
				."\n order by PrjActCode DESC limit 1 "
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	


	/*
	Function Name	: getPrjCode
	Description		: เป็นฟังก์ชันสำหรับดึง PrjCode 
	Parameter		:
		@$PrjId = รหัสโครงการ
	Return Value 	: Single(loadResult) 
	*/		
	function getPrjCode($PrjId){
		$where = array();
		$where[] = "PrjId = '".$PrjId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PrjCode "
				."\n from tblbudget_project"
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	

//----------------------------- party ---------------------------------
	/* 
	Line by Line
	Name			: getNetworkParent
	Description		: เรียกข้อมูลหมวดหมู่ภาคีเครือข่าย
	Parameter		: -
	Return Value 	: ObjectList
	*/
	function getNetworkParent()
	{
		$sql = "SELECT CatGroupId FROM nh_in_categorygroup where CatGroupName='Root' ";
		$this->db->setQuery($sql);
		$CatGroupId = $this->db->loadResult(); 
		
		$sql = "SELECT * FROM nh_in_categorygroup where CatGroupParent='$CatGroupId' order by CONVERT(CatGroupName USING TIS620) ASC  ";
		$this->db->setQuery($sql);
		$List = $this->db->loadObjectList(); 
		
		return $List;
	}
	
	/* 
	Line by Line
	Name			: getSubNetwork
	Description		: เรียกข้อมูลหมวดหมู่ย่อยภาคีเครือข่าย
	Parameter		: CatGroupId(รหัสของตาราง nh_in_categorygroup)
	Return Value 	: ObjectList
	*/
	function getSubNetwork($CatGroupId)
	{
		$sql = "SELECT * FROM nh_in_categorygroup where CatGroupParent='$CatGroupId' AND EnableStatus='Y' AND DeleteStatus='N'  order by CONVERT(CatGroupName USING TIS620) ASC  ";
		//echo $sql;
		$this->db->setQuery($sql);
		$List = $this->db->loadObjectList(); 
		return $List;
	}

	function getPartyPerson($CatGroupCode){
		
		$where = array();
		$where[] = " t1.CatGroupCode IN ('$CatGroupCode')  ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select t1.PartnerCode,concat(t3.PtnPrefixTH,t2.PtnFname,' ',t2.PtnSname) as PtnFullName, t2.PositionName, t2.Under
				from tblmou_owner as t1	
				left join nh_in_partner	 as t2					on t1.PartnerCode = t2.PartnerCode
				left join nh_in_partner_prefix as t3			on t2.PrefixUid = t3.PrefixUid
		 		".$where_r." order by t1.Ordering desc";
		//echo $sql;
		$this->db->setQuery($sql);
		$List = $this->db->loadObjectList(); 
		return $List;
		
	}

	/* Function Name: getIndicator */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของกิจกรรม*/
	function getPartySelect($PrjActId=0){
		$sql = "select PartyId,PartnerCode,CatGroupId,CatGroupCode "
				."\n from tblbudget_project_party "
				."\n where PrjActId='".$PrjActId."'"
				."\n order by PartyId ASC  "
				;
		//echo "<pre>$sql</pre>";	
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */	

//----------------------------------------------------------------------

	/*
	Function Name	: getCountSubSCType
	Description		: เป็นฟังก์ชันสำหรับนับว่าขั้นตอนการจัดทำงบประมาณที่วนมามีขั้นตอนย่อยหรือไม่
	Parameter		:
		@$SCTypeId = รหัสขั้นตอนการจัดทำงบประมาณ
	Return Value 	: Single(loadResult) 
	*/		
/*	function getCountSubSCType($BgtYear,$SCTypeId){
		$where = array();
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
		$where[] = "BgtYear='".$BgtYear."'";
				
		$where[] = "SCTypeId = '".$SCTypeId."'";
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select count(*)  "
				."\n from tblbudget_init_screen_item"
				."\n ".$where_r
				;
				
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}*/
	/* END */	







	///--------------------------------------------------------------------------------------------------------------
	function getScreenRecordSet($BgtYear=0){
		return $this->dpublic->getScreenRecordSet($BgtYear);
	}
	
	function getCurProcess($BgtYear=0,$OrganizeCode=0){
		return $this->dpublic->getCurProcess($BgtYear,$OrganizeCode);
	}
	
	function getListScreenLevel($BgtYear=0){
		return $this->dpublic->getListScreenLevel($BgtYear);
	}
	
	function getNameByScreen($BgtYear=0,$ScreenLevel=0,$SCTypeId=0,$countScreenLevel=0){
		$where = array();
		$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.SCTypeId='".$SCTypeId."'";
		$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n t1.ScreenName "
				."\n FROM "
				."\n tblbudget_init_screen_item as t1  "
				."\n left join tblbudget_init_screen_type as t2 on t2.SCTypeId=t1.SCTypeId "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		 return $datas;
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
	
	function countProject($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel){
		$where = array();
		$where[] = "t2.BgtYear = '".$BgtYear."'";
		$where[] = "t2.OrganizeCode = '".$OrganizeCode."'";
		$where[] = "t1.SCTypeId = '".$SCTypeId."'";
		$where[] = "t1.ScreenLevel = '".$ScreenLevel."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select count(*)  "
				."\n from tblbudget_project_detail as t1 "
				."\n left join tblbudget_project as t2 on t2.PrjCode=t1.PrjCode "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult(); 
		return $data;
		
	}
	
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
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getTaskIndPerson($IndicatorCode){
		$where = array();
		$where[] = "PP.IndicatorCode = '".$IndicatorCode."' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "SELECT P.PersonalCode,
					CONCAT(PR.PrefixName,
					P.FirstName,' ',
					P.LastName) as Name
					FROM
					tblbudget_project_indicator_person AS PP
					Inner Join tblpersonal AS P ON PP.PersonalCode = P.PersonalCode
					Inner Join tblpersonal_prefix AS PR ON PR.PrefixId = P.PrefixId "
					."\n ".$where_r;
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	
	
	function getIndicatorMonth($IndicatorCode,$MonthNo){
		$where 	  = array();
		$where[] ="IndicatorCode='".$IndicatorCode."'";
		$where[] ="MonthNo='".$MonthNo."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT MonthTargetPlan "
				."\n FROM "
				."\n tblbudget_project_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getIndDetail($PrjIndId){
		$where 	  = array();
		$where[] ="t1.PrjIndId='".$PrjIndId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblbudget_project_indicator as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function getQTIndMonth($PrjIndId,$MonthNo){
		$where 	  = array();
		$where[] ="PrjIndId='".$PrjIndId."'";
		$where[] ="MonthNo='".$MonthNo."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QTMTargetPlan "
				."\n FROM "
				."\n tblbudget_project_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getQTIndMonthResult($PrjIndId,$MonthNo){
		$where 	  = array();
		$where[] ="PrjIndId='".$PrjIndId."'";
		$where[] ="MonthNo='".$MonthNo."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QTMTargetResult "
				."\n FROM "
				."\n tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getQLIndMonth($PrjIndId,$MonthNo){
		$where 	  = array();
		$where[] ="PrjIndId='".$PrjIndId."'";
		$where[] ="MonthNo='".$MonthNo."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QLMTargetPlan "
				."\n FROM "
				."\n tblbudget_project_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getQLIndMonthResult($PrjIndId,$MonthNo){
		$where 	  = array();
		$where[] ="PrjIndId='".$PrjIndId."'";
		$where[] ="MonthNo='".$MonthNo."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QLMTargetResult "
				."\n FROM "
				."\n tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getTQLScore($PrjIndId,$selected=0,$tag_name='QLYTargetPlan0',$tag_attribs='style="width:98%;"',$lebel='ระบุ'){
		$where = array();
		$where[] = "PrjIndId = '".$PrjIndId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT TQLScore0,TQLScore1,TQLScore2,TQLScore3,TQLScore4,TQLScore5 "
			 ."\n FROM tblbudget_project_indicator "
			 ."\n ".$where_r
			 ;		 
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	
		$datas = $this->db->loadObjectList();
		$title[] = clssHTML::makeOption(0,$lebel);
		foreach($datas as $row){
			foreach( $row as $a=>$q){ ${$a} = $q;}
			$data[0] = clssHTML::makeOption($TQLScore0,$TQLScore0);
			$data[1] = clssHTML::makeOption($TQLScore1,$TQLScore1);
			$data[2] = clssHTML::makeOption($TQLScore2,$TQLScore2);
			$data[3] = clssHTML::makeOption($TQLScore3,$TQLScore3);
			$data[4] = clssHTML::makeOption($TQLScore4,$TQLScore4);
			$data[5] = clssHTML::makeOption($TQLScore5,$TQLScore5);
		}
		$data = array_merge($title,$data);
		echo clssHTML::selectList( $data, $tag_name, $tag_attribs,'value','text', $selected );
	}	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function getProject($PrjDetailId=0){
		$where = array();
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}else{
			if(!$_REQUEST["BgtYear"]){
				$_REQUEST["BgtYear"] = date("Y")+543;
			}
			$where[] = "t2.BgtYear='".$_REQUEST["BgtYear"]."'";
		}
		$where[] = "t1.ActiveStatus ='Y' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
		."\n t1.*, "
		."\n t2.BgtYear, "
		."\n t2.OrganizeCode, "
		."\n t2.PrjId, "
		."\n t2.PrjCode, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t2.PrjMethods, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		//."\n inner Join tblbudget_project_person as t4 on t4.PrjId = t2.PrjId "				
		."\n ".$where_r
		."\n order by t2.PrjCode "
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	/* END */
	
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
	
	function getMTargetScore($IndicatorCode,$MonthNo){
		$where = array();
		$where[] = "IndicatorCode = '".$IndicatorCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MTargetScore "
				."\n from tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		$data = ($data)?$data:"0";
		return $data;
	}	
	
	function getMaxQTMTargetResult($IndicatorCode){
		$where = array();
		$where[] = "IndicatorCode = '".$IndicatorCode."'";
		$where[] = "MTargetScore = (select max(MTargetScore) from tblbudget_project_indicator_month_result where IndicatorCode='".$IndicatorCode."' )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MTargetScore,QTMTargetResult "
				."\n from tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadObjectList();
		return $data;
	}	
	
	function getMaxQLMTargetResult($IndicatorCode){
		$where = array();
		$where[] = "IndicatorCode = '".$IndicatorCode."'";
		$where[] = "MTargetScore = (select max(MTargetScore) from tblbudget_project_indicator_month_result where IndicatorCode='".$IndicatorCode."' )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MTargetScore,QLMTargetResult "
				."\n from tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo '<pre>'.$sql.'</pre>';
		$data = $this->db->loadObjectList();
		return $data;
	}	
	
		/////////////////////////////////////////////////////////////////////////////////////////////////
	
	function getCalQTScore($PrjIndId,$scoreResult){
		$indicator = $this->getIndDetail($PrjIndId);//ltxt::print_r($indicator);
		foreach($indicator as $in){ foreach( $in as $a=>$q){ ${$a} = $q;} }
		switch($scoreResult){
			case (($scoreResult >= $QTMinScore0)&&($scoreResult <= $QTMaxScore0)) :
				$YTargetScore = $Score0;
			break;
			case (($scoreResult >= $QTMinScore1)&&($scoreResult <= $QTMaxScore1)) :
				$YTargetScore = $Score1;
			break;
			case (($scoreResult >= $QTMinScore2)&&($scoreResult <= $QTMaxScore2)) :
				$YTargetScore =$Score2;
			break;
			case (($scoreResult >= $QTMinScore3)&&($scoreResult <= $QTMaxScore3)) :
				$YTargetScore = $Score3;
			break;
			case (($scoreResult >= $QTMinScore4)&&($scoreResult <= $QTMaxScore4)) :
				$YTargetScore = $Score4;
			break;
			case (($scoreResult >= $QTMinScore5)&&($scoreResult <= $QTMaxScore5)) :
				$YTargetScore = $Score5;
			break;
			default:
				$YTargetScore = 0;
		}
		return $YTargetScore;
	}
	
	function getCalQLScore($PrjIndId,$scoreResult){
		$indicator = $this->getIndDetail($PrjIndId);
		foreach($indicator as $in){ foreach( $in as $a=>$q){ ${$a} = $q;} }
		switch($scoreResult){
			case ($scoreResult == $TQLScore0) :
				$YTargetScore = $Score0;
			break;
			case ($scoreResult == $TQLScore1) :
				$YTargetScore = $Score1;
			break;
			case ($scoreResult == $TQLScore2) :
				$YTargetScore = $Score2;
			break;
			case ($scoreResult == $TQLScore3) :
				$YTargetScore = $Score3;
			break;
			case ($scoreResult == $TQLScore4) :
				$YTargetScore = $Score4;
			break;
			case ($scoreResult == $TQLScore5) :
				$YTargetScore = $Score5;
			break;
			default:
				$YTargetScore = 0;
		}
		return $YTargetScore;
	}
	
	
	

}// end class		

?>
