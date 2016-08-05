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
				//------ save คำอิบายบัญชี------
				$DATAPL = array();
				for($a=0;$a <= $_POST["countPL"];$a++){ //MaxLine เริ่มจาก 0
					if ($_POST["PaymentListDetailId".$a]){
						$DATAPL["PaymentListDetailId"] = $_POST["PaymentListDetailId".$a];
						$DATAPL["DetailCostAccount"] = $_POST["DetailCostAccount".$a];
						$this->db->arecSave('tblfinance_payment_list_detail',$DATAPL);
					}
				}
				//----------------------------------
				if ($_POST["AcActionId"] == ""){ // กรณีเพิ่ม
					$pv = $_POST["PV"];
					$yy = substr($pv,2,2);//yy
					$mm = substr($pv,4,2);//mm
          $mm = intval($mm);
					$runno = substr($pv,6,4);//runno
					$sql = "Update ac_action set YYear= 25".$yy.",RunNo = ".$runno.",MMonth=".$mm." where AcActionId = ".$pk;
					$this->db->Execute($sql);
				}

				$sql = "DELETE FROM ac_action_detail where AcActionId = ".$pk;
				$this->db->Execute($sql);
				$DataDatail = array();

				for($aa=0;$aa <= $_POST["countPL"];$aa++){ // รายการค่าใช้จ่ายมีกี่ ตัว
					if ($_POST["PaymentListDetailId".$aa]){
						$PDId = $_POST["PaymentListDetailId".$aa];
						// save ลงบัญชี
						//echo "MaxLine=".$_POST["MaxLine".$PDId];
						for($a=0;$a <= $_POST["MaxLine".$PDId];$a++){ //MaxLine เริ่มจาก 0
							//echo "ac_chart_id=".$_POST["ac_chart_id".$PDId.$a];
							if ($_POST["ac_chart_id".$PDId.$a]){
								$DataDatail["AcActionId"] = $pk;

								$DataDatail["CrId"] ="";
								$DataDatail["CrDetail"] = "";
								$DataDatail["CrValue"] = "";
								$DataDatail["DrId"] ="";
								$DataDatail["DrDetail"] = "";
								$DataDatail["DrValue"] = "";

								if ($_POST["DrValue".$PDId.$a] != "" && $_POST["DrValue".$PDId.$a] != 0){
									$DataDatail["DrId"] = $_POST["ac_chart_id".$PDId.$a];
									$DataDatail["DrDetail"] = $_POST["textDetail".$PDId.$a];
									$DataDatail["DrValue"] = $_POST["DrValue".$PDId.$a];

								}
								if ($_POST["CrValue".$PDId.$a] != "" && $_POST["CrValue".$PDId.$a] != 0){
									$DataDatail["CrId"] = $_POST["ac_chart_id".$PDId.$a];
									$DataDatail["CrDetail"] = $_POST["textDetail".$PDId.$a];
									$DataDatail["CrValue"] = $_POST["CrValue".$PDId.$a];

								}

								$DataDatail["PaymentListDetailId"] = $_POST["PaymentListDetailId".$aa];
								$DataDatail["CostItemCode"] = $_POST["CostItemCode".$aa];

								if ($DataDatail["DrValue"] > 0 || $DataDatail["CrValue"]>0){
									$this->db->arecSave('ac_action_detail',$DataDatail);
								}
							}
						}
						//---------
					}
				}

			//LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
      LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&jid='.$_REQUEST["journalId"].'&jtxt='.$_REQUEST["journalName"].'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	function Savenew(){
		// ตาราง tblfinance_payment

		if($pk = $this->db->arecSave('ac_action',$_POST)){
				if ($_POST["AcActionId"] == ""){ // กรณีเพิ่ม
          $pv = $_POST["PV"];
          $yy = substr($pv,2,2);//yy
          $mm = substr($pv,4,2);//mm
          $mm = intval($mm);
          $runno = substr($pv,6,4);//runno
          $sql = "Update ac_action set YYear= 25".$yy.",RunNo = ".$runno.",MMonth=".$mm." where AcActionId = ".$pk;
          $this->db->Execute($sql);
				}

				$sql = "DELETE FROM ac_action_detail where AcActionId = ".$pk;
				$this->db->Execute($sql);
				$DataDatail = array();
			//	echo "MaxLine".$_POST["MaxLine"];
			//	echo "pk".$pk;
				for($a=0;$a <= $_POST["MaxLine"];$a++){ //MaxLine เริ่มจาก 0
					if ($_POST["ac_chart_id".$a]){
						$DataDatail["AcActionId"] = $pk;
						if ($_POST["DrValue".$a] != "" && $_POST["DrValue".$a] != 0){
							$DataDatail["DrId"] = $_POST["ac_chart_id".$a];
							$DataDatail["DrDetail"] = $_POST["textDetail".$a];
							$DataDatail["DrValue"] = $_POST["DrValue".$a];
							$DataDatail["CrId"] ="";
							$DataDatail["CrDetail"] = "";
							$DataDatail["CrValue"] = "";
						}
						if ($_POST["CrValue".$a] != "" && $_POST["CrValue".$a] != 0){
							$DataDatail["CrId"] = $_POST["ac_chart_id".$a];
							$DataDatail["CrDetail"] = $_POST["textDetail".$a];
							$DataDatail["CrValue"] = $_POST["CrValue".$a];
							$DataDatail["DrId"] ="";
							$DataDatail["DrDetail"] = "";
							$DataDatail["DrValue"] = "";
						}
						if ($DataDatail["DrValue"] >0 || $DataDatail["CrValue"]>0){
							$this->db->arecSave('ac_action_detail',$DataDatail);

						}
					}
				}
			$journalName = $this->findjournalName($_POST["journalId"]);
			LTXT::_( '?mod=account.otherjournal.otherjournal_list&jid='.$_REQUEST["journalId"].'&jtxt='.$journalName.'&start='.$_REQUEST["start"], 'redirect' );

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

    $journalId = $this->getjournalId($_REQUEST["id"]);
		//LogFiles::SaveLog("ระบบบัญชี","ลบข้อมูลผังบัญชี",$_REQUEST["id"],$AcName);
		$sql = "Update ac_action set DeleteStatus='Y' where AcActionId = ".$_REQUEST["id"];
		$this->db->Execute($sql);
    $sql = "Update ac_action_detail set DeleteStatus='Y' where AcActionId = ".$_REQUEST["id"];
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"]."&jid=".$journalId, 'redirect' );
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
