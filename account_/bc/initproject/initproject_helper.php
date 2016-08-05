<?php

class sHelper
{
	var $dpublic;
	var $db;
	var $debug = 0;
	/* 
	START #F1
	Function Name		: sHelper 
	Description			: เป็นฟังก์ชันสำหรับติดต่อฐานข้อมูล
	Parameter			: -
	Return Value 		: -
	*/	
	function sHelper(){
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
		$this->dpublic		= new BGPublic();
	}
	/*END*/
	
	function getQueryString(){
		$expStr = explode("&",$_SERVER['QUERY_STRING']);
		unset($expStr[0]);
		$impStr = implode("&",$expStr);
		if($impStr){
			$impStr = "&".$impStr;
		}
		return $impStr;
	}
	
	function getYear($Year,$ObjYear){
		return $this->dpublic->getYear($Year,$ObjYear);
	}	
	
	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0){
		return $this->dpublic->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId);
	}	
	
/*	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}

	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		return $this->dpublic->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	}	*/
	
	
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
	
	
	/* 
	START #F3
	Function Name	: getProject 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการโครงการ
	Parameter		:
		@$PItemCode	=  รหัสแผนงาน
		@$BgtYear = ปีงบประมาณ
	Return Value 	: Array(loadDataSet) 
	*/		
	function getProject($PItemCode,$BgtYear){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		$where[] = "PItemCode='".$PItemCode."'";
		
		if($BgtYear == ""){
			$BgtYear = date("Y")+543;
		}
		
		$where[] = "BgtYear='".$BgtYear."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_project ".$where_r." order by CONVERT(PrjCode USING TIS620) ASC ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	
	}
	/*END*/
		
	/*START #F4
	Function Name	: getOrgShortName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อย่อหน่วยงาน
	Parameter		:
		@$BgtYear = ปีงบประมาณ
		@$OrganizeCode	=  รหัสหน่วยงาน
	Return Value 	: Single(loadResult) 
	*/		
	function getOrgShortName($BgtYear=0, $OrganizeCode=0){
		$where = array();
		$where[] = "OrgYear = '".$BgtYear."'";
		$where[] = "OrganizeCode = '".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select OrgShortName "
				."\n from tblorganize "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	
	
	
	/* 
	START #F5
	Function Name: getPrjName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อโครงการ
	Parameter		: 
		@PrjId	= ID (PK) ของตาราง tblbudget_project
	Return Value 	: single(loadResult) 
	*/	
	function getPrjName($PrjId){
		$where 	  = array();
		if($PrjId){
			$where[] ="PrjId='".$PrjId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select PrjName from tblbudget_project ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/	
	
	/* START #F6 */
	/* Function Name: getPlanItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการนโยบายแผนงาน  */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getPlanItemList($BgtYear=0,$selected=0,$tag_attribs='onchange="loadPrj()" style="width:80%"',$tag_name='PItemCode',$lebel='เลือก'){
		$where = array();
		
		if($BgtYear == ""){
			$BgtYear = date("Y")+543;
		}
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "PGroupId=12 ";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT PItemCode as value , PItemName as text "
			 ."\n FROM tblbudget_init_plan_item "
			 ."\n ".$where_r
			 ."\n order by PItemCode ASC "
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
	/* START 7 */
	/* Function Name: getOrgShortNameList */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	function getOrgShortNameList($BgtYear=0,$selected=0,$tag_attribs='onchange="loadPrj()"  style="width:80%"',$tag_name='OrganizeCode',$lebel='เลือก'){
		$where = array();

		if($BgtYear == ""){
			$BgtYear = date("Y")+543;
		}
		
		$where[] = " t1.BgtYear='".$BgtYear."'";
	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.OrganizeCode as value , t2.OrgName as text "
			 ."\n FROM tblbudget_init_year_org as t1 "
			 ."\n left join tblorganize as t2 on t2.OrgId=t1.OrgId "
			 ."\n ".$where_r
			 ;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	/* END */		
	
	
	/* 
	START #F8
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดขั้นตอนการกลั่นกรองงบประมาณ 
	Parameter		: 
		@PrjId	= ID (PK) ของตาราง tblbudget_project
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($PrjId){
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
	/*END*/

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

	/* Function Name: getProjectList */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการประจำปี */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getProjectList($BgtYear=0,$PItemCode=0,$OrganizeCode=0,$tag_name='OldPrjId',$selected=0,$tag_attribs='style="width:60%"',$lebel='เลือก'){
	
		$where = array();
		
		$where[] = " t1.EnableStatus='Y'";
		$where[] = " t1.DeleteStatus='N'";	
		
		if($OrganizeCode){
		$where[] = " t1.OrganizeCode='".$OrganizeCode."' ";	
		}
		
		if($BgtYear){
			$where[] = " t1.BgtYear='".$BgtYear."' ";
		}
		
		if($PItemCode){
			$where[] = " t1.PItemCode='".$PItemCode."' ";
		}

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
	
	/*
	Function Name	: getOldPrjCode 
	Description		: เป็นฟังก์ชันสำหรับดึง PrjCode ของโครงการล่าสุด
	Parameter		:
		@$BgtYear = ปีงบประมาณ
		@$OrganizeCode = หน่วยงาน
		@$PItemCode = รหัสแผนงาน สช
	Return Value 	: Single(loadResult) 
	*/		
	function getOldPrjCode($BgtYear,$PItemCode){
		$where = array();
		$where[] = "BgtYear = '".$BgtYear."'";
		$where[] = "PItemCode = '".$PItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PrjCode "
				."\n from tblbudget_project "
				."\n ".$where_r
				."\n order by PrjCode DESC limit 1 "
				;
		echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	
	
	/*START #F4
	Function Name	: getPItemCode 
	Description		: เป็นฟังก์ชันสำหรับดึงรหัสนโยบายแผนงาน
	Parameter		:
		@$PItemCode	=  ID โยบายแผนงาน
	Return Value 	: Single(loadResult) 
	*/		
	function getPItemCode($PItemCode){
		$where = array();
		$where[] = "PItemCode = '".$PItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PItemCode "
				."\n from tblbudget_init_plan_item "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	

	/* Function Name: getMapCode */
	/* Description: เป็นฟังก์ชันสำหรับดึง Code */
		function getMapCode($BgtYear,$PItemCode,$PrjCode){
			
		if($PrjCode){	
			$GSubCode = 	substr($PrjCode,5,1);
		}else{
			$GSubCode = "A";
		}
		
		//echo "GSubCode= ".$GSubCode;
		$PItemCode = $this->getPItemCode($PItemCode);		
		$PrjCode = $PItemCode.$GSubCode;
			
		$where = array();
		$where[] = "PrjCode = '".$PrjCode."'";
		$where[] = "PItemCode = '".$PItemCode."'";
		$where[] = "BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PrjCode "
				."\n from tblbudget_project "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadSingleObject();
		return $data;
		}
	/* END */
	
	
	function getMainList($selected=0,$tag_attribs='onchange="loadMainPlan(this.value)" style="width:50%"',$tag_name='PLongCode',$lebel='=ระบุแผนหลัก='){
		$where = array();
		$where[] ="DeleteStatus <> 'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PLongCode as value , PLongName as text "
			 ."\n FROM tblbudget_longterm "
			 ."\n ".$where_r
			 ."\n order by PLongYear ASC "
			 ;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getMainPlanList($PLongCode=0,$selected=0,$tag_attribs='onchange="loadMainProject(this.value)" style="width:50%"',$tag_name='LPlanCode',$lebel='=ระบุแผนงานภายใต้แผนหลัก='){
		$where = array();
		$where[] ="t1.PLongCode='".$PLongCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.LPlanCode as value , concat('(',t1.LPlanCode,')','   ',t1.LPlanName)as text "
			 ."\n FROM tblbudget_longterm_plan as t1 "
			 ."\n left join tblbudget_longterm as t2 on t2.PLongCode=t1.PlongCode "
			 ."\n ".$where_r
			 ."\n order by t1.LPlanCode ASC "
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getMainProjectList($LPlanCode=0,$selected=0,$tag_attribs='style="width:98%"',$tag_name='LPrjCode',$lebel='=ระบุโครงการภายใต้แผนงาน='){
		$where = array();
		$where[] ="t1.LPlanCode='".$LPlanCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.LPrjCode as value , concat('(',t1.LPrjCode,')','   ',t1.LPrjName)as text "
			 ."\n FROM tblbudget_longterm_plan_project as t1 "
			 ."\n left join tblbudget_longterm_plan as t2 on t2.LPlanCode=t1.LPlanCode "
			 ."\n ".$where_r
			 ."\n order by t1.LPrjCode ASC "
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getLPlanCode($LPrjCode){
		$where 	  = array();
		$where[] ="LPrjCode='".$LPrjCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select LPlanCode from tblbudget_longterm_plan_project ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	
	function getPLongCode($LPlanCode){
		$where 	  = array();
		$where[] ="LPlanCode='".$LPlanCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select PLongCode from tblbudget_longterm_plan ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	
	function getSumPrjMass($PItemCode){
		$where = array();
		$where[] = "PItemCode = '".$PItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select sum(PrjMass) "
				."\n from tblbudget_project "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
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



}// end 
?>
