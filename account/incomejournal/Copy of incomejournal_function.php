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
		
		if($pk = $this->db->arecSave('ac_action',$_POST)){
			//บันทึกรหัส eform 
				
				if ($_POST["AcActionId"] == ""){ // กรณีเพิ่ม 
						//PC58110052 : format PV
						/*$sql = "SELECT tblfinance_doccode.BgtYear FROM tblfinance_doccode INNER JOIN tblfinance_payment_list ON tblfinance_doccode.DocCode = tblfinance_payment_list.DocCode WHERE tblfinance_payment_list.PaymentId = ".$_POST["PaymentId"];// หา ปีงปม 
						$this->db->setQuery($sql);
						$detail = $this->db->loadDataSet();
						if($detail["rows"]){
							 foreach($detail["rows"] as $r1 ) {
								 $YYear = $r1->BgtYear;
							 }
						}*/
						$year = date("Y")+543;
						$mon = date("m");
						if($mon<10){
							$YYear = $year;
						}else{
							$YYear = $year+1;
						}
						$MM = substr($_POST["ActionDate"],5,2); // เดือนลงบัญชี 2016-06-10
					
						$MM = str_replace("0","",$MM);
					
						$sql = "select max(RunNo) as RunNo from ac_action where YYear = ".$YYear." and MMonth =".$MM ;// หา runno ของแต่ละปี เดือน
						$this->db->setQuery($sql);
						$detail = $this->db->loadDataSet();
						if($detail["rows"]){
							 foreach($detail["rows"] as $r2 ) {
								 $RunNo = $r2->RunNo;
								 if (is_null($RunNo)){
									$RunNo = 0;
								}
							 }
						}
						$RunNo++;
						
						$txtlen = $RunNo;
						$zero = "";
						$len = 4;
						$coid = strlen($txtlen);
						 for($ic = $coid; $ic < $len; $ic++){
							 $zero = $zero."0";
						 }
						 $RunNoText = $zero.$txtlen;
						 
						$txtlen = $MM;
						$zero = "";
						$len = 2;
						$coid = strlen($txtlen);
						 for($ic = $coid; $ic < $len; $ic++){
							 $zero = $zero."0";
						 }
						 $MMText = $zero.$txtlen;
						 
						$pv = "PV".$YYear.$MMText.$RunNoText;
					
						$sql = "Update ac_action set YYear= ".$YYear.",RunNo = ".$RunNo.",PV='".$pv."',MMonth='".$MMText."' where AcActionId = ".$pk;
						$this->db->Execute($sql);
				}
			
				
				$sql = "DELETE FROM ac_action_detail where AcActionId = ".$pk;
				$this->db->Execute($sql);
				$DataDatail = array();
				
				for($a=0;$a <= $_POST["MaxLine"];$a++){ //MaxLine เริ่มจาก 0
					
					if ($_POST["ac_chart_id".$a]){
						
						$DataDatail["AcActionId"] = $pk;
						if ($_POST["DrValue".$a] != "" ){
							$DataDatail["DrId"] = $_POST["ac_chart_id".$a];
							//$DataDatail["DrValue"] = $_POST["DrValue".$a];
							$DataDatail["DrDetail"] = $_POST["textDetail".$a];
							//$DataDatail["CrId"] = "";
							//$DataDatail["CrValue"] = 0;
							//$DataDatail["CrDetail"] = "";
						}else{
							$DataDatail["CrId"] = $_POST["ac_chart_id".$a];
							//$DataDatail["CrValue"] = $_POST["CrValue".$a];
							$DataDatail["CrDetail"] = $_POST["textDetail".$a];
							//$DataDatail["DrId"] = "";
							//$DataDatail["DrValue"] = 0;
							//$DataDatail["DrDetail"] = "";
						}
					
						$DataDatail["DrValue"] = $_POST["DrValue".$a];
						$DataDatail["CrValue"] = $_POST["CrValue".$a];
						$this->db->arecSave('ac_action_detail',$DataDatail);
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