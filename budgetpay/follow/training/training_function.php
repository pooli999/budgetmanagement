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
			}	
			$sql = "update tblintra_eform_formal_borrow set DocStatusId=".$_REQUEST["DocStatusId"]." where DocCode='".$_REQUEST["DocCode"]."' ";
			$this->db->Execute($sql);	
/*			if($DocStatusId==7){ 
				$this->db->arecSave('tblbudget_bg_hold',$_REQUEST);//จัดเก็บข้อมูลลงตารางกันเงินงบประมาณ
			}	
*/			LogFiles::SaveLog("ระบบงานการเงิน","บันทึกผลการอนุมัติเอกสารการเงิน",$pk,$_REQUEST["DocCode"]." ".$_REQUEST["Topic"]);
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
		
	}

	
	
}// end 
?>