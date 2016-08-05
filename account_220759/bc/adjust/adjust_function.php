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
		ltxt::print_r($_REQUEST);
		$nextScreenLevel = $_REQUEST["ScreenLevel"]+1;echo  $nextScreenLevel;
		$nextSCTypeId = $this->getNextSCTypeID($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"]);echo $nextSCTypeId;
		
		// โครงการ
		$ListPrj = $this->getPrjList($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		//ltxt::print_r($ListPrj);

		foreach($ListPrj as $r){
			foreach($r as $k=>$v){ ${$k} = $v;}

				$Data["PrjId"] = $PrjId;
				$Data["PrjCode"] = $PrjCode;
				$Data["StartDate"] = $StartDate;
				$Data["EndDate"] = $EndDate;
				$Data["Telephone"] = $Telephone;
				$Data["Fax"] = $Fax;
				$Data["Email"] = $Email;
				$Data["Principles"] = $Principles;
				$Data["Purpose"] = $Purpose;
				$Data["Indicator"] = $Indicator;
				$Data["Outputs"] = $Outputs;
				$Data["StatusId"] = "1";
				$Data["DetailIdRefer"] = $DetailIdRefer;
				$Data["SCTypeId"] = $nextSCTypeId;
				$Data["ScreenLevel"] = $nextScreenLevel;
				$Data["ActiveStatus"] = "Y";
				$Data["UpdateDate"] = $UpdateDate;
				$Data["UpdateBy"] = $UpdateBy;
				$Data["CreateDate"] = $CreateDate;
				$Data["CreateBy"] = $CreateBy;	
	
				$pkPrj = $this->db->arecSave("tblbudget_project_detail",$Data);
			
				$sql = "update tblbudget_project_detail set ActiveStatus='N'  where  PrjId='$PrjId' and PrjDetailId='$PrjDetailId' and  SCTypeId='".$_POST["SCTypeId"]."'  and ScreenLevel='".$_POST["ScreenLevel"]."'  ";
				$this->db->Execute($sql);		
			
			//ไฟล์แนบ
			$ListPrjFile = $this->getPrjFile($PrjDetailId);
			//ltxt::print_r($ListPrjFile);
			foreach($ListPrjFile as $rFlie){
				foreach($rFlie as $k=>$v){ ${$k} = $v;}
						$DataFile["DocId"] = $DocId;
						$DataFile["PrjDetailId"] = $pkPrj;				
						$DataFile["CreateDate"] = $CreateDate;
						$DataFile["CreateBy"] = $CreateBy;	
						
						//$pkFile = $this->db->arecSave("tblbudget_project_file",$DataFile);				
			}
						
			//ตัวชี้วัดโครงการ
			$ListPrjIndicator = $this->getPrjIndicator($PrjDetailId);
			//ltxt::print_r($ListPrjIndicator);
			foreach($ListPrjIndicator as $rInd){
				foreach($rInd as $k=>$v){ ${$k} = $v;}
						$DataInd["PrjDetailId"] = $pkPrj;	
						$DataInd["IndicatorName"] = $IndicatorName;				
						$DataInd["Value"] = $Value;				
						$DataInd["UnitID"] = $UnitID;		
						$DataInd["IndTypeId"] = $IndTypeId;			
						$DataInd["CreateDate"] = $CreateDate;
						$DataInd["CreateBy"] = $CreateBy;	
						$DataInd["UpdateDate"] = $UpdateDate;
						$DataInd["UpdateBy"] = $UpdateBy;	
						
						$pkInd = $this->db->arecSave("tblbudget_project_indicator",$DataInd);				
			}
				
/*			//ผู้รับผิดชอบโครงการ
			$ListPrjPerson = $this->getPrjPerson($PrjDetailId);
			//ltxt::print_r($ListPrjPerson);
			foreach($ListPrjPerson as $rPer){
				foreach($rPer as $k=>$v){ ${$k} = $v;}
						$DataPer["PrjDetailId"] = $pkPrj;	
						$DataPer["PersonalCode"] = $PersonalCode;							
						$DataPer["CreateDate"] = $CreateDate;
						$DataPer["CreateBy"] = $CreateBy;	
						
						$pkPer = $this->db->arecSave("tblbudget_project_person",$DataPer);					
			}*/

			// กิจกรรม	
			$ListActPrj = $this->getPrjActList($PrjDetailId,$_POST["BgtYear"],$_POST["OrganizeCode"],$_POST["SCTypeId"],$_POST["ScreenLevel"]);
			//ltxt::print_r($ListActPrj);
			foreach($ListActPrj as $rAct){
				foreach($rAct as $k=>$v){ ${$k} = $v;}
				
						$DataAct["PrjActCode"] = $PrjActCode;
						$DataAct["OrganizeCode"] = $OrganizeCode;
						$DataAct["StartDate"] = $StartDate;
						$DataAct["EndDate"] = $EndDate;
						$DataAct["PrjActName"] = $PrjActName;
						$DataAct["PrjDetailId"] = $pkPrj;						
						$DataAct["UpdateDate"] = $UpdateDate;
						$DataAct["UpdateBy"] = $UpdateBy;
						$DataAct["CreateDate"] = $CreateDate;
						$DataAct["CreateBy"] = $CreateBy;	
						
						$pkActPrj = $this->db->arecSave("tblbudget_project_activity",$DataAct);
						
						//ตัวชี้วัดกิจกรรม
						$ListPrjIndicatorAct = $this->getPrjIndicatorAct($PrjActId);
						//ltxt::print_r($ListPrjIndicatorAct);
						foreach($ListPrjIndicatorAct as $rIndAct){
							foreach($rIndAct as $k=>$v){ ${$k} = $v;}
									$DataIndAct["PrjActId"] = $pkActPrj;	
									$DataIndAct["IndicatorName"] = $IndicatorName;				
									$DataIndAct["Value"] = $Value;				
									$DataIndAct["UnitID"] = $UnitID;		
									$DataIndAct["IndTypeId"] = $IndTypeId;				
									$DataIndAct["CreateDate"] = $CreateDate;
									$DataIndAct["CreateBy"] = $CreateBy;	
									$DataIndAct["UpdateDate"] = $UpdateDate;
									$DataIndAct["UpdateBy"] = $UpdateBy;	
									
									$pkIndAct = $this->db->arecSave("tblbudget_project_activity_indicator",$DataIndAct);				
						}	
						
						//ภาคีเครือข่าย
						$PartyList = $this->getPartyListAct($PrjActId);
						//ltxt::print_r($ListPrjIndicatorAct);
						foreach($PartyList as $rPtyAct){
							foreach($rPtyAct as $k=>$v){ ${$k} = $v;}
									$DataPtyAct["PrjActId"] = $pkActPrj;	
									$DataPtyAct["PartnerCode"] = $PartnerCode;				
									$DataPtyAct["CatGroupId"] = $CatGroupId;				
									$DataPtyAct["CatGroupCode"] = $CatGroupCode;				
									$DataPtyAct["CreateDate"] = $CreateDate;
									$DataPtyAct["CreateBy"] = $CreateBy;	
									$DataPtyAct["UpdateDate"] = $UpdateDate;
									$DataPtyAct["UpdateBy"] = $UpdateBy;	
									
									$pkPtyAct = $this->db->arecSave("tblbudget_project_party",$DataPtyAct);				
						}						

						// คูณ 4 ช่อง Internal
						$ListX4InternalPrj = $this->getPrjX4InternalList($PrjActId,$_POST["BgtYear"],$_POST["OrganizeCode"],$_POST["SCTypeId"],$_POST["ScreenLevel"]);
						//ltxt::print_r($ListX4InternalPrj);
						foreach($ListX4InternalPrj as $rX4In){
							foreach($rX4In as $k=>$v){ ${$k} = $v;}

								$DataX4In["CostItemCode"] = $CostItemCode;	
								$DataX4In["Detail"] = $Detail;						
								$DataX4In["Value1"] = $Value1;						
								$DataX4In["Unit1"] = $Unit1;						
								$DataX4In["Value2"] = $Value2;						
								$DataX4In["Unit2"] = $Unit2;						
								$DataX4In["Value3"] = $Value3;						
								$DataX4In["Unit3"] = $Unit3;						
								$DataX4In["Value4"] = $Value4;						
								$DataX4In["Unit4"] = $Unit4;						
								$DataX4In["SumCost"] = $SumCost;						
								$DataX4In["PrjActId"] = $pkActPrj;						
								$DataX4In["UpdateDate"] = $UpdateDate;
								$DataX4In["UpdateBy"] = $UpdateBy;
								$DataX4In["CreateDate"] = $CreateDate;
								$DataX4In["CreateBy"] = $CreateBy;			
													
								$pkX4In = $this->db->arecSave("tblbudget_project_activity_cost_internal",$DataX4In);
							
								// แจกแจงรายเดือน Internal
								$ListInternalMonth = $this->getListInternalMonth($CostIntId,$_POST["BgtYear"],$_POST["OrganizeCode"],$_POST["SCTypeId"],$_POST["ScreenLevel"]);										
								//ltxt::print_r($ListInternalMonth);
								foreach($ListInternalMonth as $rInMonth){
									foreach($rInMonth as $k=>$v){ ${$k} = $v;}
										$DataInMonth["CostIntId"] = $pkX4In;
										$DataInMonth["MonthNo"] = $MonthNo;									
										$DataInMonth["Budget"] = $Budget;
										$DataInMonth["CreateDate"] = $CreateDate;
										$DataInMonth["CreateBy"] = $CreateBy;		
																			
										$this->db->arecSave("tblbudget_project_activity_cost_internal_month",$DataInMonth);
										
										
								}//ListInternalMonth
								
							
						}//ListX4InternalPrj
						

						
						// คูณ 4 ช่อง External
						$ListX4ExternalPrj = $this->getPrjX4ExnternalList($PrjActId,$_POST["BgtYear"],$_POST["OrganizeCode"],$_POST["SCTypeId"],$_POST["ScreenLevel"]);
						//ltxt::print_r($ListX4ExternalPrj);
						foreach($ListX4ExternalPrj as $rX4Ex){
							foreach($rX4Ex as $k=>$v){ ${$k} = $v;}

								$DataX4Ex["SourceExId"] = $SourceExId;	
								$DataX4Ex["CostItemCode"] = $CostItemCode;	
								$DataX4Ex["Detail"] = $Detail;						
								$DataX4Ex["Value1"] = $Value1;						
								$DataX4Ex["Unit1"] = $Unit1;						
								$DataX4Ex["Value2"] = $Value2;						
								$DataX4Ex["Unit2"] = $Unit2;						
								$DataX4Ex["Value3"] = $Value3;						
								$DataX4Ex["Unit3"] = $Unit3;						
								$DataX4Ex["Value4"] = $Value4;						
								$DataX4Ex["Unit4"] = $Unit4;						
								$DataX4Ex["SumCost"] = $SumCost;						
								$DataX4Ex["PrjActId"] =  $pkActPrj;						
								$DataX4Ex["UpdateDate"] = $UpdateDate;
								$DataX4Ex["UpdateBy"] = $UpdateBy;
								$DataX4Ex["CreateDate"] = $CreateDate;
								$DataX4Ex["CreateBy"] = $CreateBy;			
													
								 $pkX4Ex = $this->db->arecSave("tblbudget_project_activity_cost_external",$DataX4Ex);
							
								// แจกแจงรายเดือน Internal
								$ListExternalMonth = $this->getListExternalMonth($CostExtId,$_POST["BgtYear"],$_POST["OrganizeCode"],$_POST["SCTypeId"],$_POST["ScreenLevel"]);										
								//ltxt::print_r($ListExternalMonth);
								foreach($ListExternalMonth as $rExMonth){
									foreach($rExMonth as $k=>$v){ ${$k} = $v;}
										$DataExMonth["CostExtId"] = $pkX4Ex;
										$DataExMonth["MonthNo"] = $MonthNo;									
										$DataExMonth["Budget"] = $Budget;
										$DataExMonth["CreateDate"] = $CreateDate;
										$DataExMonth["CreateBy"] = $CreateBy;		
																			
										$this->db->arecSave("tblbudget_project_activity_cost_external_month",$DataExMonth);
										
										
								}//ListExternalMonth
								
							
						}//ListX4ExternalPrj						
						
	
						
			}//ListActPrj
			
		}  // ListPrj

		
		$sqly = "update tblbudget_init_year_org set SCTypeId='$nextSCTypeId', ScreenLevel='$nextScreenLevel',CloseStep='N'  where  OrganizeCode='".$_POST["OrganizeCode"]."'  and  BgtYear='".$_POST["BgtYear"]."'   ";
		$this->db->Execute($sqly);			
		
		//== Log File ===
		$SCTypeName = $this->getSCTypeName($nextSCTypeId);
		if($ScreenLevel > 0){ $ScreenName = $this->getScreenName($nextScreenLevel);  $txtScreenName =  " --> ".$ScreenName;}  	
		LogFiles::SaveLog("กลั่นกรองงบ/จัดสรรงบ/ทำแผนฯ","ปรับขั้นตอนการจัดทำงบประมาณ",$_POST["BgtYear"],"ปรับขั้นตอนการจัดทำงบประมาณ ปี ".$_POST["BgtYear"]."  รหัสหน่วยงาน  ".$_POST["OrganizeCode"]." เป็น ".$SCTypeName.$txtScreenName);
		//============
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_POST["BgtYear"].'&OrganizeCode='.$_POST["OrganizeCode"], 'redirect' );


	}
	


}

?>