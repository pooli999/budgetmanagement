<?php

class sHelper
{
	var $db;
	var $debug = 0;
	/*
	START #F1
	Function Name		: sHelper
	Description			: เป็นฟังก์ชันสำหรับติดต่อฐานข้อมูล
	Parameter			: -
	Return Value 		: -
	*/
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
	}
	/*END*/

	/*
	START #F2
	Function Name	: getDataList
	Description		: เป็นฟังก์ชันสำหรับดึงรายการสมุดรายวัน
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อสมุดรายวันเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet)
	*/
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="tblbudget_finance_income.DeleteStatus='N'";
		//$where[] ="SendStatus='Y'";

		/*$fn1 = '(select PaymentValue from tblfinance_payment_methods where tblfinance_payment_methods.PaymentId = tblfinance_payment.PaymentId) as pvalue';
		$fn5 = '(select PV from ac_action where ac_action.PaymentId = tblfinance_payment.PaymentId) as PV';
		$fn2 = '(select ChequeMakeDate from tblfinance_payment_methods where tblfinance_payment_methods.PaymentId = tblfinance_payment.PaymentId) as ChequeMakeDate';
		$fn3 = '(select PaymentNumber from tblfinance_payment_methods where tblfinance_payment_methods.PaymentId = tblfinance_payment.PaymentId) as PaymentNumber';
		$fn4 = '(select ChequePayDate from tblfinance_payment_comp where tblfinance_payment_comp.PaymentId = tblfinance_payment.PaymentId) as ChequePayDate';
		$sql="select tblfinance_payment.*,$fn1,$fn2,$fn3,$fn4,$fn5 from tblfinance_payment inner join tblfinance_payment_comp on tblfinance_payment.PaymentId = tblfinance_payment_comp.PaymentId  ".$where_r."  order by tblfinance_payment.PaymentId DESC";*/

		if($_REQUEST["pvsearch"]){
			$where[] = "(tblbudget_finance_income.IncomeId IN(select IncomeId from  ac_action where PV like '%".$_REQUEST["pvsearch"]."%'))";
		}
		if($_REQUEST["tsearch"]){
			$where[] = " PayName like '%".$_REQUEST["tsearch"]."%'";
		}
		if($_REQUEST["descsearch"]){
			$where[] = " IncomeDetailAccount like '%".$_REQUEST["descsearch"]."%'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$fn1 = '(select PV from ac_action where ac_action.IncomeId = tblbudget_finance_income.IncomeId) as PV';
		$sql="select *,$fn1 from tblbudget_finance_income ".$where_r."  order by Ordering desc";
		//echo $sql;

		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/
	function getIncomeType($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

		$sql="SELECT IncomeType as value , IncomeType_Name as text "
			 ."\n FROM tblbudget_finance_income_type "
			 ."\n ".$where_r
			 ."\n order by IncomeType ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "

		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );

}
function getDataList3($PaymentId){
		$where 	  = array();
		//$where[] ="DocStatusId >= 7"; // 7 คืออนุมัติ
		//$where[] ="DeleteStatus='N'";
		$where[] ="PaymentId=".$PaymentId;
		if($_REQUEST["PersonalCode"]){
		//	$where[] = "RQPersonalCode like ('%".$_REQUEST["PersonalCode"]."%')";
		}

		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		//$fn1 = "(select BankName from tblbudget_finance_bank where tblbudget_finance_bank.BankId = tblbudget_finance_bookbank.BankId) as BankName";
		//$fn2 = "(select BookbankType from tblbudget_finance_bookbank_type where tblbudget_finance_bookbank_type.BookbankTypeId = tblbudget_finance_bookbank.BookbankTypeId) as BookbankType";
		$sql="select * from tblfinance_payment_list ".$where_r." ";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$tList2 = $this->db->loadDataSet();
		return $tList2;
	}
	/*
	START #F3
	Function Name: getDetail
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดผังบัญชี
	Parameter		:
		@AcChartId	= ID (PK) ของตาราง ac_chart
	Return Value 	: Array 1 รายการ (loadSingleObject)
	*/
	function getDetail($IncomeId){
		//echo "aa";
		$where 	  = array();
		if($IncomeId){
			$where[] ="tblbudget_finance_income.IncomeId=".$IncomeId;
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		//$fn1 = "(select CONCAT(PtnPrefixTH,PtnFname,' ',PtnSname) from nh_in_partner inner join nh_in_partner_prefix on nh_in_partner.PrefixUid=nh_in_partner_prefix.PrefixUid where nh_in_partner.PartnerCode = tblfinance_payment_comp.PartnerCode) as pname";
		//$sql = "SELECT tblfinance_payment_comp.Tax,tblfinance_payment_comp.TaxW,tblfinance_payment_methods.PaymentType,ac_action.AcActionId,$fn1,tblfinance_payment_comp.CashValue,tblfinance_payment_methods.PaymentValue,tblfinance_payment_methods.PaymentNumber,ac_action.PV, ac_action.ActionDate, ac_action.journalId, ac_action.AcStatus, ac_action.AcDescription,tblfinance_payment_comp.PartnerCode, tblfinance_payment_comp.ChequeOrCash, tblbudget_finance_bank.BankId,  tblbudget_finance_bank.BankName, tblbudget_finance_bookbank.BookbankId, tblbudget_finance_bookbank.BookbankNumber, tblfinance_payment_comp.ChequePayDate FROM tblfinance_payment INNER JOIN tblfinance_payment_comp ON tblfinance_payment.PaymentId = tblfinance_payment_comp.PaymentId INNER JOIN tblfinance_payment_methods ON tblfinance_payment_comp.PaymentCompId = tblfinance_payment_methods.PaymentCompId INNER JOIN tblbudget_finance_bank ON tblfinance_payment_methods.BankId = tblbudget_finance_bank.BankId INNER JOIN tblbudget_finance_bookbank ON tblbudget_finance_bank.BankId = tblbudget_finance_bookbank.BankId left JOIN (ac_action) ON tblfinance_payment.PaymentId = ac_action.PaymentId ".$where_r;
		$fn2 = "(select journalName from ac_journal where ac_journal.journalId = ac_action.journalId) as journalName";
		$sql = "SELECT $fn2,tblbudget_finance_income.*,tblbudget_finance_income_type.*,ac_action.*,tblbudget_finance_income.PartnerCode as pnc FROM (tblbudget_finance_income INNER JOIN tblbudget_finance_income_type ON tblbudget_finance_income.IncomeType = tblbudget_finance_income_type.IncomeType) left JOIN ac_action ON tblbudget_finance_income.IncomeId = ac_action.IncomeId".$where_r;
	//	echo $sql;

		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject();
		return $detail;
	}
	/*END*/
	function findjournalName($journalId){
			$sql = "select journalName from ac_journal where journalId = ".$journalId;
			$this->db->setQuery($sql);
			$journalNam = $this->db->loadResult();
		return $journalNam;
	}
	function getDataList1($PaymentId){
		$where 	  = array();
		$where[] ="tblfinance_payment_list.PaymentId=".$PaymentId;
		$where[] ="tblfinance_payment_list.DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select tblfinance_doccode.formcode,tblfinance_payment_list.PaymentListId
,tblfinance_payment_list.DocCode,tblbudget_project.PrjCode from tblfinance_payment_list inner join tblfinance_doccode on tblfinance_payment_list.DocCode=tblfinance_doccode.DocCode inner join tblbudget_project on tblfinance_doccode.PrjId = tblbudget_project.PrjId ".$where_r." ";
		//echo $sql;
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$tList2 = $this->db->loadDataSet();
		return $tList2;
	}
	function getDataList2($PaymentListId,$formcode){
		$where 	  = array();
		$where[] ="tblfinance_payment_list_detail.PaymentListId=".$PaymentListId;
		$where[] ="tblfinance_payment_list_detail.DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		if ($formcode == "FC002" || $formcode == "FF004A" || $formcode == "FF004B" || $formcode == "FF005A" || $formcode == "FF005B" || $formcode == "FF006A" || $formcode == "FF006B"){
			$tbla = "tblfinance_form_chain_cost";
		}
		if ($formcode == "FP001" || $formcode == "FC001" || $formcode == "FF001" || $formcode == "FF003" || $formcode == "FH001" || $formcode == "FH002" || $formcode == "FP002" || $formcode == "FF002"){
			$tbla = "tblfinance_form_hold_cost";
		}

		if ($formcode == "FF009" || $formcode == "FP003" || $formcode == "FH004" || $formcode == "FP004"){
			$tbla = "tblfinance_form_pay_cost";
		}

		if ($formcode == "FF007" || $formcode == "FF008" || $formcode == "FF010" || $formcode == "FC003"){
			$tbla = "tblfinance_form_paybr_cost";
		}
		$fn1 = "(select CostName from tblbudget_init_cost_item where tblbudget_init_cost_item.CostItemCode = tblfinance_payment_list_detail.CostItemCode) as CostName";
		$fn2 = "(select DetailCost from $tbla where $tbla.DocCode=tblfinance_payment_list_detail.DocCode and $tbla.CostItemCode = tblfinance_payment_list_detail.CostItemCode) as DetailCost";
		$sql="select CastValue,$fn1,$fn2 from tblfinance_payment_list_detail ".$where_r." ";

		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$tList2 = $this->db->loadDataSet();
		return $tList2;
	}

	function findname($ptyep,$PartnerCode){
		if ($ptyep == "1"){// ภานนอก
			$sql = "select nh_in_partner.PtnFname from nh_in_partner where PartnerCode ='".$PartnerCode."'";
			$this->db->setQuery($sql);
			$aname = $this->db->loadResult();
			$sql = "select nh_in_partner.PtnSname from nh_in_partner where PartnerCode ='".$PartnerCode."'";
			$this->db->setQuery($sql);
			$bname = $this->db->loadResult();
		}else{
			$sql = "select tblpersonal.FirstName from tblpersonal where PersonalCode = '".$PartnerCode."'";
			$this->db->setQuery($sql);
			echo $sql;
			$aname = $this->db->loadResult();
			$sql = "select tblpersonal.LastName from tblpersonal where PersonalCode = '".$PartnerCode."'";
			$this->db->setQuery($sql);
			$bname = $this->db->loadResult();
		}

		$pname = $aname." ".$bname;
		return $pname;
	}
	function getLinkPersonal($ActivityId,$ActPerType='inter',$ResultType='rs'){
		$sql = "select * from tblfinance_payment_comp WHERE PaymentId=$PaymentId";
		$this->db->setQuery($sql); //echo $sql;
		$detail = $this->db->loadObjectList();
		if($ResultType=='rs'){
			return $detail;
		}else if($ResultType=='array'){
			$ArrTmp = array();
			foreach($detail as $rs){
				$ArrTmp[] = $rs->PersonalCode;
			}
			return $ArrTmp;
		}else{ // string
			$ArrTmp = array();
			foreach($detail as $rs){
				$ArrTmp[] = $rs->PersonalCode;
			}
			return implode(",",$ArrTmp);
		}
	}
	function getautocomp(){
				$year = date("Y")+543;
				$mon = date("m");
				if($mon<10){
					$Budget_year_now = $year;
				}else{
					$Budget_year_now = $year+1;
				}
				$sql = "select AcSeriesId from tblbudget_init_year where BgtYear = '".$Budget_year_now."'";
				//echo $sql;
				$this->db->setQuery($sql);
				$this->db->limit = $limit;
				$list2 = $this->db->loadDataSet();
				if($list2["rows"]){
					 foreach($list2["rows"] as $r1 ) {
						$AcSeriesId= $r1->AcSeriesId;
					}
				}
				$data_send=array();
				$sql = "SELECT AcChartId,AcChartCode,ThaiName FROM ac_chart WHERE AcSeriesId = ".$AcSeriesId;//ดึงรายการบัญชีขาจ่าย
				$this->db->setQuery($sql);
				$detail1 = $this->db->loadDataSet();
				$line1 = 0;
				if($detail1["rows"]){
					 foreach($detail1["rows"] as $r3 ) {
						$data_send[$line1]["key"]=$r3->AcChartId;
						$data_send[$line1]["value"]=$r3->AcChartCode;
						$data_send[$line1]["value1"]=$r3->ThaiName;
						$line1++;
					 }
				}
		echo json_encode ($data_send);
	}
	function getaccount(){
		//echo $AcActionId;
		$AcActionId = ltxt::getVar( 'AcActionId','post' );
		$IncomeId = ltxt::getVar( 'IncomeId','post' );
		$where 	  = array();
		if ($AcActionId == ""){ // undefined load ผูกบัญชี
				$where[] ="tblbudget_finance_income.IncomeId=".$IncomeId;

				$year = date("Y")+543;
				$mon = date("m");
				if($mon<10){
					$Budget_year_now = $year;
				}else{
					$Budget_year_now = $year+1;
				}
				$sql = "select AcSeriesId from tblbudget_init_year where BgtYear = '".$Budget_year_now."'";
				$this->db->setQuery($sql);
				$this->db->limit = $limit;
				$list2 = $this->db->loadDataSet();
				if($list2["rows"]){
					 foreach($list2["rows"] as $r1 ) {
						$AcSeriesId= $r1->AcSeriesId;
					}
				}

				$where[] ="ac_chart.AcSeriesId = ".$AcSeriesId;

				if($where){
					$where_r = "\n where ".implode(" and ",$where);
				}
				//$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, tblbudget_finance_income.IncomeValue, ac_chart.AcChartId FROM tblbudget_init_cost_item_ac INNER JOIN tblbudget_init_cost_item ON tblbudget_init_cost_item_ac.CostItemId = tblbudget_init_cost_item.CostItemId INNER JOIN tblfinance_payment_list_detail ON tblbudget_init_cost_item.CostItemCode = tblfinance_payment_list_detail.CostItemCode INNER JOIN ac_chart ON tblbudget_init_cost_item_ac.AcChartId = ac_chart.AcChartId ".$where_r;//ดึงรายการบัญชีขาจ่าย
				//$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, tblbudget_finance_income.IncomeValue, ac_chart.AcChartId FROM tblbudget_finance_income INNER JOIN tblbudget_finance_income_type ON tblbudget_finance_income.IncomeType = tblbudget_finance_income_type.IncomeType INNER JOIN tblbudget_finance_income_type_ac ON tblbudget_finance_income_type.IncomeType = tblbudget_finance_income_type_ac.IncomeType ".$where_r;
				$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, tblbudget_finance_income.IncomeValue, ac_chart.AcChartId FROM tblbudget_finance_income INNER JOIN tblbudget_finance_income_type ON tblbudget_finance_income.IncomeType = tblbudget_finance_income_type.IncomeType INNER JOIN (tblbudget_finance_income_type_ac inner join ac_chart on tblbudget_finance_income_type_ac.AcChartId = ac_chart.AcChartId) ON tblbudget_finance_income_type.IncomeType = tblbudget_finance_income_type_ac.IncomeType ".$where_r;
				//echo $sql;
				$this->db->setQuery($sql);
				$detail = $this->db->loadDataSet();
				$line = 0;
				$data_send=array();
				if($detail["rows"]){
					 foreach($detail["rows"] as $r2 ) {
							$data_send[$line]["AcChartCode"]=$r2->AcChartCode;
							$data_send[$line]["ThaiName"]=$r2->ThaiName;
							//$data_send[$line]["DRValue"]=$r2->IncomeValue; // จำนวนเงินค่าใช้จ่าย
							$data_send[$line]["DRValue"]=0; // จำนวนเงินค่าใช้จ่าย
							$data_send[$line]["CRValue"]="";
							$data_send[$line]["AcChartId"]=$r2->AcChartId;
							$data_send[$line]["TextDetail"]="";
							$line++;
					}
				}
				// ดึงรายการบัญชีขา เงินสด หรือ ธนาคาร
				$sql = "select ReceiveType,IncomeValue from tblbudget_finance_income where IncomeId = ".$IncomeId;// หาก่อนว่า เงินสดหรือธนาคาร
				$this->db->setQuery($sql);
				$this->db->limit = $limit;
				$list2 = $this->db->loadDataSet();
				if($list2["rows"]){
					 foreach($list2["rows"] as $r1 ) {
						$ReceiveType= $r1->ReceiveType;// 1 ธนาคาร 2 เงินสด
						$IncomeValue= $r1->IncomeValue;//จำนวนเงินสด

					}
				}
				if ($ReceiveType == 2){	//ดึงบัญชีธนาคาร
					//$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, tblfinance_payment_methods.PaymentValue, ac_chart.AcChartId FROM tblfinance_payment_methods INNER JOIN tblbudget_finance_bookbank_ac ON tblfinance_payment_methods.BookbankId = tblbudget_finance_bookbank_ac.BookbankId INNER JOIN ac_chart ON tblbudget_finance_bookbank_ac.AcChartId = ac_chart.AcChartId WHERE tblfinance_payment_methods.PaymentId = ".$PaymentId;
					$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, tblbudget_finance_income.IncomeValue, ac_chart.AcChartId FROM tblbudget_finance_bookbank INNER JOIN  tblbudget_finance_bookbank_ac ON tblbudget_finance_bookbank.BookbankId = tblbudget_finance_bookbank_ac.BookbankId INNER JOIN tblbudget_finance_income ON dbo.tblbudget_finance_bookbank_ac.BookbankAcId = tblbudget_finance_income.BookbankId WHERE tblbudget_finance_income.IncomeId = ".$IncomeId;
				//	echo $sql;
				}else{//ดึงบัญชีเงินสด
					$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, ac_chart.AcChartId FROM ac_cash INNER JOIN ac_chart ON ac_cash.AcChartId = ac_chart.AcChartId WHERE ac_cash.AcSeriesId = ".$AcSeriesId;
				}

				$this->db->setQuery($sql);
				$this->db->limit = $limit;
				$list2 = $this->db->loadDataSet();
				if($list2["rows"]){
					 foreach($list2["rows"] as $r1 ) {
						$data_send[$line]["AcChartCode"]=$r1->AcChartCode;
						$data_send[$line]["ThaiName"]=$r1->ThaiName;

						$data_send[$line]["CRValue"]=$IncomeValue; // จำนวนเงินค่าใช้จ่าย

						$data_send[$line]["DRValue"]="";
						$data_send[$line]["AcChartId"]=$r1->AcChartId;
						$data_send[$line]["TextDetail"]="";
						$line++;
					}
				}
		}else{// not undefined แสดงรายการที่บันทึก
				//echo "ccc";
				$sql = "SELECT  DrId, DrValue, DrDetail, CrId, CrValue, CrDetail FROM ac_action_detail WHERE (AcActionId = ".$AcActionId.") ORDER BY Ordering";//ดึงรายการบัญชีขาจ่าย
				//echo $sql;
				$this->db->setQuery($sql);
				$detail = $this->db->loadDataSet();
				$line = 0;
				$data_send=array();
				if($detail["rows"]){
					 foreach($detail["rows"] as $r2 ) {
						 	$AcChartId = "";
							$AcChartCode = "";
							$ThaiName = "";
							$DRValue = "";
							$CrValue = "";
							$TextDetail = "";
							$DrId = $r2->DrId;
							$DrValue = $r2->DrValue;
							$DrDetail = $r2->DrDetail;

							$CrId = $r2->CrId;
							$CrValue = $r2->CrValue;
							$CrDetail = $r2->CrDetail;

						//	echo "aaa".$DrValue;
							if ($DrId != 0){
								$TextDetail = $DrDetail;
								$AcChartId = $DrId;
							}else{
								$TextDetail = $CrDetail;
								$AcChartId = $CrId;
							}

							$sql = "SELECT ThaiName, AcChartCode FROM ac_chart WHERE AcChartId = ".$AcChartId;//ดึงรายการบัญชีขาจ่าย

							$this->db->setQuery($sql);
							$detail1 = $this->db->loadDataSet();
							$line1 = 0;
							if($detail1["rows"]){
								 foreach($detail1["rows"] as $r3 ) {
									$AcChartCode = $r3->AcChartCode;
									//echo $AcChartCode;
									$ThaiName = $r3->ThaiName;
									$line1++;
								 }
							}

						 	$data_send[$line]["AcChartId"]=$AcChartId;

							$data_send[$line]["AcChartCode"]=$AcChartCode;
							$data_send[$line]["ThaiName"]=$ThaiName;

							$data_send[$line]["DRValue"]=$DrValue; // จำนวนเงินค่าใช้จ่าย
							$data_send[$line]["CRValue"]=$CrValue;
							$data_send[$line]["TextDetail"]=$TextDetail;
							$line++;
					}
				}
		}

		//echo $AcActionId;





		echo json_encode ($data_send);
	}
	/*END*/

	/*
	START #F4
	Function Name: getTypeActName
	Description		: เป็นฟังก์ชันสำหรับดึงชื่อธนาคาร
	Parameter		:
		@BankId	= ID (PK) ของตาราง tblbudget_finance_bank
	Return Value 	: single(loadResult)
	*/
	function getAcName($AcChartId){
		$where 	  = array();
		if($BankId){
			$where[] ="AcChartId='".$AcChartId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql = "select ThaiName from ac_chart ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult();
		return $detail;
	}
	/*END*/

	/*
	START #F5
	Function Name: getOrderList
	Description		: เป็นฟังก์ชันสำหรับดึงรายการธนาคารขึ้นมาเรียงลำดับ
	Parameter		: -
	Return Value 	: Array(loadObjectList)
	*/
	function getOrderList(){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql="select * from tblbudget_finance_bank ".$where_r."  order by Ordering ASC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadObjectList();
		return $list;
	}
	/*END*/

 	/* START #F6 */
	/* Function Name: getAccGroupSelect */
	/* Description: เป็นฟังก์ชันสำหรับดึงราหมวดบัญชี  */
	/* Parameter: */
			/* @AcGroupId	 	= รหัสหมวดบัญชี */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */

	function getAccGroupSelect($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
//		$where = array();
//		$where[] = "EnableStatus='Y'";
//		$where[] = "DeleteStatus='N'";
//
//		if(count($where)) {
//			$where_r = "WHERE ". implode( " AND ", $where );
//		}

		$sql="SELECT AcGroupId as value , CONCAT(GInitial,' ',GName) as text "
			 ."\n FROM ac_group "
//			 ."\n ".$where_r
			 ."\n order by AcGroupId ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "

		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );

	}
	/* END */
}
?>
