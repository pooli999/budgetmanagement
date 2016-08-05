<?php       
include("config.php");
include($KeyPage."_helper.php");
class sFunction extends sHelper{
	var $RedirectPage;
	var $PathUpload;
	//  Not Remove  //
	function RedirectPage($RPage){
		$this->RedirectPage = $RPage;
	}
	
	function setUploadPath($Path){
		$this->PathUpload = $Path;
	}
	
	function Reload($redirect_page){		
		LTXT::_( $redirect_page, 'redirect' );
	}
	
	//  End Not Remove  //
	
	function Approve(){
		$this->db->debug(2);
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
			if($_REQUEST["DocStatusId"]=="11"){//กรณีผลการโอนเงินเป็นตึกลับเอกสาร
				$sql = "delete from tblbudget_bg_transfer where DocCode='".$_REQUEST["DocCode"]."' ";//ลบรายการข้อมูลออกจากตารางโอนเงิน
				$this->db->Execute($sql);
			}else{//กรณีผลการโอนเป็นยืนยันการโอนเงิน
				$sql = "update tblbudget_bg_transfer set CommitStatus='Y' where DocCode='".$_REQUEST["DocCode"]."' ";
				$this->db->Execute($sql);//update CommitStatus รายการโอนเงินของตารางโอนเงิน
			}
			$sql = "update tblintra_eform_transfer set DocStatusId=".$_REQUEST["DocStatusId"]." where DocCode='".$_REQUEST["DocCode"]."' ";
			$this->db->Execute($sql);//update สถานะเอกสาร
			LogFiles::SaveLog("ระบบงบประมาณ","บันทึกโอนงบประมาณประจำปี",$pk,$_REQUEST["DocCode"]." ".$_REQUEST["Topic"]);
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
		
	}
	
	function Cancel(){
		$this->db->debug(2);
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
			$sql = "update tblbudget_bg_transfer set CancelStatus='Y' where DocCode='".$_REQUEST["DocCode"]."' ";
			$this->db->Execute($sql);//update CancelStatus ของตารางโอนเงิน
			$sql2 = "update tblintra_eform_transfer set DocStatusId='8' where DocCode='".$_REQUEST["DocCode"]."' ";
			$this->db->Execute($sql2);	//update สถานะเอกสาร
			$sql3 = "update tblbudget_bg_book set CloseStatus='N' where DocCode='".$_REQUEST["DocCode"]."' ";
			$this->db->Execute($sql3);	//update สถานะการจองเงินงบประมาณ
			LogFiles::SaveLog("ระบบงบประมาณ","ยกเลิกรายการโอนเงินงบประมาณ",$_REQUEST["DocCode"],$_REQUEST["Topic"]);
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
		
	}
	
}// end 
?>