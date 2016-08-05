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
	Description		: เปลี่ยนสถานะประเภทกิจกรรมเป็น แสดง หรือไม่แสดง
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
		$Topic = $this->getBookbankNumber($_REQUEST["BookbankId"]);

		LogFiles::SaveLog("ระบบการเงิน","เปลี่ยนสถานะเลขที่บัญชีธนาคารเป็น ".$Str,$_REQUEST["BookbankId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_finance_bookbank',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');	
		}
		echo $pk;
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข เลขที่บัญชีธนาคาร
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		if($pk = $this->db->arecSave('tblbudget_finance_pettycash',$_POST)){	
			if($_POST["PettyCashId"]=='')
				LogFiles::SaveLog("ระบบนการเงิน","เพิ่มข้อมูลเพดานเงินสดย่อย",$pk,$_REQUEST["PettyCashId"]);
			else
				LogFiles::SaveLog("ระบบนการเงิน","แก้ไขข้อมูลเพดานเงินสดย่อย",$pk,$_REQUEST["PettyCashId"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบประเภทกิจกรรม
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = $this->getBookbankNumber($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบการเงิน","ลบข้อมูลเพดานเงินสดย่อย",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_finance_bookbank set DeleteStatus='Y' where BookbankId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
	}
	/*End*/
	
	/* 
	START #F4
	Function Name: SaveOrder 
	Description		: เรียงลำดับประเภทกิจกรรม
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
					$sql = "Update tblbudget_finance_pettycash set Ordering='$i' where PettyCashId = '".$id."'  ";
				//	echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
	}
	/*End*/
		
}
?>