<?php

class sHelper
{
	var $dpublic;
	var $db;
	var $debug = 0;
	/* 
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
	
	function getYear($Year,$ObjYear){
		return $this->dpublic->getYear($Year,$ObjYear);
	}	
	
	function getSCTypeName($SCTypeId=0){	
		return $this->dpublic->getSCTypeName($SCTypeId);
	}	
	
	/* 
	Function Name	: getDataList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการขั้นตอนการกลั่นกรองงบประมาณทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อขั้นตอนการกลั่นกรองงบประมาณเมื่อกรอกข้อมูลค้นหา
		@$_REQUEST["BgtYear"]	=	ปีงบประมาณ
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		//$where[] ="SCTypeId in (2,4) ";
	/*		
		if($_REQUEST["tsearch"]){
			$where[] = "ScreenName like ('%".$_REQUEST["tsearch"]."%')";
		}
		
	if($_REQUEST["BgtYear"]){
			$where[] = "BgtYear='".$_REQUEST["BgtYear"]."'";
		}else{
			$BgtYear = date("Y")+543;
			$where[] = "BgtYear='".$BgtYear."'";
		}
*/		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_screen_type ".$where_r."  order by SCTypeId ASC";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/

	/* 
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดขั้นตอนการกลั่นกรองงบประมาณ 
	Parameter		: 
		@ScreenId	= ID (PK) ของตาราง tblbudget_init_screen_item
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($ScreenId){
		$where 	  = array();
		if($ScreenId){
			$where[] ="ScreenId='".$ScreenId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_screen_item ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* 
	Function Name: getScreenName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อขั้นตอนการกลั่นกรองงบประมาณ 
	Parameter		: 
		@ScreenId	= ID (PK) ของตาราง tblbudget_init_screen_item
	Return Value 	: single(loadResult) 
	*/	
	function getScreenName($ScreenId){
		$where 	  = array();
		if($ScreenId){
			$where[] ="ScreenId='".$ScreenId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select ScreenName from tblbudget_init_screen_item ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/
	
	/* 
	Function Name: getOrderList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการขั้นตอนการกลั่นกรองงบประมาณขึ้นมาเรียงลำดับ 
	Parameter		: 
		@$_REQUEST["BgtYear"]	=	ปีงบประมาณ
	Return Value 	: Array(loadObjectList) 
	*/	
	function getOrderList($BgtYear){
		$where 	  = array();
		$where[] ="t1.DeleteStatus='N'";
		
		if($BgtYear == ""){
			$BgtYear = date("Y")+543;
		}

		$where[] = "t1.BgtYear='".$BgtYear."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select t1.*,t2.SCTypeName "
				."\n from tblbudget_init_screen_item as t1 "
				."\n left join tblbudget_init_screen_type as t2 on t2.SCTypeId=t1.SCTypeId "
				."\n".$where_r
				."\n order by ScreenLevel "
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}	
	/*END*/
	
	/* 
	Function Name: getScreenLevel 
	Description		: เป็นฟังก์ชันสำหรับดึงระดับการกลั่นกรองค่าที่มากที่สุดของปีนั้น
	Parameter		: 
		@$_REQUEST["BgtYear"]	=	ปีงบประมาณ
	Return Value 	: Single(loadResult) 
	*/	
	function getScreenLevel($BgtYear=0){

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

		$sql="SELECT max(ScreenLevel) as max "
				."\n FROM "
				."\n tblbudget_init_screen_item "
				."\n ".$where_r
				;

		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadResult();
		return $list;

	}	
	/*END*/	
	
	/* Function Name: getScreenTypeList */
	/* Description: เป็นฟังชั่นสำหรับดึงรายการขั้นตอนการจัดทำงบประมาณ
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getScreenTypeList($selected=0,$tag_name='SCTypeId',$tag_attribs='style="width:31%"',$lebel='เลือก'){
		$where = array();
		//$where[] ="SCTypeId in (2,4) ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT SCTypeId as value , SCTypeName as text "
			 ."\n FROM tblbudget_init_screen_type "
			 ."\n ".$where_r
			 ."\n order by SCTypeId ASC"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
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





}
?>
