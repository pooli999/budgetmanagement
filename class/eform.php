<?php

class EForm
{
	
	var $db;
	var $debug = 0;
	function EForm()
	{
		$this->db = &JFactory::getDBO();
	}
	
//------------------------- Gen DocCode -----------------------------
function GenDocCode(){
	
	$GenDate = date('Y-m-d');
	$GenDateTwo = date('Y-m-d');
	$html ='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	$html .='<tr><td style="border-bottom:0px">';
	$html .='<input name="TypeCode" id="TypeCode1" type="radio" value="C1" /> ระบบสร้างอัตโนมัติ';
	$html .='</td></tr>';
	
	$html .='<tr><td style="border-bottom:0px">';
	$html .='<input name="TypeCode" id="TypeCode2" type="radio" value="C2" /> เลือกเลขที่ สช.น ที่กันเลขไว้ของวันที่ ';
	$html .=InputCalendar_text(array(
			'id' => 'GenDate',
			'name' => 'GenDate',
			'value' => $GenDate
		));
		
	$html .=' <input name="btnCode" id="btnCode" type="button"  value="แสดงเลขที่ สช.น"  onclick="ShowCode();"  class="btnRed" /> ระบุเลขที่ สช.น <span id="setcode">'.$this->getSetCode(0,'N',$SetCode).'</span>';
	$html .='</td></tr>';
	
	$html .='<tr><td style="border-bottom:0px">';
	$html .='<input name="TypeCode" id="TypeCode3" type="radio" value="C3" /> แทรกจากเลขที่ สช.น ที่ถูกใช้แล้วของวันที่ ';
	$html .=InputCalendar_text(array(
			'name' => 'GenDateTwo',
			'value' => $GenDateTwo
		));
		
	$html .=' <input name="btnCodeTwo" id="btnCodeTwo" type="button"  value="แสดงเลขที่ สช.น"  onclick="ShowCodeTwo();" class="btnRed" /> ระบุเลขที่ สช.น <span id="setcodetwo">'.$this->getSetCode(0,'Y',$SetCodeTwo,'SetCodeTwo','style="width:15%"').'</span>';
	$html .=' . (จุด) <input name="GenPoint" id="GenPoint" type="text" value="" size="15"  onkeyup="checkPoint();">';
	$html .='</td></tr>';


	$html .='</table>';
	

	return $html;
}

