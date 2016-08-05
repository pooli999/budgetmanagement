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
		
	/* 
	START #F2
	Function Name	: getDataList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการแผนงานต่อเนื่องทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อแผนงานต่อเนื่องเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list){
		$where 	  = array();
		if($_REQUEST["tsearch"]){
			$where[] = "PLongName like ('%".$_REQUEST["tsearch"]."%')";
		}
		/*if(!$_REQUEST["PLongCode"]){
			$where[] = "PLongCode=(select max(PLongCode) from tblbudget_longterm) ";
		}else{
			$where[] = "PLongCode='".$_REQUEST["PLongCode"]."'";
		}*/
		$where[] = "PLongCode='".$_REQUEST["PLongCode"]."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select * from tblbudget_longterm ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();//ltxt::print_r($list);
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแผนงานต่อเนื่อง 
	Parameter		: 
		@PLongId	= ID (PK) ของตาราง tblbudget_longterm
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
		
		$sql = "select * from tblbudget_longterm ".$where_r;
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
		@PLongId	= ID (PK) ของตาราง tblbudget_longterm
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
		
		$sql = "select PLongName from tblbudget_longterm ".$where_r;
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
		
		$sql="select * from tblbudget_longterm ".$where_r."  order by Ordering ASC";
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
				."\n tblbudget_longterm "
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
	
	
	function getPlanItem($PLongCode){
		$where 	  = array();
		$where[] ="PLongCode='".$PLongCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT * "
				."\n FROM "
				."\n tblbudget_longterm_plan "
				."\n ".$where_r
				."\n order by LPlanCode asc"
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	function getPlanDetail($LPlanCode){
		$where 	  = array();
		$where[] ="t1.LPlanCode='".$LPlanCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT t1.*,t2.PLongName,t2.PLongDetail,t2.PLongYear,t2.PLongAmount,t2.PLongYearEnd "
				."\n FROM "
				."\n tblbudget_longterm_plan as t1 "
				."\n left join tblbudget_longterm as t2 on t2.PLongCode=t1.PLongCode "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	function getProjectItem($LPlanCode){
		$where 	  = array();
		$where[] ="LPlanCode='".$LPlanCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT * "
				."\n FROM "
				."\n tblbudget_longterm_plan_project "
				."\n ".$where_r
				."\n order by LPrjCode asc"
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	function getIndicatorItem($LPlanCode){
		$where 	  = array();
		$where[] ="LPlanCode='".$LPlanCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT * "
				."\n FROM "
				."\n tblbudget_longterm_plan_indicator "
				."\n ".$where_r
				."\n order by LindCode asc"
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	function getIndDetail($LindId){
		$where 	  = array();
		$where[] ="t1.LindId='".$LindId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblbudget_longterm_plan_indicator as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	function getUnitList($selected=0,$tag_name='UnitID',$tag_attribs='style="width:200px;"',$lebel='ระบุหน่วยนับ'){
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
	
	function getTaskPerson($LindCode){
		$where = array();
		$where[] = "PP.LindCode = '".$LindCode."' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "SELECT P.PersonalCode,
					CONCAT(PR.PrefixName,
					P.FirstName,' ',
					P.LastName) as Name
					FROM
					tblbudget_longterm_plan_indicator_person AS PP
					Inner Join tblpersonal AS P ON PP.PersonalCode = P.PersonalCode
					Inner Join tblpersonal_prefix AS PR ON PR.PrefixId = P.PrefixId "
					."\n ".$where_r;
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	

	function getQTIndicatorYear($LindCode,$BgtYear){
		$where 	  = array();
		$where[] ="LindCode='".$LindCode."'";
		$where[] ="BgtYear='".$BgtYear."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QTYTargetPlan "
				."\n FROM "
				."\n tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getQTIndicatorYearResult($LindCode,$BgtYear){
		$where 	  = array();
		$where[] ="LindCode='".$LindCode."'";
		$where[] ="BgtYear='".$BgtYear."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QTYTargetResult "
				."\n FROM "
				."\n tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getQLIndicatorYear($LindCode,$BgtYear){
		$where 	  = array();
		$where[] ="LindCode='".$LindCode."'";
		$where[] ="BgtYear='".$BgtYear."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QLYTargetPlan "
				."\n FROM "
				."\n tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getQLIndicatorYearResult($LindCode,$BgtYear){
		$where 	  = array();
		$where[] ="LindCode='".$LindCode."'";
		$where[] ="BgtYear='".$BgtYear."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QLYTargetResult "
				."\n FROM "
				."\n tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
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
	
	function getYearMainPlan($selected=0,$tag_name='PLongCode',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
		$where 	  = array();
		$where[] ="DeleteStatus <> 'Y'";
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
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	
	function getTQLScore($LindId,$selected=0,$tag_name='QLYTargetPlan0',$tag_attribs='style="width:98%;"',$lebel='ระบุ'){
		$where = array();
		$where[] = "LindId = '".$LindId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT TQLScore0,TQLScore1,TQLScore2,TQLScore3,TQLScore4,TQLScore5 "
			 ."\n FROM tblbudget_longterm_plan_indicator "
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
	
	function getYTargetScore($BgtYear,$LindCode){
		$where = array();
		$where[] = "BgtYear = '".$BgtYear."'";
		$where[] = "LindCode = '".$LindCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select YTargetScore "
				."\n from tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		$data = ($data)?$data:"0";
		return $data;
	}	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////
	
	function getCalQTScore($LindId,$scoreResult){
		$indicator = $this->getIndDetail($LindId);
		foreach($indicator as $in){ foreach( $in as $a=>$q){ ${$a} = $q;} }
		switch($scoreResult){
			case (($scoreResult >= $QTMinScore0)&&($scoreResult <= $QTMaxScore0)) :
				$YTargetScore = $Score0;
			break;
			case (($scoreResult >= $QTMinScore1)&&($scoreResult <= $QTMaxScore1)) :
				$YTargetScore = $Score1;
			break;
			case (($scoreResult >= $QTMinScore2)&&($scoreResult <= $QTMaxScore2)) :
				$YTargetScore = $Score2;
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
	
	function getCalQLScore($LindId,$scoreResult){
		$indicator = $this->getIndDetail($LindId);
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
	
	function getMaxLindQTTGResult($LindCode){
		$where = array();
		$where[] = "LindCode = '".$LindCode."'";
		$where[] = "YTargetScore = (select max(YTargetScore) from tblbudget_longterm_plan_indicator_year where LindCode='".$LindCode."' )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select YTargetScore,QTYTargetResult "
				."\n from tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}	
	
	function getMaxLindQLTGResult($LindCode){
		$where = array();
		$where[] = "LindCode = '".$LindCode."'";
		$where[] = "YTargetScore = (select max(YTargetScore) from tblbudget_longterm_plan_indicator_year where LindCode='".$LindCode."' )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select YTargetScore,QLYTargetResult "
				."\n from tblbudget_longterm_plan_indicator_year "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}	



}
?>
