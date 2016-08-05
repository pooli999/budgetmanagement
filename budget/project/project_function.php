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
		
		//$Status = "เปลี่ยนสถานะเป็น".$Str;
		//LogFiles::SaveLog("ระบบจองห้องประชุม","เปลี่ยนสถานะข้อมูลประธาน/ผู้ทรงคุณวุฒิ",$_REQUEST["OrganizeId"],$Status);
		
		if($pk = $this->db->arecSave('tblintra_organize',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}*/
	//  End Not Remove  //

	//บันทึก / แก้ไข รายละเอียดโครงการ
	function Save(){ ltxt::print_r($_REQUEST);
		$this->db->debug(2);
		//ltxt::print_r($_POST);	
		if(!$_POST["PrjDetailId"]){
			$_POST["StatusId"] = 1;
		}			
		// ดึงรหัสโครงการ
		$_POST["PrjCode"] = $this->getPrjCode($_POST["PrjId"]); echo $_POST["PrjCode"];
				
		if($pk = $this->db->arecSave('tblbudget_project_detail',$_POST)){	
					
			// Add Files
			$ArrDoc = explode(",",$_POST["MultiDocId"]);
			$sql = "DELETE FROM tblbudget_project_file where PrjDetailId = ".$pk."  ";
			$this->db->Execute($sql);
			foreach($ArrDoc as $val){
				if($val != 0){
					$Data["PrjDetailId"] 		= $pk;
					$Data["DocId"] 			= $val;
					$Data["CreateBy"] 		= $_POST["CreateBy"];
					$Data["CreateDate"] 	= $_POST["CreateDate"];		
					$this->db->arecSave('tblbudget_project_file',$Data);
				}
			}		
		
			
			
			$actSelect = $this->getProjectDetailActRecordSet($pk);
			 foreach($actSelect as $r){
				 $checkPrjActId = $r->PrjActId;
				 //echo "checkPrjActId=".$checkPrjActId;
				 if(@in_array($checkPrjActId,$_POST["PrjActId"])){
					// 
				 }else{
					$sqldelact = "DELETE FROM tblbudget_project_activity where PrjActId = ".$checkPrjActId."  ";
					$this->db->Execute($sqldelact);
			
				 }
			 }
			
			//บันทึกกิจกรรม
			$DataAct = array();
			for($a=0;$a< count($_POST["PrjActName"]);$a++){ 
				if($_POST["PrjActName"][$a] != ""){
					
					if(empty($_POST["PrjActCode"][$a])){
						
						$genPrjActCode = $this->genCode($_POST["PrjId"]);
						
					}else{
						$genPrjActCode = $_POST["PrjActCode"][$a];
					}
					
					$DataAct["PrjActId"] 			= $_POST["PrjActId"][$a];
					$DataAct["PrjActCode"] 		= $genPrjActCode;
					$DataAct["PrjDetailId"] 		=	$pk;
					$DataAct["TypeActCode"]	=	$_POST["TypeActCode"][$a];
					$DataAct["OrganizeCode"]	=	$_POST["Organize"][$a];
					$DataAct["StartDate"]			=	$_POST["PrjActStart"][$a];
					$DataAct["EndDate"]			=	$_POST["PrjActEnd"][$a];
					$DataAct["PrjActName"]		=	$_POST["PrjActName"][$a];
					$DataAct["PercentMass"]		=	$_POST["PercentMass"][$a];
					$DataAct["CreateBy"]			=	$_POST["CreateBy"];
					$DataAct["CreateDate"]		=	$_POST["CreateDate"];
					$DataAct["UpdateBy"]			=	$_POST["UpdateBy"];
					$DataAct["UpdateDate"]		=	$_POST["UpdateDate"];		
					
					$DataAct["PrjActId"] 			= $this->db->arecSave('tblbudget_project_activity',$DataAct);
					
				}
			}

			$Topic = $this->getPrjName($_REQUEST["PrjId"]);
			$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
			$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
			$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);
			
			if($_POST["PrjDetailId"]==''){
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มแผนปฏิบัติงานประจำปี",$pk,"โครงการ: ".$Topic." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
			}else{
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขแผนปฏิบัติงานประจำปี",$pk,"โครงการ: ".$Topic." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);	
			}
			
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&BgtYear='.$_POST["BgtYear"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );	
			
		}else{
			echo ltxt::_('Error!','jalert');
		}		
		

	}//end
	


	/* 
	Function Name: GenCode 
	Description		: รัน PItemCode Auto
	Parameter		: -
	Return Value 	: -
	*/			
	function  genCode($PrjId){
		// ดึงรหัสโครงการ
		$oldPrjCode = $this->getPrjCode($PrjId); //echo "<br>oldPrjCode=".$oldPrjCode;
		
		// ดึงรหัสกิจกรรมล่าสุด
		$actCode = $this->getPrjActCode($PrjId);  //echo "<br>actCode=".$actCode;
		$SubactCode = substr($actCode,7,2);	 //echo "<br>SubactCode=".$SubactCode;
		
		$AddSubactCode = $SubactCode +1; //echo "<br>AddSubactCode=".$AddSubactCode;
		
		if(strlen($AddSubactCode) == 1){
			$AddSubactCode = "0".$AddSubactCode; //echo "<br>AddSubactCode=".$AddSubactCode;
		}		
		
		$Code = $oldPrjCode.$AddSubactCode;	 //echo "<br>Code=".$Code; echo "<br><br><br>";
		return $Code;
	}
	/*End*/
	
	
	//บันทึกรายการค่าใช้จ่ายแจงรายเดือน 
	function saveCostMonth(){
			$this->db->debug(0);
			$this->db->Execute("delete from tblbudget_project_activity_cost_internal_month Where CostIntId=".$_POST["CostIntId"]);
			for($i=1;$i<=12;$i++){
				$data2["CostIntId"] = $_POST["CostIntId"];
				$data2["MonthNo"]	=	$i;
				$data2["Budget"]	=	$_POST["Budget".$i];
				$this->db->arecSave('tblbudget_project_activity_cost_internal_month',$data2);
			}
	
			//------- log file ----------
			$CostName = $this->getCostName($_POST["CostItemCode"]);
			$ActName = $this->getActName($_POST["PrjActId"]);
			$Topic = $this->getPrjName($_POST["PrjId"]);
			$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
			
			$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
			$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);

			LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [แจงรายเดือน/ไตรมาส]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." กิจกรรม: ".$ActName." รายการค่าใช้จ่าย: ".$CostName." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
			//---------------------------
					
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjActId='.$_POST["PrjActId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&CostItemCode='.$_POST["CostItemCode"].'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"], 'redirect' );				
			
	}
	
	//บันทึกรายการค่าใช้จ่ายเงินงบประมาณ *4
	function saveCostInternal(){
		//ltxt::print_r($_POST);
		$actSelect = $this->getItemRequireInternal($_POST["CostItemCode"],$_POST["PrjActId"]);
		//ltxt::print_r($actSelect);
				 foreach($actSelect as $r){
				 $checkCostIntId = $r->CostIntId;
				 //echo "checkPrjActId=".$checkPrjActId;
				 if(@in_array($checkCostIntId,$_POST["CostIntId"])){
					// 
				 }else{
					$sqldelact = "DELETE FROM tblbudget_project_activity_cost_internal where CostIntId = ".$checkCostIntId."  ";
					$this->db->Execute($sqldelact);
			
				 }
			 }		
		
		
		for($i=0;$i< count($_POST["Detail"]);$i++){
			if($_POST["Detail"][$i]){
					$data["PrjActId"] = $_POST["PrjActId"];
					$data["CostItemCode"] = $_POST["CostItemCode"];
					
					$data["CostIntId"] 	= $_POST["CostIntId"][$i];
					$data["Detail"] 			= $_POST["Detail"][$i];
					$data["Value1"] 		= $_POST["Value1"][$i];
					$data["Unit1"] 			= $_POST["Unit1"][$i];
					$data["Value2"] 		= $_POST["Value2"][$i];
					$data["Unit2"] 			= $_POST["Unit2"][$i];
					$data["Value3"] 		= $_POST["Value3"][$i];
					$data["Unit3"] 			= $_POST["Unit3"][$i];
					$data["Value4"] 		= $_POST["Value4"][$i];
					$data["Unit4"] 			= $_POST["Unit4"][$i];
					$data["SumCost"] = str_replace(",","",$_POST["SumCost"][$i]);
					$this->db->arecSave('tblbudget_project_activity_cost_internal',$data);
			}
		}
		
		//------- log file ----------
		$CostName = $this->getCostName($_POST["CostItemCode"]);
		$ActName = $this->getActName($_POST["PrjActId"]);
		$Topic = $this->getPrjName($_POST["PrjId"]);
		$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
		$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
		$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);
		
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [บันทึกรายการชี้แจงตัวคูณ 4 ช่อง]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." กิจกรรม: ".$ActName." รายการค่าใช้จ่าย: ".$CostName." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
		//---------------------------

		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjActId='.$_POST["PrjActId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&CostItemCode='.$_POST["CostItemCode"].'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"], 'redirect' );	
				
}

	//บันทึกรายการค่าใช้จ่ายเงินนอกงบประมาณ *4
	function saveCostExternal(){

		$actSelect = $this->getItemRequireExternal($_POST["CostItemCode"],$_POST["PrjActId"],0,$_POST["PrjDetailId"],$_REQUEST["SourceExId"]);
		//ltxt::print_r($actSelect);
				 foreach($actSelect as $r){
				 $checkCostExtId = $r->CostExtId;
				 //echo "checkPrjActId=".$checkPrjActId;
				 if(@in_array($checkCostExtId,$_POST["CostExtId"])){
					// 
				 }else{
					$sqldelact = "DELETE FROM tblbudget_project_activity_cost_external where CostExtId = ".$checkCostExtId."  ";
					$this->db->Execute($sqldelact);
			
				 }
			 }			
		
		for($i=0;$i< count($_POST["Detail"]);$i++){
			if($_POST["Detail"][$i]){
					$data["PrjActId"] = $_POST["PrjActId"];
					$data["SourceExId"] = $_POST["SourceExId"];					
					$data["CostItemCode"] = $_POST["CostItemCode"];
					
					$data["CostExtId"] 	= $_POST["CostExtId"][$i];
					$data["Detail"] 			= $_POST["Detail"][$i];
					$data["Value1"] 		= $_POST["Value1"][$i];
					$data["Unit1"] 			= $_POST["Unit1"][$i];
					$data["Value2"] 		= $_POST["Value2"][$i];
					$data["Unit2"] 			= $_POST["Unit2"][$i];
					$data["Value3"] 		= $_POST["Value3"][$i];
					$data["Unit3"] 			= $_POST["Unit3"][$i];
					$data["Value4"] 		= $_POST["Value4"][$i];
					$data["Unit4"] 			= $_POST["Unit4"][$i];
					$data["SumCost"] = str_replace(",","",$_POST["SumCost"][$i]);
					$this->db->arecSave('tblbudget_project_activity_cost_external',$data);
			}
		}
		
		//------- log file ----------
		$CostName = $this->getCostName($_POST["CostItemCode"]);
		$ActName = $this->getActName($_POST["PrjActId"]);
		$Topic = $this->getPrjName($_POST["PrjId"]);
		$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
		$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
		$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);
		
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [บันทึกรายการชี้แจงตัวคูณ 4 ช่อง]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." กิจกรรม: ".$ActName." รายการค่าใช้จ่าย: ".$CostName." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
		//---------------------------

		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjActId='.$_POST["PrjActId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&CostItemCode='.$_POST["CostItemCode"].'&SourceExId='.$_POST["SourceExId"].'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"], 'redirect' );	
		
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
		
			//------- log file ----------
			$CostName = $this->getCostName($_POST["CostItemCode"]);
			$ActName = $this->getActName($_POST["PrjActId"]);
			$Topic = $this->getPrjName($_POST["PrjId"]);
			$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
			$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
			$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);

			LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [แจงรายเดือน/ไตรมาส]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." กิจกรรม: ".$ActName." รายการค่าใช้จ่าย: ".$CostName." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
			//---------------------------
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjActId='.$_POST["PrjActId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&CostItemCode='.$_POST["CostItemCode"].'&SourceExId='.$_POST["SourceExId"].'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"], 'redirect' );	
		
	}

			//ส่งโครงการ
			function Sent(){
				$this->db->debug(0);
				$data["PrjId"] 							= $_REQUEST["PrjId"];
				$data["PrjDetailId"] 					= $_REQUEST["PrjDetailId"];
				$this->db->Execute("update tblbudget_project_detail set StatusId='2' where PrjId=".$_REQUEST["PrjId"]." and   PrjDetailId  = ".$_REQUEST["PrjDetailId"]."  "); //รอตรวจสอบ
			
				//------- log file ----------
				$Topic = $this->getPrjName($_POST["PrjId"]);
				$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
				$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
				$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);
				
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [ส่งโครงการไปตรวจสอบ]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
				//---------------------------
								
				LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_REQUEST["PrjId"].'&OrganizeCode='.$_REQUEST["OrganizeCode"].'&SCTypeId='.$_REQUEST["SCTypeId"].'&BgtYear='.$_REQUEST["BgtYear"].'&ScreenLevel='.$_REQUEST["ScreenLevel"], 'redirect' );	

			}
			//ลบโครงการ
			function Delete(){
																
					//ดึงกิจกรรม
					$selectAct = $this->getActivity($_REQUEST["PrjDetailId"]);		
					foreach($selectAct as $rAct){
						
						// ตัวชี้วัดกิจกรรม
						$this->db->Execute("delete from tblbudget_project_activity_indicator where PrjActId = ".$rAct->PrjActId." ");
						
						
							// ดึงรายการงบแผ่นดิน
							$selectIn = $this->getActivityIn($rAct->PrjActId);
							foreach($selectIn as $rIn){
								$this->db->Execute("delete from tblbudget_project_activity_cost_internal_month where CostIntId = ".$rIn->CostIntId." ");
							}
								$this->db->Execute("delete from tblbudget_project_activity_cost_internal where PrjActId = ".$rAct->PrjActId." ");
							
							
							// ดึงรายการเงินนอกงบ
							$selectEx = $this->getActivityEx($rAct->PrjActId);
							foreach($selectEx as $rEx){
								$this->db->Execute("delete from tblbudget_project_activity_cost_external_month where CostExtId = ".$rEx->CostExtId." ");
							}
								$this->db->Execute("delete from tblbudget_project_activity_cost_external where PrjActId = ".$rAct->PrjActId." ");	

					}// end กิจกรรม
					
					$selectActResult = $this->getActivityResult($_REQUEST["PrjDetailId"]);		
					foreach($selectActResult as $rResult){
						$this->db->Execute("delete from tblbudget_project_activity_result_file where ResultId = ".$rResult->ResultId." ");
					}
			
					$this->db->Execute("delete from tblbudget_project_activity_result where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
					$this->db->Execute("delete from tblbudget_project_activity where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
					$this->db->Execute("delete from tblbudget_project_check where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
					$this->db->Execute("delete from tblbudget_project_file where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
					$this->db->Execute("delete from tblbudget_project_indicator where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
					$this->db->Execute("delete from tblbudget_project_person where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
					$this->db->Execute("delete from tblbudget_project_detail where PrjDetailId = ".$_REQUEST["PrjDetailId"]." ");
										
				//------- log file ----------
				$Topic = $this->getPrjName($_POST["PrjId"]);
				$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
				$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
				$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);

				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [ลบโครงการ]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
				//---------------------------

					LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&OrganizeCode='.$_REQUEST["OrganizeCode"].'&SCTypeId='.$_REQUEST["SCTypeId"].'&BgtYear='.$_REQUEST["BgtYear"].'&ScreenLevel='.$_REQUEST["ScreenLevel"], 'redirect' );	
					
			}
				
			//ปิดโครงการ
			function Cancel(){
				//$this->db->debug(2);
				$this->db->Execute("update tblbudget_project_detail set StatusId='5' where PrjId=".$_REQUEST["PrjId"]." and   PrjDetailId  = ".$_REQUEST["PrjDetailId"]." and  SCTypeId  = ".$_REQUEST["SCTypeId"]."  and  ScreenLevel  = ".$_REQUEST["ScreenLevel"]."  ");
				
				//------- log file ----------
				$Topic = $this->getPrjName($_REQUEST["PrjId"]);
				$OrgName = $this->getOrgNameAct($_REQUEST["OrganizeCode"]);
				$SCTypeName = $this->getSCTypeName($_REQUEST["SCTypeId"]);
				$ScreenName = $this->getScreenName2($_REQUEST["ScreenLevel"]);

				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [ปิดโครงการ]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." ประจำปี: ".$_REQUEST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_REQUEST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
				//---------------------------	
									
				LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_REQUEST["PrjId"].'&PrjDetailId='.$_REQUEST["PrjDetailId"].'&BgtYear='.$_REQUEST["BgtYear"].'&SCTypeId='.$_REQUEST["SCTypeId"].'&ScreenLevel='.$_REQUEST["ScreenLevel"].'&OrganizeCode='.$_REQUEST["OrganizeCode"], 'redirect' );	

			}
			
			//บันทึกตัวชี้วัดของกิจกรรม
			function SaveInd(){ 
				
				//บันทึกตัวชี้วัด
				$sql = "DELETE FROM tblbudget_project_activity_indicator where PrjActId = ".$_POST["PrjActId"]."  ";
				$this->db->Execute($sql);
				
				$DataInd = array();
				for($i=0;$i< count($_POST["IndicatorName"]);$i++){ 
					if($_POST["IndicatorName"][$i] != ""){
	
						$DataInd["PrjActId"] 			=	$_POST["PrjActId"];
						$DataInd["IndicatorName"]	=	$_POST["IndicatorName"][$i];
						$DataInd["IndTypeId"]			=	$_POST["IndTypeId"][$i];
						$DataInd["Value"]					=	$_POST["Value"][$i];
						$DataInd["UnitID"]				=	$_POST["UnitID"][$i];
						$DataInd["CreateBy"]			=	$_POST["CreateBy"];
						$DataInd["CreateDate"]		=	$_POST["CreateDate"];
						$DataInd["UpdateBy"]			=	$_POST["UpdateBy"];
						$DataInd["UpdateDate"]		=	$_POST["UpdateDate"];
						
						$this->db->arecSave('tblbudget_project_activity_indicator',$DataInd);
					}
				}
										
			//------- log file ----------
			$ActName = $this->getActName($_POST["PrjActId"]);
			$Topic = $this->getPrjName($_POST["PrjId"]);
			$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
			$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
			$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);
			
			LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [บันทึกตัวชี้วัดของกิจกรรม]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." กิจกรรม: ".$ActName." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
			//---------------------------
									
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjActId='.$_POST["PrjActId"].'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&BgtYear='.$_POST["BgtYear"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );	
					

			}
			
	function saveParty(){
		//ltxt::print_r($_POST);
				//บันทึกตัวชี้วัด
				$sql = "DELETE FROM tblbudget_project_party where PrjActId = ".$_POST["PrjActId"]."  ";
				$this->db->Execute($sql);
				
				$DataInd = array();
				for($i=0;$i< count($_POST["PartnerCode"]);$i++){ 
					if($_POST["PartnerCode"][$i] != ""){
	
						$DataInd["PrjActId"] 			=	$_POST["PrjActId"];
						$DataInd["PartnerCode"]	=	$_POST["PartnerCode"][$i];
						$DataInd["CatGroupCode"]			=	$_POST["CatGroupCode"][$i];
						$DataInd["CatGroupId"]			=	$_POST["CatGroupId"][$i];
						$DataInd["CreateBy"]			=	$_POST["CreateBy"];
						$DataInd["CreateDate"]		=	$_POST["CreateDate"];
						$DataInd["UpdateBy"]			=	$_POST["UpdateBy"];
						$DataInd["UpdateDate"]		=	$_POST["UpdateDate"];
						
						$this->db->arecSave('tblbudget_project_party',$DataInd);
					}
				}
										
			//------- log file ----------
			$ActName = $this->getActName($_POST["PrjActId"]);
			$Topic = $this->getPrjName($_POST["PrjId"]);
			$OrgName = $this->getOrgNameAct($_POST["OrganizeCode"]);
			$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
			$ScreenName = $this->getScreenName2($_POST["ScreenLevel"]);
			
			LogFiles::SaveLog("ระบบนโยบายแผนงาน","แผนปฏิบัติงานประจำปี [บันทึกภาคีเครือข่าย]",$_REQUEST["PrjId"],"โครงการ: ".$Topic." กิจกรรม: ".$ActName." ประจำปี: ".$_POST["BgtYear"]." หน่วยงาน: ".$OrgName."[".$_POST["OrganizeCode"]."] ขั้นตอน".$SCTypeName.$ScreenName);
			//---------------------------
									
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjActId='.$_POST["PrjActId"].'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&BgtYear='.$_POST["BgtYear"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );	
					
	}// end 
	
	function changeToCancel($PrjActId){
		$this->db->Execute("update tblbudget_project_activity set StatusId='5' where PrjActId=".$_REQUEST["PrjActId"]."  ");
		
		echo '<div style="width:100px; text-align:left; color:green" class="ico enabled">ยกเลิกกิจกรรม</div>';
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function SaveProjectIndxx(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		if($pk = $this->db->arecSave('tblbudget_project_indicator',$_POST)){	
		
			$sql = "DELETE FROM tblbudget_project_indicator_person where IndicatorCode = '".$_POST["IndicatorCode"]." ' ";
			$this->db->Execute($sql);
			$person["PrjIndId"]		= $pk;
			$person["IndicatorCode"]		= $_POST["IndicatorCode"];	
			$person["CreateBy"]		= $_POST["CreateBy"];
			$person["CreateDate"]	= $_POST["CreateDate"];				
			for($i=0;$i<count($_POST["PersonalSelect"]);$i++){
				$person["PersonalCode"]		= $_POST["PersonalSelect"][$i];
				$this->db->arecSave('tblbudget_project_indicator_person',$person);
			}
			
			$sql = "DELETE FROM tblbudget_project_indicator_month where PrjIndId = '".$pk." ' ";
			$this->db->Execute($sql);
			$month["PrjIndId"]		= $pk;	
			$month["IndicatorCode"]		= $_POST["IndicatorCode"];	
			$month["CreateBy"]		= $_POST["CreateBy"];
			$month["CreateDate"]	= $_POST["CreateDate"];				
			for($i=1;$i<=12;$i++){
				if($_POST["MonthTargetPlan"][$i]){
					$month["MonthNo"]				= $i;
					$month["MonthTargetPlan"]		= $_POST["MonthTargetPlan"][$i];
					$this->db->arecSave('tblbudget_project_indicator_month',$month);
				}
			}
			LTXT::_( '?mod='.LURL::dotPage('project_ind').'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"],'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function SaveProjectInd(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		if($_POST["CriterionType"]=="quantity"){
			$_POST["TQLScore0"] = ""; $_POST["TQLScore1"] = ""; $_POST["TQLScore2"] = ""; $_POST["TQLScore3"] = ""; $_POST["TQLScore4"] = ""; $_POST["TQLScore5"] = "";
			$_POST["Score0"] = $_POST["QTScore0"];
			$_POST["Score1"] = $_POST["QTScore1"];
			$_POST["Score2"] = $_POST["QTScore2"];
			$_POST["Score3"] = $_POST["QTScore3"];
			$_POST["Score4"] = $_POST["QTScore4"];
			$_POST["Score5"] = $_POST["QTScore5"];
			$_POST["DetailScore0"] = $_POST["QTDetailScore0"];
			$_POST["DetailScore1"] = $_POST["QTDetailScore1"];
			$_POST["DetailScore2"] = $_POST["QTDetailScore2"];
			$_POST["DetailScore3"] = $_POST["QTDetailScore3"];
			$_POST["DetailScore4"] = $_POST["QTDetailScore4"];
			$_POST["DetailScore5"] = $_POST["QTDetailScore5"];
		}
		if($_POST["CriterionType"]=="quality"){
			$_POST["QTMinScore0"] = 0; $_POST["QTMinScore1"] = 0; $_POST["QTMinScore2"] = 0; $_POST["QTMinScore3"] = 0; $_POST["QTMinScore4"] = 0; $_POST["QTMinScore5"] = 0; 
			$_POST["QTMaxScore0"] = 0; $_POST["QTMaxScore1"] = 0; $_POST["QTMaxScore2"] = 0; $_POST["QTMaxScore3"] = 0; $_POST["QTMaxScore4"] = 0; $_POST["QTMaxScore5"] = 0; 
			$_POST["Score0"] = $_POST["QLScore0"];
			$_POST["Score1"] = $_POST["QLScore1"];
			$_POST["Score2"] = $_POST["QLScore2"];
			$_POST["Score3"] = $_POST["QLScore3"];
			$_POST["Score4"] = $_POST["QLScore4"];
			$_POST["Score5"] = $_POST["QLScore5"];
			$_POST["DetailScore0"] = $_POST["QLDetailScore0"];
			$_POST["DetailScore1"] = $_POST["QLDetailScore1"];
			$_POST["DetailScore2"] = $_POST["QLDetailScore2"];
			$_POST["DetailScore3"] = $_POST["QLDetailScore3"];
			$_POST["DetailScore4"] = $_POST["QLDetailScore4"];
			$_POST["DetailScore5"] = $_POST["QLDetailScore5"];
		}
		
		//if($_POST["PrjIndId"]==''){
			$_POST["Running"] = $this->getLastRunningNo($_POST["PrjCode"]);
			$BG = substr($_POST["BgtYear"], -2); 
			$Code = substr($_POST["PrjCode"], -1); 
			$MCode = substr($_POST["LPrjCode"],0,6);
			$Number = sprintf("%02s",$_POST["Running"]);
			$_POST["IndicatorCode"] = $MCode.$BG."-".$Code."-K".$Number;
		//}
		if($_POST["PrjIndId"] = $this->db->arecSave('tblbudget_project_indicator',$_POST)){	
		
			$sql = "DELETE FROM tblbudget_project_indicator_person where IndicatorCode = '".$_POST["IndicatorCode"]." ' ";
			$this->db->Execute($sql);
			$person["PrjIndId"]		= $_POST["PrjIndId"];
			$person["IndicatorCode"]		= $_POST["IndicatorCode"];	
			$person["CreateBy"]		= $_POST["CreateBy"];
			$person["CreateDate"]	= $_POST["CreateDate"];				
			for($i=0;$i<count($_POST["PersonalSelect"]);$i++){
				$person["PersonalCode"]		= $_POST["PersonalSelect"][$i];
				$this->db->arecSave('tblbudget_project_indicator_person',$person);
			}
			//save แจกแจงเดือน
			$sql = "DELETE FROM tblbudget_project_indicator_month where PrjIndId = '".$_POST["PrjIndId"]." ' ";
			$this->db->Execute($sql);
			$month["PrjIndId"]		= $_POST["PrjIndId"];	
			$month["IndicatorCode"]		= $_POST["IndicatorCode"];	
			$month["CreateBy"]		= $_POST["CreateBy"];
			$month["CreateDate"]	= $_POST["CreateDate"];				
			for($i=1;$i<=12;$i++){
				if($_POST["QTMTargetPlan"][$i]){
					$month["MonthNo"]				= $i;
					$month["QTMTargetPlan"]		= $_POST["QTMTargetPlan"][$i];
					$this->db->arecSave('tblbudget_project_indicator_month',$month);
				}
				if($_POST["QLMTargetPlan"][$i]){
					$month["MonthNo"]				= $i;
					$month["QLMTargetPlan"]		= $_POST["QLMTargetPlan"][$i];
					$this->db->arecSave('tblbudget_project_indicator_month',$month);
				}
			}
			LTXT::_( '?mod='.LURL::dotPage('project_ind_view').'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"].'&PrjIndId='.$_POST["PrjIndId"],'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	
	function SaveProjectIndMonth(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		$_POST["PrjIndId"] = $this->db->arecSave('tblbudget_project_indicator',$_POST);
		$sql = "DELETE FROM tblbudget_project_indicator_month where PrjIndId = '".$_POST["PrjIndId"]." ' ";
		$this->db->Execute($sql);
		$month["PrjIndId"]		= $_POST["PrjIndId"];	
		$month["IndicatorCode"]		= $_POST["IndicatorCode"];	
		$month["CreateBy"]		= $_POST["CreateBy"];
		$month["CreateDate"]	= $_POST["CreateDate"];				
		for($i=1;$i<=12;$i++){
			if($_POST["QTMTargetPlan"][$i]){
				$month["MonthNo"]				= $i;
				$month["QTMTargetPlan"]		= $_POST["QTMTargetPlan"][$i];
				$this->db->arecSave('tblbudget_project_indicator_month',$month);
			}
			if($_POST["QLMTargetPlan"][$i]){
				$month["MonthNo"]				= $i;
				$month["QLMTargetPlan"]		= $_POST["QLMTargetPlan"][$i];
				$this->db->arecSave('tblbudget_project_indicator_month',$month);
			}
		}
		LTXT::_( '?mod='.LURL::dotPage('project_ind').'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&PrjId='.$_POST["PrjId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"],'redirect' );
	}
	
			
			
}// end class

?>