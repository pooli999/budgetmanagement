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
	
/*	function changeStatus()
	{
		if($_REQUEST['EnableStatus'] == 1){
			$_REQUEST['EnableStatus']='Y'; $Str = 'แสดง';
		}else{
			$_REQUEST['EnableStatus']='N'; $Str = 'ไม่แสดง';
		}
		
		$Status = "เปลี่ยนสถานะเป็น".$Str;
		LogFiles::SaveLog("แบบฟอร์มอิเล็กทรอนิกส์","เปลี่ยนแบบฟอร์มเอกสารขออนุมัติหลักการทั่วไป",$_REQUEST["DocId"],$Status);
		
		if($pk = $this->db->arecSave('tblintra_eform_formal_general',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	//  End Not Remove  //
	
	function Save(){ 
		if($_REQUEST["DocId"]==''){$_POST["DocStatusId"]=1;}
		$textDetail = str_replace( "<p>", "", $_POST["Detail"]);
		$textDetail = str_replace( "</p>", "", $textDetail);
		$_POST["Detail"] = $textDetail ;

		if($pk = $this->db->arecSave('tblintra_eform_formal_general',$_POST)){
			
			if($_REQUEST["DocId"]=='')
				LogFiles::SaveLog("แบบฟอร์มอิเล็กทรอนิกส์","เพิ่มแบบฟอร์มเอกสารขออนุมัติหลักการทั่วไป",$pk,$_REQUEST["Topic"]);
			else
				LogFiles::SaveLog("แบบฟอร์มอิเล็กทรอนิกส์","แก้ไขแบบฟอร์มเอกสารขออนุมัติหลักการทั่วไป",$pk,$_REQUEST["Topic"]);
						
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}
		

	}

	function Delete(){
		
		$Topic = $this->getTopic($_REQUEST["id"]);
		LogFiles::SaveLog("แบบฟอร์มอิเล็กทรอนิกส์","ลบแบบฟอร์มเอกสารขออนุมัติหลักการทั่วไป",$_REQUEST["id"],$Topic);
		
		$sql = "update tblintra_eform_formal_general set DeleteStatus='Y' where DocId='".$_REQUEST["id"]."' ";
		$this->db->Execute($sql);		
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
	}*/
	
}
?>