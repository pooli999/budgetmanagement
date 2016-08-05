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
	Description		: เปลี่ยนสถานะตัวชี้วัดเป็น แสดง หรือไม่แสดง
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
		
		$Topic = $this->getIndName($_REQUEST["IndId"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","เปลี่ยนสถานะข้อมูลพื้นฐานในส่วนของตัวชี้วัดเป็น ".$Str,$_REQUEST["IndId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_indicator',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข ตัวชี้วัด
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		$this->db->debug(2);
		ltxt::print_r($_POST);
		if($_POST["IndId"]==''){
			$_POST["Running"] = $this->getLastRunningNo();
			$_POST["IndCode"] = sprintf("%03s",$_POST["Running"]);
		}
		if($pk = $this->db->arecSave('tblbudget_indicator',$_POST)){						
			if($_POST["IndId"]==''){
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มข้อมูลพื้นฐานในส่วนของตัวชี้วัด",$pk,$_REQUEST["IndName"]);
			}else{
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขข้อมูลข้อมูลพื้นฐานในส่วนของตัวชี้วัด",$pk,$_REQUEST["IndName"]);
			}
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบตัวชี้วัด
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = $this->getIndName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลพื้นฐานในส่วนของตัวชี้วัด",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_indicator set DeleteStatus='Y' where IndId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
	}
	/*End*/
	
	/* 
	START #F4
	Function Name: SaveOrder 
	Description		: เรียงลำดับตัวชี้วัด
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
					$sql = "Update tblbudget_indicator set Ordering='$i' where IndId = '".$id."'  ";
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