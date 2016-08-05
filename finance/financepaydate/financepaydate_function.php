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
		$smode = $_POST["smode"];// pay or send or changepaydate
		if ($smode == ""){// แก้วันที่จ่ายเงิน
			$c_pid = $_POST["c_pid1"];
			$str1 = $_POST["ChequePayDate1"];
			$str1 =	explode("/",$str1);
			$aline1 = $str1[2]-543;
			$ans = $aline1 ."-".$str1[1]."-".$str1[0];
			$sql = "Update tblfinance_payment_comp set ChequePayDate= '".$ans."' where PaymentId = ".$c_pid; //
			echo $sql; 
			$this->db->Execute($sql);
		}else{
			if ($smode == "pay"){
				$udata = $_POST["data1"];	
			}else{
				$udata = $_POST["data2"];
				$data2_c = $_POST["data2_c"]; // กรณีติ๊กออก
				$data_arr = explode("||", $data2_c);
				foreach($data_arr as $p_id) {
					$PaymentId = trim($p_id);
					$sql = "Update tblfinance_payment set SendStatus= 'N' where PaymentId = ".$PaymentId; //
					$this->db->Execute($sql);
				}
			}
	
			$data_arr = explode("||", $udata);
			foreach($data_arr as $p_id) {
				$PaymentId = trim($p_id);
				$t1 = str_replace("/","-",date("Y/m/d"));
				if ($smode == "pay"){
					$sql = "Update tblfinance_payment_comp set ChequePayDate= '".$t1."' where PaymentId = ".$PaymentId; //
				}else{
					$sql = "Update tblfinance_payment set SendStatus= 'Y' where PaymentId = ".$PaymentId; //
				}	
				$this->db->Execute($sql);
			}
		}
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
				
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