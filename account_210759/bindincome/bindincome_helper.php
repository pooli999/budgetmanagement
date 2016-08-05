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
			$where0="tblbudget_finance_income_type.DeleteStatus='N'";
			$where1 = "tblbudget_finance_income_type_ac.AcSeriesId =".$_REQUEST["AcSeriesId"];

			$sql="select *,";
			//$sql = $sql."(select CONCAT(AcChartCode,' | ',ThaiName) from tblbudget_finance_income_type_ac inner join ac_chart on tblbudget_finance_income_type_ac.AcChartId=ac_chart.AcChartId where tblbudget_finance_income_type.IncomeType=tblbudget_finance_income_type_ac.IncomeType and ".$where1.") as acName,";
			//$sql = $sql."(select IncomeTypeAcId from tblbudget_finance_income_type_ac where tblbudget_finance_income_type.IncomeType=tblbudget_finance_income_type_ac.IncomeType and ".$where1.") as IncomeTypeAcId,";
			//$sql = $sql."(select AcGroupId from tblbudget_finance_income_type_ac where tblbudget_finance_income_type.IncomeType=tblbudget_finance_income_type_ac.IncomeType and ".$where1.") as AcGroupId,";
			$sql = $sql."'".$_REQUEST["AcSeriesId"]."' as AcSeriesId,'".$_REQUEST["AcSeriesName"]."' as AcSeriesName ";
			$sql = $sql."from tblbudget_finance_income_type where ".$where0."  order by tblbudget_finance_income_type.IncomeType ASC";
			//echo $sql;
			$this->db->setQuery($sql);
			$this->db->limit = $limit;
			$list = $this->db->loadDataSet();
			return $list;
		}
	}
	/*END*/
	function getAcDataList(&$IncomeType){
		if($_REQUEST["AcSeriesId"]!="0"){
			$where1 = "tblbudget_finance_income_type_ac.IncomeType =".$IncomeType;
			$sql = "select CONCAT(AcChartCode,' | ',ThaiName) as acName from tblbudget_finance_income_type_ac inner join ac_chart on tblbudget_finance_income_type_ac.AcChartId=ac_chart.AcChartId where ".$where1;
			//echo $sql;
			$this->db->setQuery($sql);
			$list = $this->db->loadDataSet();
			return $list;
		}
	}		

	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดผูกบัญชีรายรับ 
	Parameter		: 
		@ 	IncomeType	= ID (PK) ของตาราง tblbudget_finance_income_type
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($IncomeType,$IncomeTypeAcId){
		$where 	  = array();
		if($IncomeType){
			$where[] ="tblbudget_finance_income_type.IncomeType=".$IncomeType;
		}
		if($IncomeTypeAcId){
			$where[] ="tblbudget_finance_income_type_ac.IncomeTypeAcId=".$IncomeTypeAcId;
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblbudget_finance_income_type left join tblbudget_finance_income_type_ac on tblbudget_finance_income_type.IncomeType =tblbudget_finance_income_type_ac.IncomeType ".$where_r;
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
	
	function AcSubSelect($AcGroupId ='',$AcSeriesId ='',$tag_name, $tag_attribs='', $selected=null){
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		$where[] = "AcType='D'";
	
		if($AcGroupId){
		$where[] = "AcGroupId=$AcGroupId";
		}
		if($AcSeriesId){
		$where[] = "AcSeriesId=$AcSeriesId";
		}

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

		if($AcGroupId){
			$sql="SELECT AcChartId as value , CONCAT(AcChartCode,' | ',ThaiName) as text "
			."\n FROM ac_chart "
			."\n ".$where_r
			."\n order by AcChartId ASC " ;
				 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "

			//echo "<pre>$sql;</pre>";
			$this->db->setQuery($sql);
			//$title[] = clssHTML::makeOption(0,$lebel);
			$datas = $this->db->loadObjectList();
		}
		$datas = array_merge($datas);
		return clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );

        //return clssHTML::selectList($ob,$tag_name,$tag_attribs,'value','text',$selected);
    }
	
	function GetAcData(){
		$where 	  = array();
		$IncomeType = ltxt::getVar( 'IncomeType','post' );
		$where[] = "tblbudget_finance_income_type_ac.IncomeType=$IncomeType";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$data_send=array();
		$sql = "select tblbudget_finance_income_type_ac.AcChartId as AcChartId, CONCAT(AcChartCode,' | ',ThaiName) as Cname from tblbudget_finance_income_type_ac inner join ac_chart on tblbudget_finance_income_type_ac.AcChartId   = ac_chart.AcChartId  ".$where_r;
		//echo $sql;
		$this->db->setQuery($sql);
		$detail1 = $this->db->loadDataSet();
		$line1 = 0;
		if($detail1["rows"]){
			 foreach($detail1["rows"] as $r3 ) {
				$data_send[$line1]["key"]=$r3->AcChartId;
				$data_send[$line1]["value"]=$r3->Cname;
				$line1++;
			 }
		}
		echo json_encode ($data_send);
    }
}
?>
