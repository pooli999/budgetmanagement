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
		$Topic = $this->getBookbankNumber($_REQUEST["BookbankId"]);

		LogFiles::SaveLog("ระบบการเงิน","เปลี่ยนสถานะเลขที่บัญชีธนาคารเป็น ".$Str,$_REQUEST["BookbankId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_finance_bookbank',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');	
		}
		echo $pk;
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข เลขที่บัญชีธนาคาร
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
//		echo $_POST["DepositValue"];
		if($pk = $this->db->arecSave('tblbudget_finance_deposit',$_POST)){	
			$BookbankNumber = $this->getBookbankNumberData($_POST["BookbankId"]);
			if($_POST["DepositId"]=='')		//บันทึก log ตาราง tblbudget_finance_deposit
				LogFiles::SaveLog("ระบบการเงิน","เพิ่มข้อมูลฝากเงินสดและเช็ค",$pk,"เลขที่บัญชี ".$BookbankNumber." วันที่ฝาก".$_POST["DepositDate"]);
			else
				LogFiles::SaveLog("ระบบการเงิน","แก้ไขข้อมูลฝากเงินสดและเช็ค",$pk,"เลขที่บัญชี ".$BookbankNumber." วันที่ฝาก".$_POST["DepositDate"]);
		
			//บันทึกรายการฝาก 
			$sql = "DELETE FROM tblbudget_finance_deposit_list where DepositId = ".$pk;
			$this->db->Execute($sql);
			$DataIncome = array();
			for($a=1;$a<= $_POST["IncomeSize"];$a++){ 
				
				if($_POST["IncomeId".$a] != ""){
					$DataIncome["DepositId"] 			= $pk;
					$DataIncome["IncomeId"] 		= $_POST["IncomeId".$a];
					$DataIncome["CreateBy"]			=	$_POST["CreateBy"];
					$DataIncome["CreateDate"]		=	$_POST["CreateDate"];
					$DataIncome["UpdateBy"]			=	$_POST["UpdateBy"];
					$DataIncome["UpdateDate"]		=	$_POST["UpdateDate"];		
					
					$DepositListId = $this->db->arecSave('tblbudget_finance_deposit_list',$DataIncome);
					
					LogFiles::SaveLog("ระบบการเงิน","เพิ่มข้อมูลฝากเงินสดและเช็ค->รายการฝาก",$DepositListId,"รหัสฝากเงินสดและเช็ค ".$pk." วันที่ฝาก".$_POST["DepositDate"])." รหัสรายการฝาก".$_POST["IncomeId".$a];
				}
			}
		

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบรายการฝากเงินสดและเช็ค
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = $this->getBookbankNumber($_REQUEST["id"]);
		$BookbankNumber = $this->getBookbankNumberData($_REQUEST["BookbankId"]);
		LogFiles::SaveLog("ระบบการเงิน","ลบรายการฝากเงินสดและเช็ค",$_REQUEST["id"],"เลขที่บัญชี ".$BookbankNumber." วันที่ฝาก".$_POST["DepositDate"]);
		
		$sql = "Update tblbudget_finance_deposit set DeleteStatus='Y' where DepositId = ".$_REQUEST["id"]."";
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
					$sql = "Update tblbudget_finance_bookbank set Ordering='$i' where BookbankId = '".$id."'  ";
				//	echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
	}
	/*End*/
		
}
?>