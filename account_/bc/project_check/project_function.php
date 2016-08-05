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
	
	//บันทึก / แก้ไข รายละเอียดโครงการ
	function Save(){
		$this->db->debug(2);
		if(!$_POST["PrjDetailId"]){
			$_POST["StatusId"] = 1;
		}
		$DataDetail["PrjDetailId"] 		= $_POST["PrjDetailId"];
		$DataDetail["SCTypeId"] 			= $_POST["SCTypeId"];
		$DataDetail["ScreenLevel"] 		= $_POST["ScreenLevel"];
		$DataDetail["PrjId"] 					= $_POST["PrjId"];
		$DataDetail["StartDate"] 			= $_POST["StartDate"];
		$DataDetail["EndDate"] 			= $_POST["EndDate"];
		$DataDetail["Telephone"]		= $_POST["Telephone"];
		$DataDetail["Fax"] 					= $_POST["Fax"];
		$DataDetail["Email"] 				= $_POST["Email"];
		$DataDetail["Purpose"] 			= $_POST["Purpose"];
		$DataDetail["Indicator"] 			= $_POST["Indicator"];
		$DataDetail["Outputs"] 			= $_POST["Outputs"];
		$DataDetail["StatusId"] 			= $_POST["StatusId"];
		$DataDetail["ActiveStatus"] 		= "Y";
		$DataDetail["UpdateDate"] 		= $_POST["UpdateDate"];
		$DataDetail["UpdateBy"] 			= $_POST["UpdateBy"];
		$DataDetail["CreateDate"] 		= $_POST["CreateDate"];
		$DataDetail["CreateBy"] 			= $_POST["CreateBy"];
		$_POST["PrjDetailId"] = $this->db->arecSave('tblbudget_project_detail',$DataDetail);	
				
		//บันทึกตัวชี้วัด
		if($_POST["PrjDetailId"]){
		$sql = "DELETE FROM tblbudget_project_indicator where PrjDetailId = ".$_POST["PrjDetailId"]."  ";
		$this->db->Execute($sql);
		}
		$DataInd["PrjDetailId"] 	= $_POST["PrjDetailId"];
		for($i=0;$i< count($_POST["IndId"]);$i++){ 
			if($_POST["IndId"][$i]){
						$DataInd["IndId"] 				= $_POST["IndId"][$i];
						$DataInd["UpdateDate"] 	= $_POST["UpdateDate"];
						$DataInd["UpdateBy"] 		= $_POST["UpdateBy"];
				}
				$DataInd["Value"] 						= $_POST["Value"][$i];
				$DataInd["UnitId"] 						= $_POST["UnitId"][$i];
				$this->db->arecSave('tblbudget_project_indicator',$DataInd);
		}
		
		//บันทึกกิจกรรม
		$DataAct["PrjDetailId"] = $_POST["PrjDetailId"];
		$DataAct["UpdateDate"] = $_POST["UpdateDate"];
		$DataAct["UpdateBy"] = $_POST["UpdateBy"];
		$DataAct["CreateDate"] = $_POST["CreateDate"];
		$DataAct["CreateBy"] = $_POST["CreateBy"];
		for($k=0;$k<=$_POST["h-ct_index"];$k++){
			if($_POST["PrjActName"][$k]){
				$DataAct["PrjActId"] = $_POST["PrjActId"][$k];
				$DataAct["OrganizeCode"] = $_POST["Organize"][$k];
				$DataAct["StartDate"] = $_POST["PrjActStart".$k];
				$DataAct["EndDate"] = $_POST["PrjActEnd".$k];
				$DataAct["PrjActName"] = $_POST["PrjActName"][$k];
				$DataAct["PrjActId"] = $this->db->arecSave('tblbudget_project_activity',$DataAct);
				$DataAct["PrjActCode"] = $DataAct["PrjActId"];
				$this->db->arecSave('tblbudget_project_activity',$DataAct);
			}
		}
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&BgtYear='.$_POST["BgtYear"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );	
	}
	
	//บันทึกรายการค่าใช้จ่ายแจงรายเดือน 
	function saveCostMonth(){
				ltxt::print_r($_POST);

					$this->db->debug(2);
					$this->db->Execute("delete from tblbudget_project_activity_cost_internal_month Where CostIntId=".$_POST["CostIntId"]);
					for($i=1;$i<=12;$i++){
					$data2["CostIntId"] = $_POST["CostIntId"];
					$data2["MonthNo"]	=	$i;
					$data2["Budget"]	=	$_POST["Budget".$i];
					$this->db->arecSave('tblbudget_project_activity_cost_internal_month',$data2);
					}
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&BgtYear='.$_POST["BgtYear"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );	
	}
	
	//บันทึกรายการค่าใช้จ่ายเงินงบประมาณ *4
	function saveCostInternal(){
		$this->db->debug(0);
		$sql = "DELETE FROM tblbudget_project_activity_cost_internal where PrjActId = ".$_POST["PrjActId"]."  and   CostItemCode  = ".$_POST["CostItemCode"]."  ";
		$this->db->Execute($sql);
		for($i=0;$i< count($_POST["Detail"]);$i++){
			if($_POST["Detail"][$i]){
					$data["PrjActId"] = $_POST["PrjActId"];
					$data["CostItemCode"] = $_POST["CostItemCode"];
					$data["Detail"] 			= $_POST["Detail"][$i];
					$data["Value1"] 		= $_POST["Value1"][$i];
					$data["Unit1"] 			= $_POST["UnitId1"][$i];
					$data["Value2"] 		= $_POST["Value2"][$i];
					$data["Unit2"] 			= $_POST["UnitId2"][$i];
					$data["Value3"] 		= $_POST["Value3"][$i];
					$data["Unit3"] 			= $_POST["UnitId3"][$i];
					$data["Value4"] 		= $_POST["Value4"][$i];
					$data["Unit4"] 			= $_POST["UnitId4"][$i];
					$data["SumCost"] = str_replace(",","",$_POST["SumCost"][$i]);
					$this->db->arecSave('tblbudget_project_activity_cost_internal',$data);
			}
		}
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&BgtYear='.$_POST["BgtYear"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );	
}

	//บันทึกรายการค่าใช้จ่ายเงินนอกงบประมาณ *4
	function saveCostExternal(){
		$this->db->debug(2);
		$sql = "DELETE FROM tblbudget_project_activity_cost_external where PrjActId = ".$_POST["PrjActId"]."  and   CostItemCode  = ".$_POST["CostItemCode"]."  ";
		$this->db->Execute($sql);
		for($i=0;$i< count($_POST["Detail"]);$i++){
			if($_POST["Detail"][$i]){
					$data["PrjActId"] = $_POST["PrjActId"];
					$data["SourceExId"] = $_POST["SourceExId"];					
					$data["CostItemCode"] = $_POST["CostItemCode"];
					$data["Detail"] 			= $_POST["Detail"][$i];
					$data["Value1"] 		= $_POST["Value1"][$i];
					$data["Unit1"] 			= $_POST["UnitId1"][$i];
					$data["Value2"] 		= $_POST["Value2"][$i];
					$data["Unit2"] 			= $_POST["UnitId2"][$i];
					$data["Value3"] 		= $_POST["Value3"][$i];
					$data["Unit3"] 			= $_POST["UnitId3"][$i];
					$data["Value4"] 		= $_POST["Value4"][$i];
					$data["Unit4"] 			= $_POST["UnitId4"][$i];
					$data["SumCost"] = str_replace(",","",$_POST["SumCost"][$i]);
					$this->db->arecSave('tblbudget_project_activity_cost_external',$data);
			}
		}
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&BgtYear='.$_POST["BgtYear"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SourceExId='.$_POST["SourceExId"], 'redirect' );	
}

					//บันทึกรายการค่าใช้จ่ายแจงรายเดือนเงินนอกงบประมาณ 
					function saveCostMonthEx(){
					$this->db->debug(0);
					$this->db->Execute("delete from tblbudget_project_activity_cost_external_month Where CostExtId=".$_POST["CostExtId"]);
					for($i=1;$i<=12;$i++){
											
						$data2["CostExtId"] = $_POST["CostExtId"];
						$data2["MonthNo"]	=	$i;
						$data2["Budget"]	=	$_POST["Budget".$i];
						$this->db->arecSave('tblbudget_project_activity_cost_external_month',$data2);
					
					}
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&BgtYear='.$_POST["BgtYear"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SourceExId='.$_POST["SourceExId"], 'redirect' );	
	}


				//ลบโครงการ
					function Delete(){
					$this->db->debug(2);
					$this->db->Execute("delete from tblbudget_project_detail where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
					$this->db->Execute("delete from tblbudget_project_activity where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
					LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&BgtYear='.$_POST["BgtYear"], 'redirect' );	
				}
				
				//ยกเลิกโครงการ
				function Cancel(){
				$this->db->debug(2);
				$data["PrjId"] 						= $_REQUEST["PrjId"];
				$data["PrjDetailId"] 				= $_REQUEST["PrjDetailId"];
				$this->db->Execute("update tblbudget_project_detail set StatusId='5' where PrjId=".$_REQUEST["PrjId"]." and   PrjDetailId  = ".$_REQUEST["PrjDetailId"]."  ");
				LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&BgtYear='.$_POST["BgtYear"], 'redirect' );	
			}

/*****************************************************************************/
//บันทึกผลการตรวจสอบ
		function saveApprove(){	
		 
		$this->db->debug(2);
		$_POST["ChkNo"]=$this->getMaxChk($_POST["PrjDetailId"]);
		$data["CreateDate"] 					= $_POST["UpdateDate"];
		$data["CreateBy"]				 		= $_POST["UpdateBy"];
		$data["Result"] 							= $_POST["Result"];
		$data["Comment"] 						= $_POST["Comment"];
		$data["PrjDetailId"] 						= $_POST["PrjDetailId"];
		$data["ChkNo"] 							= $_POST["ChkNo"]+1;
		$this->db->arecSave('tblbudget_project_check',$data);
		if($_POST["Result"]=="Y"){
					$this->db->Execute("update tblbudget_project_detail set StatusId='4' Where PrjDetailId='".$_POST["PrjDetailId"]."'");//ผ่านการตรวจสอบ
		}else{
					$this->db->Execute("update tblbudget_project_detail set StatusId='3' Where PrjDetailId='".$_POST["PrjDetailId"]."'");//ไม่ผ่านการตรวจสอบ
		}
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&BgtYear='.$_POST["BgtYear"].'&ScreenLevel='.$_POST["ScreenLevel"], 'redirect' );	
		
		}

/******************************************************************************/	
}

?>