	/* Function Name: getSetCode */
	/* Description: เป็นฟังชั่นสำหรับดึงแบบฟอร์ม
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 		= ชื่อ list box */
			/* @lebel 				= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */	
	function getSetCode($gendate='',$usestatus='N',$selected='',$tag_name='SetCode',$tag_attribs='style="width:15%"',$lebel='เลือก'){
		global $DBO;
				
		$where = array();
		
		if($gendate){
			//$where[] = "DocDate = '".Date2DB($gendate)."' ";
			$where[] = "DocDate = '".$gendate."' ";
		}
		
		$where[] = "UseStatus = '".$usestatus."' ";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT DocCode as value , DocCode as text "
			 ."\n FROM tblfinance_form_doccode "
			 ."\n ".$where_r
			 ."\n order by DocCode asc"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$DBO->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $DBO->loadObjectList();
		$datas = array_merge($title,$datas);
		return clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	/* END */	



function FnRunDocCode($TypeCode='',$GenDate='',$SetCode='',$GenDateTwo='',$SetCodeTwo='',$GenPoint='',$FormCode=0,$Topic='',$Owner=0,$BgtYear=0,$PItemId=0,$PrjId=0,$PrjActCode=0,$Budget=0,$DocStatusId=1,$CreateBy=0,$CreateDate=0){
	global $DBO;
	
	if($TypeCode=="C1"){   
		$MaxNo = $this->FnMaxNo() ;
		$RunNo = $MaxNo+1;
		//echo "RunNo=".$RunNo;
		$NoLen = strlen($RunNo);
		//echo "NoLen=".$NoLen;
		
		$RunYear = substr(date("Y")+543,2,2);
		//echo "RunYear=".$RunYear;
		
		for($r=$NoLen;$r<=3;$r++){
			$RunZero = $RunZero."0";
		}
	
		$Code = $RunZero.$RunNo."/".$RunYear;
		//echo "Code=".$Code;
				
		$DCode["DocCode"] 		= $Code;
		$DCode["AutoNo"] 			= $RunNo;
		$DCode["UseStatus"] 		= 'Y';
		$DCode["DocDate"] 		= date("Y-m-d");
		//$DCode["KeyPoint"] 		= '';
		
		$DCode["FormCode"] 			= $FormCode;
		$DCode["Topic"] 				= $Topic;
		$DCode["Owner"] 			= $Owner;
		$DCode["BgtYear"] 			= $BgtYear;
		$DCode["PItemId"] 			= $PItemId;
		$DCode["PrjId"] 				= $PrjId;
		$DCode["PrjActCode"] 		= $PrjActCode;
		$DCode["Budget"] 			= $Budget;
		$DCode["DocStatusId"] 	= $DocStatusId;
		$DCode["CreateBy"] 		= $CreateBy;
		$DCode["CreateDate"] 	= $CreateDate;

		$DBO->arecSave('tblfinance_form_doccode',$DCode);
		
	}else if($TypeCode=="C2"){ 
	
		$Code = $SetCode;
		//echo "Code=".$Code;
		
	}else if($TypeCode=="C3"){ 
		$SubCode = substr($SetCodeTwo,0,4);
		$SubYear = substr($SetCodeTwo,5,2);
		//echo "SubCode=".$SubCode;
		//echo "SubYear=".$SubYear;
		$Code = $SubCode.".".$GenPoint."/".$SubYear;
		//echo "Code=".$Code;
		
		$DCode["DocCode"] 	= $Code;
		$DCode["AutoNo"] 	= $SubCode;
		$DCode["KeyPoint"] 	= $GenPoint;
		$DCode["UseStatus"] = 'Y';
		$DCode["DocDate"] 	= date("Y-m-d");
		
		$DCode["FormCode"] 			= $FormCode;
		$DCode["Topic"] 				= $Topic;
		$DCode["Owner"] 			= $Owner;
		$DCode["BgtYear"] 			= $BgtYear;
		$DCode["PItemId"] 			= $PItemId;
		$DCode["PrjId"] 				= $PrjId;
		$DCode["PrjActCode"] 		= $PrjActCode;
		$DCode["Budget"] 			= $Budget;
		$DCode["DocStatusId"] 	= $DocStatusId;
		$DCode["CreateBy"] 		= $CreateBy;
		$DCode["CreateDate"] 	= $CreateDate;

		$DBO->arecSave('tblfinance_form_doccode',$DCode);
		
	}
	
	return $Code;
	
}// end function


function FnMaxNo(){
    global $DBO;	
	$sql = "SELECT MAX(AutoNo) as MaxNo  FROM tblfinance_form_doccode  "; //echo $sql;
    $DBO->setQuery($sql);
    $Data = $DBO->loadResult();
    return $Data;
}

function CheckRepeat($SetCodeTwo,$GenPoint,$GenDateTwo){
	
		global $DBO;	
		$SubCode = intval(substr($SetCodeTwo,0,4));
				
		$where = array();
		$where[] = "AutoNo = '".$SubCode."'";
		$where[] = "KeyPoint = '".$GenPoint."'";
		$where[] = "DocDate = '".$GenDateTwo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select count(*) as countresult "
				."\n from tblfinance_form_doccode "
				."\n ".$where_r
				;
		//echo $sql;
		$DBO->setQuery($sql);
		$data = $DBO->loadSingleObject();
		return $data;
	
	
}


//----------------------------- End ---------------------------------------------
	
/*-----------------START  ฟังก์ชันการตรวจสอบเอกสาร-----------------*/
	/* START
		Function Name: getHistoryResult
		Description: เป็นฟังก์ชันสำหรับดึงรายการตรวจสอบเอกสาร
		Parameter:	
			@DocCode	= เลขที่ สช.น. ของเอกสาร
		Return Value : Array 
	*/
	function getHistoryResult($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select t1.*,t2.* "
				."\n from tblfinance_form_operate as t1 "
				."\n left join tblintra_eform_init_status as t2 on t2.DocStatusId=t1.StatusId "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/*END*/

	/* START
		Function Name: getPersonalName
		Description: เป็นฟังก์ชันสำหรับดึงชื่อบุคลากรตามโครงสร้าง
		Parameter:	
			@UserID	= รหัสของผู้ล็อกอินเข้าใช้งานระบบ
		Return Value : Single(loadResult) 
	*/
	function getPersonalName($UserID){
		$where = array();
		$where[] = "u.UserID='".$UserID."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select concat(p.FirstName, ' ', p.LastName) as FullName "
				."\n from authen_users u "
				."\n inner join tblpersonal p on u.PersonalCode = p.PersonalCode "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
	/* END */
	
	/* START
		Function Name: getFiles
		Description: เป็นฟังก์ชันสำหรับดึงรายการไฟล์แนบของผลการตรวจสอบเอกสารการเงิน
		Parameter:	
			@CheckId=  รหัสรายการตรวจสอบเอกสารการเงิน
		Return Value : Array 
	*/
	function getFiles($CheckId){
		$sql = "SELECT * FROM tblfinance_form_operate_file where  CheckId=".$CheckId;
		$this->db->setQuery($sql);
		$files = $this->db->loadObjectList();
		return $files;
	}
	/* END */	
	
	/* START
		Function Name: getCheckLastNo
		Description: เป็นฟังก์ชันสำหรับครั้งที่ล่าสุดของการตรวจสอบเอกสารแต่ละรายการ
		Parameter:	
			@DocCode=  เลขที่ สช.น. ของเอกสารการเงิน
		Return Value : Single(loadResult) 
	*/
	function getCheckLastNo($DocCode){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select count(*) "
				."\n from tblfinance_form_operate "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return ($datas+1);
	}
	/* END */
	
	function CheckDetail($DocCode){
			
 		$html ='<tr>';
    	$html .='<td colspan="2" ><div class="title-bar">ประวัติการดำเนินการของเอกสาร  :</div></td>';
  		$html .='</tr>';
		$html .='<tr>';
   		$html .=' <td colspan="2" >';
		$html .='<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
		<tr>
			<th style="width:30px;">ครั้งที่</th>
			<th style="width:80px;">วันที่ดำเนินการ</th>
			<th style="width:100px;">ผลการดำเนินการ</th>
			<th>หมายเหตุ</th>
			<th style="width:80px;">ไฟล์แนบ</th>
			<th style="width:120px;">ผู้บันทึกข้อมูล</th>
		  </tr>
		';

		  $dataResult = $this->getHistoryResult($DocCode); //ltxt::print_r($dataResult);
		  if($dataResult){
				  $h=0;
				  foreach($dataResult as $r_dataResult){
					  foreach($r_dataResult as $k=>$v){
						 ${$k} = $v;
					  }
		
			  $html .='<tr>';
				$html .='<td style="text-align:center;">'.($h+1).'</td>';
				$html .='<td style="text-align:center;">'.ShowDate($CreateDate).'</td>';
				$html .='<td>';
				$html .='<div  style="color:'.$TextColor.'; background:url('.$Icon.') left center no-repeat; padding-left:18px;">'.$StatusName.'</div>';
				$html .='</td>';
				$html .='<td>';
					if($Comment){ $html .= $Comment; }else{ $html .='<span class="txt-brown">- ไม่ระบุ -</span>'; }
				$html .='</td>';			
				$html .='<td>';
				//if(count($this->getFiles($CheckId))){
					//$html .='<a class="ico-view" title="คลิกเพื่อเปิดหน้าต่างแสดงรายการไฟล์แนบ จำนวน '.count($this->getFiles($CheckId)).' ไฟล์" href="javascript:void(0)" style="color:#003399" onclick="window.open(\'?mod=finance.approve.general.general_view_file&format=row&CheckId='.$CheckId.'\',null,\'scrollbars=yes,height=500,width=650,toolbar=yes,menubar=yes,status=yes\');">&nbsp;</a>';
				//}
				$html .='</td>';
				$html .='<td>'.$this->getPersonalName($CreateBy).'</td>';
			  $html .='</tr>';
			
				$h++;
			  }
	  }else{

		  $html .='<tr>';
				$html .='<td colspan="6" style="text-align:center; color:#999;">ไม่มีประวัติการตรวจสอบข้อมูล</td>';
		  $html .='</tr>';
    
	  }

    $html .='</table>
    </td>
  </tr>';
		
		
		return $html;
			
	}// end function	
	
/*-----------------END  ฟังก์ชันการตรวจสอบเอกสาร-----------------*/
	
/*-----------------Start ฟังก์ชันการผูกพันงบประมาณ -----------------*/

/* 
	Function Name: getTaskNoList 
	Description: เป็นฟังก์ชันสำหรับดึงครั่งที่ของรายการผูกพัน
	Parameter: -
	Return Value : Array (loadObjectList) 
*/
	function getTaskNoList($DocCode){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select DISTINCT TaskNo "
				."\n from tblbudget_bg_chain "
				."\n".$where_r
				."\n order by TaskNo asc"
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
/* END */
	
/* 
	Function Name: getMaxTaskNo 
	Description: เป็นฟังก์ชันสำหรับดึงครั้งที่ล่าสุดของรายการผูกพัน
	Parameter: -
	Return Value : Single (loadResult) 
*/
	function getMaxTaskNo($DocCode){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select max(TaskNo) "
				."\n from tblbudget_bg_chain "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
/* END */	

/* 
	Function Name: getSumCostChain 
	Description: เป็นฟังก์ชันสำหรับดึงยอกงบผูกพัน
	Parameter: -
	Return Value : Single (loadResult) 
*/
	function getSumCostChain($SumValue='',$BgtYear=0, $DocCode=0, $PrjActCode=0, $CostItemCode=0){
		$where = array();
		
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "DocCode='".$DocCode."'";
		$where[] = "PrjActCode='".$PrjActCode."'";

		if($CostItemCode){
			$where[] = "CostItemCode='".$CostItemCode."'";
		}		
								
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(".$SumValue.")"
				."\n FROM "
				."\n tblbudget_bg_hold "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */		


	/* 
	Function Name: ChainList 
	Description: เป็นฟังก์ชันสำหรับดึงรายการผูกพัน
	Parameter: -
	Return Value : Array List	 
	*/
		function ChainList($DocCode=0){
		$where = array();
		$where[] = "DocCode = '".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select * from tblbudget_bg_hold "
		."\n ".$where_r
		;
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;
		}
	/* END */	

	/* 
	Function Name: getChainList 
	Description: เป็นฟังก์ชันสำหรับดึงรายการผูกพันจากตารางผูกพัน
	Parameter: -
	Return Value : Array List	 
	*/
		function getChainList($DocCode,$TaskNo=1){
		$where = array();
		$where[] = "DocCode = '".$DocCode."'";
		$where[] = "TaskNo = '".$TaskNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select * from tblbudget_bg_chain "
		."\n ".$where_r
		;
		
/*		echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;*/
		
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		$Arr = array();
		foreach($data as $v){
			$Arr[] = $v->CostCode.'|'.$v->Detail.'|'.$v->SumCost;
		}
		return $Arr;		
		
		
		}
	/* END */	

	/* 
	Function Name: getChainDetail
	Description: เป็นฟังก์ชันสำหรับดึงรายการผูกพันจากตารางผูกพัน
	Parameter: -
	Return Value : Array List	 
	*/
		function getChainDetail($DocCode,$TaskNo=1){
		$where = array();
		$where[] = "DocCode = '".$DocCode."'";
		$where[] = "TaskNo = '".$TaskNo."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select * from tblbudget_bg_chain "
		."\n ".$where_r
		."\n order by TaskNo asc"
		;
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;

		}
	/* END */	

/* 
	Function Name: getChainCost 
	Description: เป็นฟังก์ชันสำหรับดึงงบผูกพันของรายการค่าใช้จ่าย (CostCode)
	Parameter: -
	Return Value : Single (loadResult) 
*/
	function getChainCost($DocCode,$TaskNo){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if($TaskNo){
		$where[] = "TaskNo='".$TaskNo."'";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select sum(SumCost) "
				."\n from tblbudget_bg_chain "
				."\n".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
/* END */	



/*-----------------END  ฟังก์ชันการผูกพันงบประมาณ-----------------*/

/*-----------------START  ฟังก์ชันเบิกจ่ายงบประมาณ-----------------*/

/* 
	Function Name: getSumPay
	Description: เป็นฟังก์ชันสำหรับรวมงบเบิกจ่ายจากตารางผูกพันงบ
	Parameter: -
	Return Value : Single (loadResult) 
*/
/*	function getSumPay($DocCode){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select sum(SumPay) "
				."\n from tblbudget_bg_chain "
				."\n".$where_r
				;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}*/
/* END */	

	/* Function Name: getTaskNoListBox */
	/* Description: เป็นฟังก์ชันสำหรับดึงครั่งที่ของรายการผูกพันเป็น ListBox  */
	/* Parameter: */
			/* @DocCode 		= เลขที่ สช.น */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getTaskNoListBox($DocCode='',$selected=0,$tag_name='TaskNo',$tag_attribs='onchange="loadChain()" style="width:5%" ',$lebel='เลือก'){
		//$SumPay = $this->getSumPay($DocCode); 
		
		$where = array();
		$where[] = "DocCode = '".$DocCode."'";
		
		
		if(empty($_GET["PayId"])){
			$where[] = "SumPay <= 0 ";
		}
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select DISTINCT TaskNo as value ,  TaskNo as text " 
				."\n from tblbudget_bg_chain "
				."\n".$where_r
				."\n order by TaskNo asc"
				;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */

	/* 
	Function Name: getTaskChainList
	Description: เป็นฟังก์ชันสำหรับดึงรายการผูกพันจากตารางผูกพัน
	Parameter: -
	Return Value : Array List	 
	*/
		function getTaskChainList($TaskNo=1,$TaskNoTo=1,$DocCode=''){
		$where = array();
		$where[] = "DocCode = '".$DocCode."'";
		$where[] = "TaskNo BETWEEN '".$TaskNo."' AND '".$TaskNoTo."' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select * from tblbudget_bg_chain "
		."\n ".$where_r
		."\n order by TaskNo asc, ChainId asc"
		;
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;

		}
	/* END */	

	/* 
	Function Name: getPayCost
	Description: เป็นฟังก์ชันสำหรับดึงรายการผูกพันจากตารางผูกพัน
	Parameter: -
	Return Value : Array List	 
	*/
		function getPayCost($TaskNo,$TaskNoTo,$DocCode,$DocCodePay,$TableName){
			$TaskChainList = $this->getTaskChainList($TaskNo,$TaskNoTo,$DocCode);
			//ltxt::print_r($TaskChainList);
			
			$html = '<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="border-bottom:0px">';
			  $html .= '<tr>
				<th style="text-align:left; width:5%">ลำดับ</th>
				<th style="text-align:center; width:20%">รายการค่าใช้จ่าย</th>
				<th style="text-align:center; width:20%">รายการชี้แจงผูกพันงบ</th>
				<th style="text-align:center; width:20%">รายการชี้แจง</th>
				<th style="text-align:center; width:12%">งบผูกพัน (บาท)</th>
				<th style="text-align:center; width:13%">งบขอเบิกจ่าย (บาท)</th>
			  </tr>';
			$od = 1;  
       		foreach($TaskChainList as $rt){
            	foreach( $rt as $k=>$v){ ${$k} = $v;}
				$TotalCost = $TotalCost + $SumCost;
				
				$ChainByPayCost = $this->getChainByPayCost($CostCode,$CostItemCode,$TaskNo,$DocCodePay,$TableName);	
				//ltxt::print_r($ChainByPayCost);
				$TotalPay = $TotalPay+$ChainByPayCost[0]->SumCost;
				
			  $html .= '<tr>';
			  $html .= '<td style="text-align:center;">'.$od.'<input type="hidden" name="HidTaskNo[]" id="HidTaskNo" value="'.$TaskNo.'" /></td>';
			  $html .= '<td>'.$this->getCostItemName($CostItemCode).'<input type="hidden" name="CostItemCode[]" id="CostItemCode" value="'.$CostItemCode.'" /></td>';
			  $html .= '<td>'.$Detail.'<input type="hidden" name="Detail[]" id="Detail" value="'.$Detail.'" /><input type="hidden" name="CostCode[]" id="CostCode" value="'.$CostCode.'" /></td>';
			  $html .= '<td style="text-align:center;"><input type="text" name="DetailCost[]"  id="DetailCost" value="'.$ChainByPayCost[0]->Detail.'" style="width:95%" /></td>';
			  $html .= '<td style="text-align:right">'.number_format($SumCost,2).'<input type="hidden" name="SumCost[]" id="SumCost" value="'.$SumCost.'" /></td>';
			  $html .= '<td style="text-align:center;"><input type="text" name="SumPay[]" id="SumPay" rel="SumPay" value="'.number_format($ChainByPayCost[0]->SumCost,2).'" style="width:95%; text-align:right" onkeypress="return validChars(event,2)" onkeyup="CalSum()"  /></td>';
			  $html .= '</tr>';
			  
			 	$od++;
			}
			
			$html .= '<tr>';
			$html .= '<td colspan="4" style="text-align:right"><strong>รวมทั้งสิ้น</strong></td>';
			$html .= '<td style="text-align:right">'.number_format($TotalCost,2).'</td>';
			$html .= '<td><input type="text" name="TotalPay" id="TotalPay" value="'.number_format($TotalPay,2).'" style="width:95%; text-align:right; font-weight:bold" readonly="readonly" /></td>';
			$html .= '</tr>';
			
			$html .= '</table>';
			return $html;
			
		}
	/* END */	


	/* Function Name: getCostItemName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย */
		function getCostItemName($CostItemCode=0){
		$where = array();
		$where[] = "CostItemCode = '".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostName "
				."\n from tblbudget_init_cost_item "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
		}
	/* END */	

	/* 
	Function Name: getChainByPayCost 
	Description: เป็นฟังก์ชันสำหรับดึงรายการผูกพันจากตารางผูกพัน
	Parameter: -
	Return Value : Array List	 
	*/
		function getChainByPayCost($CostCode,$CostItemCode,$TaskNoRefer,$DocCodePay,$TableName){ 
		$where = array();
		
		$where[] = "DocCodePay = '".$DocCodePay."'";
		
		//if($CostCode){
		$where[] = "CostCode = '".$CostCode."'";
		//}
		
		if($CostItemCode){
		$where[] = "CostItemCode = '".$CostItemCode."'";
		}		

		if($TaskNoRefer){
		$where[] = "TaskNoRefer = '".$TaskNoRefer."'";
		}		

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select * from ".$TableName
		."\n ".$where_r
		;

		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
		
/*		$Arr = array();
		foreach($data as $v){
			$Arr[] = $v->CostCode.'|'.$v->Detail.'|'.$v->SumCost;
		}
		return $Arr;		
*/		
		
		}
	/* END */	

	
/* 
	Function Name: getMaxPayTask 
	Description: เป็นฟังก์ชันสำหรับดึงครั้งที่ล่าสุดของรายการผูกพัน
	Parameter: -
	Return Value : Single (loadResult) 
*/
	function getMaxPayTask($DocCode,$TableName){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select max(TaskNo) "
				."\n from ".$TableName
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
/* END */	


/*-----------------END  ฟังก์ชันเบิกจ่ายงบประมาณ-----------------*/

	// listbox รายการค่าใช้จ่าย
	///////////////////////////////////////////////////
	var $ArrLevel = array();
	var $Level = 1;
	function getCategoryAllList($Parent=0,$fix=3){
		$sql = "SELECT * FROM tblbudget_init_cost_item where ParentCode='$Parent' AND DeleteStatus='N' AND EnableStatus='Y' ";
		$this->db->setQuery($sql);  //echo "<br>$sql</br>";
		$list = $this->db->loadObjectList(); 

		foreach($list as $rs){			
			$ind = $rs->CostItemCode;
			$Len = strlen($this->getLevel($ind));
			
			if($Len < (($fix-1)*2)){ 
				$this->ArrLevel[$ind] = $this->getLevel($ind).' '.$rs->CostName;
			}
			
			if($this->checkChild($ind)){
				$this->getCategoryAllList($ind,$fix);
			}
			
		}
		
		return $this->ArrLevel;
		
	}
	
	function checkChild($Parent)
	{
		$sql = "SELECT COUNT(*) as Num FROM tblbudget_init_cost_item where ParentCode='$Parent' AND DeleteStatus='N' AND EnableStatus='Y' ";
		$this->db->setQuery($sql); //echo "<br>$sql</br>";
		return $this->db->loadResult(); 
	}
	
	function getLevel($CostItemCode)
	{
		$sql = "SELECT LevelId  FROM tblbudget_init_cost_item where CostItemCode='$CostItemCode' AND DeleteStatus='N' AND EnableStatus='Y' ";
		$this->db->setQuery($sql); //echo "<br>$sql</br>";
		$Id = $this->db->loadResult(); 
		if($Id!=0){
			$Step = '|--'.$this->getLevel($Id);
		}
		return $Step;
	}
	
	function getCType($CostItemCode){
		$sql = "SELECT CostTypeId  FROM tblbudget_init_cost_item where CostItemCode='$CostItemCode' AND DeleteStatus='N' AND EnableStatus='Y' ";
		$this->db->setQuery($sql); //echo "<br>$sql</br>";
		$sctype = $this->db->loadResult(); 
		return $sctype;
	}

	function getCTypeName($CostTypeId){
		$sql = "SELECT CostTypeName  FROM tblbudget_init_cost_type where CostTypeId='$CostTypeId' AND DeleteStatus='N' AND EnableStatus='Y' ";
		$this->db->setQuery($sql); //echo "<br>$sql</br>";
		$sctype = $this->db->loadResult(); 
		return $sctype;
	}	
	
	function getParentCode($CostItemCode){
		$sql = "SELECT ParentCode  FROM tblbudget_init_cost_item where CostItemCode='$CostItemCode' AND DeleteStatus='N' AND EnableStatus='Y' ";
		$this->db->setQuery($sql); //echo "<br>$sql</br>";
		$sctype = $this->db->loadResult(); 
		return $sctype;
	}
	
	function getMaxCode($CostTypeId){
		$sql = "SELECT max(CostItemCode) as CostItemCode  FROM tblbudget_init_cost_item where CostTypeId='$CostTypeId' AND ParentCode=0  AND DeleteStatus='N' AND EnableStatus='Y' ";
		$this->db->setQuery($sql); //echo "<br>$sql</br>";
		$sctype = $this->db->loadResult(); 
		return $sctype;
	}	
			
	////////////////////////////////////////////////


	/*
	Function Name	: getPrjCode
	Description		: เป็นฟังก์ชันสำหรับดึง PrjCode 
	Parameter		:
		@$PrjId = รหัสโครงการ
	Return Value 	: Single(loadResult) 
	*/		
	function getPrjCode($PrjId){
		$where = array();
		$where[] = "PrjId = '".$PrjId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select PrjCode "
				."\n from tblbudget_project"
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */	

	/* 
	Function Name: getGroupChain
	Description: เป็นฟังก์ชันสำหรับดึงกลุ่มของรายการผูกพันจากตารางผูกพัน (ไม่ให้กลุ่มซ้ำกัน)
	Parameter: -
	Return Value : Array List	 
	*/
		function getGroupChain($TaskNo=1,$TaskNoTo=1,$DocCode=''){
		$where = array();
		$where[] = "DocCode = '".$DocCode."'";
		$where[] = "TaskNo BETWEEN '".$TaskNo."' AND '".$TaskNoTo."' ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select DISTINCT TaskNo from tblbudget_bg_chain "
		."\n ".$where_r
		."\n order by TaskNo asc"
		;
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$list = $this->db->loadObjectList();
		return $list;

		}
	/* END */	




	
}// end class
	
