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
	Description		: เพิ่ม/แก้ไข สมุดรายวัน
	Parameter		: -
	Return Value 	: -
	*/	
	function zeroofid($id,$len){
		$zero = "";
		$coid = strlen($id);
		//echo "id=".$coid;
		 for($i = $coid; $i < $len; $i++){
			 $zero = $zero."0";
		 }
		 $return = $zero.$id;
		return  $return;
	}
	function Save(){
	
			$udata = $_POST["data2"];
			
			$data2_c = $_POST["data2_c"]; // กรณีติ๊กออก
			$data_arr = explode("||", $data2_c);
			foreach($data_arr as $a_id) {
				$AcActionId = trim($a_id);
				$sql = "Update ac_action set PostStatus= '0' where AcActionId = ".$AcActionId; //
				$this->db->Execute($sql);
			}

	
			$data_arr = explode("||", $udata);
			foreach($data_arr as $a_id) {
				$AcActionId = trim($a_id);
				$sql = "Update ac_action set PostStatus= '1' where AcActionId = ".$AcActionId; //
				$this->db->Execute($sql);
			}

		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );

	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบประเภทผังบัญชี
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$AcName = $this->getAcName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบบัญชี","ลบข้อมูลผังบัญชี",$_REQUEST["id"],$AcName);
		
		$sql = "Update ac_chart set DeleteStatus='Y' where AcChartId = ".$_REQUEST["id"];
		echo $sql;
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