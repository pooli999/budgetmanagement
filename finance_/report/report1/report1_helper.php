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
	
	/*function getTotalPrjMonth($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0,$MonthNo=0){
		switch($_REQUEST["ExType"]){
			case "Internal":
					//$BGInternal = $this->getTotalPrjMonthInternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$MonthNo);
					//return $BGInternal;
			break;
			case "External":
					$BGExternal = $this->getTotalPrjMonthExternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$MonthNo);
					return $BGExternal;
			break;
			default:
					//$BGInternal = $this->getTotalPrjMonthInternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$MonthNo);
					$BGExternal = $this->getTotalPrjMonthExternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$MonthNo);
					$result = $BGInternal+$BGExternal;
					return $result;
		}
	}*/
	
	
		/* START #F58 */
	/* Function Name: getTotalPrjInternalMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการรายเดือน/ไตรมาส(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjMonthInternal($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0,$MonthNo=0){
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
		if($MonthNo){
			$where[] = "t8.MonthNo='".$MonthNo."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		/*$sql="SELECT "
				."\n sum(t8.Budget)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_internal AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n Inner Join tblbudget_project_activity_cost_internal_month AS t8 ON t8.CostIntId = t4.CostIntId "
				."\n ".$where_r
				;*/
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
	/* Function Name: getTotalPrjMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการรายเดือน/ไตรมาส(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjMonth($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0,$MonthNo=0){
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
		if($_REQUEST["SourceExId"]){
			$where[] = "t4.SourceExId='".$_REQUEST["SourceExId"]."'";
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
		/*$sql="SELECT "
				."\n sum(t8.Budget)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_external AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n Inner Join tblbudget_project_activity_cost_external_month AS t8 ON t8.CostExtId = t4.CostExtId "
				."\n ".$where_r
				;*/
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
		$datas = $this->db->loadResult();
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
		$where[] = "BgtYear='".$_REQUEST["BgtYear"]."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT OrganizeCode as value , OrgName as text "
			 ."\n FROM tblbudget_init_year_org "
			 ."\n ".$where_r
			 ."\n order by OrgName "
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
		$where[] = "t1.ActiveStatus='Y'";
		
		$PItemCode = ($_REQUEST["PItemCode"])?$_REQUEST["PItemCode"]:"";
		if($PItemCode){
			$where[] = "t4.PItemCode='".$PItemCode."'";
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
	
	function getSourceExternal($selected=0,$tag_name='SourceExId',$tag_attribs='',$label='ทั้งหมด'){
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
	
	function getOrgName($BgtYear,$OrganizeCode){
	
		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "OrganizeCode='".$OrganizeCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select OrgName "
				."\n from tblbudget_init_year_org "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	
	function getActRecordSet($PrjDetailId){
		$where = array();
		$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		if($_REQUEST["PrjActId"]){
			$where[] = "t1.PrjActId='".$_REQUEST["PrjActId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
			 ."\n FROM tblbudget_project_activity as t1 "
			  ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	
	function getItemRecordSet($PrjActCode){
		$where = array();
		$where[] = "t1.PrjActCode='".$PrjActCode."'";
		$where[] = "t1.DocCodeRefer is NULL ";
		if($_REQUEST["SourceExId"]){
			$where[] = "t1.SourceExId='".$_REQUEST["SourceExId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
			 ."\n FROM tblfinance_doccode as t1 "
			  ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	
	function getSubItemRecordSet($DocCodeRefer){
		$where = array();
		$where[] = "t1.DocCodeRefer='".$DocCodeRefer."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
			 ."\n FROM tblfinance_doccode as t1 "
			  ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	
	/* START*/
	/* Function Name: getSumBGPlan */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณตามแผน */
	function getSumBGPlan($PrjDetailId,$PrjActId){
		$where = array();
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($_REQUEST["SourceExId"]){
			$where[] = "t4.SourceExId='".$_REQUEST["SourceExId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.Budget)as total "
				."\n FROM "
				."\n tblbudget_project_activity_cost_external_month as t8 "
				."\n left Join tblbudget_project_activity_cost_external AS t4 ON t4.CostExtId = t8.CostExtId "
				."\n left Join tblbudget_project_activity AS t3 ON t3.PrjActId = t4.PrjActId "
				."\n left Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n left Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	
	/* START*/
	/* Function Name: getSumBGHold */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณหลักการคงเหลือ */
	function getSumBGHold($PrjDetailId,$PrjActId,$DocCode=0){
		$where = array();
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($DocCode){
			$where[] = "t8.DocCode='".$DocCode."'";
		}
		if($_REQUEST["SourceExId"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGHold)as total "
				."\n FROM "
				."\n tblfinance_bg_hold as t8 "
				."\n left Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCode "
				."\n left Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n left Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START*/
	/* Function Name: getSumBGChain */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณผูกพันคงเหลือ */
	function getSumBGChain($PrjDetailId,$PrjActId,$DocCode=0){
		$where = array();
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($DocCode){
			$where[] = "t8.DocCode='".$DocCode."'";
		}
		if($_REQUEST["SourceExId"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGChain)as total "
				."\n FROM "
				."\n tblfinance_bg_chain as t8 "
				."\n left Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCode "
				."\n left Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n left Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START*/
	/* Function Name: getSumBGPay */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณเบิกจ่าย */
	function getSumBGPay($PrjDetailId,$PrjActId,$DocCode=0){
		$where = array();
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($DocCode){
			$where[] = "t8.DocCode='".$DocCode."'";
		}
		if($_REQUEST["SourceExId"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGPay)as total "
				."\n FROM "
				."\n tblfinance_bg_pay as t8 "
				."\n left Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCode "
				."\n left Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n left Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START*/
	/* Function Name: getSumBGTferIn */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณรับโอน */
	function getSumBGTferIn($PrjDetailId,$PrjActId){
		$where = array();
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($_REQUEST["SourceExId"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGTfer)as total "
				."\n FROM "
				."\n tblfinance_bg_transfer as t8 "
				."\n left Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCodeTo "
				."\n left Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n left Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START*/
	/* Function Name: getSumBGTferOut */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโอนออก */
	function getSumBGTferOut($PrjDetailId,$PrjActId){
		$where = array();
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($_REQUEST["SourceExId"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGTfer)as total "
				."\n FROM "
				."\n tblfinance_bg_transfer as t8 "
				."\n left Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCodeFrom "
				."\n left Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n left Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START*/
	/* Function Name: getSumBGBorrow */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณยืมเงิน */
	function getSumBGBorrow($PrjDetailId,$PrjActId,$DocCode=0){
		$where = array();
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($DocCode){
			$where[] = "t8.DocCode='".$DocCode."'";
		}
		if($_REQUEST["SourceExId"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExId"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGRemain)as total "
				."\n FROM "
				."\n tblfinance_bg_borrow as t8 "
				."\n left Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCode "
				."\n left Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n left Join tblbudget_project AS t1 ON t1.PrjId = t2.PrjId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	




}
?>
