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
					$pv = $_POST["PV"];
					$yy = substr($pv,2,2);//yy
					$mm = substr($pv,4,2);//mm
					$mm = intval($mm);
					$runno = substr($pv,6,4);//runno
					$sql = "Update ac_action set YYear= 25".$yy.",RunNo = ".$runno.",MMonth=".$mm." where AcActionId = ".$pk;
					$this->db->Execute($sql);
				}
				//------ save คำอิบายบัญชี------
				$DATAPL = array();
				if ($_POST["IncomeId"]){
					$DATAPL["IncomeId"] = $_POST["IncomeId"];
					$DATAPL["IncomeDetailAccount"] = $_POST["IncomeDetailAccount"];
					$this->db->arecSave('tblbudget_finance_income',$DATAPL);
				}
				//----------------------------------

				$sql = "DELETE FROM ac_action_detail where AcActionId = ".$pk;
				$this->db->Execute($sql);
				$DataDatail = array();

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


			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );

		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/
	function Savenew(){
		//บันทึกรรายรับ
		$DataIncomes = array();

		if ($_POST["ptyep"] == "1"){// ภานนอก
			$PartnerCode = $_POST["PartnerCode"];
		}else{
			$PartnerCode = $_POST["PersonalSelect"];
		}
		if ($PartnerCode == ""){
			$PartnerCode = $_POST["PartnerCodeedit"];
		}
		echo "ptyep".$_POST["ptyep"];
		$DataIncomes["IncomeId"] = $_POST["IncomeId"];
		$DataIncomes["IncomeType"] = $_POST["IncomeType"];

		$DataIncomes["PartnerCode"] = $PartnerCode;

		$pname = $this->findname($_POST["ptyep"],$PartnerCode);

		$DataIncomes["PartnerName"] = $pname;
		$DataIncomes["PayName"] = $pname;

		$DataIncomes["ReferCode"] = $_POST["ReferCode"];
		$DataIncomes["IncomeDetailAccount"] = $_POST["IncomeDetailAccount"];
		$DataIncomes["IncomeValue"] = $_POST["IncomeValue"];
		$DataIncomes["ReceiveType"] = $_POST["ReceiveType"];
		$DataIncomes["CheckNumber"] = $_POST["CheckNumber"];
		$DataIncomes["CheckDate"] = $_POST["CheckDate"];

		$DataIncomes["PType"] = $_POST["ptyep"];

		$DataIncomes["AcSource"] = "1";


		$DataIncomes["CreateBy"] = $_POST["CreateBy"];
		$DataIncomes["CreateDate"] = $_POST["CreateDate"];

		$pk = $this->db->arecSave('tblbudget_finance_income',$DataIncomes);

		$_POST["IncomeId"] = $pk;

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
						// if ($_POST["DrValue".$a] != "" ){
						// 	$DataDatail["DrId"] = $_POST["ac_chart_id".$a];
						// 	$DataDatail["DrDetail"] = $_POST["textDetail".$a];
						// }else{
						// 	$DataDatail["CrId"] = $_POST["ac_chart_id".$a];
						// 	$DataDatail["CrDetail"] = $_POST["textDetail".$a];
						// }
						// $DataDatail["DrValue"] = $_POST["DrValue".$a];
						// $DataDatail["CrValue"] = $_POST["CrValue".$a];
						// $this->db->arecSave('ac_action_detail',$DataDatail);
					}

				}

			$journalName = $this->findjournalName($_POST["journalId"]);
			LTXT::_( '?mod=account.incomejournal.incomejournal_list&jid='.$_REQUEST["journalId"].'&jtxt='.$journalName.'&start='.$_REQUEST["start"], 'redirect' );
			//LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );

		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
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
