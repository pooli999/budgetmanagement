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
	Description		: เปลี่ยนสถานะนโยบายแผนงานประมาณเป็น แสดง หรือไม่แสดง
	Parameter		: -
	Return Value 	: -
	*/	
/*	function changeStatus()
	{
		if($_REQUEST['EnableStatus'] == 1){
			$_REQUEST['EnableStatus']='Y'; $Str = 'แสดง';
		}else{
			$_REQUEST['EnableStatus']='N'; $Str = 'ไม่แสดง';
		}
		
		$Topic = $this->getPGroupName($_REQUEST["PGroupId"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","เปลี่ยนสถานะข้อมูลพื้นฐานในส่วนของนโยบายแผนงานประมาณเป็น ".$Str,$_REQUEST["PGroupId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_init_plan_group',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}*/
	/*End*/
		
		
	/* 
	Function Name: GenCode 
	Description		: รัน PItemCode Auto
	Parameter		: -
	Return Value 	: -
	*/			
	function  genCode($BgtYear,$PGroupId,$AutoNum){
		$SubYear = substr($BgtYear,2,2);	//echo "SubYear=".$SubYear;
		if(strlen($AutoNum) == 1){
			$AutoNum = "0".$AutoNum; 
		}
		$PGroupCode = $this->getPGroupCode($PGroupId);
		$Code = $SubYear.$PGroupCode.$AutoNum;	//echo "Code=".$Code;
		
		return $Code;
	}
	/*End*/
		
	/* 
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข นโยบายแผนงานประมาณย่อย
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		
		ltxt::print_r($_POST);
		$this->db->debug(2);
		if(($_POST["PItemId"] != "" && $_POST["NewGen"] == "Y") || $_POST["PItemId"] == ""){
			$_POST["AutoNum"] = $this->getPItemCode($_POST["BgtYear"],$_POST["PGroupId"]);
			$genPItemCode = $this->genCode($_POST["BgtYear"],$_POST["PGroupId"],$_POST["AutoNum"]); 
			$_POST["PItemCode"] = $genPItemCode;
			//echo "genPItemCode=".$genPItemCode;
		}
		
		if($pk = $this->db->arecSave('tblbudget_init_plan_item',$_POST)){			
		
			$sql = "DELETE FROM tblbudget_plan_select where PItemId = ".$_POST["PItemId"]."  ";
			$this->db->Execute($sql);
			
			$Animal = $this->getPlanLongterm();
			$t=0;
			$Datat = array();
			foreach($Animal as $v){
				
				if( $_POST["PLongCode"][$t]){
				
					$Datat["PItemId"] = $pk;								
					$Datat['PLongCode'] = $_POST["PLongCode"][$t];
					$Datat["UpdateBy"] = $_POST["UpdateBy"];
					$Datat["CreateBy"] = $_POST["CreateBy"];
					$Datat["CreateDate"] = $_POST["CreateDate"];
					
					$this->db->arecSave('tblbudget_plan_select',$Datat);
				
				}
				
				$t++;
			}	
			
			$sql = "DELETE FROM tblbudget_init_plan_item_purpose where PItemCode = '".$_POST["PItemCode"]."'  ";
			$this->db->Execute($sql);
			$data["PItemCode"]	= $_POST["PItemCode"];	
			$data["CreateBy"]		= $_POST["CreateBy"];
			$data["CreateDate"]	= $_POST["CreateDate"];				
			for($i=0;$i<count($_POST["PurposeName"]);$i++){
				$data["PurposeName"]		= $_POST["PurposeName"][$i];
				$PurposeId = $this->db->arecSave('tblbudget_init_plan_item_purpose',$data);
				
				$sql = "Update tblbudget_init_plan_item_purpose set PurposeCode='".$PurposeId."' where PurposeId = ".$PurposeId."";
				$this->db->Execute($sql);
			}
			
			
			if($_POST["PItemId"]=='')
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มข้อมูลพื้นฐานในส่วนของนโยบายแผนงานย่อย",$pk,$_REQUEST["PItemName"]);
			else
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขข้อมูลข้อมูลพื้นฐานในส่วนของนโยบายแผนงานย่อย",$pk,$_REQUEST["PItemName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}
	
	
	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบนโยบายแผนงานประมาณย่อย
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = $this->getItemName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลพื้นฐานในส่วนของนโยบายแผนงานย่อย",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_init_plan_item set DeleteStatus='Y' where PItemId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
	}
	/*End*/
	
	/* 
	START #F4
	Function Name: SaveOrder 
	Description		: เรียงลำดับตัวชี้วัดรายการนโยบายแผนงานประมาณ
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
					$sql = "Update tblbudget_init_plan_item_indicator set Ordering='$i'  where PIndId = '".$id."'  and  PItemId= '".$_REQUEST["PItemId"]."'  ";
					//echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	

		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"].'&PGroupId='.$_REQUEST["PGroupId"].'&PItemId='.$_REQUEST["PItemId"], 'redirect' );
			
	}
	/*End*/
	
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
		if($_POST["PIndId"]==''){
			$_POST["Running"] = $this->getLastRunningNo($_POST["PItemCode"]);
			$BG = substr($_POST["BgtYear"], -2); 
			$Number = sprintf("%02s",$_POST["Running"]);
			$_POST["PIndCode"] = $_POST["LPlanCode"].$BG."-K".$Number;
		}
		if($_POST["PIndId"] = $this->db->arecSave('tblbudget_init_plan_item_indicator',$_POST)){	
			$sql = "DELETE FROM tblbudget_init_plan_item_indicator_person where PIndCode = '".$_POST["PIndCode"]." ' ";
			$this->db->Execute($sql);
			$person["PIndCode"]		= $_POST["PIndCode"];	
			$person["CreateBy"]		= $_POST["CreateBy"];
			$person["CreateDate"]	= $_POST["CreateDate"];				
			for($i=0;$i<count($_POST["PersonalSelect"]);$i++){
				$person["PersonalCode"]		= $_POST["PersonalSelect"][$i];
				$this->db->arecSave('tblbudget_init_plan_item_indicator_person',$person);
			}
			//save แจกแจงเดือน
			$sql = "DELETE FROM tblbudget_init_plan_item_indicator_month where PIndCode = '".$_POST["PIndCode"]." ' ";
			$this->db->Execute($sql);
			$month["PIndCode"]		= $_POST["PIndCode"];	
			$month["CreateBy"]		= $_POST["CreateBy"];
			$month["CreateDate"]	= $_POST["CreateDate"];				
			for($i=1;$i<=12;$i++){
				if($_POST["QTMTargetPlan"][$i]){
					$month["MonthNo"]				= $i;
					$month["QTMTargetPlan"]		= $_POST["QTMTargetPlan"][$i];
					$this->db->arecSave('tblbudget_init_plan_item_indicator_month',$month);
				}
				if($_POST["QLMTargetPlan"][$i]){
					$month["MonthNo"]				= $i;
					$month["QLMTargetPlan"]		= $_POST["QLMTargetPlan"][$i];
					$this->db->arecSave('tblbudget_init_plan_item_indicator_month',$month);
				}
			}
			LTXT::_( '?mod='.LURL::dotPage("policy_ind_view").'&PItemId='.$_POST["PItemId"].'&PIndId='.$_POST["PIndId"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	
	function SaveIndMonth(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		$_POST["PIndId"] = $this->db->arecSave('tblbudget_init_plan_item_indicator',$_POST);
		$sql = "DELETE FROM tblbudget_init_plan_item_indicator_month where PIndCode = '".$_POST["PIndCode"]." ' ";
		$this->db->Execute($sql);
		$month["PIndCode"]		= $_POST["PIndCode"];	
		$month["CreateBy"]		= $_POST["CreateBy"];
		$month["CreateDate"]	= $_POST["CreateDate"];				
		for($i=1;$i<=12;$i++){
			if($_POST["QTMTargetPlan"][$i]){
				$month["MonthNo"]				= $i;
				$month["QTMTargetPlan"]		= $_POST["QTMTargetPlan"][$i];
				$this->db->arecSave('tblbudget_init_plan_item_indicator_month',$month);
			}
			if($_POST["QLMTargetPlan"][$i]){
				$month["MonthNo"]				= $i;
				$month["QLMTargetPlan"]		= $_POST["QLMTargetPlan"][$i];
				$this->db->arecSave('tblbudget_init_plan_item_indicator_month',$month);
			}
		}
		LTXT::_( '?mod='.LURL::dotPage("policy_list").'&BgtYear='.$_POST["BgtYear"], 'redirect' );
	}
	
	
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข ตัวชี้วัดนโยบายแผนงานประมาณ
	Parameter		: -
	Return Value 	: -
	*/	
	function SaveIndxx(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		if($pk = $this->db->arecSave('tblbudget_init_plan_item_indicator',$_POST)){	
		
			$sql = "DELETE FROM tblbudget_init_plan_item_indicator_person where PIndCode = '".$_POST["PIndCode"]." ' ";
			$this->db->Execute($sql);
			$person["PIndCode"]		= $_POST["PIndCode"];	
			$person["CreateBy"]		= $_POST["CreateBy"];
			$person["CreateDate"]	= $_POST["CreateDate"];				
			for($i=0;$i<count($_POST["PersonalSelect"]);$i++){
				$person["PersonalCode"]		= $_POST["PersonalSelect"][$i];
				$this->db->arecSave('tblbudget_init_plan_item_indicator_person',$person);
			}
			
			$sql = "DELETE FROM tblbudget_init_plan_item_indicator_month where PIndCode = '".$_POST["PIndCode"]." ' ";
			$this->db->Execute($sql);
			$month["PIndCode"]		= $_POST["PIndCode"];	
			$month["CreateBy"]		= $_POST["CreateBy"];
			$month["CreateDate"]	= $_POST["CreateDate"];				
			for($i=1;$i<=12;$i++){
				if($_POST["MonthTargetPlan"][$i]){
					$month["MonthNo"]				= $i;
					$month["MonthTargetPlan"]		= $_POST["MonthTargetPlan"][$i];
					$this->db->arecSave('tblbudget_init_plan_item_indicator_month',$month);
				}
			}
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"].'&start='.$_REQUEST["start"], 'redirect' );
		
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/	
	
	
	/* 
	START #F
	Function Name: DeleteInd 
	Description		: ลบตัวชี้วัดนโยบายแผนงานประมาณ
	Parameter		: -
	Return Value 	: -
	*/	
	function DeleteInd(){
		$Topic = $this->getIndicatorName($_REQUEST["PIndId"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลพื้นฐานในส่วนของตัวชี้วัดรายการนโยบายแผนงาน",$_REQUEST["PIndId"],$Topic);
		
		$sql = "Delete FROM tblbudget_init_plan_item_indicator  where PIndId = ".$_REQUEST["PIndId"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"].'&PGroupId='.$_REQUEST["PGroupId"].'&PItemId='.$_REQUEST["PItemId"], 'redirect' );
		
	}
	/*End*/
		
		
}
?>