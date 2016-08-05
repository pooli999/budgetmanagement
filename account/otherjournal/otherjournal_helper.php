<?php

class sHelper
{
	var $dpublic;
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
		$this->dpublic		= new BGPublic();
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
		//	echo $sql;
			$aname = $this->db->loadResult();
			$sql = "select tblpersonal.LastName from tblpersonal where PersonalCode = '".$PartnerCode."'";
			$this->db->setQuery($sql);
			$bname = $this->db->loadResult();
		}

		$pname = $aname." ".$bname;
		return $pname;
	}
	function findjournalName($journalId){
			$sql = "select journalName from ac_journal where journalId = ".$journalId;
			$this->db->setQuery($sql);
			$journalNam = $this->db->loadResult();
		return $journalNam;
	}
	function getDataList(&$list,$limit=20){
		$where 	  = array();



		 if($_REQUEST["tsearch"]){
		 	$where[] = "ac_action.PV like '%".$_REQUEST["tsearch"]."%'";
			$where[] = "ac_action.AcDescription like '%".$_REQUEST["tsearch"]."%'";
			$where[] = "ac_journal.journalName like '%".$_REQUEST["tsearch"]."%'";

	 	}

		if($where){
			$where_r = "\n where ".implode(" or ",$where);
		}
		if($_REQUEST["tsearch"]){
			$crt1 = " and (ac_action.DeleteStatus='N') and ac_action.journalId <> 1 and ac_action.journalId <> 2";
		}else{
			$crt1 = " WHERE (ac_action.DeleteStatus='N' and ac_action.journalId <> 1 and ac_action.journalId <> 2)";
		}
	//	$fn1 = '(select journalName from ac_journal where ac_journal.journalId = ac_action.journalId) as journalName';
		$fn2 = '(select sum(DrValue) as sval from ac_action_detail where ac_action_detail.AcActionId = ac_action.AcActionId) as sval';

		$sql="select $fn2,ac_action.*,ac_journal.journalName from ac_action inner join ac_journal on ac_journal.journalId = ac_action.journalId ".$where_r.$crt1;

		$sql= $sql." order by ac_action.AcActionId DESC";

		//echo $sql;
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/

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
	function getDataList4($PaymentListId){
		$where 	  = array();
		//$where[] ="DocStatusId >= 7"; // 7 คืออนุมัติ
		//$where[] ="DeleteStatus='N'";
		$where[] ="PaymentListId=".$PaymentListId;


		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select * from tblfinance_payment_list_detail ".$where_r." ";
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
	function getDetail($AcActionId){
		//echo "aa";
		$where 	  = array();
		if($AcActionId){
			$where[] ="AcActionId=".$AcActionId;
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql = "SELECT * FROM ac_action ".$where_r;

		//echo $sql;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject();
		return $detail;
	}
	/*END*/
	function getDataList1($PaymentId){
		$where 	  = array();
		$where[] ="tblfinance_payment_list.PaymentId=".$PaymentId;
		$where[] ="tblfinance_payment_list.DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select tblfinance_doccode.PrjActCode,tblfinance_doccode.formcode,tblfinance_payment_list.PaymentListId
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
		$fn1 = "(select CostName from tblbudget_init_cost_item where tblbudget_init_cost_item.CostItemCode = tblfinance_payment_list_detail.CostItemCode) as CostName";

		$sql="select tblfinance_payment_list_detail.*,$fn1 from tblfinance_payment_list_detail ".$where_r." ";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$tList2 = $this->db->loadDataSet();
		return $tList2;
	}

	function getDataList5($PaymentId){
		$where 	  = array();
		$where[] ="tblfinance_payment_list.PaymentId=".$PaymentId;
		$where[] ="tblfinance_payment_list.DeleteStatus='N'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select * from tblfinance_payment_list ".$where_r." ";
		//echo $sql;
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$tList2 = $this->db->loadDataSet();
		return $tList2;
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
						$data_send[$line1]["value"]=$r3->AcChartCode." || ".$r3->ThaiName;
						$data_send[$line1]["value1"]=$r3->ThaiName;
						$line1++;
					 }
				}
		echo json_encode ($data_send);
	}
	function getaccountadd(){
			$AcActionId = ltxt::getVar( 'AcActionId','post' );
			$sql = "SELECT  DrId, DrValue, DrDetail, CrId, CrValue, CrDetail FROM ac_action_detail WHERE (AcActionId = ".$AcActionId.") ORDER BY Ordering";//ดึงรายการบัญชีขาจ่าย
		//	echo $sql;
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

		echo json_encode ($data_send);
	}
	function getaccount(){
		//echo $AcActionId;
		$AcActionId = ltxt::getVar( 'AcActionId','post' );
		$PaymentId = ltxt::getVar( 'PaymentId','post' );
		$PaymentListDetailId = ltxt::getVar( 'PaymentListDetailId','post' );
		$PaymentValue = ltxt::getVar( 'PaymentValue','post' );
		$addcr = ltxt::getVar( 'addcr','post' );

		$where 	  = array();
		if ($AcActionId == ""){ // undefined load ผูกบัญชี
				$where[] ="tblfinance_payment_list_detail.PaymentId=".$PaymentId;

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

				$where[] ="ac_chart.AcSeriesId = ".$AcSeriesId;
				$where[] ="tblfinance_payment_list_detail.PaymentListDetailId = ".$PaymentListDetailId;

				if($where){
					$where_r = "\n where ".implode(" and ",$where);
				}
				$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, tblfinance_payment_list_detail.CastValue, ac_chart.AcChartId FROM tblbudget_init_cost_item_ac INNER JOIN tblbudget_init_cost_item ON tblbudget_init_cost_item_ac.CostItemId = tblbudget_init_cost_item.CostItemId INNER JOIN tblfinance_payment_list_detail ON tblbudget_init_cost_item.CostItemCode = tblfinance_payment_list_detail.CostItemCode INNER JOIN ac_chart ON tblbudget_init_cost_item_ac.AcChartId = ac_chart.AcChartId ".$where_r;//ดึงรายการบัญชีขาจ่าย
				$this->db->setQuery($sql);
				$detail = $this->db->loadDataSet();
				$line = 0;
				$data_send=array();
				if($detail["rows"]){
					 foreach($detail["rows"] as $r2 ) {
							$data_send[$line]["AcChartCode"]=$r2->AcChartCode;
							$data_send[$line]["ThaiName"]=$r2->ThaiName;
							// $data_send[$line]["DRValue"]=$r2->CastValue; // จำนวนเงินค่าใช้จ่าย
							$data_send[$line]["DRValue"]="0"; // จำนวนเงินค่าใช้จ่าย
							$data_send[$line]["CRValue"]="0";
							$data_send[$line]["AcChartId"]=$r2->AcChartId;
							$data_send[$line]["TextDetail"]="";
							$line++;
					}
				}
			if ($addcr == "addcr"){ // แถวสุดท้ายดึงรายการเงินสดหรือธนาคาร
				//--------------- ดึงรายการบัญชีขา เงินสด หรือ ธนาคาร---------------
					$sql = "select ChequeOrCash,CashValue,TaxType,CalTex from tblfinance_payment_comp where PaymentId = ".$PaymentId;// หาก่อนว่า เงินสดหรือธนาคาร
					$this->db->setQuery($sql);
					$this->db->limit = $limit;
					$list2 = $this->db->loadDataSet();
					if($list2["rows"]){
						 foreach($list2["rows"] as $r1 ) {
							$ChequeOrCash= $r1->ChequeOrCash;// 1 ธนาคาร 2 เงินสด
							$CashValue= $r1->CashValue;//จำนวนเงินสด
							$TaxType= $r1->TaxType;//1:3 2:53
							$CalTex= $r1->CalTex;//1:3 2:53
						}
					}
					if ($ChequeOrCash == 1){	//ดึงบัญชีธนาคาร
						$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, tblfinance_payment_methods.PaymentValue, ac_chart.AcChartId FROM tblfinance_payment_methods INNER JOIN tblbudget_finance_bookbank_ac ON tblfinance_payment_methods.BookbankId = tblbudget_finance_bookbank_ac.BookbankId INNER JOIN ac_chart ON tblbudget_finance_bookbank_ac.AcChartId = ac_chart.AcChartId WHERE tblfinance_payment_methods.PaymentId = ".$PaymentId;
					}else{//ดึงบัญชีเงินสด
						$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, ac_chart.AcChartId FROM ac_cash INNER JOIN ac_chart ON ac_cash.AcChartId = ac_chart.AcChartId WHERE ac_cash.AcSeriesId = ".$AcSeriesId." and ac_cash.CashId=1";
					}

					$this->db->setQuery($sql);
					$this->db->limit = $limit;
					$list2 = $this->db->loadDataSet();
					if($list2["rows"]){
						 foreach($list2["rows"] as $r1 ) {
							$data_send[$line]["AcChartCode"]=$r1->AcChartCode;
							$data_send[$line]["ThaiName"]=$r1->ThaiName;
							$data_send[$line]["CRValue"]=$PaymentValue;
							$data_send[$line]["DRValue"]="0";
							$data_send[$line]["AcChartId"]=$r1->AcChartId;
							$data_send[$line]["TextDetail"]="";
							$line++;
						}
					}
				//-----------------------------------------------------------------------------
				//--------------- ดึงรายการ ภาษีหัก ณที่จ่าย---------------

				if($TaxType == "1"){//1:ภงด 3 || 2:ภงด53
					$ctr1 = "2";
				}else{
					$ctr1 = "3";
				}
				$sql = "SELECT ac_chart.AcChartCode, ac_chart.ThaiName, ac_chart.AcChartId FROM ac_cash INNER JOIN ac_chart ON ac_cash.AcChartId = ac_chart.AcChartId WHERE ac_cash.AcSeriesId = ".$AcSeriesId." and ac_cash.CashId=".$ctr1;
				$this->db->setQuery($sql);
				$this->db->limit = $limit;
				$list2 = $this->db->loadDataSet();
				if($list2["rows"]){
					 foreach($list2["rows"] as $r1 ) {
						$data_send[$line]["AcChartCode"]=$r1->AcChartCode;
						$data_send[$line]["ThaiName"]=$r1->ThaiName;
						$data_send[$line]["CRValue"]=$CalTex;
						$data_send[$line]["DRValue"]="0";
						$data_send[$line]["AcChartId"]=$r1->AcChartId;
						$data_send[$line]["TextDetail"]="";
						$line++;
					}
				}

			}
		}else{// not undefined แสดงรายการที่บันทึก
				//echo "ccc";
				$sql = "SELECT  DrId, DrValue, DrDetail, CrId, CrValue, CrDetail FROM ac_action_detail WHERE (AcActionId = ".$AcActionId." and PaymentListDetailId = ".$PaymentListDetailId.") ORDER BY Ordering";//ดึงรายการบัญชีขาจ่าย
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
	function getBankNameSelect($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ª×èÍ element,$tag_attribs:attrib,$selected:¤èÒ·ÕèµéÍ§¡ÒÃãËéáÊ´§,$lebel: title ¢Í§ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

		$sql="SELECT BankId as value , BankName as text "
			 ."\n FROM tblbudget_finance_bank "
			 ."\n ".$where_r
			 ."\n order by BankName ASC " ;
			 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "

		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );

	}
	function getBookbankNumber($tag_name,$tag_attribs,$selected,$lebel,$CtrBankId){//$tag_name:ª×èÍ element,$tag_attribs:attrib,$selected:¤èÒ·ÕèµéÍ§¡ÒÃãËéáÊ´§,$lebel: title ¢Í§ element
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		if ($CtrBankId != ""){
			$bankid = $CtrBankId;
		}else{
			$bankid = ltxt::getVar( 'bankid','get' );
		}

		if($bankid){
			$where[] = "BankId=$bankid";
		}
		$selected = ltxt::getVar( 'sel1','get' );

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}

		$title[] = clssHTML::makeOption(0,$lebel);
		if($bankid){
			$sql="SELECT BookbankId as value , BookbankNumber as text "
				 ."\n FROM tblbudget_finance_bookbank "
				 ."\n ".$where_r
				 ."\n order by BookbankId ASC " ;

			$this->db->setQuery($sql);
			$datas = $this->db->loadObjectList();
			$datas = array_merge($title,$datas);
		}else{
			$datas = $title;
		}
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	function zeroc($txtlen,$len){
		$coid = strlen($txtlen);
		 for($ic = $coid; $ic < $len; $ic++){
			 $zero = $zero."0";
		 }
		 $RunNoText = $zero.$txtlen;
		 return $RunNoText;
	}

	function findpvcode($yy,$mm,$journalId,$datatypes=""){// yy 2559,mm 09
		$YYear=$yy;
		$sql = "select shortName from ac_journal where journalId = ".$journalId;
		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();
		if($detail["rows"]){
			 foreach($detail["rows"] as $r2 ) {
				 $shortName = $r2->shortName;
			 }
		}
		$mm = intval($mm);

		$sql = "select max(RunNo) as RunNo from ac_action where journalId = ".$journalId." and YYear = ".$YYear." and MMonth =".$mm ;// หา runno ของแต่ละปี เดือน
		//echo $sql;

		$this->db->setQuery($sql);
		$detail = $this->db->loadDataSet();
		if($detail["rows"]){
			 foreach($detail["rows"] as $r2 ) {
				 $RunNo = $r2->RunNo;
				 if (is_null($RunNo)){
					$RunNo = 0;
				}
			 }
		}
		$RunNo++;
		//echo $RunNo;
		$RunNoText = $this->zeroc($RunNo,4);
		$MMText = $this->zeroc($mm,2);
		$YYear = substr($YYear,2);
		$pv = $shortName.$YYear.$MMText.$RunNoText;
		if ($datatypes==""){
				return $pv;
		}else{
				//echo json_encode($pv);
				echo $pv;
		}

	}
	function getchkpv($PV,$opv){


			$sql = "SELECT PV FROM ac_action WHERE PV = '".$PV."'";


			$this->db->setQuery($sql);
			$detail = $this->db->loadResult();
			$data_send=array();
			if($detail==""){
				$ans= "notfound";
			}else{
				if ($detail == $opv){
					$ans= "notfound";
				}else{
					$ans= "found";
				}
			}
			echo json_encode($ans);
	}
  function getAcActionId($id){
		$sql = "select AcActionId from ac_action where PaymentId=".$id;
		$this->db->setQuery($sql);
		$detail = $this->db->loadResult();
		return $detail;
	}
  function getjournalId($id){
    $sql = "select journalId from ac_action where PaymentId=".$id;
    $this->db->setQuery($sql);
    $detail = $this->db->loadResult();
    return $detail;
  }
	function getJournalNameSelect($tag_name,$tag_attribs,$selected,$lebel){//$tag_name:ชื่อ element,$tag_attribs:attrib,$selected:ค่าที่ต้องการให้แสดง,$lebel: title ของ element
			$where = array();
			$where[] = "EnableStatus='Y'";
			$where[] = "DeleteStatus='N'";

			if(count($where)) {
					$where_r = "WHERE ". implode( " AND ", $where );
			}

			$sql="SELECT journalId as value , journalName as text "
					 ."\n FROM ac_journal "
					 ."\n ".$where_r
					 ."\n and journalId <> 1 and journalId <> 2 order by journalId ASC " ;
					 //."\n order by CONVERT(`PItemName` USING TIS620) ASC "

			//echo "<pre>$sql;</pre>";
			$this->db->setQuery($sql);
			$title[] = clssHTML::makeOption(0,$lebel);
			$datas = $this->db->loadObjectList();
			$datas = array_merge($title,$datas);
			echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );

	}

}
?>
