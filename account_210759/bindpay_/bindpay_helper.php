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
		
	/* 
	START #F2
	Function Name	: getDataList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการรายจ่ายเพื่อผูกบัญชี
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อประเภทรายรับเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] = "t1.EnableStatus='Y'";
		$where[] = "t1.DeleteStatus<>'Y'";
		$where[] = "t1.HasChild='N'";
		if($_REQUEST["tsearch"]){
			$where[] = "CostName like ('%".$_REQUEST["tsearch"]."%')";
		}
		if($_REQUEST["CostTypeId"]){
			$where[] = "CostTypeId = ".$_REQUEST["CostTypeId"];
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_cost_item AS t1 left join ac_chart on t1.DR_AcId=ac_chart.AcChartId ".$where_r."  order by CostItemId ASC";
		//echo $sql;
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดผูกบัญชีรายจ่าย
	Parameter		: 
		@ 	IncomeType	= ID (PK) ของตาราง tblbudget_finance_income_type
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($IncomeType){
		$where 	  = array();
		if($IncomeType){
			$where[] ="CostItemId=".$IncomeType;
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
	START #F4
	Function Name: getTypeActName 
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อธนาคาร
	Parameter		: 
		@BankId	= ID (PK) ของตาราง tblbudget_finance_bank
	Return Value 	: single(loadResult) 
	*/	
	function getBankName($BankId){
		$where 	  = array();
		if($BankId){
			$where[] ="BankId='".$BankId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select BankName from tblbudget_finance_bank ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F5
	Function Name: getOrderList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการธนาคารขึ้นมาเรียงลำดับ 
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
	*/	
	function getOrderList(){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_finance_bank ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}	
	/*END*/

 	/* START #F6 */
	/* Function Name: getAccGroupSelect */
	/* Description: เป็นฟังก์ชันสำหรับดึงราหมวดบัญชี  */
	/* Parameter: */
			/* @AcGroupId	 	= รหัสหมวดบัญชี */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getAccGroupSelect($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
//		$where = array();
//		$where[] = "EnableStatus='Y'";
//		$where[] = "DeleteStatus='N'";
//		
//		if(count($where)) {
//			$where_r = "WHERE ". implode( " AND ", $where );
//		}
		
		$sql="SELECT AcGroupId as value , CONCAT(GInitial,' ',GName) as text "
			 ."\n FROM ac_group "
//			 ."\n ".$where_r
			 ."\n order by AcGroupId ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
	 /* START #F7 */
	/* Function Name: getAcCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงรหัสบัญชี  */
	/* Parameter: */
			/* @AcGroupId		= หมวดบัญชี */
	/* Return Value : List Box */

	function getAcCode($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		$where[] = "AcType='D'";
		
		$AcGroupId = ltxt::getVar( 'AcGroupId','get' );
		if($AcGroupId){
		$where[] = "AcGroupId=$AcGroupId";
		}
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		//echo $where_r;
		$title[] = clssHTML::makeOption(0,$lebel);
		
		if($AcGroupId){
			$sql="SELECT AcChartId as value , CONCAT(AcChartCode,' | ',ThaiName) as text "
				 ."\n FROM ac_chart "
				 ."\n ".$where_r
				 ."\n order by AcChartId ASC " ;
				 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
				
			//echo "<pre>$sql;</pre>";
			$this->db->setQuery($sql);
			$datas = $this->db->loadObjectList();
			$datas = array_merge($title,$datas);
		}else{
			$datas = $title;
		}
		
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
 	/* START #F8 */
	/* Function Name: getCostTypeSelect */
	/* Description: เป็นฟังก์ชันสำหรับดึงประเภทงบ  */
	/* Parameter: */
			/* @CostTypeId	 	= รหัสประเภทงบ */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getCostTypeSelect($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT CostTypeId as value , CostTypeName as text "
			 ."\n FROM tblbudget_init_cost_type "
			 ."\n ".$where_r
			 ."\n order by CostTypeId ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
}
?>
