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
	
	/* 
	START #F2
	Function Name	: getDataList 
	Description		: เป็นฟังก์ชันสำหรับดึงกลุ่มนโยบายแผนงานทั้งหมด
	Parameter		:-
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list){
		$where 	  = array();
		/*//$where[] ="DeleteStatus='N'";
		
		if($_REQUEST["tsearch"]){
			$where[] = "PGroupName like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($_REQUEST["BgtYear"]){
			$where[] = "BgtYear='".$_REQUEST["BgtYear"]."'";
		}else{
			$BgtYear = date("Y")+543;
			$where[] = "BgtYear='".$BgtYear."'";
		}*/
		//$where[] = "PGroupId=12";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_plan_group ".$where_r."  order by Ordering ASC";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดนโยบายแผนงานย่อย
	Parameter		: 
		@PItemId	= ID (PK) ของตาราง tblbudget_init_plan_item
		@PGroupId	= ID (FK) กลุ่มนโยบายแผนงาน
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($PItemId){
		$where 	  = array();
		if($PItemId){
			$where[] ="PItemId='".$PItemId."'";
		}

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_plan_item".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F4
	Function Name: getPGroupName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อกลุ่มนโยบายแผนงาน 
	Parameter		: 
		@PGroupId	= ID (PK) ของตาราง tblbudget_init_plan_group
	Return Value 	: single(loadResult) 
	*/	
	function getPGroupName($PGroupId){
		$where 	  = array();
		if($PGroupId){
			$where[] ="PGroupId='".$PGroupId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select PGroupName from tblbudget_init_plan_group ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F5
	Function Name	: getItemList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการย่อยของนโยบายแผนงาน
	Parameter		:
		@PGroupId	=	กลุ่มนโยบายแผนงานประมาณ
		@$_REQUEST["BgtYear"]	=	ปีงบประมาณ
	Return Value 	: Array(loadDataSet) 
	*/	
	function getItemList($PGroupId){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
		$where[] = "PGroupId='".$PGroupId."'";

		if($_REQUEST["BgtYear"]){
			$where[] = "BgtYear='".$_REQUEST["BgtYear"]."'";
		}else{
			$BgtYear = date("Y")+543;
			$where[] = "BgtYear='".$BgtYear."'";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		//$sql="select * from tblbudget_init_plan_item ".$where_r."  order by CONVERT(`PItemName` USING TIS620) ASC";
		$sql="select * from tblbudget_init_plan_item ".$where_r."  order by PItemId";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}
	/*END*/	
	
	/* 
	START #F5
	Function Name: getItemName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อนโยบายแผนงานย่อย
	Parameter		: 
		@PItemId	= ID (PK) ของตาราง tblbudget_init_plan_item
	Return Value 	: single(loadResult) 
	*/	
	function getItemName($PItemId){
		$where 	  = array();
		if($PItemId){
			$where[] ="PItemId='".$PItemId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select PItemName from tblbudget_init_plan_item ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/	
	
	
	/* 
	START #F5
	Function Name: getOrderList 
	Description		: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของรายการนโยบายแผนงานขึ้นมาเรียงลำดับ 
	Parameter		: 
		@$_REQUEST["PItemId"]	=	PK รายการนโยบายแผนงาน
	Return Value 	: Array(loadObjectList) 
	*/	
	function getOrderList($PItemId){
		$where 	  = array();
		
		$where[] = "PItemId='".$PItemId."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_plan_item_indicator ".$where_r."  order by Ordering ASC";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}	
	/*END*/
	
	/* 
	START #F6
	Function Name: getScreenLevel 
	Description		: เป็นฟังก์ชันสำหรับดึงระดับการกลั่นกรองค่าที่มากที่สุดของปีนั้น
	Parameter		: 
		@$_REQUEST["BgtYear"]	=	ปีงบประมาณ
	Return Value 	: Single(loadResult) 
	*/	
/*	function getScreenLevel($BgtYear){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";

		if($BgtYear == ""){
			$BgtYear = date("Y")+543;
		}
		
		$where[] = "BgtYear='".$BgtYear."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select MAX(ScreenLevel) as  max from tblbudget_init_plan_group ".$where_r." ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadResult();
		return $list;
	}	*/
	/*END*/	
	


	/* 
	START #F
	Function Name	: getIndicatorList 
	Description		: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของนโยบายแผนงานย่อย
	Parameter		:-
	Return Value 	: Array(loadObjectList) 
	*/	
	function getIndicatorList(&$list,$limit=20){
		$where 	  = array();
		//$where[] ="DeleteStatus='N'";
		
/*		if($_REQUEST["tsearch"]){
			$where[] = "PGroupName like ('%".$_REQUEST["tsearch"]."%')";
		}*/
				
		//if($_REQUEST["PItemId"]){
			$where[] = "PItemId='".$_REQUEST["PItemId"]."'";
		//}

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_plan_item_indicator ".$where_r." ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	
	/* 
	START #F
	Function Name: getIndTypeName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อประเภทตัวชี้วัด
	Parameter		: 
		@PItemId	= ID (PK) ของตาราง tblbudget_init_plan_item
	Return Value 	: single(loadResult) 
	*/	
	function getIndTypeName($IndTypeId){
		$where 	  = array();
		if($IndTypeId){
			$where[] ="IndTypeId='".$IndTypeId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select IndTypeName from tblbudget_init_indicator_type ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/	


	/* START F*/
	/* Function Name: getGroupListbox */
	/* Description: เป็นฟังชั่นสำหรับดึงกลุ่มนโยบายแผนงานเป็น List Box 
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getGroupListbox($selected=0,$tag_name='PGroupId',$tag_attribs='onchange="loadGroup(this.value)"',$lebel='เลือก'){
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PGroupId as value , PGroupName as text "
			 ."\n FROM tblbudget_init_plan_group "
			 ."\n ".$where_r
			 ."\n order by PGroupId ASC"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */	



	/* START F*/
	/* Function Name: getItemListbox */
	/* Description: เป็นฟังชั่นสำหรับดึงรายการนโยบายแผนงานย่อยเป็น List Box 
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getItemListbox($selected=0,$tag_name='PItemId',$tag_attribs='onchange="loadList(this.value)"',$lebel='เลือก'){
		//$selected = ($selected)?$selected:(date("Y")+543);
		$where = array();
		
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";
				
		if($_REQUEST["PGroupId"]){
			$where[] = "PGroupId='".$_REQUEST["PGroupId"]."'";
		}
						
		if($_REQUEST["BgtYear"]){
			$where[] = "BgtYear='".$_REQUEST["BgtYear"]."'";
		}else{
			$BgtYear = date("Y")+543;
			$where[] = "BgtYear='".$BgtYear."'";
		}
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PItemId as value , PItemName as text "
			 ."\n FROM tblbudget_init_plan_item "
			 ."\n ".$where_r
			 ."\n order by CONVERT(`PItemName` USING TIS620) ASC"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */	


	/* START F*/
	/* Function Name: getIndTypeNameList */
	/* Description: เป็นฟังชั่นสำหรับดึงรายการประเภทตัวชี้วัดเป็น List Box 
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getIndTypeNameList($selected=0,$tag_name='IndTypeId',$tag_attribs='',$lebel='เลือก'){
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

	/* START F*/
	/* Function Name: getUnitList */
	/* Description: เป็นฟังชั่นสำหรับดึงรายการหน่วยนับเป็น List Box 
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getUnitList($selected=0,$tag_name='UnitID',$tag_attribs='',$lebel='ระบุหน่วยนับ'){
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

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดนโยบายแผนงานย่อย
	Parameter		: 
		@PItemId	= ID (PK) ของตาราง tblbudget_init_plan_item
		@PGroupId	= ID (FK) กลุ่มนโยบายแผนงาน
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getIndicatorDetail($PIndId){
		$where 	  = array();
		if($PIndId){
			$where[] ="PIndId='".$PIndId."'";
		}

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_plan_item_indicator ".$where_r;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/

	/* 
	START #F
	Function Name: getIndicatorName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อประเภทตัวชี้วัด
	Parameter		: 
		@PItemId	= ID (PK) ของตาราง tblbudget_init_plan_item
	Return Value 	: single(loadResult) 
	*/	
	function getIndicatorName($PIndId){
		$where 	  = array();
		if($PIndId){
			$where[] ="PIndId='".$PIndId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select PIndName from tblbudget_init_plan_item_indicator ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/	

	/* 
	START #F
	Function Name: getIndicatorName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อประเภทตัวชี้วัด
	Parameter		: 
		@PItemId	= ID (PK) ของตาราง tblbudget_init_plan_item
	Return Value 	: single(loadResult) 
	*/	
	function getUnitName($UnitID){
		$where 	  = array();
		if($UnitID){
			$where[] ="UnitID='".$UnitID."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select UnitName from tblunit ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/	


	/* 
	START #F
	Function Name: getPlanLongterm 
	Description		: เป็นฟังก์ชันสำหรับดึงแผนงานต่อเนื่อง
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
	*/	
	function getPlanLongterm(){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_plan_longterm ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadObjectList(); 
		return $detail;
	}
	/*END*/	

	/*
	Function Name: getPlanLongtermSelect 
	Description		: เป็นฟังก์ชันสำหรับดึงแผนงานต่อเนื่องที่มีการเลือก
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
	*/	
	function getPlanLongtermSelect($PItemId)
	{
		$sql="select PSelectId,PLongCode from tblbudget_plan_select where PItemId='$PItemId' ";
		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		$Arr = array();
		foreach($data as $v){
			$Arr[] = $v->PLongCode;
		}
		return $Arr;
	}	
	/*END*/	
	
	/* 
	START #F
	Function Name: getPlanLongName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อแผนงานต่อเนื่อง
	Parameter		: -
	Return Value 	: single(loadResult) 
	*/	
	function getPlanLongName($PLongCode){
		$where 	  = array();
		if($PLongCode){
			$where[] ="PLongCode='".$PLongCode."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select PLongName from tblbudget_init_plan_longterm ".$where_r;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/	

	/*
	Function Name	: getPItemCode
	Description		: เป็นฟังก์ชันสำหรับดึง PItemCode ของล่าสุด
	Parameter		:
		@$BgtYear = ปีงบประมาณ
	Return Value 	: Single(loadResult) 
	*/		
	function getPItemCode($BgtYear,$PGroupId){
		$where = array();
		$where[] = "BgtYear = '".$BgtYear."'";
		$where[] = "PGroupId = '".$PGroupId."'";
		$where[] ="DeleteStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(AutoNum) "
				."\n from tblbudget_init_plan_item "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		$datas = $data+1;
		return $datas;
	}
	/* END */	

	/* Function Name: getPItemCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดข้อมูลของ สช.น. ที่อ้างอิง */
		function getMapPItemCode($BgtYear,$PItemCode){
			
		$GSubYear = 	substr($BgtYear,2,2);
		$GSubCode = 	substr($PItemCode,3,3);
		
		$PItemCode = $GSubYear."P".$GSubCode;
			
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
		$data = $this->db->loadSingleObject();
		return $data;
		}
	/* END */
	
	
	function countPlanIndicator($PItemId){
		$where = array();
		$where[] = "PItemId = '".$PItemId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select count(*) "
				."\n from tblbudget_init_plan_item_indicator "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();
		return $data; 
	}
	
	
	function getPGroupCode($PGroupId){
		$where = array();
		$where[] = "PGroupId = '".$PGroupId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PGroupCode "
				."\n from tblbudget_init_plan_group "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	
	function getPlanIndicator($PItemId){
		$where 	  = array();
		$where[] = "PItemId='".$PItemId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select * from tblbudget_init_plan_item_indicator ".$where_r;
		$this->db->setQuery($sql);
		//$this->db->limit = $limit;
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	
	/* START #F20 */
	/* Function Name: getLongPlanList */
	/* Description: เป็นฟังก์ชันสำหรับดึงแผนงานต่อเนื่อง */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getPlanLongList($BgtYear=0,$selected=0,$tag_name='PLongCode',$tag_attribs='',$lebel='เลือก'){
		$where = array();
		$where[] = " t1.EnableStatus='Y'";
		$where[] = " t1.DeleteStatus='N'";	
		if($BgtYear){
			$where[] = " (t1.PLongYear='2552' or t1.PLongYearEnd='2552' or(t1.PLongYear < '2552' and t1.PLongYearEnd > '2552'))";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PLongCode as value , concat('(',PLongCode,') ',PLongName)as text "
				."\n FROM "
				."\n tblbudget_init_plan_longterm AS t1 "
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
	
	function getIndicatorItem($PItemId){
		$where 	  = array();
		$where[] ="PItemId='".$PItemId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT * "
				."\n FROM "
				."\n tblbudget_init_plan_item_indicator "
				."\n ".$where_r
				."\n order by PIndCode asc"
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	///////////////////////////////////////////////////////////////////////////////////
	function getTaskPerson($PIndCode){
		$where = array();
		$where[] = "PP.PIndCode = '".$PIndCode."' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "SELECT P.PersonalCode,
					CONCAT(PR.PrefixName,
					P.FirstName,' ',
					P.LastName) as Name
					FROM
					tblbudget_init_plan_item_indicator_person AS PP
					Inner Join tblpersonal AS P ON PP.PersonalCode = P.PersonalCode
					Inner Join tblpersonal_prefix AS PR ON PR.PrefixId = P.PrefixId "
					."\n ".$where_r;
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	
	
	function getPlanDetail($PItemId){
		$where 	  = array();
		$where[] ="t1.PItemId='".$PItemId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT t1.*,t2.PGroupName,t2.PGroupCode "
				."\n FROM "
				."\n tblbudget_init_plan_item as t1 "
				."\n left join tblbudget_init_plan_group as t2 on t2.PGroupId=t1.PGroupId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	function getIndDetail($PIndId){
		$where 	  = array();
		$where[] ="t1.PIndId='".$PIndId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblbudget_init_plan_item_indicator as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList(); //ltxt::print_r($data);
		return $data;
	}
	
	function getIndicatorMonth($PIndCode,$MonthNo){
		$where 	  = array();
		$where[] ="PIndCode='".$PIndCode."'";
		$where[] ="MonthNo='".$MonthNo."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT MonthTargetPlan "
				."\n FROM "
				."\n tblbudget_init_plan_item_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getQTIndMonth($PIndCode,$MonthNo){
		$where 	  = array();
		$where[] ="PIndCode='".$PIndCode."'";
		$where[] ="MonthNo='".$MonthNo."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QTMTargetPlan "
				."\n FROM "
				."\n tblbudget_init_plan_item_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
	}
	
	function getQLIndMonth($PIndCode,$MonthNo){
		$where 	  = array();
		$where[] ="PIndCode='".$PIndCode."'";
		$where[] ="MonthNo='".$MonthNo."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="SELECT QLMTargetPlan "
				."\n FROM "
				."\n tblbudget_init_plan_item_indicator_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult(); //ltxt::print_r($data);
		return $data;
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
	
	function getMainList($selected=0,$tag_attribs='onchange="loadMainPlan(this.value)" style="width:40%"',$tag_name='PLongCode',$lebel='=ระบุแผนหลัก='){
		$where = array();
		$where[] ="EnableStatus='Y'";
		$where[] ="DeleteStatus<>'Y'";
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
	
	function getMainPlanList($PLongCode=0,$selected=0,$tag_attribs='style="width:50%"',$tag_name='LPlanCode',$lebel='=ระบุแผนงานภายใต้แผนหลัก='){
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
	
	function getYearProject($selected=0,$tag_name='BgtYear',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
		$selected = ($selected)?$selected:(date("Y")+543);
		$where = array();
		$where[] = "BgtYear <> ' '";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(BgtYear)as value , BgtYear as text "
			 ."\n FROM tblbudget_init_plan_item "
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
	
	function getTQLScore($PIndId,$selected=0,$tag_name='QLYTargetPlan0',$tag_attribs='style="width:98%;"',$lebel='ระบุ'){
		$where = array();
		$where[] = "PIndId = '".$PIndId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT TQLScore0,TQLScore1,TQLScore2,TQLScore3,TQLScore4,TQLScore5 "
			 ."\n FROM tblbudget_init_plan_item_indicator "
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
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function getIndList($selected=0,$tag_attribs='onchange="loadIndName(this.value)" style="width:99%"',$tag_name='LindCode',$lebel='ระบุ'){
		$where = array();
		//$where[] ="DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT LindCode as value , concat('(',LindCode,') ',LindName)as text "
			 ."\n FROM tblbudget_longterm_plan_indicator "
			 ."\n ".$where_r
			 ;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getIndName($LindCode=0){
		$where = array();
		$LindCode = ($_REQUEST["LindCode"])?$_REQUEST["LindCode"]:$LindCode;
		$where[] ="t1.LindCode='".$LindCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT concat('(',LindCode,') ',LindName) "
			 ."\n FROM tblbudget_longterm_plan_indicator as t1 "
			 ."\n ".$where_r
			 ;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		echo $data;
		
	}
	
	function getLastRunningNo($PItemCode){
		$sql = "select max(Running) "
				."\n from tblbudget_init_plan_item_indicator "
				."\n where PItemCode='".$PItemCode."'"
				;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return ($data+1);
	}


	

	
	
	
	
	
	


}// end class
?>
