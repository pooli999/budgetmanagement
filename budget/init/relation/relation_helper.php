<?php

class sHelper
{
	var $db;
	var $debug = 0;
	var $dpublic;
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
	Function Name	: getGroupList 
	Description		: เป็นฟังก์ชันสำหรับดึงกลุ่มนโยบายแผนงานทั้งหมด
	Parameter		:-
	Return Value 	: Array(loadDataSet) 
	*/	
	function getGroupList(){
		$sqlcount="select count(PGroupId) from tblbudget_init_plan_group ";
		$this->db->setQuery($sqlcount);
		$countGroup = $this->db->loadResult();
		$countGroup = $countGroup-1;
				
		$sql="select  * from tblbudget_init_plan_group order by PGroupId ASC LIMIT $countGroup  ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;
	}	
	/*END*/
	
	/* 
	START #F3
	Function Name	: getNextGroup 
	Description		: เป็นฟังก์ชันสำหรับดึงกลุ่มนโยบายแผนงานกลุ่มถัดไป
	Parameter		:-
	Return Value 	: Array(loadDataSet) 
	*/	
	function getNextGroup($PGroupId){
				
/*		$sql="select  * from tblbudget_init_plan_group order by PGroupId ASC LIMIT $countGroup  ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;*/
		
		$where 	  = array();
		
		$where[] = "PGroupId > '".$PGroupId."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select PGroupId as NextPGroupId, PGroupName as NextPGroupName from tblbudget_init_plan_group ".$where_r." order by PGroupId ASC LIMIT 1 ";
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;
		

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
	function getItemList($PGroupId,$BgtYear){
		$where 	  = array();
		$where[] ="t1.DeleteStatus='N'";
		$where[] ="t1.EnableStatus='Y'";
		$where[] = "t1.PGroupId='".$PGroupId."'";
		
		if(!$BgtYear){ $BgtYear = date("Y")+543; }
		$where[] = "t1.BgtYear='".$BgtYear."'";

/*		if($_REQUEST["BgtYear"]){
			$where[] = "BgtYear='".$_REQUEST["BgtYear"]."'";
		}else{
			$BgtYear = date("Y")+543;
			$where[] = "BgtYear='".$BgtYear."'";
		}*/
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql = "select t1.*,t2.PGroupName "
			."\n from tblbudget_init_plan_item as t1"
			."\n left join tblbudget_init_plan_group as t2 on t2.PGroupId=t1.PGroupId "
			."\n ".$where_r
			."\n order by CONVERT(t1.`PItemName` USING TIS620) ASC"
			;
		//$sql="select * from tblbudget_init_plan_item ".$where_r."  order by CONVERT(`PItemName` USING TIS620) ASC";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}
	/*END*/	


	/* 
	START #F
	Function Name	: getPItemByGroup 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการย่อยของนโยบายแผนงานที่คลิกเลือก
	Parameter		:-
	Return Value 	: Array(loadDataSet) 
	*/	
	function getPItemByGroup(){

		$nextGroupName = $this->getGroupName($_REQUEST["NextPGroupId"]);
		echo '<strong>'.$nextGroupName.' : </strong>';
		
		$itemNextGroup= $this->getItemList($_REQUEST["NextPGroupId"],$_REQUEST["BgtYear"]);
		//ltxt::print_r($itemNextGroup); 
		$itemRelation= $this->getItemrelation($_REQUEST["PItemId"]);
		//ltxt::print_r($itemRelation); 
		if($itemNextGroup){
			
			foreach($itemNextGroup as $v){
				if($itemRelation){  if(@in_array($v->PItemId,$itemRelation)){ $Check = 'checked="checked"';}else{ $Check = ''; } }
				
				echo '<br>';
				echo '<input name="PItemRelate[]" id="PItemRelate" type="checkbox" value="'.$v->PItemId.'" '.$Check.' />';
				echo $v->PItemName;
			}
		
		echo '<br><span style="color:#900">( กรุณาคลิกเลือกรายการ <u>'.$nextGroupName.'</u> ที่ต้องการแล้วคลิกปุ่ม บันทึก เพื่อให้ระบบทำการบันทึกข้อมูลลงฐานข้อมูล )</span>';
		
		}else{
			echo '<br><br><span style="color:#900">- ไม่มีรายการ <u>'.$nextGroupName.'</u> ในระบบ -</span><br><br>';
		}
		
	}
	/*END*/	

	/* 
	START #F
	Function Name	: getTopic 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อกลุ่ม และรายการย่อยที่เลือกมาแสดง
	Parameter		:-
	Return Value 	: text
	*/	
	function getTopic(){
		$groupName = $this->getGroupName($_REQUEST["PGroupId"]);
		$pitemName =  $this->getPItemName($_REQUEST["PItemId"]);
		echo '<strong>'.$groupName.' : </strong> <u  class="txtblue">'.$pitemName.'</u>';

	}
	/*END*/	



	/* 
	START #F
	Function Name	: getGroupName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อกลุ่ม
	Parameter		:-
	Return Value 	: Sing(loadResult) 
	*/	
	function getGroupName($PGroupId){
		$where 	  = array();
		
		$where[] = "PGroupId = '".$PGroupId."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select PGroupName  from tblbudget_init_plan_group ".$where_r."  ";
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadResult();
		return $list;

	}
	/*END*/	

	/* 
	START #F
	Function Name	: getPItemName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อแผนงาน
	Parameter		:-
	Return Value 	: Sing(loadResult) 
	*/	
	function getPItemName($PItemId){
		$where 	  = array();
		
		$where[] = "PItemId = '".$PItemId."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select PItemName  from tblbudget_init_plan_item ".$where_r."  ";
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadResult();
		return $list;

	}
	/*END*/	

	/* 
	START #F
	Function Name	: getPItemName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อแผนงาน
	Parameter		:-
	Return Value 	: Sing(loadResult) 
	*/	
	function getItemrelation($PItemId){
		$where 	  = array();
		
		$where[] = "PItemId = '".$PItemId."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select PItemRelate  from tblbudget_init_plan_item_relation ".$where_r."  ";
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		
		$Arr = array();
		foreach($data as $v){
			$Arr[] = $v->PItemRelate;
		}
		return $Arr;
	
		
	}
	/*END*/	

	/* 
	START #F
	Function Name	: getPItemName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อแผนงาน
	Parameter		:-
	Return Value 	: Sing(loadResult) 
	*/	
	function getItemrelationList($PItemId){
		$where 	  = array();
		
		$where[] = "PItemId = '".$PItemId."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select *  from tblbudget_init_plan_item_relation ".$where_r."  ";
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;

	}
	/*END*/	





}
?>
