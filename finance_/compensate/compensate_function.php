<?php       
include("config.php");
include($KeyPage."_helper.php");
class sFunction extends sHelper{
	var $RedirectPage;
	var $PathUpload;
	//  Not Remove  //
	function RedirectPage($RPage)
	{
		$this->RedirectPage = $RPage;
	}
	
	function setUploadPath($Path)
	{
		$this->PathUpload = $Path;
	}
	
	function Reload($redirect_page)
	{		
		LTXT::_( $redirect_page, 'redirect' );
	}
	
	/* 
	START #F1
	Function Name: changeStatus 
	Description		: เปลี่ยนสถานะประเภทกิจกรรมเป็น แสดง หรือไม่แสดง
	Parameter		: -
	Return Value 	: -
	*/
	
	function changeStatus()
	{
		if($_REQUEST['EnableStatus'] == 1){
			$_REQUEST['EnableStatus']='Y'; $Str = 'แสดง';
		}else{
			$_REQUEST['EnableStatus']='N'; $Str = 'ไม่แสดง';
		}
		
		$Topic = $this->getBankName($_REQUEST["BankId"]);
		LogFiles::SaveLog("ระบบการเงิน","เปลี่ยนสถานะข้อมูลธนาคารเป็น ".$Str,$_REQUEST["BankId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_finance_bank',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข ธนาคาร
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
	
		$dataD = array();
		$dataD["CompensateId"] = "";
		$dataD["DocCode"] = $_POST["data1"];
		if($pk = $this->db->arecSave('tblbudget_finance_pettycash_compensate',$dataD)){	 // เพิ่มรายการ เบิกคืนเงินสดย่อย
				LogFiles::SaveLog("เบิกทดแทนเงินสดย่อย","เบิกทดแทนเงินสดย่อย",$pk,$_REQUEST["data1"]);
				$data1 = explode("||", $_POST["data1"]);
				foreach($data1 as $doccode) {
					$doccode = trim($doccode);
					$sql = "Update tblfinance_doccode set CompensateId= ".$pk." where DocCode = '".$doccode."'"; // อัพเดท รหัส เบิกคืนเงินสดย่อย ที่ efoem 
					$this->db->Execute($sql);
				}
				
				$sql = "select  sum(cash) as sumcash from tblfinance_doccode where CompensateId = ".$pk; // หาจำนวนเงินทั้งหมด
				$this->db->setQuery($sql);
				$this->db->limit = $limit;
				$list = $this->db->loadObjectList();
				foreach($list as $rs){
					$maxval = $rs->sumcash;
				}
				$sql = "Update tblbudget_finance_pettycash_compensate set TotalValue= ".$maxval." where CompensateId = ".$pk; // อัพเดทจำนวนเงินที่ตารางเงินสดย่อย
				$this->db->Execute($sql);
	
				LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
				
			}else{
				echo ltxt::_('Error!','jalert');
			}
	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบประเภทกิจกรรม
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = $this->getBankName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลธนาคาร",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_finance_bank set DeleteStatus='Y' where BankId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
	}
	/*End*/
	
	/* 
	START #F4
	Function Name: SaveOrder 
	Description		: เรียงลำดับประเภทกิจกรรม
	Parameter		: -
	Return Value 	: -
	*/
	function SaveOrder()
	{
			$ArrOrder = explode(",",$_REQUEST["newOrder"]);
			//$i = count($ArrOrder);
			$i=1;
			foreach($ArrOrder as $id){
				if($id != ""){
					$sql = "Update tblbudget_finance_bank set Ordering='$i' where BankId = '".$id."'  ";
					echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
			
	}
	/*End*/
		
}
?>