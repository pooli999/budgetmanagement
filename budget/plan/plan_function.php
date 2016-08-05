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
	Description		: เปลี่ยนสถานะแผนงานต่อเนื่องเป็น แสดง หรือไม่แสดง
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
		
		$Topic = $this->getPLongName($_REQUEST["PLongId"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","เปลี่ยนสถานะข้อมูลพื้นฐานในส่วนของแผนงานต่อเนื่องเป็น ".$Str,$_REQUEST["PLongId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_longterm',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข แผนงานต่อเนื่อง
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){ 
		ltxt::print_r($_POST);
		$this->db->debug(2);
		$_POST["PLongYearEnd"] = $_POST["PLongYear"]+($_POST["PLongAmount"]-1);
		if($pk = $this->db->arecSave('tblbudget_longterm',$_POST)){	
			
			$sql = "Update tblbudget_longterm set PLongCode='".$pk."' where PLongId = ".$pk."";
			$this->db->Execute($sql);
			
			$sql = "DELETE FROM tblbudget_longterm_indicator where PLongCode = '".$pk."'  ";
			$this->db->Execute($sql);
		
			$data["PLongCode"]	= $pk;	
			$data["CreateBy"]		= $_POST["CreateBy"];
			$data["CreateDate"]	= $_POST["CreateDate"];				
			for($i=0;$i<count($_POST["PIndCode"]);$i++){
				$data["PIndCode"]		= $_POST["PIndCode"][$i];
				$data["PIndName"]		= $_POST["PIndName"][$i];
				$this->db->arecSave('tblbudget_longterm_indicator',$data);
			}
			
			$sql = "DELETE FROM tblbudget_longterm_plan where PLongCode = '".$pk."'  ";
			$this->db->Execute($sql);
			for($i=0;$i<count($_POST["LPlanCode"]);$i++){
				$data["LPlanCode_Old"]	= $_POST["LPlanCode_Old"][$i];
				$data["LPlanCode"]		= $_POST["LPlanCode"][$i];
				$data["LPlanName"]		= $_POST["LPlanName"][$i];
				$this->db->arecSave('tblbudget_longterm_plan',$data);
				$sql = "Update tblbudget_longterm_plan_project set LPlanCode='".$data["LPlanCode"]."' where LPlanCode = '".$data["LPlanCode_Old"]."'";
				$this->db->Execute($sql);
			}
			if($_POST["PLongId"]=='')
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มข้อมูลพื้นฐานในส่วนของแผนงานต่อเนื่อง",$pk,$_REQUEST["PLongName"]);
			else
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขข้อมูลข้อมูลพื้นฐานในส่วนของแผนงานต่อเนื่อง",$pk,$_REQUEST["PLongName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PLongCode='.$_POST["PLongCode"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบแผนงานต่อเนื่อง
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		$Topic = $this->getPLongName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลพื้นฐานในส่วนของแผนงานต่อเนื่อง",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_longterm set DeleteStatus='Y' where PLongId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
	}
	/*End*/
	
	/* 
	Function Name: SaveOrder 
	Description		: เรียงลำดับประเภทตัวชี้วัด(KPI)
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
					$sql = "Update tblbudget_longterm set Ordering='$i' where PLongId = '".$id."'  ";
					echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
			
	}
	/*End*/
	
	
	function SaveProject(){ 
		ltxt::print_r($_POST);
		$this->db->debug(2);
		$sql = "DELETE FROM tblbudget_longterm_plan_project where LPlanCode = '".$_POST["LPlanCode"]." ' ";
		$this->db->Execute($sql);
		$data["LPlanCode"]		= $_POST["LPlanCode"];	
		$data["CreateBy"]		= $_POST["CreateBy"];
		$data["CreateDate"]	= $_POST["CreateDate"];				
		for($i=0;$i<count($_POST["LPrjCode"]);$i++){
			$data["LPrjCode"]		= $_POST["LPrjCode"][$i];
			$data["LPrjName"]		= $_POST["LPrjName"][$i];
			$this->db->arecSave('tblbudget_longterm_plan_project',$data);
		}
		/*if($_POST["PLongId"]==''){
			LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มข้อมูลพื้นฐานในส่วนของแผนงานต่อเนื่อง",$pk,$_REQUEST["PLongName"]);
		}else{
			LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขข้อมูลข้อมูลพื้นฐานในส่วนของแผนงานต่อเนื่อง",$pk,$_REQUEST["PLongName"]);
		}*/
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PLongCode='.$_POST["PLongCode"], 'redirect' );
	}
	
	function SaveInd(){ 
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
		if($_POST["LindId"]==''){
			$_POST["Running"] = $this->getLastRunningNo($_POST["LPlanCode"]);
			$Number = sprintf("%02s",$_POST["Running"]);
			$_POST["LindCode"] = $_POST["LPlanCode"]."-K".$Number;
		}
		$_POST["LindId"] = $this->db->arecSave('tblbudget_longterm_plan_indicator',$_POST);
		$sql = "DELETE FROM tblbudget_longterm_plan_indicator_person where LindCode = '".$_POST["LindCode"]." ' ";
		$this->db->Execute($sql);
		$person["LindCode"]		= $_POST["LindCode"];	
		$person["CreateBy"]		= $_POST["CreateBy"];
		$person["CreateDate"]	= $_POST["CreateDate"];				
		for($i=0;$i<count($_POST["PersonalSelect"]);$i++){
			$person["PersonalCode"]		= $_POST["PersonalSelect"][$i];
			$this->db->arecSave('tblbudget_longterm_plan_indicator_person',$person);
		}
		//save แจงรายปี
		$sql = "DELETE FROM tblbudget_longterm_plan_indicator_year where LindCode = '".$_POST["LindCode"]." ' ";
		$this->db->Execute($sql);
		$year["LindCode"]	= $_POST["LindCode"];	
		$year["CreateBy"]		= $_POST["CreateBy"];
		$year["CreateDate"]	= $_POST["CreateDate"];				
		for($i=0;$i<count($_POST["BgtYear"]);$i++){
			if($_POST["QTYTargetPlan"][$i]){
				$year["BgtYear"]				= $_POST["BgtYear"][$i];
				$year["QTYTargetPlan"]		= $_POST["QTYTargetPlan"][$i];
				$this->db->arecSave('tblbudget_longterm_plan_indicator_year',$year);
			}
			if($_POST["QLYTargetPlan"][$i]){
				$year["BgtYear"]				= $_POST["BgtYear"][$i];
				$year["QLYTargetPlan"]		= $_POST["QLYTargetPlan"][$i];
				$this->db->arecSave('tblbudget_longterm_plan_indicator_year',$year);
			}
		}
		LTXT::_( '?mod='.LURL::dotPage("plan_ind_view").'&LPlanCode='.$_POST["LPlanCode"].'&LindId='.$_POST["LindId"], 'redirect' );
	}
	
	function SaveIndYear(){ 
		//ltxt::print_r($_POST);
		//$this->db->debug(2);
		$_POST["LindId"] = $this->db->arecSave('tblbudget_longterm_plan_indicator',$_POST);
		$sql = "DELETE FROM tblbudget_longterm_plan_indicator_year where LindCode = '".$_POST["LindCode"]." ' ";
		$this->db->Execute($sql);
		$year["LindCode"]	= $_POST["LindCode"];	
		$year["CreateBy"]		= $_POST["CreateBy"];
		$year["CreateDate"]	= $_POST["CreateDate"];				
		for($i=0;$i<count($_POST["BgtYear"]);$i++){
			if($_POST["QTYTargetPlan"][$i]){
				$year["BgtYear"]				= $_POST["BgtYear"][$i];
				$year["QTYTargetPlan"]		= $_POST["QTYTargetPlan"][$i];
				$this->db->arecSave('tblbudget_longterm_plan_indicator_year',$year);
			}
			if($_POST["QLYTargetPlan"][$i]){
				$year["BgtYear"]				= $_POST["BgtYear"][$i];
				$year["QLYTargetPlan"]		= $_POST["QLYTargetPlan"][$i];
				$this->db->arecSave('tblbudget_longterm_plan_indicator_year',$year);
			}
		}
		LTXT::_( '?mod='.LURL::dotPage("plan_list").'&PLongCode='.$_POST["PLongCode"], 'redirect' );
	}
	
	
		
}
?>