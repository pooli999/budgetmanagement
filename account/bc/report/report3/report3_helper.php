<?php

class sHelper
{
	var $db;
	var $debug = 0;
	/* 
	START #F1
	Function Name		: sHelper 
	Description			: เป็นฟังก์ชันสำหรับติดต่อฐานข้อมูล
	Parameter			: -
	Return Value 		: -
	*/	
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
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
		

	/* START #F2 */
	/* Function Name: getCostTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: - */
	/* Return Value : Array(loadObjectList) */
	function getCostTypeRecordSet($CostTypeId=0){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		$CostTypeId = ($_REQUEST["CostTypeId"])?$_REQUEST["CostTypeId"]:$CostTypeId;
		if($CostTypeId){
			$where[] = "CostTypeId = '".$CostTypeId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostTypeId,CostTypeName,Ordering "
			 ."\n FROM tblbudget_init_cost_type "
			 ."\n ".$where_r
			 ."\n order by Ordering"
			 ;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F5 */
	/* Function Name: getCostItemRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: */
			/* @CostTypeId	= รหัสหมวดงบประมาณ */
			/* @LevelId	 	 	= รหัสระดับรายการ */
			/* @ParentCode 		= รหัสรายการ Parent */
	/* Return Value : Array(loadObjectList) */
	function getCostItemRecordSet($CostTypeId=0,$LevelId=1,$ParentCode=0,$HasChild=0,$CostItemCode=0){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		$where[] = "CostTypeId='".$CostTypeId."'";
		$where[] = "LevelId='".$LevelId."'";
		if($ParentCode){
			$where[] = "ParentCode='".$ParentCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostItemId, CostItemCode, CostName, LevelId, ParentCode, HasChild, CostTypeId "
			 ."\n FROM tblbudget_init_cost_item "
			 ."\n ".$where_r
			 ;
			 //echo $sql;
		$this->db->setQuery($sql); //echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
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
	
	function getTotalPrjMonth($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0,$SourceExId=0){
		$BGInternal = $this->getTotalPrjMonthInternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$BGExternal = $this->getTotalPrjMonthExternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$SourceExId);
		$result = $BGInternal+$BGExternal;
		return $result;
	}
	
	
		/* START #F58 */
	/* Function Name: getTotalPrjInternalMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการรายเดือน/ไตรมาส(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjMonthInternal($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		if($_REQUEST["BgtYear"]){
			$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		}
		if($_REQUEST["OrganizeCode"]){
			$where[] = "t1.OrganizeCode='".$_REQUEST["OrganizeCode"]."'";
		}
		if($_REQUEST["PItemCode"]){
			$where[] = "t1.PItemCode='".$_REQUEST["PItemCode"]."'";
		}
		if($_REQUEST["PrjDetailId"]){
			$where[] = "t2.PrjDetailId='".$_REQUEST["PrjDetailId"]."'";
		}
		if($_REQUEST["PrjActId"]){
			$where[] = "t3.PrjActId='".$_REQUEST["PrjActId"]."'";
		}
		if($_REQUEST["ScreenLevel"]){
			$where[] = "t2.ScreenLevel='".$_REQUEST["ScreenLevel"]."'";
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
		$CostTypeId = ($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"];
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.Budget)as total "
				."\n FROM "
				."\n tblbudget_project_activity_cost_internal_month as t8 "
				."\n Inner Join tblbudget_project_activity_cost_internal AS t4 ON t4.CostIntId = t8.CostIntId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjActId = t4.PrjActId "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n Inner Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t5.PItemCode = t1.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t6.CostItemCode = t4.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t7.CostTypeId = t6.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	
	
	/* START #F58 */
	/* Function Name: getTotalPrjInternalMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการรายเดือน/ไตรมาส(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjMonthExternal($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0,$SourceExId=0){
		$where = array();
		if($_REQUEST["BgtYear"]){
			$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		}
		if($_REQUEST["OrganizeCode"]){
			$where[] = "t1.OrganizeCode='".$_REQUEST["OrganizeCode"]."'";
		}
		if($_REQUEST["PItemCode"]){
			$where[] = "t1.PItemCode='".$_REQUEST["PItemCode"]."'";
		}
		if($_REQUEST["PrjDetailId"]){
			$where[] = "t2.PrjDetailId='".$_REQUEST["PrjDetailId"]."'";
		}
		if($_REQUEST["PrjActId"]){
			$where[] = "t3.PrjActId='".$_REQUEST["PrjActId"]."'";
		}
		if($_REQUEST["ScreenLevel"]){
			$where[] = "t2.ScreenLevel='".$_REQUEST["ScreenLevel"]."'";
		}
		if($SourceExId){
			$where[] = "t4.SourceExId='".$SourceExId."'";
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
		$CostTypeId = ($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"];
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if($MonthNo){
			$where[] = "t8.MonthNo='".$MonthNo."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.Budget)as total "
				."\n FROM "
				."\n tblbudget_project_activity_cost_external_month as t8 "
				."\n Inner Join tblbudget_project_activity_cost_external AS t4 ON t4.CostExtId = t8.CostExtId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjActId = t4.PrjActId "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n Inner Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t5.PItemCode = t1.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t6.CostItemCode = t4.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t7.CostTypeId = t6.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	
	function getYearProject($selected=0,$tag_name='BgtYear',$tag_attribs='onchange="loadStep(this.value)"',$label='ทั้งหมด'){
		$where = array();
		//$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$selected = ($selected)?$selected:$_REQUEST["BgtYear"];
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
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getPlanItemList($selected=0,$tag_name='PItemCode',$tag_attribs='style="width:500px;" onchange="loadPrj()"',$label='ทั้งหมด'){
		$where = array();
		//$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		$where[] = "t1.PGroupId='12'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.PItemCode)as value , t1.PItemName as text "
			 ."\n FROM tblbudget_init_plan_item as t1 "
			 ."\n ".$where_r
			 ."\n order by t1.PItemCode ASC "
			  //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getStepList($selected=0,$tag_name='ScreenLevel',$tag_attribs='style="width:500px;"',$label='ทั้งหมด'){
		$where = array();
		//$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t2.ScreenLevel)as value , t1.ScreenName as text "
			 ."\n FROM tblbudget_init_screen_item as t1 "
			 ."\n inner join tblbudget_project_detail as t2 on t2.ScreenLevel=t1.ScreenLevel"
			 ."\n ".$where_r
			 ."\n order by t1.ScreenLevel ASC "
			  //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getOrgList($selected=0,$tag_name='OrganizeCode',$tag_attribs='style="width:500px;" onchange="loadPrj()"',$label='ทั้งหมด'){
		
		$where = array();
		//$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.OrganizeCode as value , t2.OrgName as text "
			."\n FROM "
			."\n tblbudget_init_year_org as t1  "
			."\n left Join tblorganize AS t2 ON t1.OrgId = t2.OrgId AND t1.BgtYear = t2.OrgYear "
			."\n ".$where_r
			."\n ORDER BY CONVERT(t2.OrgName USING TIS620) ASC "
			;	 
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	
	/* START #F20 */
	/* Function Name: getProjectList */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการประจำปี */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @label 			= label ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getProjectList($selected=0,$tag_name='PrjDetailId',$tag_attribs='style="width:98%;" onchange="loadPrjAct(this.value)"',$label='ทั้งหมด'){
		$where = array();
		
		//$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "t4.BgtYear='".$_REQUEST["BgtYear"]."'";
		
		$ScreenLevel = ($_REQUEST["ScreenLevel"])?$_REQUEST["ScreenLevel"]:"";
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}
		
		$PItemCode = ($_REQUEST["PItemCode"])?$_REQUEST["PItemCode"]:"";
		if($PItemCode){
			$where[] = "t4.PItemCode='".$PItemCode."'";
		}
		$OrganizeCode = ($_REQUEST["OrganizeCode"])?$_REQUEST["OrganizeCode"]:"";
		if($OrganizeCode){
			$where[] = "t4.OrganizeCode='".$OrganizeCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT distinct(t1.PrjDetailId)as value , t4.PrjName as text "
				."\n FROM "
				."\n tblbudget_project_detail AS t1 "
				."\n Left Join tblbudget_project AS t4 ON  t4.PrjId = t1.PrjId "
				."\n ".$where_r
				."\n order by t4.PItemCode "
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	/* END */


	function getProjectActList($selected=0,$tag_name='PrjActId',$tag_attribs='style="width:98%;"',$label='ทั้งหมด'){
		$where = array();
		$where[] = "tm.PrjDetailId='".$_REQUEST["PrjDetailId"]."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT tm.PrjActId as value , tm.PrjActName as text "
				."\n FROM "
				."\n tblbudget_project_activity AS tm "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	
	
	function getCostTypeList($selected=0,$tag_name='CostTypeId',$tag_attribs='style="width:500px;"',$label='ทั้งหมด'){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostTypeId as value , CostTypeName as text "
			 ."\n FROM tblbudget_init_cost_type "
			 ."\n ".$where_r
			 ."\n order by Ordering ASC"
			 ;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getSourceExternal($selected=0,$tag_name='SourceExId',$tag_attribs='style="width:200px;"',$label='ทั้งหมด'){
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT SourceExId as value , SourceExName as text "
			 ."\n FROM tblbudget_init_source_external "
			 ."\n ".$where_r
			 ;
		
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	
	function getSourceExName($SourceExId){
	
		$where = array();
		$where[] = "SourceExId='".$SourceExId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select SourceExName "
				."\n from tblbudget_init_source_external "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	
	function getScreenName($BgtYear,$ScreenLevel){
	
		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "ScreenLevel='".$ScreenLevel."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select ScreenName "
				."\n from tblbudget_init_screen_item "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	
	function getCostTypeName($CostTypeId){
	
		$where = array();
		$where[] = "CostTypeId='".$CostTypeId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select CostTypeName "
				."\n from tblbudget_init_cost_type "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	
	function getPrjActName($PrjActId){
	
		$where = array();
		$where[] = "PrjActId='".$PrjActId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select PrjActName "
				."\n from tblbudget_project_activity "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	
	function getPrjName($PrjDetailId){
	
		$where = array();
		$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select t2.PrjName "
				."\n from tblbudget_project_detail as t1 "
				."\n left join tblbudget_project as t2 on t2.PrjId=t1.PrjId "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	
	function getPItemName($BgtYear,$PItemCode){
	
		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "PItemCode='".$PItemCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select PItemName "
				."\n from tblbudget_init_plan_item "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	
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
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getSourceYear($BgtYear){
		$where = array();
		$where[] = "t5.BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select distinct(t1.SourceExId),t2.SourceExName "
				."\n from tblbudget_project_activity_cost_external as t1 "
				."\n left join tblbudget_init_source_external as t2 on t2.SourceExId=t1.SourceExId "
				."\n left join tblbudget_project_activity as t3 on t3.PrjActId=t1.PrjActId "
				."\n left join tblbudget_project_detail as t4 on t4.PrjDetailId=t3.PrjDetailId "
				."\n left join tblbudget_project as t5 on t5.PrjId=t4.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data=$this->db->loadObjectList();	//ltxt::print_r($row);
		return $data;
	}




}
?>
