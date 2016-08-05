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
	
	//  End Not Remove  //
	
	function Approve(){ 
		$this->db->debug(2);
		$_REQUEST["StatusId"] = $_REQUEST["DocStatusId"];
		if($pk = $this->db->arecSave('tblfinance_form_operate',$_REQUEST)){
			$ArrDoc = explode(",",$_REQUEST["MultiDocId"]);
			foreach($ArrDoc as $val){
				if($val != 0){
					$Data["CheckId"] 		= $pk;
					$Data["DocId"] 			= $val;
					$Data["CreateBy"] 		= $_REQUEST["CreateBy"];
					$Data["CreateDate"] 	= $_REQUEST["CreateDate"];		
					$this->db->arecSave('tblfinance_form_operate_file',$Data);
				}
			}//วนลูป insert ไฟล์แนบของสถานะการดำเนินการเอกสาร
			if($_REQUEST["DocStatusId"]=="6"){//กรณีผลการตัดจ่ายเงินเป็นตึกลับเอกสาร
				$sql = "delete from tblbudget_bg_pay where DocCode='".$_REQUEST["DocCode"]."' ";//ลบรายการข้อมูลออกจากตารางตัดจ่ายเงิน
				$this->db->Execute($sql);
			}else{//กรณีผลการโอนเป็นยืนยันการตัดจ่ายเงิน
				$sql = "update tblbudget_bg_pay set CommitStatus='Y' where DocCode='".$_REQUEST["DocCode"]."' ";
				$this->db->Execute($sql);//update CommitStatus รายการตัดจ่ายเงินของตารางตัดจ่ายเงิน
			}
			
			$sql = "update tblintra_eform_formal_meeting_pay set DocStatusId=".$_REQUEST["DocStatusId"]." where DocCodePay='".$_REQUEST["DocCode"]."' ";
			$this->db->Execute($sql);		
			
			// update สถานะ เลขที่ สช.น.
			$sqlStatus = "update tblfinance_form_doccode set DocStatusId=".$_REQUEST["DocStatusId"]." where DocCode='".$_REQUEST["DocCode"]."' ";
			$this->db->Execute($sqlStatus);					
			
			LogFiles::SaveLog("ระบบงานการเงิน","บันทึกตัดจ่ายงบประมาณ",$pk,$_REQUEST["DocCode"]." ".$_REQUEST["Topic"]);
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&FormCode='.$_REQUEST["FormCode"].'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
		
	}
	
	function Cancel(){
		//$this->db->debug(2);
		$_REQUEST["StatusId"] = $_REQUEST["DocStatusId"];
		
		if($pk = $this->db->arecSave('tblfinance_form_operate',$_REQUEST)){//insert ตารางสถานะการดำเนินการของเอกสาร
		
			$ArrDoc = explode(",",$_REQUEST["MultiDocId"]);
			foreach($ArrDoc as $val){
				if($val != 0){
					$Data["CheckId"] 		= $pk;
					$Data["DocId"] 			= $val;
					$Data["CreateBy"] 		= $_REQUEST["CreateBy"];
					$Data["CreateDate"] 	= $_REQUEST["CreateDate"];		
					$this->db->arecSave('tblfinance_form_operate_file',$Data);
				}
			}//วนลูป insert ไฟล์แนบของสถานะการดำเนินการเอกสาร
			
			$sql = "update tblbudget_bg_pay set CancelStatus='Y' , CommitStatus='N' where DocCode='".$_REQUEST["DocCodePay"]."' ";
			$this->db->Execute($sql);//update CancelStatus ของตารางตัดจ่ายเงิน
			
			$sql2 = "update tblintra_eform_formal_meeting_pay set DocStatusId='8' where DocCodePay='".$_REQUEST["DocCodePay"]."' ";
			$this->db->Execute($sql2);	//update สถานะเอกสาร
			
			// update สถานะ เลขที่ สช.น. เป็น 8 (ยกเลิกเอกสาร) 
			$sql3 = "update tblfinance_form_doccode set DocStatusId=8 where DocCode='".$_REQUEST["DocCodePay"]."' ";
			$this->db->Execute($sql3);	
			
			// update งบเบิกจ่าย งบคงเหลือในตาราง ผูกพัน
			$CostPayList = $this->getCostPayList($_REQUEST["DocCodePay"]);
			foreach($CostPayList as $r){
				
				$SumRemain = $this->getChainRemain("SumRemain",$r->CostCode,$_POST["DocCode"]);	//ดึงยอดงบผูกพันคงเหลือ
				$SumPay = $this->getChainRemain("SumPay",$r->CostCode,$_POST["DocCode"]);	//ดึงยอดงบเบิกจ่าย
						
				$ChainRemain = $SumRemain + $r->SumCost ;
				$PayRemain = abs($SumPay - $r->SumCost) ;
				
				$sql4 = "update tblbudget_bg_chain set SumRemain='".$ChainRemain."', SumPay='".$PayRemain."'  where DocCode='".$_REQUEST["DocCode"]."'  and CostCode='".$r->CostCode."' ";
				$this->db->Execute($sql4);	//update สถานะเอกสาร
				
			}// end function

			LogFiles::SaveLog("ระบบงบประมาณ","ยกเลิกรายการตัดจ่ายงบประมาณ",$_REQUEST["DocCodePay"],$_REQUEST["Topic"]);
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&FormCode='.$_REQUEST["FormCode"].'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}
	
	}// end function cancle
		
	
	
		
}// end class
?>