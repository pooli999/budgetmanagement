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

		$sql = "DELETE FROM tblbudget_init_plan_item_relation where PItemId = ".$_POST["PItemId"]."  and  PGroupId = ".$_POST["PGroupId"]."  ";
		$this->db->Execute($sql);
		
		$Data = array();
		for($i=0;$i<count($_POST["PItemRelate"]);$i++){
				if($_POST["PItemRelate"][$i] != ""){

					$Data["PItemRelate"]	=	$_POST["PItemRelate"][$i];
					$Data["GroupRelate"]	=	$_POST["NextPGroupId"];
					$Data["PGroupId"]		=	$_POST["PGroupId"];
					$Data["PItemId"]				=	$_POST["PItemId"];
					$Data["CreateBy"]			=	$_POST["CreateBy"];
					$Data["CreateDate"]		=	$_POST["CreateDate"];
					
					$this->db->arecSave('tblbudget_init_plan_item_relation',$Data);
				}		
		}
		
		$groupName = $this->getGroupName($_POST["PGroupId"]);
		$pitemName =  $this->getPItemName($_POST["PItemId"]);
		//$nextGroupName = $this->getGroupName($_POST["NextPGroupId"]);
		
		LogFiles::SaveLog("กำหนดข้อมูลพื้นฐาน","กำหนดความเชื่อมโยงนโยบายแผนงานประจำปี",$groupName,$pitemName);
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_REQUEST["BgtYear"].'&PItemId='.$_REQUEST["PItemId"].'&PGroupId='.$_REQUEST["PGroupId"].'&NextPGroupId='.$_REQUEST["NextPGroupId"].'&MesAlert=complete', 'redirect' );
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