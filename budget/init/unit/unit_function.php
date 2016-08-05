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
	Description		: เปลี่ยนสถานะหน่วยนับเป็น แสดง หรือไม่แสดง
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
		
		$Topic = $this->getUnitName($_REQUEST["UnitID"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","เปลี่ยนสถานะข้อมูลพื้นฐานในส่วนของหน่วยนับเป็น ".$Str,$_REQUEST["UnitID"],$Topic);
		
		if($pk = $this->db->arecSave('tblunit',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข หน่วยนับ
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		
		if($pk = $this->db->arecSave('tblunit',$_POST)){						
			
			if($_POST["UnitID"]=='')
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มข้อมูลพื้นฐานในส่วนของหน่วยนับ",$pk,$_REQUEST["UnitName"]);
			else
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขข้อมูลข้อมูลพื้นฐานในส่วนของหน่วยนับ",$pk,$_REQUEST["UnitName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบหน่วยนับ
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = $this->getUnitName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลพื้นฐานในส่วนของหน่วยนับ",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblunit set DeleteStatus='Y' where UnitID = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
	}
	/*End*/
		
}
?>