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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการประเภทรายรับเพื่อผูกบัญชี
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อประเภทรายรับเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		if($_REQUEST["AcSeriesId"]!="0"){
			$where0="ac_maincash.DeleteStatus='N'";
			$where1 = "ac_cash.AcSeriesId =".$_REQUEST["AcSeriesId"];

			$sql="select *,";
			$sql = $sql."(select CONCAT(AcChartCode,' | ',ThaiName) from ac_cash inner join ac_chart on ac_cash.AcChartId=ac_chart.AcChartId where ac_maincash.CashId=ac_cash.CashId and ".$where1.") as acName,";
			$sql = $sql."(select CashAcId from ac_cash where ac_maincash.CashId=ac_cash.CashId and ".$where1.") as CashAcId,";
			$sql = $sql."(select AcGroupId from ac_cash where ac_maincash.CashId=ac_cash.CashId and ".$where1.") as AcGroupId,";
			$sql = $sql."'".$_REQUEST["AcSeriesId"]."' as AcSeriesId,'".$_REQUEST["AcSeriesName"]."' as AcSeriesName ";
			$sql = $sql."from ac_maincash where ".$where0."  order by ac_maincash.CashId ASC";
			//echo $sql;
			$this->db->setQuery($sql);
			$this->db->limit = $limit;
			$list = $this->db->loadDataSet();
			return $list;
		}
	}
	/*END*/
	

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดผูกบัญชีรายรับ 
	Parameter		: 
		@ 	CashId	= ID (PK) ของตาราง ac_maincash
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($CashId,$CashAcId){
		$where 	  = array();
		if($CashId){
			$where[] ="ac_maincash.CashId=".$CashId;
		}
		if($CashAcId){
			$where[] ="ac_cash.CashAcId=".$CashAcId;
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from ac_maincash left join ac_cash on ac_maincash.CashId =ac_cash.CashId ".$where_r;
		//echo $sql;
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
		$AcSeriesId = ltxt::getVar( 'AcSeriesId','get' );
		if($AcGroupId){
		$where[] = "AcGroupId=$AcGroupId";
		}
		if($AcSeriesId){
		$where[] = "AcSeriesId=$AcSeriesId";
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
			 ."\n order by AcSeriesId DESC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
//		$datas = array_merge($datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	/* END */
}
?>
