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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการรายรับทั้งหมด 
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อผู้รับเงินเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet) 
	*/	
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="tblbudget_finance_income.DeleteStatus='N'";
		
		if($_REQUEST["tsearch"]){
			$where[] = "PayName like ('%".$_REQUEST["tsearch"]."%')";
		}
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		//$fn1 = "(select BankName from tblbudget_finance_bank where tblbudget_finance_bank.BankId = tblbudget_finance_bookbank.BankId) as BankName";
		
		$sql="select * from tblbudget_finance_income inner join tblbudget_finance_income_type on tblbudget_finance_income.IncomeType=tblbudget_finance_income_type.IncomeType ".$where_r."  order by Ordering ASC";
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
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดรายรับ 
	Parameter		: 
		@TypeActId	= ID (PK) ของตาราง tblbudget_init_type_activity
	Return Value 	: Array 1 รายการ (loadSingleObject) 
	*/	
	function getDetail($IncomeId){
		$where 	  = array();
		if($IncomeId){
			$where[] ="IncomeId='".$IncomeId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql = "select * from tblbudget_finance_income left join tblbudget_finance_bookbank on  tblbudget_finance_income.BookbankId = tblbudget_finance_bookbank.BookbankId".$where_r;
		//echo $sql ;
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
	/*function getBookbankNumber($BookbankId){
		$where 	  = array();
		if($BankId){
			$where[] ="BookbankId='".$BookbankId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select BookbankNumber from tblbudget_finance_bookbank ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult(); 
		return $detail;
	}*/
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
		
		$sql="select * from tblbudget_finance_income ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}	
	/*END*/
	
	 /* START #F6 */
	/* Function Name: getPlanItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการเลขที่สัญญา  */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getContractId($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		$where[] = "GuaranteeStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT ContractId as value , ContractNo as text "
			 ."\n FROM stock_doc_con_contract "
			 ."\n ".$where_r
			 ."\n order by ContractNo ASC " ;
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
	/* Function Name: getBankNameSelect */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการเงขที่ข้อตกลง  */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getAgreementId($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		//$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		$where[] = "CloseStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT MouId as value , ContractNo as text "
			 ."\n FROM tblmou_project "
			 ."\n ".$where_r
			 ."\n order by ContractNo ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
	
	/* START #F8 */
	/* Function Name: getBookbankId */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการเลขที่บัญชี กรณีดอกเบี้ยรับ */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
	/* Return Value : List Box */

	function getInterestBookbankId($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT BookbankId as value , BookbankNumber as text "
			 ."\n FROM tblbudget_finance_bookbank "
			 ."\n ".$where_r
			 ."\n order by BookbankNumber ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	/* END */
	/* START #F9 */
	/* Function Name: getBookbankId */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการธนาคาร ใช้กรณีโอน */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
	/* Return Value : List Box */

	function getBankId($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT BankId as value , BankName as text "
			 ."\n FROM tblbudget_finance_bank "
			 ."\n ".$where_r
			 ."\n order by BankName ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	/* START #F10 */
	/* Function Name: getBookbankId */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการเลขที่บัญชี ใช้กรณีโอน*/
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
	/* Return Value : List Box */

	function getBookbankId($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT BookbankId as value , BookbankNumber as text "
			 ."\n FROM tblbudget_finance_bookbank "
			 ."\n ".$where_r
			 ."\n order by BookbankNumber ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
	/* START #F11 */
	/* Function Name: getBookbankId */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการเลขที่บัญชี รายละเอียดการรับเงิน */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
	/* Return Value : List Box */

	function getGuaranteeBankId($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT BankId as value , BankName as text "
			 ."\n FROM tblbudget_finance_bank "
			 ."\n ".$where_r
			 ."\n order by BankName ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}

	/* END */
	
	/* 
	START #F12
	Function Name: getOrderList 
	Description		: เป็นฟังก์ชันสำหรับดึงรายการธนาคารขึ้นมาเรียงลำดับ 
	Parameter		: -
	Return Value 	: Array(loadObjectList) 
	*/	
	function getDetail1($IncomeType,$id){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		if ($IncomeType == 1){
			$sql = "select Topic as Topic,ComName as PayName,TotalBGChain as IncomeValue from stock_doc_con_contract inner join stock_init_company on stock_doc_con_contract.ComId = stock_init_company.ComId where ContractId = ".$id;
		}else if ($IncomeType == 2){
			$sql = "select  MouName as Topic,PtnFname as PayName,mouBudget as IncomeValue from tblmou_project inner join tblmou_owner on tblmou_project.CodeOwner = tblmou_owner.PartnerCode inner join nh_in_partner  on tblmou_owner.PartnerCode = nh_in_partner.PartnerCode where MouId = ".$id;
		}else if ($IncomeType == 3){
			$sql = "select  BankName as PayName from tblbudget_finance_bookbank inner join tblbudget_finance_bank on  tblbudget_finance_bookbank.BankId =  tblbudget_finance_bank.BankId where BookbankId = ".$id;
		}else if ($IncomeType == 4){
			$sql = "select  Topic as Topic,PtnFname as PayName,TotalCost as IncomeValue from (tblfinance_form_paybr left join tblpersonal on tblfinance_form_paybr.RQPersonalCode=tblpersonal.PersonalCode) left join tblpersonal_prefix on tblpersonal.PrefixId = tblpersonal_prefix.PrefixId where DocCode = ".$id;
		
		}
		
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		foreach($list as $rs){
			$ans1 = $rs->Topic."|||".$rs->PayName."|||".$rs->IncomeValue;
		}
		return $ans1;
	}	
	/*END*/
	
	 /* START #F13 */
	/* Function Name: getIncomeType */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการประเภทรายรับ  */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getIncomeType($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT IncomeType as value , IncomeType_Name as text "
			 ."\n FROM tblbudget_finance_income_type "
			 ."\n ".$where_r
			 ."\n order by Order_run ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
	/* START #F14 */
	/* Function Name: getDocCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการเลขที่บัญชี กรณีดอกเบี้ยรับ */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
	/* Return Value : List Box */

	function getDocCode($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element

		$where_r = " where FormCode ='FF006-1' or FormCode ='FF006-2' ";
		$sql="SELECT DocCode as value , DocCode as text "
			 ."\n FROM tblfinance_form_paybr "
			 ."\n ".$where_r
			 ."\n order by EFormId ASC " ;
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