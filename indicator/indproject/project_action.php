<?php
include("config.php");
include($KeyPage."_function.php");
if($action = ltxt::getVar( 'action','req' )) {

	$tsk = new sFunction();
	switch( strtolower($action) ) {
		case "reloadpage":
			if($_REQUEST["redirect_page"] != '') $rpage = $_REQUEST["redirect_page"];
			else $rpage = lurl::dotPage($listPage);
			$tsk->Reload($rpage);
		break;
		
		case "changestatus":
			$tsk->RedirectPage($listPage);
			$tsk->changeStatus();
		break;
		
		case "save":
			$tsk->RedirectPage	($ListEditPage);
			$tsk->Save();
		break;
		
		case "sent":
			$tsk->RedirectPage	($ListEditPage);
			$tsk->Sent();
		break;
		
		case "delete":
			$tsk->RedirectPage	($ListEditPage);
			$tsk->Delete();
		break;
		
		case "cancel":
			$tsk->RedirectPage	($ListEditPage);
			$tsk->Cancel();
		break;

		case "savecostin":
			$tsk->RedirectPage($ListViewCost);
			$tsk->saveCostInternal();
		break;

		case "saveparty":
			$tsk->RedirectPage($partyListPage);
			$tsk->saveParty();
		break;
		
		case "savecostex":
			$tsk->RedirectPage($ListViewCostEx);
			$tsk->saveCostExternal();
		break;

		case "savecostmonth":
			$tsk->RedirectPage($ListViewCostMonth);
			$tsk->saveCostMonth();
		break;

		case "savecostmonthex":
			$tsk->RedirectPage($ListViewCostMonthEx);
			$tsk->saveCostMonthEx();
		break;
		
		case "saveprojectind":
			$tsk->SaveProjectInd();
		break;
		
		case "saveprojectindmonth":
			$tsk->SaveProjectIndMonth();
		break;
		
		case "saveind":
			$tsk->RedirectPage($ViewInd);
			$tsk->SaveInd();
		break;

		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;	
		
		case 'getImport' :
			$Import = ltxt::getVar($Import);
			include_once $Import.'.php' ;
			exit ;
		break ;
			
		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;
		
		case "getOrganizeCode":
			$tsk->getOrganizeCode();
		break;		
		
		case 'pitemlist':
		 	$BgtYear = ltxt::getVar( 'BgtYear','post' );
			echo $tsk->getPlanItemList($BgtYear);
			exit;
		break;	
		
		case 'projectlist':
		 	$PItemCode = ltxt::getVar( 'PItemCode','post' );
			$BgtYear = ltxt::getVar( 'BgtYear','post' );
			$OrganizeCode = ltxt::getVar( 'OrganizeCode','post' );
			$tsk->getProjectList($BgtYear,$PItemCode,$OrganizeCode,'PrjId',0);						
			exit;
		break;		
		
		case 'personlist':
		 	$PrjId = ltxt::getVar( 'PrjId','post' );
			$tsk->getPersonList($PrjId);						
			exit;
		break;		
	
		case 'changetocancel':
		 	$PrjActId = ltxt::getVar( 'PrjActId','post' );
			$tsk->changeToCancel($PrjActId);						
			exit;
		break;		

		case "subgroup":
			$Opt = '';
			$List = $tsk->getSubNetwork($_REQUEST["pid"]);
			if($List){
				foreach($List as $rs){
					$Opt .= '<option value="'.$rs->CatGroupCode.'">'.$rs->CatGroupName.'</option>';
					$SubList = $tsk->getSubNetwork($rs->CatGroupId);
					if($SubList){
						foreach($SubList as $rs2){
							$Opt .= '<option value="'.$rs2->CatGroupCode.'">|--- '.$rs2->CatGroupName.'</option>';
							$SubList2 = $tsk->getSubNetwork($rs2->CatGroupId);
							if($SubList2){
								foreach($SubList2 as $rs3){
									$Opt .= '<option value="'.$rs3->CatGroupCode.'">&nbsp;&nbsp;&nbsp;|--- '.$rs3->CatGroupName.'</option>';
									$SubList3 = $tsk->getSubNetwork($rs3->CatGroupId);
									if($SubList3){
										foreach($SubList3 as $rs4){
											$Opt .= '<option value="'.$rs4->CatGroupCode.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--- '.$rs4->CatGroupName.'</option>';
										}
									}
								}
							}
						}
					}
				}
			}else{
				$Opt = '<option value="-1">ไม่มีรายการย่อย</option>';	
			}
			echo $Opt;
		break;

		case "loadperson":
			$personOpt = '';
			$personList = $tsk->getPartyPerson($_REQUEST["pcode"]);  //ltxt::print_r($personList);
			if($personList){
				foreach($personList as $rs){
					if($rs->PtnFullName){ $PartnerName = $rs->PtnFullName; }else{ $PartnerName = $rs->PositionName.$rs->Under;  }
					$personOpt .= '<option value="'.$rs->PartnerCode.'">'.$PartnerName.'</option>';
				}
			}else{
				$personOpt = '<option value="-1">ไม่มีภาคีเครือข่าย</option>';	
			}
			echo $personOpt;		
		break;
		
		
	}
exit;

}
?>
