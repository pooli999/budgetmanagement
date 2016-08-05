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
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
		$this->dpublic		= new BGPublic();
	}
	/*END*/
		
	/* 
	START #F2
	Function Name	: getDataList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการแผนงานต่อเนื่องทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อแผนงานต่อเนื่องเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		
		if($_REQUEST["tsearch"]){
			$where[] = "PLongName like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_plan_longterm ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแผนงานต่อเนื่อง 
	Parameter		: 
		@PLongId	= ID (PK) ของตาราง tblbudget_init_plan_longterm
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($PLongId){
		$where 	  = array();
		if($PLongId){
			$where[] ="PLongId='".$PLongId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_plan_longterm ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F
	Function Name: getPLongName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อแผนงานต่อเนื่อง 
	Parameter		: 
		@PLongId	= ID (PK) ของตาราง tblbudget_init_plan_longterm
	Return Value 	: single(loadResult) 
	*/	
	function getPLongName($PLongId){
		$where 	  = array();
		if($PLongId){
			$where[] ="PLongId='".$PLongId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select PLongName from tblbudget_init_plan_longterm ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/

	/* 
	START #F5
	Function Name: getOrderList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการประเภทตัวชี้วัด(KPI)ขึ้นมาเรียงลำดับ 
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
	*/	
	function getOrderList(){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_plan_longterm ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);  //echo "<pre>$sql;</pre>";
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}	
	/*END*/
	
		/* START F47*/
	/* Function Name: getYear */
	/* Description: เป็นฟังชั่นสำหรับดึงปีงบประมาณ
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getYearLongPlan($selected=0,$tag_name='BgtYear',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PLongYear as value , concat(PLongYear,' - ',PLongYearEnd)as text "
				."\n FROM "
				."\n tblbudget_init_plan_longterm "
				."\n ".$where_r
				."\n order by PLongYear desc"
				;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */	
	
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
	
	function getPrjIndResultId($IndicatorCode,$MonthNo){
		$where = array();
		$where[] = "IndicatorCode = '".$IndicatorCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PrjIndResultId "
				."\n from tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getMaxMonthNo($IndicatorCode){
		$where = array();
		$where[] = "IndicatorCode = '".$IndicatorCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(MonthNo) "
				."\n from tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getYear($Year,$ObjYear){
		return $this->dpublic->getYear($Year,$ObjYear);
	}	
	
	function getPlan($PItemId=0){
		$where = array();
		if($PItemId){
			$where[] = "t1.PItemId='".$PItemId."'";
		}else{
			if(!$_REQUEST["BgtYear"]){
				$_REQUEST["BgtYear"] = date("Y")+543;
			}
			$where[] = "t1.BgtYear='".$_REQUEST["BgtYear"]."'";
		}
		$where[] = "t1.PGroupId ='12' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
		."\n t1.* "
		."\n FROM "
		."\n tblbudget_init_plan_item AS t1 "
		."\n ".$where_r
		."\n order by t1.PItemCode "
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	/* END */

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
	/* END */
	
	function getMaxPlanMonthNo($PIndCode){
		$where = array();
		$where[] = "PIndCode = '".$PIndCode."'";
		$where[] = "(MonthTargetResult <> '') or (MonthTargetResult > 0)  ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(MonthNo) "
				."\n from tblbudget_init_plan_item_indicator "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getPlanMonthIndicator($PIndCode,$MonthNo){
		$where = array();
		$where[] = "PIndCode = '".$PIndCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_init_plan_item_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadObjectList();
		return $data;
	}
	
	function getYearMainPlan($selected=0,$tag_name='PLongCode',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
		$where 	  = array();
		if($_REQUEST["tsearch"]){
			$where[] = "PLongName like ('%".$_REQUEST["tsearch"]."%')";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT PLongCode as value , PLongName text "
				."\n FROM "
				."\n tblbudget_longterm "
				."\n ".$where_r
				."\n order by PLongYear desc"
				;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		//$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		//$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	
	function getLongPlan($LPlanId=0){
		$where = array();
		if($LPlanId){
			$where[] = "t1.LPlanId='".$LPlanId."'";
		}else{
			if(!$_REQUEST["PLongCode"]){
				$where[] = "t2.PLongCode=(select max(PLongCode) from tblbudget_longterm) ";
			}else{
				$where[] = "t2.PLongCode='".$_REQUEST["PLongCode"]."'";
			}
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
		."\n t1.*,t2.PLongName,t2.PLongYear,t2.PLongAmount,t2.PLongYearEnd "
		."\n FROM "
		."\n tblbudget_longterm_plan AS t1 "
		."\n left join tblbudget_longterm as t2 on t2.PLongCode=t1.PLongCode "
		."\n ".$where_r
		."\n order by t1.LPlanCode "
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	/* END */
	
	function getLongPlanIndicator($LPlanCode,$LindId=0){
		$where = array();
		if($LPlanCode){
			$where[] = "t1.LPlanCode='".$LPlanCode."'";
		}
		if($LindId){
			$where[] = "t1.LindId='".$LindId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
		."\n t1.* "
		."\n FROM "
		."\n tblbudget_longterm_plan_indicator AS t1 "
		."\n ".$where_r
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	/* END */
	
	function getLongPlanMonthIndicator($LindCode,$BgtYear){
		$where = array();
		$where[] = "LindCode = '".$LindCode."'";
		$where[] = "BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadObjectList();
		return $data;
	}
	
	function getPlanMonthTargetPlan($PIndCode,$MonthNo){
		$where = array();
		$where[] = "PIndCode = '".$PIndCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MonthTargetPlan "
				."\n from tblbudget_init_plan_item_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getPlanMonthTargetResult($PIndCode,$MonthNo){
		$where = array();
		$where[] = "PIndCode = '".$PIndCode."'";
		$where[] = "MonthNo = '".$MonthNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MonthTargetResult "
				."\n from tblbudget_init_plan_item_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getYearTargetPlan($LindCode,$BgtYear){
		$where = array();
		$where[] = "LindCode = '".$LindCode."'";
		$where[] = "BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select YearTargetPlan "
				."\n from tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getYearTargetResult($LindCode,$BgtYear){
		$where = array();
		$where[] = "LindCode = '".$LindCode."'";
		$where[] = "BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select YearTargetResult "
				."\n from tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getYearStart($BgtYear){
		$where = array();
		$where[] = "BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_init_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadObjectList();
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
	
	function getMaxTargetResultMonth($IndicatorCode){
		$where = array();
		$where[] = "IndicatorCode = '".$IndicatorCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(MonthTargetResult) "
				."\n from tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}

	function getMaxTargetScoreMonth($IndicatorCode){
		$where = array();
		$where[] = "IndicatorCode = '".$IndicatorCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(MonthTargetScore) "
				."\n from tblbudget_project_indicator_month_result "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}
	//////////////////////////////////////////////////////////
	function getMaxPIndTargetResult($PIndCode){
		$where = array();
		$where[] = "PIndCode = '".$PIndCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(MonthTargetResult) "
				."\n from tblbudget_init_plan_item_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}

	function getMaxPIndTargetScore($PIndCode){
		$where = array();
		$where[] = "PIndCode = '".$PIndCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(MonthTargetScore) "
				."\n from tblbudget_init_plan_item_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}
	
	//////////////////////////////////////////////////////////
	function getMaxLindTargetResult($LindCode){
		$where = array();
		$where[] = "LindCode = '".$LindCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(YearTargetResult) "
				."\n from tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}

	function getMaxLindTargetScore($LindCode){
		$where = array();
		$where[] = "LindCode = '".$LindCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(YearTargetScore) "
				."\n from tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}
	
	




}
?>
