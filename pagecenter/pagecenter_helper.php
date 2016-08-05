<?php

class sHelper
{
	var $db;
	var $debug = 0;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
	}

	function getData($table,$field,$value){
		$sql="select * from ".$table." where ".$field." = ".$value."";
		$this->db->setQuery($sql);
		$row = $this->db->loadObjectList();
		return $row;
	}

	//*******************************อนุมัติหลักการทั่วไป***********************************
	/* 
	Function Name: getDetailGeneral 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแบบฟอร์มอนุมัติหลักการทั่วไป
	Parameter		: 
			@tbl			= ชื่อตารางของแบบฟอร์มที่ต้องการดึงข้อมูล
			@DocId	= รหัสแบบฟอร์ม
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailGeneral($DocTbl='tblintra_eform_formal_general',$DocField='DocId',$DocId){
		$where 	  = array();
		if($DocId){
			$where[] =" ".$DocField." = '".$DocId."'  ";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from ".$DocTbl." ".$where_r; //echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}	
	
/*	function getDetailGeneral($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_general ".$where_r; //echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}*/	
	/*END*/
		
	/* 
	Function Name: getCostGroupGeneral 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายแบบฟอร์มอนุมัติหลักการทั่วไป
	Parameter		: 
			@tbl			= ชื่อตารางของแบบฟอร์มที่ต้องการดึงข้อมูล
			@DocId	= รหัสแบบฟอร์ม
			@DocPK	= pk รายการค่าใช้จ่าย
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getCostGroupGeneral($DocTbl='tblintra_eform_formal_general_cost',$DocField='DocCode',$DocPK,$DocCode=0){
		$where = array();

		$where[] =" ".$DocField." = '".$DocCode."'  ";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
			
		$sql="SELECT Distinct CostItemCode "
		."\n FROM "
		."\n ".$DocTbl
		."\n ".$where_r
		."\n order by CostItemCode ASC"
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */			
		
	/* 
	Function Name: getCostItemListGeneral 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายแบบฟอร์มอนุมัติหลักการทั่วไป
	Parameter		: 
			@tbl			= ชื่อตารางของแบบฟอร์มที่ต้องการดึงข้อมูล
			@DocId	= รหัสแบบฟอร์ม
			@DocPK	= pk รายการค่าใช้จ่าย
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getCostItemListGeneral($DocTbl='tblintra_eform_formal_general_cost',$DocField='DocCode',$DocPK,$DocCode=0,$CostItemCode=0){
		$where = array();

		$where[] =" ".$DocField." = '".$DocCode."'  ";
		$where[] =" CostItemCode = '".$CostItemCode."'  ";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
			
		$sql="SELECT ".$DocPK.",".$DocField.", CostItemCode, Detail AS DetailCost, SumCost  "
		."\n FROM "
		."\n ".$DocTbl
		."\n ".$where_r
		."\n order by ".$DocPK." ASC"
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */		
	
	/* 
	Function Name: getSumCostOther
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่ายที่ไม่ได้คาดการณ์ไว้ก่อน
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostOther($DocCodePay='',$PrjActCode=0,$CostItemCode=0,$CostId=0,$DocCode='',$TaskNo=0){
		
		$where = array();
		if($DocCodePay){
			$where[] = "t1.DocCodePay='".$DocCodePay."'";
		}

		//if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		//}
		
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}		
		
		if($CostId){
			$where[] = "t1.CostId='".$CostId."'";
		}
		
		if($DocCode){
			$where[] = "t3.DocCode='".$DocCode."'";
		}	
		
		if($TaskNo){
			$where[] = "t1.TaskNo='".$TaskNo."'";
		}				
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t1.SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_meeting_pay_costother AS t1 "
				."\n LEFT JOIN tblintra_eform_formal_meeting_pay  AS t2 ON t1.DocCodePay=t2.DocCodePay "
				."\n LEFT JOIN tblintra_eform_formal_meeting  AS t3 ON t2.DocCode=t3.DocCode "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */	
	
	
	/* 
	Function Name: getSumOTOther
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่ายที่ไม่ได้คาดการณ์ไว้ก่อน
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumOTOther($DocCodePay='',$PrjActCode=0,$CostItemCode=0,$DocCode='',$TaskNo=0){
		
		$where = array();
		if($DocCodePay){
			$where[] = "t1.DocCodePay='".$DocCodePay."'";
		}

		//if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		//}
		
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}		
		
		
		if($DocCode){
			$where[] = "t3.DocCode='".$DocCode."'";
		}	
		
		if($TaskNo){
			$where[] = "t1.TaskNo='".$TaskNo."'";
		}				
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t1.SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_ot_pay_costother AS t1 "
				."\n LEFT JOIN tblintra_eform_formal_ot_pay  AS t2 ON t1.DocCodePay=t2.DocCodePay "
				."\n LEFT JOIN tblintra_eform_formal_ot  AS t3 ON t2.DocCode=t3.DocCode "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */		
	

	/* 
	Function Name: getSumCostGeneral 
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostGeneral($DocTbl='tblintra_eform_formal_general_cost',$DocField='DocCode',$DocCode=0,$PrjActCode=0,$CostItemCode=0,$DocId=0){
		
		$where = array();
		if($DocCode){
			$where[] =" ".$DocField." = '".$DocCode."'  ";
		}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($DocId){
			$where[] = "DocId='".$DocId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n ".$DocTbl
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */	
	
	
	
	//******************************* OS *****************************************************
	/* 
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailOs($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_os ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	
	//************************************MOU************************************************	
	/* 
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailMou($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_mou ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	
	//************************************* MAT ***********************************************	
	
	/* 
	START #F3
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailMat($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_mat ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* 
	START #F3
	Function Name: getDetailMatPay 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailMatPay($PayId){
		$where 	  = array();
		if($PayId){
			$where[] ="PayId='".$PayId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_mat_pay ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/	
	
	
	//****************************************Urgent********************************************	
	/* 
	Function Name: getDetailUrgent 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailUrgent($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_mat_urgent ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	/* Function Name:  getComName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อบริษัท/ห้าง/ร้าน*/
	function getComName($ComId=0){
		$where = array();
		$where[] = "ComId='".$ComId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select ComName "
				."\n from stock_init_company "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */	
	
	//**********************************Transfer**************************************************	
	/* 
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailTransfer($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_transfer ".$where_r;  
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/

	/* Function Name: getTransferItem */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการกิจกรรมที่ต้องการดำเนินการเพิ่มเติม */
	function getTransferItem($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT TraItemId, ItemName, ItemBudget"
		."\n FROM "
		."\n tblintra_eform_transfer_item"
		."\n ".$where_r
		."\n order by TraItemId asc"
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */		
	
	//***********************************แบบฟอร์มเอกสารขออนุมัติและเบิกจ่ายงบประมาณ*************************************************	
	/*   
	Function Name: getDetailPay
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแบบฟอร์มเอกสารขออนุมัติและเบิกจ่ายงบประมาณ
	Parameter		: 
		@DocId	= ID (PK) ของตาราง tblintra_eform_formal_pay
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailPay($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_pay ".$where_r; //echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/
	
	
	//***********************************แบบฟอร์มเอกสารขออนุมัติจัดประชุม(สช.บ.003) /ขออนุมัติเดินทางปฏิบัติงาน(สช.บ.004) /ขออนุมัติเบิกจ่าย(สช.บ.005)*************************************************	
	/*   
	Function Name: getDetailMeeting
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแบบฟอร์มเอกสารขออนุมัติจัดประชุม(สช.บ.003) /ขออนุมัติเดินทางปฏิบัติงาน(สช.บ.004) /ขออนุมัติเบิกจ่าย(สช.บ.005)
	Parameter		: 
		@DocId	= ID (PK) ของตาราง tblintra_eform_formal_meeting
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailMeeting($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_meeting ".$where_r; //echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/	
	
	/*   
	Function Name: getDetailMeeting
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแบบฟอร์มเอกสารขออนุมัติจัดประชุม(สช.บ.003) /ขออนุมัติเดินทางปฏิบัติงาน(สช.บ.004) /ขออนุมัติเบิกจ่าย(สช.บ.005)
	Parameter		: 
		@DocId	= ID (PK) ของตาราง tblintra_eform_formal_meeting
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailMeetingPay($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="t1.PayId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select t1.*, t2.SourceType,t2.SourceExId, t2.PItemCode, t2.PrjId, t2.PrjActCode from tblintra_eform_formal_meeting_pay as t1 left join tblintra_eform_formal_meeting as t2 on t1.DocCode = t2.DocCode ".$where_r; //echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/		
	
	
	
	//***********************************แบบฟอร์มเอกสารขออนุมัติปฏิบัติงานล่วงเวลา*************************************************	
	/*   
	Function Name: getDetailOt
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแบบฟอร์มเอกสารขออนุมัติปฏิบัติงานล่วงเวลา
	Parameter		: 
		@DocId	= ID (PK) ของตาราง tblintra_eform_formal_ot
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailOt($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_ot ".$where_r; 	//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/		
	
	/*   
	Function Name: getDetailOtPay
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแบบฟอร์มเอกสารขออนุมัติเบิกจ่ายปฏิบัติงานล่วงเวลา
	Parameter		: 
		@PayId	= ID (PK) ของตาราง tblintra_eform_formal_ot_pay
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailOtPay($PayId){
		$where 	  = array();
		if($PayId){
			$where[] ="PayId='".$PayId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_ot_pay ".$where_r; 	//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/			
	
	//************************************************************************************	
	/*   
	Function Name: getDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดแบบฟอร์มขออนุมัติจัดประชุม
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($EFormId){
		$where 	  = array();
		if($EFormId){
			$where[] ="EFormId='".$EFormId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_advance ".$where_r; //echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/

	/* 
	Function Name: getdays
	Description: เป็นฟังก์ชันหาจำนวนวัน
	*/
	function getdays($StartDate,$EndDate)
	{
		 return (round((strtotime($EndDate)-strtotime($StartDate))/(24*60*60),0))+1;
	}
	/* END */

	/* 
	Function Name: getCostItemListPay
	Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายแบบฟอร์มเอกสารขออนุมัติและเบิกจ่ายงบประมาณ */
	function getCostItemListPay($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
			
		$sql="SELECT CostId, DocCode, CostItemCode, Detail AS DetailCost, SumCost  "
		."\n FROM "
		."\n tblintra_eform_formal_pay_cost"
		."\n ".$where_r
		."\n order by CostId ASC"
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */		
	
	/* 
	Function Name: getCostItemListMeeting
	Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายแบบฟอร์มเอกสารขออนุมัติจัดประชุม(สช.บ.003) /ขออนุมัติเดินทางปฏิบัติงาน(สช.บ.004) /ขออนุมัติเบิกจ่าย(สช.บ.005) */
	function getCostItemListMeeting($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
			
		$sql="SELECT CostId, DocCode, CostItemCode, Detail AS DetailCost, SumCost  "
		."\n FROM "
		."\n tblintra_eform_formal_meeting_cost"
		."\n ".$where_r
		."\n ORDER BY CostId ASC"
		;

		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */			
	
	/* 
	Function Name: getCostItemList
	Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายแบบฟอร์มเอกสารขออนุมัติ เบิกเงินยืมทดรอง และเคลียร์เงินยืมทดรอง */
	function getCostItemList($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
			
		$sql="SELECT EFormCostId, DocCode, CostItemCode, Detail AS DetailCost, SumCost ,BorrowBudget "
		."\n FROM "
		."\n tblintra_eform_advance_cost"
		."\n ".$where_r
		."\n ORDER BY EFormCostId ASC"
		;

		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */			
	
	
	
	/* 
	Function Name: getCostItemName 
	Description: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย */
		function getCostItemName($CostItemCode=0){
		$where = array();
		$where[] = "CostItemCode = '".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostName "
				."\n from tblbudget_init_cost_item "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
		}
	/* END */

	/* 
	Function Name: getUnitName
	Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยนับ 
	*/
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
	/* END */	
	
	/* 
	Function Name: getSumCostPay 
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostPay($DocCode=0,$PrjActCode=0,$CostItemCode=0,$DocId=0){
		
		$where = array();
		if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($DocId){
			$where[] = "DocId='".$DocId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_pay_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */

	/* 
	Function Name: getSumCostMeeting
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostMeeting($DocCode=0,$PrjActCode=0,$CostItemCode=0,$DocId=0){
		
		$where = array();
		if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($DocId){
			$where[] = "DocId='".$DocId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_meeting_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */

	/* 
	Function Name: getSumCostOt
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostOt($DocCode=0,$PrjActCode=0,$CostItemCode=0,$DocId=0){
		
		$where = array();
		if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($DocId){
			$where[] = "DocId='".$DocId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_ot_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */

	/* 
	Function Name: getSumCostOt
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostOtPay($DocCodePay=0,$PrjActCode=0,$CostItemCode=0,$PayId=0){
		
		$where = array();
		if($DocCodePay){
			$where[] = "DocCodePay='".$DocCodePay."'";
		}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($PayId){
			$where[] = "PayId='".$PayId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_ot_pay_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */


	/* Function Name:  getSourceExName */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแหล่งเงิน*/
	function getSourceExName($SourceExId=0){
		$where = array();
		$where[] = "SourceExId='".$SourceExId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select SourceExName "
				."\n from tblbudget_init_source_external "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START  */
	/* Function Name: getPItemName */
	/* Description: เป็นฟังก์ชันสำหรับดึงนโยบายแผนงาน */
	function getPItemName($PItemCode=0){
		$where = array();
		$where[] = "PItemCode = '".$PItemCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PItemName "
				."\n from tblbudget_init_plan_item "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */

	/* START #F66 */
	/* Function Name: getPrjName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อโครงการ */
	/* Parameter: */
			/* @PrjId	= รหัสโครงการ */
	/* Return Value : Single(loadResult) */
	function getPrjName($PrjId=0){
				
		$where = array();
		
		$where[] = "t1.PrjId='".$PrjId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.PrjName"
		."\n FROM "
		."\n tblbudget_project AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	

	/* START #F67 */
	/* Function Name: getPrjActName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อกิจกรรม */
	/* Parameter: */
			/* @PrjActCode	= รหัสกิจกรรม */
	/* Return Value : Single(loadResult) */
	function getPrjActName($PrjActCode=0){
				
		$where = array();
		
		$where[] = "t1.PrjActCode='".$PrjActCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.PrjActName"
		."\n FROM "
		."\n tblbudget_project_activity AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	

	/* START F */
	/* Function Name: getWord */
	/* Description: เป็นฟังก์ชันสำหรับส่งออกเอกสารเป็น word */
	function getWord(){
			header("Content-Type: application/vnd.ms-word");
			header('Content-Disposition: attachment; filename="report.doc"');
			echo "<html xmlns:o='urn:schemas-microsoft-com:office:office'xmlns:x='urn:schemas-microsoft-com:office:word'xmlns='http://www.w3.org/TR/REC-html40'>" ;

	}	
	/* END */	

	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	/* Parameter: */
			/* @OrganizeCode	= รหัสหน่วยงาน */
	/* Return Value : Single(loadResult) */
	function getOrganizeName($OrganizeCode=0){
		$where = array();
		
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.OrgName"
		."\n FROM "
		."\n tblstructure_operation AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */		

	function getTaskPersonOt($DocCode)
	{
		$sql = "SELECT P.PersonalCode,
					CONCAT(PR.PrefixName,
					P.FirstName,' ',
					P.LastName) as Name 
					FROM
					tblintra_eform_formal_ot_person AS PP
					Inner Join tblpersonal AS P ON PP.PersonalCode = P.PersonalCode
					Inner Join tblpersonal_prefix AS PR ON PR.PrefixId = P.PrefixId 
					where PP.DocCode='$DocCode' ";
		//echo "<pre>$sql</pre>";			
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	

	function getTaskPersonOtPay($DocCodePay)
	{
		$sql = "SELECT * From tblintra_eform_formal_ot_pay_person where DocCodePay='$DocCodePay' order by PersonIdPay asc";
		//echo "<pre>$sql</pre>";			
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	


//******* F:15 แบบฟอร์มเอกสารขออนุมัติหลักการเข้ารับการอบรม/สัมนา/ดูงาน/ปฏิบัติงานวิจัย/เดินทางไปต่างประเทศ *******
	/*
	Function Name: getDetailTraining 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดหน่วยนับ 
	Parameter		: 
		@UnitID	= ID (PK) ของตาราง tblunit
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetailTraining($DocId){
		$where 	  = array();
		if($DocId){
			$where[] ="DocId='".$DocId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_formal_borrow ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject(); 
		return $detail;
	}
	/*END*/

	/* Function Name: getCountryName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย */
		function getCountryName($CountryCode=0){
		$where = array();
		$where[] = "CountryCode = '".$CountryCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select Country "
				."\n from tblcountry "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
		}
	/* END */


	function getTaskBorrowPerson($DocCode)
	{
		$sql = "SELECT P.PersonalCode,
					CONCAT(PR.PrefixName,
					P.FirstName,' ',
					P.LastName) as Name 
					FROM
					tblintra_eform_formal_borrow_person AS PP
					Inner Join tblpersonal AS P ON PP.PersonalCode = P.PersonalCode
					Inner Join tblpersonal_prefix AS PR ON PR.PrefixId = P.PrefixId 
					where PP.DocCode='$DocCode' ";
		//echo "<pre>$sql</pre>";			
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList(); 
		return $list;
	}	

	/* 
	Function Name: getSumCostTrainning 
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย 
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostTrainning($DocCode=0,$PrjActCode=0,$CostItemCode=0,$CostId=0){
		
		$where = array();
		if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($CostId){
			$where[] = "CostId='".$CostId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_borrow_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */

	/* 
	Function Name: getCostItemTrainingList
	Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่าย */
	function getCostItemTrainingList($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
			
		$sql="SELECT CostId, DocCode, CostItemCode, Detail AS DetailCost, SumCost  "
		."\n FROM "
		."\n tblintra_eform_formal_borrow_cost"
		."\n ".$where_r
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */		
	

	/* START #F67 */
	/* Function Name: getPositionName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อตำแหน่ง */
	/* Parameter: */
			/* @PositionId	= รหัสตำแหน่ง */
	/* Return Value : Single(loadResult) */
	function getPositionName($PositionId=0){
				
		$where = array();
		
		$where[] = "t1.PositionId='".$PositionId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.Position"
		."\n FROM "
		."\n tblposition AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	

	/* START  */
	/* Function Name: getPItemName */
	/* Description: เป็นฟังก์ชันสำหรับดึงนโยบายแผนงาน */
	function getForTypeName($FormCode=0){
		$where = array();
		$where[] = "FormCode = '".$FormCode."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select FormName "
				."\n from tblintra_eform_init_form "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	

	/* START 7 */
	/* Function Name: getTransferItem */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการคณะกรรมการจัดจ้างพัสดุ */
	function getmatItem($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT StaffId, PersonalCode as StaffPersonalCode, PositionId as StaffPositionId, DutyId"
		."\n FROM "
		."\n tblintra_eform_mat_urgent_staff"
		."\n ".$where_r
		."\n ORDER BY StaffId ASC"		
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */	
	
	/* START */
	/* Function Name: getcountstaff */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการคณะกรรมการจัดจ้างพัสดุ */
	function getcountstaff($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT count(*)"
		."\n FROM "
		."\n tblintra_eform_mat_urgent_staff"
		."\n ".$where_r
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	
	
	/* START  */
	/* Function Name: getDutyName */
	/* Description: เป็นฟังก์ชันสำหรับดึงตำแหน่งจาก stock */
	function getDutyName($DutyId=0){
		$where = array();
		$where[] = "DutyId = '".$DutyId."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select DutyName "
				."\n from stock_init_duty "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	

/* START #F49 */
	/* Function Name: getTotalPrjInternalX4 */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActCode=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjId){
			$where[] = "t1.PrjId='".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActCode){
			$where[] = "t3.PrjActCode='".$PrjActCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t4.SumCost)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_internal AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n ".$where_r
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */


	/* START #F50 */
	/* Function Name: getTotalPrjExternalX4 */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActCode=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjId){
			$where[] = "t1.PrjId='".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActCode){
			$where[] = "t3.PrjActCode='".$PrjActCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if($SourceExId){
			$where[] = "t4.SourceExId='".$SourceExId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t4.SumCost)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_external AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n Inner Join tblbudget_init_source_external AS t8 ON t8.SourceExId = t4.SourceExId "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}

	/* END */
	
	/* START #F51 */
	/* Function Name: getTotalPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ+เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */	

	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActCode=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		$BgtYear = ($BgtYear)?$BgtYear:(date("Y")+543);
		$BGInt		= $this->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActCode,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$BGExt		= $this->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActCode,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		
		$BGTotal	= $BGInt+$BGExt;
		return $BGTotal;
	}
	/* END */	

	/* Function Name: getPositionByPersonalCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อตำแหน่ง */
	/* Parameter: */
			/* @PositionId	= รหัสตำแหน่ง */
	/* Return Value : Single(loadResult) */
	function getPositionByPersonalCode($PersonalCode=0){
				
		$where = array();
		
		$where[] = "t1.PersonalCode='".$PersonalCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t2.Position"
		."\n FROM "
		."\n tblpersonal_position AS t1  "
		."\n Inner Join tblposition AS t2 ON t2.PositionId = t1.PositionId "
		."\n ".$where_r
		;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	
	
	/* Function Name: getDetailCodeRefer */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดข้อมูลของ สช.น. ที่อ้างอิง */
		function getDetailCodeRefer($DocCodeRefer=0){
		$where = array();
		$where[] = "DocCode = '".$DocCodeRefer."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select 	Detail AS DetailRefer,
								Location AS LocationRefer,
								StartDate AS StartDateRefer,
								EndDate AS EndDateRefer,
								AmountPerson AS AmountPersonRefer,
								BgtYear AS BgtYearRefer,
								OrganizeCode AS OrganizeCodeRefer,
								PItemCode AS PItemCodeRefer,
								PrjId AS PrjIdRefer,
								PrjActCode AS PrjActCodeRefer,
								SourceType AS SourceTypeRefer,
								SourceExId AS SourceExIdRefer, 
								DocDate AS DocDateRefer "
								
				."\n from tblintra_eform "
				."\n ".$where_r
				;

		//echo $sql;	
	
		$this->db->setQuery($sql);
		$data = $this->db->loadSingleObject();
		return $data;
		}
	/* END */
	
	/* Function Name: getClearCostItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการคณะกรรมการจัดจ้างพัสดุ */
	function getClearCostItemList($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
			
		$sql="SELECT EFormClearId, DocCode AS DocCodeCost, CostItemCode, Detail AS DetailCost, SumCost, PrjActCode AS PrjActCodeCost, SumCostClear  "
		."\n FROM "
		."\n tblintra_eform_cost_clear"
		."\n ".$where_r
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */		

	/* 
	Function Name: getSumCostClear
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการเบิกเงินยืมทดรอง
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostClear($DocCode=0,$PrjActCode=0,$CostItemCode=0,$EFormClearId=0){
		
		$where = array();
		//if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		//}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($EFormClearId){
			$where[] = "EFormClearId='".$EFormClearId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCostClear) "
				."\n FROM "
				."\n tblintra_eform_cost_clear "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */

	/* 
	Function Name: getSumCostBorrow
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการเบิกเงินยืมทดรอง
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	/*function getSumCostBorrow($DocCode=0,$PrjActCode=0,$CostItemCode=0,$EFormBorrowId=0){
		
		$where = array();
		//if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		//}

		//if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		//}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($EFormBorrowId){
			$where[] = "EFormBorrowId='".$EFormBorrowId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(BorrowBudget) "
				."\n FROM "
				."\n tblintra_eform_cost_borrow "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}*/
	/* END */

	
	/* 
	Function Name: getTrainingDetail 
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดงบขออนุมัติ
	Parameter		: -
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getTrainingDetail($DocCodeRefer){
		$where 	  = array();
		//if($DocCode){
			$where[] ="DocCode='".$DocCodeRefer."'";
		//}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="SELECT DocCode AS DocCode2, BgtYear AS BgtYear2, OrganizeCode AS OrganizeCode2, PItemCode AS PItemCode2, PrjId AS PrjId2, PrjActCode AS PrjActCode2, SourceType AS SourceType2, SourceExId AS SourceExId2  " 
		."\n FROM "
		."\n tblintra_eform_formal_borrow "
		."\n ".$where_r;
		
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql); 
		$list = $this->db->loadObjectList(); 
		return $list;
	}// end function
	
	/* 
	Function Name: getSumCost 
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCost($DocCode=0,$PrjActCode=0,$CostItemCode=0,$EFormCostId=0){
		
		$where = array();
		//if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		//}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($EFormCostId){
			$where[] = "EFormCostId='".$EFormCostId."'";
		}
		
		//$where[] = "t4.CostItemCode in(".$CostItemCode.")";
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n tblintra_eform_advance_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */

	/* 
	Function Name: getSumCostBorrow
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการเบิกเงินยืมทดรอง
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostBorrow($DocCode=0,$PrjActCode=0,$CostItemCode=0,$EFormBorrowId=0){
		
		$where = array();
		//if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		//}

		//if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		//}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($EFormBorrowId){
			$where[] = "EFormBorrowId='".$EFormBorrowId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(BorrowBudget) "
				."\n FROM "
				."\n tblintra_eform_advance_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	/* 
	Function Name: getSumCostPay 
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	/*function getSumCostGer($DocCode=0,$PrjActCode=0,$CostItemCode=0,$DocId=0){
		
		$where = array();
		if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($DocId){
			$where[] = "DocId='".$DocId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_general_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}*/
	/* END */
	
	/*
	Function Name	: getPrjCode
	Description		: เป็นฟังก์ชันสำหรับดึง PrjCode 
	Parameter		:
		@$PrjId = รหัสโครงการ
	Return Value 	: Single(loadResult) 
	*/		
	function getPrjCode($PrjId){
		$where = array();
		$where[] = "PrjId = '".$PrjId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PrjCode "
				."\n from tblbudget_project"
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	
	
	/* START */
	/* Function Name: getcountstaff */
	/* Description: เป็นฟังก์ชันสำหรับนับจำนวนคน */
	function countperson($TableDoc,$FieldDoc,$DocCode=0){
		$where = array();
		
		$where[] = " ".$FieldDoc."='".$DocCode."' ";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT count(*)"
		."\n FROM "
		."\n ".$TableDoc
		."\n ".$where_r
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */		
	
	/* Function Name: getCostItemListPay */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการคณะกรรมการจัดจ้างพัสดุ */
	function getCostItemListMeetingPay($DocCodePay=0,$TaskNo=1){

		$where = array();
		
		$where[] = "DocCodePay='".$DocCodePay."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
			
		$sql="SELECT CostIdPay, DocCodePay, CostItemCode, Detail AS DetailCost, SumCost  "
		."\n FROM "
		."\n tblintra_eform_formal_meeting_pay_cost"
		."\n ".$where_r
		."\n ORDER BY CostIdPay ASC"
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */			
	
	/* 
	Function Name: getSumCostMeeting
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostMeetingPay($DocCode=0,$PrjActCode=0,$CostItemCode=0,$DocId=0){
		
		$where = array();
		if($DocCode){
			$where[] = "DocCodePay='".$DocCode."'";
		}

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
		
		if($DocId){
			$where[] = "DocId='".$DocId."'";
		}
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(SumCost) "
				."\n FROM "
				."\n tblintra_eform_formal_meeting_pay_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	/* 
	Function Name: TotalBGTransfer
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่ายงบโอนเงินงบประมาณ
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function TotalBGTransfer($DocCode=0){
		
		$where = array();
		if($DocCode){
			$where[] = "DocCode='".$DocCode."'";
		}
					
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT "
				."\n sum(Budget) "
				."\n FROM "
				."\n tblintra_eform_transfer_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
/*
	Function Name: getPrjForBudget 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการผู้ให้งบประมาณ
	Parameter		: -
	Return Value 	: Array  (loadObjectList) 
*/
function getPrjForBudget($DocCode){
		$where 	  = array();
		$where[] ="DocCode='".$DocCode."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select * from tblintra_eform_transfer_cost ".$where_r; 
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$rows = $this->db->loadObjectList(); 
		return $rows;
}//end
/*END*/		
	
	/* 
	START
	Function Name			: getTotalBudget 
	Description				: เป็นฟังก์ชันสำหรับดึงยอดรวมค่าใช้จ่ายของกิจกรรมเพิ่มเติม
	Parameter				:
			 @DocCode		= เลขที่ สชน.
	Return Value			: Field 
	*/
	function getTotalBudget($DocCode=0){
		
		$where = array();

		$where[] = "DocCode='".$DocCode."'";
			
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(ItemBudget) "
				."\n FROM "
				."\n tblintra_eform_transfer_item "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */	
	
	function getMonthName($MonthNo=0){
		$where = array();
		$where[] = "MonthNo = '".$MonthNo."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select MonthNameTH "
				."\n from tblbudget_month "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}		
	
	/* Function Name: getInvenTypeName */
	/* Description: เป็นฟังก์ชันสำหรับดึงตำแหน่งจาก stock */
	function getInvenTypeName($InvenTypeId=0){
		$where = array();
		$where[] = "InvenTypeId = '".$InvenTypeId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select InvenType "
				."\n from stock_inventype "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */		
	
	
	/* START */
	/* Function Name: getTransferItem */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการคณะกรรมการจัดจ้างพัสดุ */
	function getMatStaff($DocCode=0){
		$where = array();
		
		$where[] = "DocCode='".$DocCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT StaffId, PersonalCode as StaffPersonalCode, PositionId as StaffPositionId, DutyId"
		."\n FROM "
		."\n tblintra_eform_formal_mat_staff"
		."\n ".$where_r
		."\n ORDER BY StaffId ASC"		
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */	
	
	
	/* 
	Function Name: getSumCost 
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมงบประมาณ
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumCostCenter($Table='tblintra_eform_advance_cost',$BGName='SumCost',$CodeName='DocCode',$IDName='EFormCostId',$DocCode=0,$EFormCostId=0,$PrjActCode=0,$CostItemCode=0){
		
		$where = array();
		//if($DocCode){
			$where[] = " ".$CodeName."='".$DocCode."'";
		//}
		
		if($EFormCostId){
			$where[] = " ".$EFormCostId."='".$EFormCostId."'";
		}		

		if($PrjActCode){
			$where[] = "PrjActCode='".$PrjActCode."'";
		}
		
		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		

		//$where[] = "t4.CostItemCode in(".$CostItemCode.")";
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(".$BGName.") "
				."\n FROM "
				."\n ".$Table
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* 
	Function Name	: getCountFile
	Description			: เป็นฟังก์ชันสำหรับดึงรายการไฟล์แนบเพื่อแสดงรายละเอียด
	Parameter			: 
		@TblName 		= ชื่อตาราง	
		@DocCode 	= เลขที่ สชน. (FK)
	Return Value 		: Field	
	*/
	function getCountFile($TblName='',$DocCode){
		$where 	  = array();
		$where[] =" DocCode='".$DocCode."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select COUNT(*) from ".$TblName.$where_r;  //	echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$rows = $this->db->loadResult(); 
		return $rows;
	}	
	/* END */
	
	
	
	
}// end
?>
