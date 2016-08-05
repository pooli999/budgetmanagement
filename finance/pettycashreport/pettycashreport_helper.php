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
	Description		: เป็นฟังก์ชันสำหรับดึงรายการธนาคารทั้งหมด
	Parameter		:
		@$_REQUEST["tsearch"]	=  ชื่อธนาคารเมื่อกรอกข้อมูลค้นหา
	Return Value 	: Array(loadDataSet)
	*/
	function getDataList(&$list,$limit=20){
		$where 	  = array();
		$where[] ="DeleteStatus='N'";

		if($_REQUEST["tsearch"]){
			$where[] = "CreateDate like ('%".$_REQUEST["tsearch"]."%')";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql="select * from tblbudget_finance_pettycash_compensate ".$where_r."  order by CreateDate DESC";
		$this->db->setQuery($sql);
		$this->db->limit = $limit;
		$list = $this->db->loadDataSet();
		return $list;
	}
	/*END*/


	/*
	START #F3
	Function Name: getDetail
	Description		: เป็นฟังก์ชันสำหรับดึงรายละเอียดธนาคาร
	Parameter		:
		@TypeActId	= ID (PK) ของตาราง tblbudget_init_type_activity
	Return Value 	: Array 1 รายการ (loadSingleObject)
	*/
	function getDetail($BankId){
		$where 	  = array();
		if($BankId){
			$where[] ="BankId='".$BankId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql = "select * from tblbudget_finance_bank ".$where_r;
		$this->db->setQuery($sql);
		$detail = $this->db->loadSingleObject();
		return $detail;
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
	function getBankName($BankId){
		$where 	  = array();
		if($BankId){
			$where[] ="BankId='".$BankId."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}

		$sql = "select BankName from tblbudget_finance_bank ".$where_r;
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
	function getbtnstvaule(){
        //echo $AcActionId;
      $stvalue = ltxt::getVar( 'stvalue','post' );
			$sql = "Update tblbudget_finance_pettycash_balance set PettyCashBalance=$stvalue where PettyCashBalanceId = 1";
			$this->db->Execute($sql);
      echo "1";

  }
	function getloadstvaule(){
        //echo $AcActionId;
				//	หายอดยกมา
				$sql = "select PettyCashBalance from tblbudget_finance_pettycash_balance where PettyCashBalanceId  = 1";
        //echo $sql;
        $this->db->setQuery($sql);
        $this->db->limit = $limit;
        $list2 = $this->db->loadDataSet();
        if($list2["rows"]){
             foreach($list2["rows"] as $r1 ) {
                $PettyCashBalance= $r1->PettyCashBalance;
            }
        }
				//	เบิกจ่ายไป
				$sql = "select sum(Budget) as Budget from tblfinance_doccode where FormCode  = 'FF009' and DocStatusId >= 7";
        //echo $sql;
        $this->db->setQuery($sql);
        $this->db->limit = $limit;
        $list2 = $this->db->loadDataSet();
        if($list2["rows"]){
             foreach($list2["rows"] as $r1 ) {
                $Budget= $r1->Budget;
            }
        }
				// 	เบิกทดแทน
				$sql = "select sum(TotalValue) as TotalValue from tblbudget_finance_pettycash_compensate where DeleteStatus  = 'N'";
        //echo $sql;
        $this->db->setQuery($sql);
        $this->db->limit = $limit;
        $list2 = $this->db->loadDataSet();
        if($list2["rows"]){
             foreach($list2["rows"] as $r1 ) {
                $TotalValue= $r1->TotalValue;
            }
        }
				// 	ยอดคงเหลือ

        $data_send[0]["v0"]=number_format($PettyCashBalance,2); // ยอดยกมา
        $data_send[0]["v1"]=number_format($Budget,2); // จ่ายเงินสดย่อย
  			$data_send[0]["v2"]=number_format($TotalValue,2); // เบิกทดแทน
				$def =$PettyCashBalance-$Budget+$TotalValue;
				$data_send[0]["v3"]=number_format($def,2);
        $line++;

        echo json_encode ($data_send);

    }


}
?>
