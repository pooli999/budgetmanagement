<?php
include("config.php");
include("helper.php");
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

	function changeStatus()
	{
		if($_REQUEST['EnableStatus'] == 1){
			$_REQUEST['EnableStatus']='Y'; $Str = 'แสดง';
		}else{
			$_REQUEST['EnableStatus']='N'; $Str = 'ไม่แสดง';
		}

		$Status = "เปลี่ยนสถานะเป็น".$Str;
		LogFiles::SaveLog("แบบฟอร์มอิเล็กทรอนิกส์","เปลี่ยนแบบฟอร์มเอกสารขออนุมัติเบิกเงินยืมทดรองจ่าย",$_REQUEST["EFormId"],$Status);

		if($pk = $this->db->arecSave('tblintra_eform_advance',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	//  End Not Remove  //


	function Check(){
		$this->db->debug(2);
		ltxt::print_r($_POST);

		$sql = "Update tblfinance_doccode set DocStatusId='".$_POST["DocStatusId"]."' where DocCode = '".$_POST["DocCode"]."'";
		$this->db->Execute($sql);

		$sql = "Update tblfinance_form_chain set DocStatusId='".$_POST["DocStatusId"]."' where DocCode = '".$_POST["DocCode"]."'";
		$this->db->Execute($sql);


		$dataFile["OperateId"] 	= $this->db->arecSave('tblfinance_doccode_operate',$_POST);
		$ArrDoc = explode(",",$_POST["MultiDocId"]);
		foreach($ArrDoc as $val){
			if($val != 0){
				$dataFile["DocId"] 		= $val;
				$this->db->arecSave('tblfinance_doccode_operate_file',$dataFile);
			}
		}
		//save log file
		LogFiles::SaveLog("ระบบงบประมาณการเงิน","ตรวจสอบเอกสาร",$_POST["EFormId"],"บันทึกผลการตรวจสอบเอกสาร สช.น เลขที่ ".$_POST["DocCode"]);
		LTXT::_( '?mod=finance.form.list_check', 'redirect' );
	}

	function Approve(){
		$this->db->debug(2);
		ltxt::print_r($_POST);
		if(!$_POST["OtherDate"]){
			$_POST["BGPayDate"] =  $_POST["ApproveDate"];
		}
		if($_POST["DocStatusId"]==5){
			$_POST["BGPayDate"] =  "";
		}else{
			$sql = "Update tblfinance_bg_chain set ApproveStatus='Y' where DocCode = '".$_POST["DocCode"]."'";
			$this->db->Execute($sql);
		}
		//ผูกพันงบประมาณ-------------------------------------------------------------------------
		if($_POST["DocStatusId"] == 7){
			//insert table MOU
			$itemHold = $this->getItemChain($_POST["DocCode"]);ltxt::print_r($itemHold);
			foreach($itemHold as $itemHoldRow){
				foreach($itemHoldRow as $k=>$v){
					$hold[$k] = $v;
				}
				$hold["ContractNo"] 			= $this->genMOUContractCode();
				$hold["AutoNo"] 				= $this->getMOUMaxNo();
				$hold["MouName"] 			= $hold["Title"];
				$hold["MouBudget"] 		= $hold["TotalCost"];
				$hold["NHOrg"] 				= $hold["NHOrg"];
				$hold["NHPerson"] 			= $hold["NHPerson"];
				$hold["NHPosition"] 			= $hold["NHPosition"];
				$hold["CloseStatus"] 		= "N";
				$hold["ActiveStatus"] 		= "Y";
				$hold["VersionNo"] 			= 1;
				$hold["CreateBy"] 			= $_POST["CreateBy"];
				$hold["CreateDate"] 			= $_POST["CreateDate"];ltxt::print_r($hold);
				$MouId = $this->db->arecSave('tblmou_project',$hold);
				//update MouCode
				$sql = "Update tblmou_project set MouCode='".$MouId."' where MouId = '".$MouId."'";
				$this->db->Execute($sql);
			}
		//END insert table MOU
		}
		//END ผูกพันงบประมาณ-------------------------------------------------------------------
		$sql = "Update tblfinance_doccode set DocStatusId='".$_POST["DocStatusId"]."' , ApproveBy='".$_POST["ApproveBy"]."' , ApproveDate='".$_POST["ApproveDate"]."' , BGPayDate='".$_POST["BGPayDate"]."' where DocCode = '".$_POST["DocCode"]."'";
		$this->db->Execute($sql);

		$sql = "Update tblfinance_form_chain set DocStatusId='".$_POST["DocStatusId"]."' where DocCode = '".$_POST["DocCode"]."'";
		$this->db->Execute($sql);

		//ประวัติการดำเนินการของเอกสาร
		$dataFile["OperateId"] 	= $this->db->arecSave('tblfinance_doccode_operate',$_POST);
		$ArrDoc = explode(",",$_POST["MultiDocId"]);
		foreach($ArrDoc as $val){
			if($val != 0){
				$dataFile["DocId"] 		= $val;
				$this->db->arecSave('tblfinance_doccode_operate_file',$dataFile);
			}
		}
		//save log file
		LogFiles::SaveLog("ระบบงบประมาณการเงิน","ตรวจสอบเอกสาร",$_POST["EFormId"],"บันทึกผลการอนุมัติเอกสาร สช.น เลขที่ ".$_POST["DocCode"]);
		LTXT::_( '?mod=finance.form.list_approve', 'redirect' );

	}




}// end class
?>
