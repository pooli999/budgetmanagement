<?php

class sHelper
{
	var $db;
	var $debug = 0;
	var $dpublic;
	var $fpublic;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
		$this->dpublic	= new BGPublic();
		$this->fpublic = new F_Public();		
	}

	/* 
	START #F2
	Function Name	: getDataList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการหน่วยนับทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อหน่วยนับเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		//$where[] ="t1.DeleteStatus='N'";
		//$where[] ="t1.EnableStatus='Y'";
		//$where[] ="t1.DocumentId in (11) ";
		
		if($_REQUEST["tsearch"]){
			$where[] = "t1.Topic like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="select t1.*,t2.StatusName,t2.TextColor,t2.Icon from tblintra_eform_formal_ot_pay AS t1 "
		."\n Inner Join tblintra_eform_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
		."\n".$where_r
		."\n order by t2.DocStatusId ASC, t1.DocDate DESC, t1.DocCode ASC";
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	
	function getFormName($FormCode){
		return $this->dpublic->getFormName($FormCode);
	}	
	
	/* 
	Function Name: getSumCost 
	Description: เป็นฟังก์ชันสำหรับดึงยอดรวมรายการค่าใช้จ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getSumBudget($DocCode=0,$PrjActCode=0,$CostItemCode=0,$CostId=0){
		
		$where = array();
		//if($DocCode){
			$where[] = "DocCodePay='".$DocCode."'";
		//}

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
				."\n tblintra_eform_formal_ot_pay_cost "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
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

		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}
		
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
	Function Name: getCostPayList
	Description: เป็นฟังก์ชันสำหรับดึงรายการขอเบิกจ่าย
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getCostPayList($DocCodePay){
		
		$where = array();
		
		$where[] = "DocCodePay='".$DocCodePay."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql="SELECT * FROM tblintra_eform_formal_ot_pay_cost".$where_r;
		
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();	//echo "<pre>$sql</pre>";
		return $list;
		
	}
	/* END */	
	
	/* 
	Function Name: getChainCost
	Description: เป็นฟังก์ชันสำหรับดึงยอดผูกพันคงเหลือของรายการค่าใช้จ่ายนั้น
	Parameter:
			 @XXXX	= -
	Return Value : Field 
	*/
	function getChainRemain($Field,$CostCode,$DocCode){
		$where = array();
		
		$where[] = "CostCode='".$CostCode."'";
		$where[] = "DocCode='".$DocCode."'";

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT ".$Field."  FROM tblbudget_bg_chain"
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;		
		
	}
	/* END */		
	
	
	
}// end class
?>
