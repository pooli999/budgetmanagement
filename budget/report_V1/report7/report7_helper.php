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
		

	function getPItemRecordSet(){
		$where = array();
		$where[] = "t1.PGroupId='12'";
		$where[] = "t1.EnableStatus='Y'";
		$where[] = "t1.DeleteStatus<>'Y'";
		if($_REQUEST["ScreenLevel"]){
			$where[] = "t3.ScreenLevel='".$_REQUEST["ScreenLevel"]."'";
		}
		if($_REQUEST["PItemCode"]){
			$where[] = "t1.PItemCode='".$_REQUEST["PItemCode"]."'";
		}
		if($_REQUEST["BgtYear"]){
			$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		}
		if($_REQUEST["OrganizeCode"]){
			$where[] = "t2.OrganizeCode='".$_REQUEST["OrganizeCode"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.PItemCode),t1.* "
			 ."\n FROM tblbudget_init_plan_item as t1 "
			 ."\n left join tblbudget_project as t2 on t2.PItemCode=t1.PItemCode "
			 ."\n left join tblbudget_project_detail as t3 on t3.PrjId=t2.PrjId "
			  ."\n ".$where_r
			 ."\n order by t1.PItemCode"
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	
	function getProjectRecordSet($PItemCode){
		$where = array();
		$where[] = "t2.PItemCode='".$PItemCode."'";
		if($_REQUEST["ScreenLevel"]){
			$where[] = "t1.ScreenLevel='".$_REQUEST["ScreenLevel"]."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.PrjDetailId),t2.* "
			 ."\n FROM tblbudget_project_detail as t1 "
			 ."\n left join tblbudget_project as t2 on t2.PrjId=t1.PrjId "
			  ."\n ".$where_r
			 ."\n order by t2.PrjCode "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	
	function getActRecordSet($PrjDetailId){
		$where = array();
		$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
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
	
	function getTotalPrjMonth($PItemCode=0,$PrjDetailId=0,$PrjActId=0,$ScreenLevel=0){
		switch($_REQUEST["ExType"]){
			case "Internal":
					$BGInternal = $this->getTotalPrjMonthInternal($PItemCode,$PrjDetailId,$PrjActId,$ScreenLevel);
					return $BGInternal;
			break;
			case "External":
					$BGExternal = $this->getTotalPrjMonthExternal($PItemCode,$PrjDetailId,$PrjActId,$ScreenLevel);
					return $BGExternal;
			break;
			default:
					$BGInternal = $this->getTotalPrjMonthInternal($PItemCode,$PrjDetailId,$PrjActId,$ScreenLevel);
					$BGExternal = $this->getTotalPrjMonthExternal($PItemCode,$PrjDetailId,$PrjActId,$ScreenLevel);
					$result = $BGInternal+$BGExternal;
					return $result;
		}
	}
	
		/* START #F58 */
	/* Function Name: getTotalPrjInternalMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการรายเดือน/ไตรมาส(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjMonthInternal($PItemCode=0,$PrjDetailId=0,$PrjActId=0,$ScreenLevel=0){
		$where = array();
		if($_REQUEST["BgtYear"]){
			$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		}
		if($_REQUEST["OrganizeCode"]){
			$where[] = "t1.OrganizeCode='".$_REQUEST["OrganizeCode"]."'";
		}
		$PItemCode = ($_REQUEST["PItemCode"])?$_REQUEST["PItemCode"]:$PItemCode;
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
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
	function getTotalPrjMonthExternal($PItemCode=0,$PrjDetailId=0,$PrjActId=0,$ScreenLevel=0){
		$where = array();
		if($_REQUEST["BgtYear"]){
			$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		}
		if($_REQUEST["OrganizeCode"]){
			$where[] = "t1.OrganizeCode='".$_REQUEST["OrganizeCode"]."'";
		}
		$PItemCode = ($_REQUEST["PItemCode"])?$_REQUEST["PItemCode"]:$PItemCode;
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
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
	
	function getYearProject($selected=0,$tag_name='BgtYear',$tag_attribs='onchange="loadPlan(this.value)"',$label='ทั้งหมด'){
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
	
		function getPlanItemList($selected=0,$tag_name='PItemCode',$tag_attribs='style="width:500px;"',$label='ทั้งหมด'){
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
	
	function getOrgList($selected=0,$tag_name='OrganizeCode',$tag_attribs='style="width:500px;"',$label='ทั้งหมด'){
		
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
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getScreenYear($BgtYear){
		$where = array();
		$where[] = "t1.BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.ScreenLevel , t1.ScreenName "
			 ."\n FROM tblbudget_init_screen_item as t1 "
			 ."\n ".$where_r
			 ."\n order by t1.ScreenLevel ASC "
			 ;
		$this->db->setQuery($sql);
		$data=$this->db->loadObjectList();//ltxt::print_r($data);
		return $data;
	}




}
?>
