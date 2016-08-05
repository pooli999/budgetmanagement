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
			LTXT::_( '?mod='.LURL::dotPage("policy_ind_add_month").'&PItemId='.$_POST["PItemId"].'&PIndId='.$_POST["PIndId"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
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
		LTXT::_( '?mod='.LURL::dotPage("policy_list").'&BgtYear='.$_POST["BgtYear"], 'redirect' );
	}
	
		
}
?>