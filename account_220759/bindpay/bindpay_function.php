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
		
		$Topic = $this->getBankName($_REQUEST["BankId"]);
		LogFiles::SaveLog("ระบบการเงิน","เปลี่ยนสถานะข้อมูลธนาคารเป็น ".$Str,$_REQUEST["BankId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_finance_bank',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข ผูกบัญชีรายรับ
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		$CostItemId = $_POST["CostItemId"];
		$AcSeriesId = $_POST["AcSeriesId"];
		//$ArrAc = explode(",",$_POST["AcCode2"]);
		//print("ddd");
		//print_r($_POST["AcCode2"]);
		//print("sss");
		$sql = "DELETE FROM tblbudget_init_cost_item_ac WHERE CostItemId='$CostItemId' ";
		$this->db->Execute($sql);
		$Data = array();
		if($_POST["AcCode2"]){
			for($i=0;$i<count($_POST["AcCode2"]);$i++ ){

				$Data["CostItemId"] = $CostItemId;
				$Data["AcSeriesId"] = $AcSeriesId;
				$Data["AcChartId"] = $_POST["AcCode2"][$i];
				$pk=$this->db->arecSave('tblbudget_init_cost_item_ac',$Data);
				LogFiles::SaveLog("ระบบบัญชี","เพิ่มข้อมูลผูกบัญชีรายจ่าย",$pk,$_REQUEST["CostName"]);
				print_r($Data);
			}
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&AcSeriesId='.$_REQUEST["AcSeriesId"].'&AcSeriesName='.$_REQUEST["AcSeriesName"].'&start='.$_REQUEST["start"], 'redirect' );
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
		
		$Topic = $this->getBankName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลธนาคาร",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_finance_bank set DeleteStatus='Y' where BankId = ".$_REQUEST["id"]."";
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
					$sql = "Update tblbudget_finance_bank set Ordering='$i' where BankId = '".$id."'  ";
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