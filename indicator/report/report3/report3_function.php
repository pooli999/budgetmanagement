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
		ltxt::print_r($_POST);
		$this->db->debug(2);
		if($pk = $this->db->arecSave('tblbudget_project_activity_result',$_POST)){
			
			$_POST['ResultId']=$pk;
			
			$ArrDoc = explode(",",$_POST["MultiDocId"]);
			$sql = "DELETE FROM tblbudget_project_activity_report3_file where ResultId = ".$_POST["ResultId"]."  ";
			$this->db->Execute($sql);
			// Add Files
			foreach($ArrDoc as $val){
				if($val != 0){
					$Data["ResultId"] = $_POST['ResultId'];
					$Data["DocId"] = $val;
					$Data["CreateBy"] = $_POST["CreateBy"];
					$Data["CreateDate"] = date("Y-m-d H:i:s");
					$Data["UpdateBy"] = $_POST["UpdateBy"];				
					$this->db->arecSave('tblbudget_project_activity_report3_file',$Data);
				}
			}
						
		//== Log File ===
			//$PrjName = $this->getPrjName($_POST["PrjId"]);
			//if($ScreenLevel > 0){ $ScreenName = $this->getScreenName($nextScreenLevel);  $txtScreenName =  " --> ".$ScreenName;}  	
			//LogFiles::SaveLog("บันทึกผลการดำเนินโครงการ","บันทึกผลการดำเนินโครงการ",$_POST['ResultId'],"บันทึกผลการดำเนินโครงการ".$PrjName." ปี ".$_POST["BgtYear"]."  รหัสหน่วยงาน  ".$_POST["OrgCode"]);
			//============					
						
						
			LTXT::_( '?mod='.LURL::dotPage('report3_projectmonth').'&PrjDetailId='.$_POST["PrjDetailId"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}		

	}
	
	function SavePrj(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		if($_POST['PrjResultId'] = $this->db->arecSave('tblbudget_project_result',$_POST)){
			$ArrDoc = explode(",",$_POST["MultiDocId"]);
			$sql = "DELETE FROM tblbudget_project_report3_file where PrjResultId = ".$_POST["PrjResultId"]."  ";
			$this->db->Execute($sql);
			// Add Files
			foreach($ArrDoc as $val){
				if($val != 0){
					$Data["PrjResultId"] = $_POST['PrjResultId'];
					$Data["DocId"] = $val;
					$Data["CreateBy"] = $_POST["CreateBy"];
					$Data["CreateDate"] = date("Y-m-d H:i:s");
					$Data["UpdateBy"] = $_POST["UpdateBy"];				
					$this->db->arecSave('tblbudget_project_report3_file',$Data);
				}
			}
			LTXT::_( '?mod='.LURL::dotPage('report3_projectmonth').'&PrjDetailId='.$_POST["PrjDetailId"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}		

	}



	function Delete(){		
		$sql = "delete from tblbudget_project_activity_report3_file where ResultId = ".$_REQUEST["ResultId"]." ";
		$this->db->Execute($sql);
		
		$sql = "delete from tblbudget_project_activity_result where ResultId = ".$_REQUEST["ResultId"]." ";
		$this->db->Execute($sql);
		
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&PrjId='.$_POST["PrjId"].'&PrjActId='.$_POST["PrjActId"].'&PrjDetailId='.$_POST["PrjDetailId"].'&OrgCode='.$_POST["OrgCode"].'&BgtYear='.$_POST["BgtYear"], 'redirect' );
	}
	
	function SaveProjectIndMonth(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		$sql = "DELETE FROM tblbudget_project_indicator_month_result where PrjIndId = '".$_POST["PrjIndId"]." ' ";
		$this->db->Execute($sql);
		$month["PrjIndId"]		= $_POST["PrjIndId"];	
		$month["IndicatorCode"]	= $_POST["IndicatorCode"];	
		$month["CreateBy"]		= $_POST["CreateBy"];
		$month["CreateDate"]	= $_POST["CreateDate"];				
		for($i=1;$i<=12;$i++){
			if($_POST["CriterionType"]=="quantity"){
				$month["MonthNo"]				= $i;
				$month["MTargetScore"] = $this->getCalQTScore($_POST["PrjIndId"],$_POST["QTMTargetResult"][$i]);
				$month["QTMTargetResult"]		= $_POST["QTMTargetResult"][$i];
				$this->db->arecSave('tblbudget_project_indicator_month_result',$month);
			}
			if($_POST["CriterionType"]=="quality"){
				$month["MonthNo"]				= $i;
				$month["MTargetScore"] = $this->getCalQLScore($_POST["PrjIndId"],$_POST["QLMTargetResult"][$i]);
				$month["QLMTargetResult"]		= $_POST["QLMTargetResult"][$i];
				$this->db->arecSave('tblbudget_project_indicator_month_result',$month);
			}
		}
		if($_POST["CriterionType"]=="quantity"){
			$data = $this->getMaxQTMTargetResult($_POST["IndicatorCode"]);
			$sql2 = "Update tblbudget_project_indicator set QTTGResult='".$data[0]->QTMTargetResult."', TGScore='".$data[0]->MTargetScore."' where IndicatorCode = '".$_POST["IndicatorCode"]." ' ";
			$this->db->Execute($sql2);
		}
		if($_POST["CriterionType"]=="quality"){
			$data = $this->getMaxQLMTargetResult($_POST["IndicatorCode"]);
			$sql2 = "Update tblbudget_project_indicator set QLTGResult='".$data[0]->QLMTargetResult."', TGScore='".$data[0]->MTargetScore."' where IndicatorCode = '".$_POST["IndicatorCode"]." ' ";
			$this->db->Execute($sql2);
		}
		LTXT::_( '?mod='.LURL::dotPage('report3_projectmonth').'&PrjDetailId='.$_POST["PrjDetailId"],'redirect' );
	}
	
	function SaveIndMonth(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		for($i=1;$i<=12;$i++){
			if($_POST["CriterionType"]=="quantity"){
				$_POST["MTargetScore"] = $this->getCalQTScore($_POST["PIndId"],$_POST["QTMTargetResult"][$i]);//echo "MTargetScore->".$_POST["MTargetScore"]."<br>";
				$sql = "Update tblbudget_init_plan_item_indicator_month set QTMTargetResult='".$_POST["QTMTargetResult"][$i]."', MTargetScore='".$_POST["MTargetScore"]."', UpdateBy='".$_POST["UpdateBy"]."', UpdateDate='".$_POST["UpdateDate"]."' where MonthNo='".$i."' and PIndCode = '".$_POST["PIndCode"]." ' ";
				$this->db->Execute($sql);
			}
			if($_POST["CriterionType"]=="quality"){
				$_POST["MTargetScore"] = $this->getCalQLScore($_POST["PIndId"],$_POST["QLMTargetResult"][$i]);//echo "MTargetScore->".$_POST["MTargetScore"]."<br>";
				$sql = "Update tblbudget_init_plan_item_indicator_month set QLMTargetResult='".$_POST["QLMTargetResult"][$i]."', MTargetScore='".$_POST["MTargetScore"]."', UpdateBy='".$_POST["UpdateBy"]."', UpdateDate='".$_POST["UpdateDate"]."' where MonthNo='".$i."' and PIndCode = '".$_POST["PIndCode"]." ' ";
				$this->db->Execute($sql);
			}
		}
		if($_POST["CriterionType"]=="quantity"){
			$data = $this->getMaxPIndQTTGResult($_POST["PIndCode"]);
			$sql2 = "Update tblbudget_init_plan_item_indicator set PIndQTTGResult='".$data[0]->QTMTargetResult."', PIndTGScore='".$data[0]->MTargetScore."' where PIndId = '".$_POST["PIndId"]." ' ";
			$this->db->Execute($sql2);
		}
		if($_POST["CriterionType"]=="quality"){
			$data = $this->getMaxPIndQLTGResult($_POST["PIndCode"]);
			$sql2 = "Update tblbudget_init_plan_item_indicator set PIndQLTGResult='".$data[0]->QLMTargetResult."', PIndTGScore='".$data[0]->MTargetScore."' where PIndId = '".$_POST["PIndId"]." ' ";
			$this->db->Execute($sql2);
		}
		LTXT::_( '?mod='.LURL::dotPage("report3_planmonth").'&PItemCode='.$_POST["PItemCode"], 'redirect' );
	}




}

?>