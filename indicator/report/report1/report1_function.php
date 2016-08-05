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

	function SaveIndYear(){ 
		ltxt::print_r($_POST);
		$this->db->debug(2);
		for($i=0;$i<count($_POST["BgtYear"]);$i++){
			if($_POST["CriterionType"]=="quantity"){
				$_POST["YTargetScore"] = $this->getCalQTScore($_POST["LindId"],$_POST["QTYTargetResult"][$i]);
				$sql = "Update tblbudget_longterm_plan_indicator_year set QTYTargetResult='".$_POST["QTYTargetResult"][$i]."', YTargetScore='".$_POST["YTargetScore"]."', UpdateBy='".$_POST["UpdateBy"]."', UpdateDate='".$_POST["UpdateDate"]."' where BgtYear='".$_POST["BgtYear"][$i]."' and LindCode = '".$_POST["LindCode"]." ' ";
				$this->db->Execute($sql);
				/*$data = $this->getMaxLindQTTGResult($_POST["BgtYear"][$i],$_POST["LindCode"]);
				$sql2 = "Update tblbudget_longterm_plan_indicator set LindQTTGResult='".$data[0]->QTYTargetResult."', LindTGScore='".$data[0]->YTargetScore."' where LindId = '".$_POST["LindId"]." ' ";
				$this->db->Execute($sql2);*/
				
			}
			if($_POST["CriterionType"]=="quality"){
				$_POST["YTargetScore"] = $this->getCalQLScore($_POST["LindId"],$_POST["QLYTargetResult"][$i]);
				$sql = "Update tblbudget_longterm_plan_indicator_year set QLYTargetResult='".$_POST["QLYTargetResult"][$i]."', YTargetScore='".$_POST["YTargetScore"]."', UpdateBy='".$_POST["UpdateBy"]."', UpdateDate='".$_POST["UpdateDate"]."' where BgtYear='".$_POST["BgtYear"][$i]."' and LindCode = '".$_POST["LindCode"]." ' ";
				$this->db->Execute($sql);
				/*$data = $this->getMaxLindQLTGResult($_POST["BgtYear"][$i],$_POST["LindCode"]);
				$sql2 = "Update tblbudget_longterm_plan_indicator set LindQLTGResult='".$data[0]->QLYTargetResult."', LindTGScore='".$data[0]->YTargetScore."' where LindId = '".$_POST["LindId"]." ' ";
				$this->db->Execute($sql2);*/
				
			}
		}
		if($_POST["CriterionType"]=="quantity"){
			$data = $this->getMaxLindQTTGResult($_POST["LindCode"]);
			$sql2 = "Update tblbudget_longterm_plan_indicator set LindQTTGResult='".$data[0]->QTYTargetResult."', LindTGScore='".$data[0]->YTargetScore."' where LindId = '".$_POST["LindId"]." ' ";
			$this->db->Execute($sql2);
		}
		if($_POST["CriterionType"]=="quality"){
			$data = $this->getMaxLindQLTGResult($_POST["LindCode"]);
			$sql2 = "Update tblbudget_longterm_plan_indicator set LindQLTGResult='".$data[0]->QLYTargetResult."', LindTGScore='".$data[0]->YTargetScore."' where LindId = '".$_POST["LindId"]." ' ";
			$this->db->Execute($sql2);
		}
		LTXT::_( '?mod='.LURL::dotPage("report1_list").'&PLongCode='.$_POST["PLongCode"], 'redirect' );
	}
	
	
		
}
?>