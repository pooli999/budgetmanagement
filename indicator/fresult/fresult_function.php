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
	
	function Save(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		if($pk = $this->db->arecSave('tblbudget_project_activity_result',$_POST)){
			
			$_POST['ResultId']=$pk;
			
			$ArrDoc = explode(",",$_POST["MultiDocId"]);
			$sql = "DELETE FROM tblbudget_project_activity_fresult_file where ResultId = ".$_POST["ResultId"]."  ";
			$this->db->Execute($sql);
			// Add Files
			foreach($ArrDoc as $val){
				if($val != 0){
					$Data["ResultId"] = $_POST['ResultId'];
					$Data["DocId"] = $val;
					$Data["CreateBy"] = $_POST["CreateBy"];
					$Data["CreateDate"] = date("Y-m-d H:i:s");
					$Data["UpdateBy"] = $_POST["UpdateBy"];				
					$this->db->arecSave('tblbudget_project_activity_fresult_file',$Data);
				}
			}
						
		//== Log File ===
			//$PrjName = $this->getPrjName($_POST["PrjId"]);
			//if($ScreenLevel > 0){ $ScreenName = $this->getScreenName($nextScreenLevel);  $txtScreenName =  " --> ".$ScreenName;}  	
			//LogFiles::SaveLog("บันทึกผลการดำเนินโครงการ","บันทึกผลการดำเนินโครงการ",$_POST['ResultId'],"บันทึกผลการดำเนินโครงการ".$PrjName." ปี ".$_POST["BgtYear"]."  รหัสหน่วยงาน  ".$_POST["OrgCode"]);
			//============					
						
						
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}		
		


	}


	function Delete(){		
		$sql = "delete from tblbudget_project_activity_fresult_file where ResultId = ".$_REQUEST["ResultId"]." ";
		$this->db->Execute($sql);
		
		$sql = "delete from tblbudget_project_activity_result where ResultId = ".$_REQUEST["ResultId"]." ";
		$this->db->Execute($sql);
		
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjActId='.$_POST["PrjActId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&OrgCode='.$_POST["OrgCode"].'&BgtYear='.$_POST["BgtYear"], 'redirect' );
	}




}

?>