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
		//$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		$where[] = "CostTypeId='".$CostTypeId."'";
		$where[] = "LevelId='".$LevelId."'";
		if($ParentCode){
			$where[] = "ParentCode='".$ParentCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostItemId, CostItemCode, CostName, LevelId, ParentCode, HasChild, CostTypeId,EnableStatus "
			 ."\n FROM tblbudget_init_cost_item "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql); //echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */	
	
	/* START #F1 */
	/* Function Name: getCostTypeFilter */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getCostTypeFilter($selected=0,$tag_name='CostTypeId',$tag_attribs='style="width:200px;"',$lebel='เลือก'){
		
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
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
		
				
	/* 
	START #F2
	Function Name	: getDataList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ
	Parameter		:
		@$_REQUEST["CostTypeId"]	=  PK ตาราง tblbudget_init_cost_type 
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="EnableStatus='Y'";
		$where[] ="DeleteStatus='N'";
		
		if($_REQUEST["CostTypeId"]){
			$where[] = "CostTypeId = '".$_REQUEST["CostTypeId"]."'";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_cost_type ".$where_r."  order by Ordering ASC";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	
	/* 
	START #F3
	Function Name	: getCostItemLevel 
	Description		: เป็นฟังก์ชันสำหรับดึงระดับรายการค่าใช้จ่าย
	Parameter		:
		@$_REQUEST["CostTypeId"]	=  PK ตาราง tblbudget_init_cost_type 
	Return Value 	: Array(loadDataSet) 
	*/		
	function getCostItemLevel($ParentCode,$LevelId,$CostTypeId){
		$where 	  = array();
		$where[] = "ParentCode = '".$ParentCode."'";
		$where[] = "LevelId = '".$LevelId."'";
		
		if($CostTypeId){
			$where[] = "CostTypeId = '".$CostTypeId."'";
		}

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_cost_item ".$where_r."  order by CostItemId ASC";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;				
	}
	/*END*/
	
	function getMaxCode(){
		$sql="select  SUBSTR(MAX(CostItemCode),1,2)+1 as maxcode from  tblbudget_init_cost_item where CostItemCode like '%0000'  and ParentCode='0'  ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadResult();
		return $list;		
	}	
	
	function getMaxCode2($ParentCode){
		//$sql="select  SUBSTR(MAX(CostItemCode),4,1)+1 as maxcode from  tblbudget_init_cost_item where CostItemCode like '%00'  and ParentCode='$ParentCode' ";
		$sql="select  SUBSTR(MAX(CostItemCode),1,4) as maxcode from  tblbudget_init_cost_item where CostItemCode like '%00'  and ParentCode='$ParentCode' ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadResult();
		return $list;		
	}	
	
	function getMaxCode3($ParentCode){
		$sql="select  MAX(CostItemCode) as maxcode from  tblbudget_init_cost_item where  ParentCode='$ParentCode' ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadResult();
		return $list;		
	}		
	
	/* 
	START #F4
	Function Name: getCostName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย
	Parameter		: 
		@CostItemId	= ID (PK) ของตาราง tblbudget_init_cost_item รหัสรายการค่าใช้จ่าย
	Return Value 	: single(loadResult) 
	*/	
	function getCostName($CostItemId){
		$where 	  = array();
		if($CostItemId){
			$where[] ="CostItemId='".$CostItemId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select CostName from tblbudget_init_cost_item ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดรายการค่าใช้จ่าย
	Parameter		: 
		@CostItemId	= ID (PK) ของตาราง tblbudget_init_cost_item
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($CostItemId){
		$where 	  = array();
		if($CostItemId){
			$where[] ="CostItemId='".$CostItemId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_cost_item ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/		
	
	/* 
	START #F
	Function Name: getLevel 
	Description		: เป็นฟังก์ชันสำหรับดึง Level รายการค่าใช้จ่าย
	Parameter		: 
		@CostItemId	= ID (PK) ของตาราง tblbudget_init_cost_item
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getLevel($ParentCode=0){
		$where 	  = array();
		$where[] ="CostItemCode='".$ParentCode."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select LevelId from tblbudget_init_cost_item ".$where_r;
		echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/			
	
	
	/* 
	START #F
	Function Name: getHasChild 
	Description		: เป็นฟังก์ชันสำหรับดึง HasChild รายการค่าใช้จ่าย
	Parameter		: 
		@CostItemId	= ID (PK) ของตาราง tblbudget_init_cost_item
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getHasChild($CostItemCode=0){
		$where 	  = array();
		
		$where[] ="ParentCode='".$CostItemCode."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select CostItemCode from tblbudget_init_cost_item ".$where_r;
		echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadDataset(); 
		return $detail;
	}
	/*END*/			
	
	
	
	
		
	
	/* START F3*/
	/* Function Name: getUnitList */
	/* Description: เป็นฟังชั่นสำหรับดึงระดับรายการค่าใช่จ่ายเป็น List Box 
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

/*	function getCostLevelList($selected=0,$tag_name='LevelId',$tag_attribs='',$lebel='เลือก'){
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT LevelId as value , LevelName as text "
			 ."\n FROM tblbudget_init_cost_level "
			 ."\n ".$where_r
			 ."\n order by LevelId  ASC"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}*/

	/* END */		



}
?>
