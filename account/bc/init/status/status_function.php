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
	Description		: เปลี่ยนสถานะขั้นตอนการกลั่นกรองงบประมาณเป็น แสดง หรือไม่แสดง
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
		
		$_REQUEST["BgtYear"] = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		
		$Topic = $this->getScreenName($_REQUEST["ScreenId"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","เปลี่ยนสถานะข้อมูลพื้นฐานในส่วนของขั้นตอนการกลั่นกรองงบประมาณเป็น ".$Str,$_REQUEST["ScreenId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_init_screen_item',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข ขั้นตอนการกลั่นกรองงบประมาณ
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		
		if($_POST["ScreenId"]==''){
			$maxlevel = $this->getScreenLevel($_POST["BgtYear"]);
			if(empty($maxlevel)){$maxlevel=0;}
			$_POST["ScreenLevel"] = $maxlevel+1;
		}
		if(!$_POST["Allot"]){
			$_POST["Allot"] = "N";
		}
		
		if($pk = $this->db->arecSave('tblbudget_init_screen_item',$_POST)){						
			
			if($_POST["ScreenId"]=='')
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มข้อมูลพื้นฐานในส่วนของขั้นตอนการกลั่นกรองงบประมาณ",$pk,$_REQUEST["ScreenName"]);
			else
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขข้อมูลข้อมูลพื้นฐานในส่วนของขั้นตอนการกลั่นกรองงบประมาณ",$pk,$_REQUEST["ScreenName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบขั้นตอนการกลั่นกรองงบประมาณ
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = $this->getScreenName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลพื้นฐานในส่วนของขั้นตอนการกลั่นกรองงบประมาณ",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_init_screen_item set DeleteStatus='Y' where ScreenId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
	}
	/*End*/
	
	/* 
	START #F4
	Function Name: SaveOrder 
	Description		: เรียงลำดับขั้นตอนการกลั่นกรองงบประมาณ
	Parameter		: -
	Return Value 	: -
	*/
	function SaveOrder()
	{
			if($_REQUEST["BgtYear"] == ""){$_REQUEST["BgtYear"] = date("Y")+543;}
			$ArrOrder = explode(",",$_REQUEST["newOrder"]);
			//$i = count($ArrOrder);
			$i=1;
			foreach($ArrOrder as $id){
				if($id != ""){
					$sql = "Update tblbudget_init_screen_item set Ordering='$i', ScreenLevel='$i'  where ScreenId = '".$id."'  and  BgtYear= '".$_REQUEST["BgtYear"]."'  and  SCTypeId= '".$_REQUEST["SCTypeId"]."'  ";
					//echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
			
	}
	/*End*/
		
}
?>