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
	
	function changeStatus()
	{
		if($_REQUEST['EnableStatus'] == 1){
			$_REQUEST['EnableStatus']='Y'; $Str = 'แสดง';
		}else{
			$_REQUEST['EnableStatus']='N'; $Str = 'ไม่แสดง';
		}
		
		$Status = "เปลี่ยนสถานะเป็น".$Str;
		LogFiles::SaveLog("ระบบจองห้องประชุม","เปลี่ยนสถานะข้อมูลประธาน/ผู้ทรงคุณวุฒิ",$_REQUEST["OrganizeId"],$Status);
		
		if($pk = $this->db->arecSave('tblintra_organize',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	//  End Not Remove  //
	
	function Save(){

		if($pk = $this->db->arecSave('tblintra_organize',$_POST)){						
			
			if($_REQUEST["OrganizeId"]=='')
				LogFiles::SaveLog("ระบบจองห้องประชุม","เพิ่มข้อมูลประธาน/ผู้ทรงคุณวุฒิ",$pk,$_REQUEST["LedName"]);
			else
				LogFiles::SaveLog("ระบบจองห้องประชุม","แก้ไขข้อมูลประธาน/ผู้ทรงคุณวุฒิ",$pk,$_REQUEST["LedName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}

	function Delete(){
		
		$LedName = $this->getGroupName($_REQUEST["OrganizeId"]);
		LogFiles::SaveLog("ระบบจองห้องประชุม","ลบข้อมูลประธาน/ผู้ทรงคุณวุฒิ",$_REQUEST["OrganizeId"],$LedName);
		
		$sql = "Update tblintra_organize set DeleteStatus='Y' where OrganizeId = ".$_REQUEST["OrganizeId"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
	}
	
}
?>