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
	
	function Save(){
		$this->db->debug(2);
		ltxt::print_r($_POST);
		$DataY["BgtYearId"] = $_POST["BgtYearId"];		
		$DataY["BgtYear"] = $_POST["BgtYear"];
		$DataY["CloseStatus"] = "N";
		$DataY["CreateBy"] = $_POST["CreateBy"];
		$DataY["CreateDate"] = $_POST["CreateDate"];
		$DataY["UpdateBy"] = $_POST["UpdateBy"];
		$DataY["UpdateDate"] = $_POST["UpdateDate"];
		$pkY = $this->db->arecSave('tblbudget_init_year',$DataY);
		
		for($i=0;$i<count($_POST["OrgId"]);$i++){
			if($_POST["OrganizeCode"][$i]){
				$Data["OrganizeCode"] = $_POST["OrganizeCode"][$i];
				$Data["OrgId"] = $_POST["OrgId"][$i];
				$Data["BgtYearId"] = $pkY;
				$Data["BgtYear"] = $_POST["BgtYear"];
				$Data["SCTypeId"] = $this->getSCTypeId($_POST["BgtYear"],1);
				$Data["ScreenLevel"] = "1";
				$Data["CloseStep"] = "N";
				$Data["CreateBy"] = $_POST["CreateBy"];
				$Data["CreateDate"] = $_POST["CreateDate"];
				$pk = $this->db->arecSave('tblbudget_init_year_org',$Data);
			}
		}
		
		//== Log File ===
		LogFiles::SaveLog("จัดการหน่วยงานประจำปี","บันทึกข้อมูลหน่วยงานประจำปี",$pk,"บันทึกข้อมูลหน่วยงานประจำปี  ".$_POST["BgtYear"]);
		//============					
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjActId='.$_POST["PrjActId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&OrgCode='.$_POST["OrgCode"].'&BgtYear='.$_POST["BgtYear"], 'redirect' );
		
	}

	function CloseYear(){
		
		$sql = "update tblbudget_init_year set CloseStatus='Y',CloseDate=NOW()  where   BgtYear='".$_POST["BgtYear"]."'   ";
		$this->db->Execute($sql);	

		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );	

	}
	
	function Delete(){		
		
		$sql = "delete from tblbudget_init_year where BgtYear = ".$_REQUEST["BgtYear"]." ";
		$this->db->Execute($sql);
		
		$sql = "delete from tblbudget_init_year_org where BgtYear = ".$_REQUEST["BgtYear"]." ";
		$this->db->Execute($sql);
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );	
	}




}

?>