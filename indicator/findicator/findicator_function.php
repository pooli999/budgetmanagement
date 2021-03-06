<?php       
include("config.php");
include($KeyPage."_helper.php");
class sFunction extends sHelper{
	var $RedirectPage;
	var $PathUpload;
	//  Not Remove  //
	function RedirectPage($RPage){
		$this->RedirectPage = $RPage;
	}
	
	function setUploadPath($Path){
		$this->PathUpload = $Path;
	}
	
	function Reload($redirect_page){		
		LTXT::_( $redirect_page, 'redirect' );
	}
	
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
		
		$data["MonthNo"] = $_POST["MonthNo"];			
		for($i=0;$i<count($_POST["PrjIndId"]);$i++){
			if($_POST["PrjIndResultId"][$i]){
				$data["PrjIndResultId"]		= $_POST["PrjIndResultId"][$i];
				$data["UpdateBy"]		= $_POST["UpdateBy"];
				$data["UpdateDate"]	= $_POST["UpdateDate"];	
			}else{
				unset($data["PrjIndResultId"]);
				$data["CreateBy"]		= $_POST["CreateBy"];
				$data["CreateDate"]	= $_POST["CreateDate"];	
			}
			$data["IndicatorCode"]				= $_POST["IndicatorCode"][$i];
			$data["MonthTargetResult"]		= $_POST["MonthTargetResult"][$i];
			
			$indicator = $this->getProjectIndicator(0,$_POST["PrjIndId"][$i]);
			foreach($indicator as $r_indicator){
				foreach($r_indicator as $m=>$p){
					${$m} = $p;
				}
			}
			if(($data["MonthTargetResult"] >= $MinScore0)&&($data["MonthTargetResult"] <= $MaxScore0)){
				
				$data["MonthTargetScore"] = 0;
				
			}else if(($data["MonthTargetResult"] >= $MinScore1)&&($data["MonthTargetResult"] <= $MaxScore1)){
				
				$data["MonthTargetScore"] = 1;
				
			}else if(($data["MonthTargetResult"] >= $MinScore2)&&($data["MonthTargetResult"] <= $MaxScore2)){
				
				$data["MonthTargetScore"] = 2;
				
			}else if(($data["MonthTargetResult"] >= $MinScore3)&&($data["MonthTargetResult"] <= $MaxScore3)){
				
				$data["MonthTargetScore"] = 3;
				
			}else if(($data["MonthTargetResult"] >= $MinScore4)&&($data["MonthTargetResult"] <= $MaxScore4)){
				
				$data["MonthTargetScore"] = 4;
				
			}else if(($data["MonthTargetResult"] >= $MinScore5)&&($data["MonthTargetResult"] <= $MaxScore5)){
				
				$data["MonthTargetScore"] = 5;
				
			}
			$this->db->arecSave('tblbudget_project_findicator_month_result',$data);
		}
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );

	}
	/*End*/
	
	function SavePlan(){
		
		ltxt::print_r($_POST);
		$this->db->debug(2);
		
		$data["MonthNo"] = $_POST["MonthNo"];			
		for($i=0;$i<count($_POST["PIndId"]);$i++){
			if($_POST["IndMonthId"][$i]){
				$data["IndMonthId"]		= $_POST["IndMonthId"][$i];
				$data["UpdateBy"]		= $_POST["UpdateBy"];
				$data["UpdateDate"]	= $_POST["UpdateDate"];	
			}else{
				unset($data["IndMonthId"]);
				$data["CreateBy"]		= $_POST["CreateBy"];
				$data["CreateDate"]	= $_POST["CreateDate"];	
			}
			$data["PIndCode"]				= $_POST["PIndCode"][$i];
			$data["MonthTargetResult"]		= $_POST["MonthTargetResult"][$i];
			
			$indicator = $this->getPlanIndicator(0,$_POST["PIndId"][$i]);
			foreach($indicator as $r_indicator){
				foreach($r_indicator as $m=>$p){
					${$m} = $p;
				}
			}
			if(($data["MonthTargetResult"] >= $MinScore0)&&($data["MonthTargetResult"] <= $MaxScore0)){
				
				$data["MonthTargetScore"] = 0;
				
			}else if(($data["MonthTargetResult"] >= $MinScore1)&&($data["MonthTargetResult"] <= $MaxScore1)){
				
				$data["MonthTargetScore"] = 1;
				
			}else if(($data["MonthTargetResult"] >= $MinScore2)&&($data["MonthTargetResult"] <= $MaxScore2)){
				
				$data["MonthTargetScore"] = 2;
				
			}else if(($data["MonthTargetResult"] >= $MinScore3)&&($data["MonthTargetResult"] <= $MaxScore3)){
				
				$data["MonthTargetScore"] = 3;
				
			}else if(($data["MonthTargetResult"] >= $MinScore4)&&($data["MonthTargetResult"] <= $MaxScore4)){
				
				$data["MonthTargetScore"] = 4;
				
			}else if(($data["MonthTargetResult"] >= $MinScore5)&&($data["MonthTargetResult"] <= $MaxScore5)){
				
				$data["MonthTargetScore"] = 5;
				
			}
			$this->db->arecSave('tblbudget_init_plan_item_findicator_month',$data);
		}
		LTXT::_( '?mod='.LURL::dotPage('findicator_plan_list'), 'redirect' );

	}
	/*End*/
	
	function SaveLongPlan(){
		
		ltxt::print_r($_POST);
		$this->db->debug(2);
		
		$data["BgtYear"] = $_POST["BgtYear"];			
		for($i=0;$i<count($_POST["LindId"]);$i++){
			if($_POST["LIndMonthId"][$i]){
				$data["LIndMonthId"]		= $_POST["LIndMonthId"][$i];
				$data["UpdateBy"]		= $_POST["UpdateBy"];
				$data["UpdateDate"]	= $_POST["UpdateDate"];	
			}else{
				unset($data["LIndMonthId"]);
				$data["CreateBy"]		= $_POST["CreateBy"];
				$data["CreateDate"]	= $_POST["CreateDate"];	
			}
			$data["LindCode"]				= $_POST["LindCode"][$i];
			$data["YearTargetResult"]		= $_POST["YearTargetResult"][$i];
			
			unset($data["YearTargetScore"]);
			$indicator = $this->getLongPlanIndicator(0,$_POST["LindId"][$i]);
			foreach($indicator as $r_indicator){
				foreach($r_indicator as $m=>$p){
					${$m} = $p;
				}
			}
			if(($data["YearTargetResult"] >= $MinScore0)&&($data["YearTargetResult"] <= $MaxScore0)){
				
				$data["YearTargetScore"] = 0;
				
			}else if(($data["YearTargetResult"] >= $MinScore1)&&($data["YearTargetResult"] <= $MaxScore1)){
				
				$data["YearTargetScore"] = 1;
				
			}else if(($data["YearTargetResult"] >= $MinScore2)&&($data["YearTargetResult"] <= $MaxScore2)){
				
				$data["YearTargetScore"] = 2;
				
			}else if(($data["YearTargetResult"] >= $MinScore3)&&($data["YearTargetResult"] <= $MaxScore3)){
				
				$data["YearTargetScore"] = 3;
				
			}else if(($data["YearTargetResult"] >= $MinScore4)&&($data["YearTargetResult"] <= $MaxScore4)){
				
				$data["YearTargetScore"] = 4;
				
			}else if(($data["YearTargetResult"] >= $MinScore5)&&($data["YearTargetResult"] <= $MaxScore5)){
				
				$data["YearTargetScore"] = 5;
				
			}
			$this->db->arecSave('tblbudget_longterm_plan_findicator_year',$data);
		}
		LTXT::_( '?mod='.LURL::dotPage('findicator_longplan_list').'&PLongCode='.$_POST["PLongCode"], 'redirect' );

	}
	/*End*/

	
	
	
		
}
?>