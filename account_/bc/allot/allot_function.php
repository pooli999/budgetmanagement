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
	
	//  End Not Remove  //
	
	function Save(){
		//ltxt::print_r($_POST);
		//$countScreenLevel = $this->countScreenLevel();
		
		$countScreenLevel = $this->countScreenLevel($_POST['BgtYear'],$_POST["SCTypeId"]);
		
		if($_POST["SCTypeId"] == 1){	
		
			$nextScreenLevel = $_POST["ScreenLevel"]+1;
			$nextSCTypeId = $_POST["SCTypeId"]+1;
			
		}else if($_POST["SCTypeId"] == 2 && $_POST["ScreenLevel"] < $countScreenLevel){
			
			$nextScreenLevel = $_POST["ScreenLevel"]+1;
			$nextSCTypeId = $_POST["SCTypeId"];
			
		}else{
			
			$nextScreenLevel = 0;
			$nextSCTypeId = $_POST["SCTypeId"]+1;
			
		}
		
		//== Log File ===
		$SCTypeName = $this->getSCTypeName($nextSCTypeId);
		if($ScreenLevel > 0){ $ScreenName = $this->getScreenName($nextScreenLevel);  $txtScreenName =  " --> ".$ScreenName;}  	
		LogFiles::SaveLog("กลั่นกรองงบ/จัดสรรงบ/ทำแผนฯ","ปรับขั้นตอนการจัดทำงบประมาณ",$_POST["BgtYear"],"ปรับขั้นตอนการจัดทำงบประมาณ ปี ".$_POST["BgtYear"]."  รหัสหน่วยงาน  ".$_POST["OrganizeCode"]." เป็น ".$SCTypeName.$txtScreenName);
		//============
		
		
		
		
/*			$ListPrj = $this->getProjectScreenType($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel']);
			
			foreach($ListPrj as $r){
				foreach($r as $k=>$v){ ${$k} = $v;}
				
			$sqld = "update tblbudget_project_detail set SCTypeId='$nextSCTypeId', ScreenLevel='$nextScreenLevel'  where  PrjDetailId='".$PrjDetailId."'  and  PrjId='".$PrjId."'   ";
			$this->db->Execute($sqld);	
		
			}*/

		
		$sqly = "update tblbudget_init_year_org set SCTypeId='$nextSCTypeId', ScreenLevel='$nextScreenLevel',CloseStep='N'  where  OrganizeCode='".$_POST["OrganizeCode"]."'  and  BgtYear='".$_POST["BgtYear"]."'   ";
		$this->db->Execute($sqly);				
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );

	}

	
	
	function SaveScreen(){
					//ltxt::print_r($_POST);
					
					 $ScreenLevel = ($_POST["ScreenLevel"])?$_POST["ScreenLevel"]:0;
			
					  $DataAllot["AllotId"] =  $_POST["AllotId"];
					   //$DataAllot["PrjActId"] =  $_POST["PrjActId"];
					   //$DataAllot["PrjActCode"] =  $_POST["PrjActCode"];
					   $DataAllot["PrjDetailId"] =  $_POST["PrjDetailId"];
					   //$DataAllot["PrjId"] =  $_POST["PrjId"];
					  $DataAllot["BGInternal"] =  $_POST["BGInternal"];
					  $DataAllot["BgtYear"] =  $_POST["BgtYear"];
					  $DataAllot["OrganizeCode"] =  $_POST["OrganizeCode"];
					  $DataAllot["SCTypeId"] =  $_POST["SCTypeId"];
					  $DataAllot["ScreenLevel"] =  $ScreenLevel;					  
					  $DataAllot["UpdateDate"] = $_POST["UpdateDate"];
					  $DataAllot["UpdateBy"] = $_POST["UpdateBy"];
					  $DataAllot["CreateDate"] = $_POST["CreateDate"];
					  $DataAllot["CreateBy"] = $_POST["CreateBy"];
					  
					  $pk = $this->db->arecSave("tblbudget_allot",$DataAllot);			
					  
					//== Log File ===
					$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
					if($ScreenLevel > 0){ $ScreenName = $this->getScreenName($ScreenLevel);  $txtScreenName =  " ระดับ ".$ScreenName;}  	
					LogFiles::SaveLog("ระบบนโยบายแผนงาน","กลั่นกรองจัดสรรงบโครงการ [บันทึกกลั่นกรองงบ]",$pk,$SCTypeName.$ScreenName."  ปี  ".$_POST["BgtYear"]."  รหัสหน่วยงาน  ".$_POST["OrganizeCode"]);
					//============

	
					LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_REQUEST["ScreenLevel"], 'redirect' );	
							
		}
		
		
	function SaveAllot(){
		//ltxt::print_r($_POST);
				$sql = "DELETE FROM tblbudget_allot where PrjDetailId = ".$_POST["PrjDetailId"]."     ";
				$this->db->Execute($sql);
					  $DataAllot["AllotId"] =  $_POST["AllotId"];	  
					  $DataAllot["PrjDetailId"] =  $_POST["PrjDetailId"];		
					  $DataAllot["BGInternal"] =  $_POST["BGInternal"];		  
					  $DataAllot["BgtYear"] =  $_POST["BgtYear"];
					  $DataAllot["OrganizeCode"] =  $_POST["OrganizeCode"];
					  $DataAllot["SCTypeId"] =  $_POST["SCTypeId"];
					  $DataAllot["ScreenLevel"] =  $_POST["ScreenLevel"];					  
					  $DataAllot["UpdateDate"] = $_POST["UpdateDate"];
					  $DataAllot["UpdateBy"] = $_POST["UpdateBy"];
					  $DataAllot["CreateDate"] = $_POST["CreateDate"];
					  $DataAllot["CreateBy"] = $_POST["CreateBy"];
					  
					  $pk = $this->db->arecSave("tblbudget_allot",$DataAllot);			
					  
					//== Log File ===
					$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
					LogFiles::SaveLog("ระบบนโยบายแผนงาน","กลั่นกรองจัดสรรงบโครงการ [บันทึกจัดสรร]",$pk,$SCTypeName."  ปี  ".$_POST["BgtYear"]."  รหัสหน่วยงาน  ".$_POST["OrganizeCode"]);
					//============

					
		########## external ##########
				//-------------- ลบ allot_external ------------------------		
				$sql = "DELETE FROM tblbudget_allot_external where PrjDetailId = ".$_POST["PrjDetailId"]."     ";
				$this->db->Execute($sql);
					
					for($i=0;$i<count($_POST["BGExternal"]);$i++){
						if($_POST["BGExternal"][$i] != ""){
							  $DataAllot["AllotExId"] =  $_POST["AllotExId"];	  
							  $DataEx["PrjDetailId"] =  $_POST["PrjDetailId"];	
							  $DataEx["BGExternal"] =  $_POST["BGExternal"][$i];		  
							  $DataEx["SourceExId"] =  $_POST["SourceExId"][$i];	
							  $DataEx["BgtYear"] =  $_POST["BgtYear"];
							  $DataEx["OrganizeCode"] =  $_POST["OrganizeCode"];
							  $DataEx["SCTypeId"] =  $_POST["SCTypeId"];
							  $DataEx["ScreenLevel"] = $_POST["ScreenLevel"];				  
							  $DataEx["UpdateDate"] = $_POST["UpdateDate"];
							  $DataEx["UpdateBy"] = $_POST["UpdateBy"];
							  $DataEx["CreateDate"] = $_POST["CreateDate"];
							  $DataEx["CreateBy"] = $_POST["CreateBy"];						
						
							  $this->db->arecSave("tblbudget_allot_external",$DataEx);
						}
					}

					LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"], 'redirect' );	
	
	}
		
		
		function CloseScreen(){
			
		//ltxt::print_r($_POST);	
				
		$sql = "update tblbudget_init_year_org set CloseStep='Y'  where  OrganizeCode='".$_POST["OrganizeCode"]."'  and  BgtYear='".$_POST["BgtYear"]."'   ";
		$this->db->Execute($sql);	
		
		//== Log File ===
		$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
		if($_POST["SCTypeId"]){ $ScreenName = $this->getScreenName($_POST["ScreenLevel"]);  $txtScreenName =  " --> ".$ScreenName;}  	
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","กลั่นกรองจัดสรรงบโครงการ [ปิดการกลั่นกรอง/จัดสรรงบประมาณ]",$_POST["BgtYear"],"ปิดการกลั่นกรอง/จัดสรรงบประมาณ ปี ".$_POST["BgtYear"]."  รหัสหน่วยงาน  ".$_POST["OrganizeCode"]." เป็น ".$SCTypeName.$txtScreenName);
		//============		
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );	
	
	}
	

	function SaveAdjust(){
		
		//ltxt::print_r($_POST);	

					  $DataAdjust["AllotId"] =  $_POST["AllotId"];
					  $DataAdjust["PrjActId"] =  $_POST["PrjActId"];
					  $DataAdjust["PrjActCode"] =  $_POST["PrjActCode"];
					  $DataAdjust["PrjDetailId"] =  $_POST["PrjDetailId"];
					  //$DataAdjust["PrjId"] =  $_POST["PrjId"];					  
					  $DataAdjust["BgtYear"] =  $_POST["BgtYear"];
					  $DataAdjust["OrganizeCode"] =  $_POST["OrganizeCode"];
					  $DataAdjust["SCTypeId"] =  $_POST["SCTypeId"];
					  $DataAdjust["ScreenLevel"] =  0;					  
					  $DataAdjust["UpdateDate"] = $_POST["UpdateDate"];
					  $DataAdjust["UpdateBy"] = $_POST["UpdateBy"];
					  $DataAdjust["CreateDate"] = $_POST["CreateDate"];
					  $DataAdjust["CreateBy"] = $_POST["CreateBy"];
					  
					  $pk = $this->db->arecSave("tblbudget_allot",$DataAdjust);			
					  
					//== Log File ===
					$SCTypeName = $this->getSCTypeName($_POST["SCTypeId"]);
					LogFiles::SaveLog("กลั่นกรองงบ/จัดสรรงบ/ทำแผนฯ","ปรับแผนปฏิบัติงานกลางปี",$pk,$SCTypeName."  ปี  ".$_POST["BgtYear"]."  รหัสหน่วยงาน  ".$_POST["OrganizeCode"]);
					//============
		

		########## internal ##########
				//-------------- ลบ adjust_internal ------------------------		
					$sql = "DELETE FROM tblbudget_allot_internal where AllotId = ".$_POST["AllotId"]."     ";
					$this->db->Execute($sql);
		
					  $Data = array();
					  for($i=0; $i<count($_POST["BGIncrease"]); $i++){ 
					  
					  	
							if($_POST["BGIncrease"][$i] != 0){		
								$Data["AllotId"] =  $pk;
								$Data["BGAllot"] =  $_POST["sumRemainLevel"][$i];		
								$Data["BGIncrease"] =  $_POST["BGIncrease"][$i];		
								$Data["BGDecrease"] =  $_POST["BGDecrease"][$i];		
								$Data["BGTotal"] =  $_POST["BGIncrease"][$i];										
								$Data["CostItemCode"] =  $_POST["CostItemCode"][$i];
									
								$this->db->arecSave("tblbudget_allot_internal",$Data);
							}
						}	
		
		
		
		########## external ##########
				//-------------- ลบ allot_external ------------------------		
					$sql = "DELETE FROM tblbudget_allot_external where AllotId = ".$_POST["AllotId"]."     ";
					$this->db->Execute($sql);
			
					$getExName=$this->getSourceExName();
					$j=0;
					foreach($getExName as $sName){
							foreach($sName as $k=>$v){${$k} = $v;}
									
									$DataEx = array();
									for($c=0; $c<count($_POST["ExBGIncrease".$SourceExId]); $c++){
										
										if($_POST["ExBGIncrease".$SourceExId][$c] != 0){		
											
											$DataEx["SourceExId"] =  $SourceExId;
											$DataEx["AllotId"] =  $pk;
											$DataEx["BGAllot"] =  $_POST["sumExRemainLevel".$SourceExId][$c];		
											$DataEx["BGIncrease"] =  $_POST["ExBGIncrease".$SourceExId][$c];		
											$DataEx["BGDecrease"] =  $_POST["ExBGDecrease".$SourceExId][$c];		
											$DataEx["BGTotal"] =  $_POST["ExBGIncrease".$SourceExId][$c];										
											$DataEx["CostItemCode"] =  $_POST["ExCostItemCode".$SourceExId][$c];	
									
											$this->db->arecSave("tblbudget_allot_external",$DataEx);
										
										}
									}
									
							$j++;				
						
					}
		
					LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"].'&SCTypeId='.$_POST["SCTypeId"].'&ScreenLevel='.$_POST["ScreenLevel"], 'redirect' );	
					
					//LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );		
	}


}

?>