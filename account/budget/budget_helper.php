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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการปีงบประมาณทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อธนาคารเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
	//	$where[] ="DeleteStatus='N'";
		
		if($_REQUEST["tsearch"]){
			$where[] = "BankName like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select * from tblbudget_init_year left join ac_series on  tblbudget_init_year.AcSeriesId=ac_series.AcSeriesId ".$where_r."  order by BgtYear ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดปีงบประมาณ
	Parameter		: 
		@BgtYearId	= ID (PK) ของตาราง tblbudget_init_year
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($BgtYearId){
		$where 	  = array();
		if($BgtYearId){
			$where[] ="BgtYearId=".$BgtYearId;
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_init_year ".$where_r;

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
	/* Function Name: getAcSeriesIdSelect */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อชุดผังบัญชี */
	/* Parameter: */
			/* @AcSeriesId	 	= รหัสชุดผังบัญชี */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getAcSeriesIdSelect($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
//		$where = array();
//		$where[] = "EnableStatus='Y'";
//		$where[] = "DeleteStatus='N'";
//		
//		if(count($where)) {
//			$where_r = "WHERE ". implode( " AND ", $where );
//		}
		
		$sql="SELECT AcSeriesId as value , SeriesName as text "
			 ."\n FROM ac_series "
//			 ."\n ".$where_r
			 ."\n order by AcSeriesId ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$newrow[] = clssHTML::makeOption("newr","สร้างชุดผังบัญชีใหม่...");
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas,$newrow);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
}
?>
