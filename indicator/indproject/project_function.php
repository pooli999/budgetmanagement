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
		LTXT::_( '?mod='.LURL::dotPage('project_list').'&BgtYear='.$_POST["BgtYear"],'redirect' );
	}
	
			
			
}// end class

?>