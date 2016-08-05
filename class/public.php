<?php    
include_once 'budget.php';  
class BGPublic extends F_Public  {
	
	function __construct($options=array()){
		foreach($options as $k => $v){ $this->$k = $v;}
		$this->db = &JFactory::getDBO();
	}
	
	/* START #F1 */
	/* Function Name: getCostTypeList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getCostTypeList($selected=0,$tag_attribs='style="width:200px;"',$tag_name='CostTypeId',$lebel='เลือก'){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostTypeId as value , CostTypeName as text "
			 ."\n FROM tblbudget_init_cost_type "
			 ."\n ".$where_r
			 ."\n order by Ordering"
			 ;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
	/* START #F2 */
	/* Function Name: getCostTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: - */
	/* Return Value : Array(loadObjectList) */
	function getCostTypeRecordSet($CostTypeId=0){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		if($CostTypeId){
			$where[] = "CostTypeId = '".$CostTypeId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostTypeId,CostTypeName,Ordering "
			 ."\n FROM tblbudget_init_cost_type "
			 ."\n ".$where_r
			 ."\n order by Ordering"
			 ;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F3 */
	/* Function Name: getCostTypeDataSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: - */
	/* Return Value : Array(loadDataset) */
	function getCostTypeDataSet(){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostTypeId,CostTypeName,Ordering "
			 ."\n FROM tblbudget_init_cost_type "
			 ."\n ".$where_r
			 ."\n order by Ordering"
			 ;
		$this->db->setQuery($sql);
		$datas = $this->db->loadDataset();
		return $datas;
		
	}
	/* END */
	
	/* START #F4 */
	/* Function Name: getCostItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการงบรายจ่ายแต่ละระดับ มีทั้งหมด 3 ระดับ คือ รายการหลัก(1) รายการรอง(2) และรายการย่อย(3)  */
	/* Parameter: */
			/* @CostTypeId	= รหัสหมวดงบประมาณ */
			/* @LevelId	 	 	= รหัสระดับรายการ */
			/* @ParentCode 		= รหัสรายการ Parent */
			/* @selected 			= ค่า selected ของ list box */
			/* @tag_attribs 		= attribute ของ list box */
			/* @tag_name 		= ชื่อ list box */
			/* @lebel 				= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getCostItemList($CostTypeId='',$LevelId=1,$ParentCode=0,$selected=0,$tag_attribs='style="width:200px;"',$tag_name='CostTypeId',$lebel='เลือก'){
		
		$data1 = $this->getCostItemRecordSet($CostTypeId,$LevelId,$ParentCode);//ltxt::print_r($data1);
		$datas = array();
		foreach($data1 as $row){
			$datas[$row->CostItemCode]	= $row->CostName;
			if($row->HasChild=='Y'){
				$LevelId=2; 
				$data2 = $this->getCostItemRecordSet($row->CostTypeId,$LevelId,$row->CostItemCode);//ltxt::print_r($data2);
				foreach($data2 as $row2){
					$LevelId=3;
					$datas[$row2->CostItemCode]	= $row2->CostName;
					if($row2->HasChild=='Y'){
						$data3 = $this->getCostItemRecordSet($row2->CostTypeId,$LevelId,$row2->CostItemCode);
						if($data3){
							foreach($data3 as $row3){
								$datas[$row3->CostItemCode]	= $row3->CostName;
							}
						}
					}
				}
			}
		}
		$html  = '<select name="CostItemCode" id="CostItemCode">';
		$html .= '<option value="0">เลือก</option>';
		foreach($datas as $CostItemCode=>$CostName){
			${$k} = $v;
			if($selected==$CostItemCode) $scl = 'selected="selected"'; else $scl = '';
			$HasChild = $this->checkHasChild($CostItemCode);
			if($HasChild=="Y"){
				$html .= '<optgroup title="'.$CostName.'" label="'.$CostName.'"></optgroup>';
			}else{
				$html .= '<option value="'.$CostItemCode.'" '.$scl.' >'.$CostName.'</option>';
			}
		}
		$html .= '</select>';
		echo $html;
		
	}
	/* END */
	
	/* START #F5 */
	/* Function Name: getCostItemRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: */
			/* @CostTypeId	= รหัสหมวดงบประมาณ */
			/* @LevelId	 	 	= รหัสระดับรายการ */
			/* @ParentCode 		= รหัสรายการ Parent */
	/* Return Value : Array(loadObjectList) */
	function getCostItemRecordSet($CostTypeId=0,$LevelId=1,$ParentCode=0,$HasChild=0,$CostItemCode=0){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		$where[] = "CostTypeId='".$CostTypeId."'";
		$where[] = "LevelId='".$LevelId."'";
		if($ParentCode){
			$where[] = "ParentCode='".$ParentCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostItemId, CostItemCode, CostName, LevelId, ParentCode, HasChild, CostTypeId "
			 ."\n FROM tblbudget_init_cost_item "
			 ."\n ".$where_r
			 ;
			 //echo $sql;
		$this->db->setQuery($sql); //echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F6 */
	/* Function Name: getCostItemDataSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการหมวดงบประมาณ  */
	/* Parameter: */
			/* @CostTypeId	= รหัสหมวดงบประมาณ */
			/* @LevelId	 	 	= รหัสระดับรายการ */
			/* @ParentCode 		= รหัสรายการ Parent */
	/* Return Value : Array(loadDataset) */
	function getCostItemDataSet($CostTypeId=0,$LevelId=1,$ParentCode=0){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		$where[] = "CostTypeId='".$CostTypeId."'";
		$where[] = "LevelId='".$LevelId."'";
		$where[] = "ParentCode='".$ParentCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostItemId, CostItemCode, CostName, LevelId, ParentCode, HasChild, CostTypeId "
			 ."\n FROM tblbudget_init_cost_item "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F7 */
	/* Function Name: getSCTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getSCTypeRecordSet(){
		
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT SCTypeId, SCTypeName, SCTypeName2 "
				."\n FROM "
				."\n tblbudget_init_screen_type "
				."\n ".$where_r
				."\n ORDER BY SCTypeId ASC"
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F8 */
	/* Function Name: getSCTypeCurOrg */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณปัจจุบันของแต่ละหน่วยงาน  */
	/* Parameter: */
			/* @BgtYear			= ปีงบประมาณ */
			/* @OrganizeCode 	= รหัสหน่วยงาน */
	/* Return Value : Array(loadObjectList) */
	function getSCTypeCurOrg($BgtYear=0,$OrganizeCode=0){
		
		$where = array();
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n t1.SCTypeId, t1.ScreenLevel, t1.CloseStep, t1.BgtYear, t1.OrganizeCode, t2.SCTypeName, t2.SCTypeName2 "
				."\n FROM "
				."\n tblbudget_init_year_org AS t1 "
				."\n Inner Join tblbudget_init_screen_type AS t2 ON t1.SCTypeId = t2.SCTypeId "
				."\n ".$where_r
				;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	
	/* START #F10 */
	/* Function Name: getPlanItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการนโยบายแผนงาน  */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getPlanItemList($BgtYear=0,$PGroupId=9,$selected=0,$tag_name='PItemCode',$tag_attribs='onchange="loadPrj(this.value)"',$lebel='เลือก'){

		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "PGroupId='".$PGroupId."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PItemCode as value , PItemName as text "
			 ."\n FROM tblbudget_init_plan_item "
			 ."\n ".$where_r
			 ."\n order by PItemCode ASC "
			  //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */
	
	/* START #F11 */
	/* Function Name: getPlanItemRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการนโยบายแผนงาน  */
	/* Parameter: */
			/* @BgtYear		= ปีงบประมาณ */
			/* @PGroupId	 	= รหัสกลุ่มนโยบายแผนงาน */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : Array(loadObjectList) */
	function getPlanItemRecordSet($BgtYear=0,$PGroupId=10){

		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "PGroupId='".$PGroupId."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT * "
			 ."\n FROM tblbudget_init_plan_item "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F12 */
	/* Function Name: getPlanIndicatorDataSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการตัวชี้วัดของนโยบายแผนงานแต่ละรายการ  */
	/* Parameter: */
			/* @PItemId	= รหัสรายการนโยบายแผนงาน */
	/* Return Value : Array(loadDataset) */
	function getPlanIndicatorDataSet($PItemId=0){
		
		$where = array();
		$where[] = "t1.PItemId='".$PItemId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.PIndId, t1.PItemId, t1.PIndName, t1.IndTypeId, t1.Value, t1.UnitId, t1.Ordering, t2.UnitName, t3.IndTypeName "
				."\n FROM "
				."\n tblbudget_init_plan_item_indicator as t1 "
				."\n left join tblunit as t2 on t2.UnitId=t1.UnitId "
				."\n left join tblbudget_init_indicator_type as t3 on t3.IndTypeId=t1.IndTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadDataset();
		return $datas;
	}
	/* END */
	
	/* START #F13 */
	/* Function Name: getSCTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการตัวชี้วัดของนโยบายแผนงานแต่ละรายการ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getPlanItemIndRecordSet($PItemId=0){
		
		$where = array();
		$where[] = "t1.PItemId='".$PItemId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.PIndId, t1.PItemId, t1.PIndName, t1.IndTypeId, t1.Value, t1.UnitId, t1.Ordering, t2.UnitName, t3.IndTypeName "
				."\n FROM "
				."\n tblbudget_init_plan_item_indicator as t1 "
				."\n left join tblunit as t2 on t2.UnitId=t1.UnitId "
				."\n left join tblbudget_init_indicator_type as t3 on t3.IndTypeId=t1.IndTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */
	
	/* START #F14 */
	/* Function Name: getIndTypeList */
	/* Description: เป็นฟังก์ชันสำหรับดึงประเภทตัวชี้วัด */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getIndTypeList($selected=0,$tag_attribs='style="width:200px;"',$tag_name='IndTypeId',$lebel='เลือก'){

		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT IndTypeId as value , IndTypeName as text "
				."\n FROM "
				."\n tblbudget_init_indicator_type "
				."\n ".$where_r
				."\n order by Ordering "
				;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	/* END */
	
	/* START #F15 */
	/* Function Name: getPlanIndicatorDataSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงประเภทตัวชี้วัด  */
	/* Parameter: - */
	/* Return Value : Array(loadDataset) */
	function getIndTypeDataSet(){
		
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT IndTypeId, IndTypeName, Ordering "
				."\n FROM "
				."\n tblbudget_init_indicator_type "
				."\n ".$where_r
				."\n order by Ordering "
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadDataset();
		return $datas;
		
	}
	/* END */
	
	/* START #F16 */
	/* Function Name: getIndTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงประเภทตัวชี้วัด */
	/* Parameter: */
			/* @IndTypeId	= รหัสประเภทตัวชี้วัด */
	/* Return Value : Array(loadObjectList) */
	function getIndTypeRecordSet($IndTypeId=0){
		
		$where = array();
		if($IndTypeId){
			$where[] = "IndTypeId='".$IndTypeId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT IndTypeId, IndTypeName, Ordering "
				."\n FROM "
				."\n tblbudget_init_indicator_type "
				."\n ".$where_r
				."\n order by Ordering "
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F17 */
	/* Function Name: getIndProjectList */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดโครงการประจำปี */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getIndProjectList($selected=0,$tag_attribs='style="width:500px;"',$tag_name='IndId',$lebel='เลือก'){

		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT IndId as value , IndName as text "
				."\n FROM "
				."\n tblbudget_init_indicator as t1 "
				."\n left join tblbudget_init_indicator_type as t2 on t2.IndTypeId=t1.IndTypeId "
				."\n ".$where_r
				."\n order by t1.Ordering "
				;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	/* END */
	
	/* START #F18 */
	/* Function Name: getIndProjectDataSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดโครงการประจำปี  */
	/* Parameter: - */
	/* Return Value : Array(loadDataset) */
	function getIndProjectDataSet(){
		
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.IndId, t1.IndName, t1.BgtYear, t1.IndTypeId, t1.Ordering, t2.IndTypeName "
				."\n FROM "
				."\n tblbudget_init_indicator as t1 "
				."\n left join tblbudget_init_indicator_type as t2 on t2.IndTypeId=t1.IndTypeId "
				."\n ".$where_r
				."\n order by t1.Ordering "
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadDataset();
		return $datas;
		
	}
	/* END */
	
	/* START #F19 */
	/* Function Name: getIndProjectRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดโครงการประจำปี */
	/* Parameter: */
			/* @IndId	= รหัสตัวชี้วัดโครงการ */
	/* Return Value : Array(loadObjectList) */
	function getIndProjectRecordSet($IndId=0){
		
		$where = array();
		if($IndId){
			$where[] = "IndId='".$IndId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.IndId, t1.IndName, t1.BgtYear, t1.IndTypeId, t1.Ordering, t2.IndTypeName "
				."\n FROM "
				."\n tblbudget_init_indicator as t1 "
				."\n left join tblbudget_init_indicator_type as t2 on t2.IndTypeId=t1.IndTypeId "
				."\n ".$where_r
				."\n order by t1.Ordering "
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F20 */
	/* Function Name: getProjectList */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการประจำปี */
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getProjectList($BgtYear=0,$PItemId=0,$OrganizeCode=0,$tag_name='PrjId',$selected=0,$tag_attribs='style="width:500px;"',$lebel='เลือก'){

		$where = array();
		
		$where[] = "t1.EnableStatus='Y'";
		$where[] = "t1.DeleteStatus='N'";	
		
		///if($OrganizeCode){
			$where[] = " t1.OrganizeCode='".$OrganizeCode."'";
		//}			
		
		if($BgtYear){
			$where[] = " t1.BgtYear='".$BgtYear."' ";
		}
		if($PItemCode){
			$where[] = " t1.PItemCode='".$PItemCode."' ";
		}


		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PrjId as value , PrjName as text "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_init_plan_item AS t2 ON t1.PItemId = t2.PItemId "
				."\n Inner Join tblorganize AS t3 ON t1.BgtYear = t3.OrgYear AND t1.OrganizeCode = t3.OrganizeCode "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	/* END */
	
	/* START #F21 */
	/* Function Name: getProjectDataSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการประจำปี  */
	/* Parameter: - */
	/* Return Value : Array(loadDataset) */
	function getProjectDataSet(){
		
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
			."\n t1.*, t2.PItemName, t3.OrgName, t3.OrgShortName "
			."\n FROM "
			."\n tblbudget_project AS t1 "
			."\n Inner Join tblbudget_init_plan_item AS t2 ON t1.PItemCode = t2.PItemCode "
			."\n Inner Join tblorganize AS t3 ON t1.BgtYear = t3.OrgYear AND t1.OrganizeCode = t3.OrganizeCode "
			."\n ".$where_r
			;
		$this->db->setQuery($sql);
		$datas = $this->db->loadDataset();
		return $datas;
		
	}
	/* END */
	
	/* START #F22 */
	/* Function Name: getProjectRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการประจำปี */
	/* Parameter: */
			/* @IndId	= รหัสตัวชี้วัดโครงการ */
	/* Return Value : Array(loadObjectList) */
	function getProjectRecordSet($PrjId=0){
		
		$where = array();
		if($PrjId){
			$where[] = "PrjId='".$PrjId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
			."\n t1.*, t2.PItemName, t3.OrgName, t3.OrgShortName "
			."\n FROM "
			."\n tblbudget_project AS t1 "
			."\n Inner Join tblbudget_init_plan_item AS t2 ON t1.PItemCode = t2.PItemCode "
			."\n Inner Join tblorganize AS t3 ON t1.BgtYear = t3.OrgYear AND t1.OrganizeCode = t3.OrganizeCode "
			."\n ".$where_r
			;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F23 */
	/* Function Name: getProjectDetailDataSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการประจำปีแต่ละชุดขั้นตอนฯ  */
	/* Parameter: - */
	/* Return Value : Array(loadDataset) */
	function getProjectDetailDataSet(){
		
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
		."\n t1.*, "
		."\n t2.PrjCode, "
		."\n t2.BgtYear, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t2.OrganizeCode, "
		."\n t3.PItemName, "
		."\n t4.OrgName, "
		."\n t4.OrgShortName, "
		."\n t5.StatusName, "
		."\n t5.TextColor, "
		."\n t5.Icon "
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n Inner Join tblbudget_init_plan_item AS t3 ON t2.PItemCode = t3.PItemCode "
		."\n Inner Join tblorganize AS t4 ON t2.OrganizeCode = t4.OrganizeCode AND t2.BgtYear = t4.OrgYear "
		."\n inner Join tblbudget_init_status as t5 on t5.StatusId = t1.StatusId "
		."\n ".$where_r
		;
		//echo $sql;
		$this->db->setQuery($sql);
		$datas = $this->db->loadDataset();
		return $datas;
		
	}
	/* END */
	
	/* START #F24 */
	/* Function Name: getProjectDetailRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการประจำปีแต่ละชุดขั้นตอนฯ */
	/* Parameter: */
			/* @PrjDetailId	= รหัสโครงการแต่ละชุดขั้นตอนฯ */
	/* Return Value : Array(loadObjectList) */
	function getProjectDetailRecordSet($PrjDetailId=0){
		
		$where = array();
		if($PrjDetailId){
			$where[] = "PrjDetailId='".$PrjDetailId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
		."\n t1.*, "
		."\n t2.PrjCode, "
		."\n t2.BgtYear, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t2.OrganizeCode, "
		."\n t3.PItemName, "
		."\n t4.OrgName, "
		."\n t4.OrgShortName, "
		."\n t5.StatusName, "
		."\n t5.TextColor, "
		."\n t5.Icon "
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n Inner Join tblbudget_init_plan_item AS t3 ON t2.PItemCode = t3.PItemCode "
		."\n Inner Join tblorganize AS t4 ON t2.OrganizeCode = t4.OrganizeCode AND t2.BgtYear = t4.OrgYear "
		."\n inner Join tblbudget_init_status as t5 on t5.StatusId = t1.StatusId "
		."\n ".$where_r
		;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F25 */
	/* Function Name: getProjectDetailActRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงกิจกรรมของโครงการประจำปีแต่ละชุดขั้นตอนฯ */
	/* Parameter: */
			/* @PrjDetailId	= รหัสโครงการแต่ละชุดขั้นตอนฯ */
	/* Return Value : Array(loadObjectList) */
	function getProjectDetailActRecordSet($PrjDetailId=0){
		
		$where = array();
		//if($PrjDetailId){
			$where[] = "PrjDetailId='".$PrjDetailId."'";
		//}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT * "
				."\n FROM "
				."\n tblbudget_project_activity "
				."\n ".$where_r
				."\n order by PrjActId ASC "
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F26 */
	/* Function Name: getProjectDetailIndRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงตัวชี้วัดของโครงการประจำปีแต่ละชุดขั้นตอนฯ */
	/* Parameter: */
			/* @PrjDetailId	= รหัสโครงการแต่ละชุดขั้นตอนฯ */
	/* Return Value : Array(loadObjectList) */
	function getProjectDetailIndRecordSet($PrjDetailId=0){
		
		$where = array();
		if($PrjDetailId){
			$where[] = "PrjDetailId='".$PrjDetailId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n t1.*, t3.IndTypeName, t2.IndName "
				."\n FROM "
				."\n tblbudget_project_indicator AS t1 "
				."\n Inner Join tblbudget_init_indicator AS t2 ON t1.IndId = t2.IndId "
				."\n Inner Join tblbudget_init_indicator_type AS t3 ON t2.IndTypeId = t3.IndTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F27 */
	/* Function Name: getProjectDetailIndRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงไฟล์แนบของโครงการประจำปีแต่ละชุดขั้นตอนฯ */
	/* Parameter: */
			/* @PrjDetailId	= รหัสโครงการแต่ละชุดขั้นตอนฯ */
	/* Return Value : Array(loadObjectList) */
	function getProjectDetailFileRecordSet($PrjDetailId=0){
		
		$where = array();
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t2.* "
				."\n FROM "
				."\n tblbudget_project_file AS t1 "
				."\n Inner Join tblintra_edoc_center AS t2 ON t1.DocId = t2.DocId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F28 */
	/* Function Name: getProjectDetailCheckRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลการตรวจสอบโครงการประจำปีแต่ละชุดขั้นตอนฯ */
	/* Parameter: */
			/* @PrjDetailId	= รหัสโครงการแต่ละชุดขั้นตอนฯ */
	/* Return Value : Array(loadObjectList) */
	function getProjectDetailCheckRecordSet($PrjDetailId=0,$ChkId=0){
		
		$where = array();
		$where[] = "PrjDetailId='".$PrjDetailId."'";
		if($ChkId){
			$where[] = "ChkId='".$ChkId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT *  "
				."\n FROM "
				."\n tblbudget_project_check "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F29 */
	/* Function Name: getProjectDetailCountCheckRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับนับจำนวนการตรวจสอบโครงการประจำปีแต่ละชุดขั้นตอนฯ */
	/* Parameter: */
			/* @PrjDetailId	= รหัสโครงการแต่ละชุดขั้นตอนฯ */
	/* Return Value : Array(loadObjectList) */
	function getProjectDetailCountCheckRecordSet($PrjDetailId=0){
		
		$where = array();
		if($PrjDetailId){
			$where[] = "PrjDetailId='".$PrjDetailId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT count(*)  "
				."\n FROM "
				."\n tblbudget_project_check "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	//////////////////////////////---------------------------------------------------------------------------------------------------////////////////////////////////////////////
	
	/* START #F30 */
	/* Function Name: getX4BGInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการงบรายจ่าย X4ช่อง(เงินงบประมาณ) */
	/* Parameter: */
			/* @PrjDetailId	= - */
			/* @PrjActId		= - */
			/* @CostIntId		= - */
	/* Return Value : Array(loadObjectList) */
	function getX4BGInternal($PrjDetailId=0,$PrjActId=0,$CostIntId=0){
		
		$where = array();
		if($PrjDetailId){
			$where[] = "t3.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t2.PrjActId='".$PrjActId."'";
		}
		if($CostIntId){
			$where[] = "t1.CostIntId='".$CostIntId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblbudget_project_activity_cost_internal AS t1 "
				."\n Inner Join tblbudget_project_activity AS t2 ON t1.PrjActId = t2.PrjActId "
				."\n Inner Join tblbudget_project_detail AS t3 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F31 */
	/* Function Name: getX4BGExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการงบรายจ่าย X4ช่อง(เงินนอกงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Array(loadObjectList) */
	function getX4BGExternal($PrjDetailId=0,$PrjActId=0,$CostExtId=0){
		
		$where = array();
		if($PrjDetailId){
			$where[] = "t3.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t2.PrjActId='".$PrjActId."'";
		}
		if($CostExtId){
			$where[] = "t1.CostExtId='".$CostExtId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblbudget_project_activity_cost_external AS t1 "
				."\n Inner Join tblbudget_project_activity AS t2 ON t1.PrjActId = t2.PrjActId "
				."\n Inner Join tblbudget_project_detail AS t3 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F32 */
	/* Function Name: getMonthInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการงบรายจ่ายรายเดือน/ไตรมาส(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Array(loadObjectList) */
	function getMonthInternal($PrjDetailId=0,$PrjActId=0,$CostIntId=0,$MonthNo=0){
		
		$where = array();
		if($PrjDetailId){
			$where[] = "t4.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($CostIntId){
			$where[] = "t2.CostIntId='".$CostIntId."'";
		}
		if($MonthNo){
			$where[] = "t1.MonthNo='".$MonthNo."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*, t5.MonthNameTH "
		."\n FROM "
		."\n tblbudget_project_activity_cost_internal_month AS t1 "
		."\n Inner Join tblbudget_project_activity_cost_internal AS t2 ON t1.CostIntId = t2.CostIntId "
		."\n Inner Join tblbudget_project_activity AS t3 ON t2.PrjActId = t3.PrjActId "
		."\n Inner Join tblbudget_project_detail AS t4 ON t3.PrjDetailId = t4.PrjDetailId "
		."\n Inner Join tblbudget_month AS t5 ON t1.MonthNo = t5.MonthNo "
		."\n ".$where_r
		;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F33 */
	/* Function Name: getMonthExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการงบรายจ่ายรายเดือน/ไตรมาส(เงินนอกงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Array(loadObjectList) */
	function getMonthExternal($PrjDetailId=0,$PrjActId=0,$CostExtId=0,$MonthNo=0){
		
		$where = array();
		if($PrjDetailId){
			$where[] = "t4.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($CostExtId){
			$where[] = "t2.CostExtId='".$CostExtId."'";
		}
		if($MonthNo){
			$where[] = "t1.MonthNo='".$MonthNo."'";
		}

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*, t5.MonthNameTH "
		."\n FROM "
		."\n tblbudget_project_activity_cost_external_month AS t1 "
		."\n Inner Join tblbudget_project_activity_cost_external AS t2 ON t1.CostExtId = t2.CostExtId "
		."\n Inner Join tblbudget_project_activity AS t3 ON t2.PrjActId = t3.PrjActId "
		."\n Inner Join tblbudget_project_detail AS t4 ON t3.PrjDetailId = t4.PrjDetailId "
		."\n Inner Join tblbudget_month AS t5 ON t1.MonthNo = t5.MonthNo "
		."\n ".$where_r
		;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F34 */
	/* Function Name: getAllot */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลงบกลั่นกรอง/จัดสรร/ปรับงบกลางปี */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Array(loadObjectList) */
	function getAllot($BgtYear=0,$OrganizeCode=0,$AllotId=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($AllotId){
			$where[] = "t1.AllotId='".$AllotId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*, t2.OrgName, t2.OrgShortName, t2.OrgId "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n Inner Join tblorganize AS t2 ON t1.OrganizeCode = t2.OrganizeCode AND t1.BgtYear = t2.OrgYear "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F35 */
	/* Function Name: getBGAllotInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบกลั่นกรอง/จัดสรร/ปรับรายการงบรายจ่าย(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getBGAllotInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}

		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}
		
		if($PrjActId){
			$where[] = "t1.PrjActId='".$PrjActId."'";
		}
		
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}
				
		if($AllotId){
			$where[] = "t2.AllotId='".$AllotId."'";
		}
								
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t3.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t4.CostTypeId='".$CostTypeId."'";
		}	
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
				
		$sql="SELECT "
				."\n t2.BGAllot "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n Inner Join tblbudget_allot_internal AS t2 ON t2.AllotId = t1.AllotId "
				."\n Inner Join tblbudget_init_cost_item AS t3 ON t3.CostItemCode = t2.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t4 ON t4.CostTypeId = t3.CostTypeId "
				."\n ".$where_r
				;				
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	/* START #F36 */
	/* Function Name: getBGTotalInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดรวมงบกลั่นกรอง/จัดสรร/ปรับรายการงบรายจ่าย(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
/*	function getBGTotalInternal($BgtYear=0,$OrganizeCode=0,$AllotId=0,$CostTypeId=0,$CostItemCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}
		if($AllotId){
			$where[] = "t1.AllotId='".$AllotId."'";
		}
		if($CostTypeId){
			$where[] = "t5.CostTypeId='".$CostTypeId."'";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}	
		
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}	
		
		if($PrjActId){
			$where[] = "t2.PrjActId='".$PrjActId."'";
		}	
					
		if($PrjActCode){
			$where[] = "t2.PrjActCode='".$PrjActCode."'";
		}	
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t1.BGTotal) "
				."\n FROM "
				."\n tblbudget_allot_internal as t1 "
				."\n Inner Join tblbudget_allot AS t2 ON t1.AllotId = t2.AllotId "
				."\n Inner Join tblorganize AS t3 ON t2.OrganizeCode = t3.OrganizeCode AND t2.BgtYear = t3.OrgYear "
				."\n Inner Join tblbudget_init_cost_item AS t4 ON t4.CostItemCode = t1.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t5 ON t5.CostTypeId = t4.CostTypeId "
				."\n ".$where_r
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}*/
	/* END */
	
	
	/* START #F36 */
	/* Function Name: getBGTotalInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดรวมงบกลั่นกรอง/จัดสรร/ปรับรายการงบรายจ่าย(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getBGTotalInternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "BgtYear='".$BgtYear."'";
		}
		
		if($OrganizeCode){
			$where[] = "OrganizeCode='".$OrganizeCode."'";
		}
	
		if($ScreenLevel){
			$where[] = "ScreenLevel='".$ScreenLevel."'";
		}
		
		if($SCTypeId){
			$where[] = "SCTypeId='".$SCTypeId."'";
		}	
		
		if($PrjDetailId){
			$where[] = "PrjDetailId='".$PrjDetailId."'";
		}	
		
		if($AllotId){
			$where[] = "AllotId='".$AllotId."'";
		}
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(BGInternal) "
				."\n FROM "
				."\n tblbudget_allot "
				."\n ".$where_r
				;
		//echo "IN<br><pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
		
	
	/* START #F37 */
	/* Function Name: getBGAllotExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบกลั่นกรองรายการงบรายจ่าย(เงินนอกงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getBGAllotExternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){		
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}

		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}
			
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}
		
		if($PrjActId){
			$where[] = "t1.PrjActId='".$PrjActId."'";
		}
		
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}		
		
		if($AllotId){
			$where[] = "t2.AllotId='".$AllotId."'";
		}
	
								
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t3.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t4.CostTypeId='".$CostTypeId."'";
		}	
		
		if($SourceExId){
			$where[] = "t2.SourceExId='".$SourceExId."'";
		}		
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
				
		$sql="SELECT "
				."\n t2.BGAllot "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n Inner Join tblbudget_allot_external AS t2 ON t2.AllotId = t1.AllotId "
				."\n Inner Join tblbudget_init_cost_item AS t3 ON t3.CostItemCode = t2.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t4 ON t4.CostTypeId = t3.CostTypeId "
				."\n ".$where_r
				;				
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;		
	}
	/* END */
	
	/* START #F38 */
	/* Function Name: getBGTotalExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดรวมงบกลั่นกรองรายการงบรายจ่าย(เงินนอกงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	
	function getBGTotalExternal($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0,$SourceExId=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "BgtYear='".$BgtYear."'";
		}
		
		if($OrganizeCode){
			$where[] = "OrganizeCode='".$OrganizeCode."'";
		}
	
		if($ScreenLevel){
			$where[] = "ScreenLevel='".$ScreenLevel."'";
		}
		
		if($SCTypeId){
			$where[] = "SCTypeId='".$SCTypeId."'";
		}		
		
		if($PrjDetailId){
			$where[] = "PrjDetailId='".$PrjDetailId."'";
		}			
		
		if($AllotId){
			$where[] = "AllotId='".$AllotId."'";
		}
				
		if($SourceExId){
			$where[] = "SourceExId='".$SourceExId."'";
		}

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(BGExternal) "
				."\n FROM "
				."\n tblbudget_allot_external "
				."\n ".$where_r
				;
		//echo "Ex<br><pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */	
	
	/* START #F38 */
	/* Function Name: getBGTotalExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดรวมงบกลั่นกรองรายการงบรายจ่าย(เงินนอกงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
/*	function getBGTotalExternal($BgtYear=0,$OrganizeCode=0,$AllotId=0,$CostTypeId=0,$CostItemCode=0,$ScreenLevel=0,$SCTypeId=0,$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}
		if($AllotId){
			$where[] = "t1.AllotId='".$AllotId."'";
		}
		if($CostTypeId){
			$where[] = "t5.CostTypeId='".$CostTypeId."'";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}		
		
		if($SourceExId){
			$where[] = "t1.SourceExId='".$SourceExId."'";
		}
		
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}	
		
		if($PrjActId){
			$where[] = "t2.PrjActId='".$PrjActId."'";
		}	
					
		if($PrjActCode){
			$where[] = "t2.PrjActCode='".$PrjActCode."'";
		}	
		
		

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t1.BGTotal) "
				."\n FROM "
				."\n tblbudget_allot_external as t1 "
				."\n Inner Join tblbudget_allot AS t2 ON t1.AllotId = t2.AllotId "
				."\n Inner Join tblorganize AS t3 ON t2.OrganizeCode = t3.OrganizeCode AND t2.BgtYear = t3.OrgYear "
				."\n Inner Join tblbudget_init_cost_item AS t4 ON t4.CostItemCode = t1.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t5 ON t5.CostTypeId = t4.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}*/
	/* END */
	
	/* START #F39 */
	/* Function Name: getBGIncreaseInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบปรับเพิ่มการจัดสรร/ปรับงบกลางปีรายการงบรายจ่าย(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getBGIncreaseInternal($BgtYear=0,$OrganizeCode=0,$AllotId=0,$CostTypeId=0,$CostItemCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}
		if($AllotId){
			$where[] = "t1.AllotId='".$AllotId."'";
		}
		if($CostTypeId){
			$where[] = "t5.CostTypeId='".$CostTypeId."'";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n t1.BGIncrease "
				."\n FROM "
				."\n tblbudget_allot_internal as t1 "
				."\n Inner Join tblbudget_allot AS t2 ON t1.AllotId = t2.AllotId "
				."\n Inner Join tblorganize AS t3 ON t2.OrganizeCode = t3.OrganizeCode AND t2.BgtYear = t3.OrgYear "
				."\n Inner Join tblbudget_init_cost_item AS t4 ON t4.CostItemCode = t1.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t5 ON t5.CostTypeId = t4.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	/* START #F40 */
	/* Function Name: getBGDecreaseInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบปรับลดการจัดสรร/ปรับงบกลางปีรายการงบรายจ่าย(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getBGDecreaseInternal($BgtYear=0,$OrganizeCode=0,$AllotId=0,$CostTypeId=0,$CostItemCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}
		if($AllotId){
			$where[] = "t1.AllotId='".$AllotId."'";
		}
		if($CostTypeId){
			$where[] = "t5.CostTypeId='".$CostTypeId."'";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n t1.BGDecrease "
				."\n FROM "
				."\n tblbudget_allot_internal as t1 "
				."\n Inner Join tblbudget_allot AS t2 ON t1.AllotId = t2.AllotId "
				."\n Inner Join tblorganize AS t3 ON t2.OrganizeCode = t3.OrganizeCode AND t2.BgtYear = t3.OrgYear "
				."\n Inner Join tblbudget_init_cost_item AS t4 ON t4.CostItemCode = t1.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t5 ON t5.CostTypeId = t4.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	/* START #F41 */
	/* Function Name: getBGIncreaseExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบปรับเพิ่มจัดสรร/ปรับงบกลางปีรายการงบรายจ่าย(เงินนอกงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getBGIncreaseExternal($BgtYear=0,$OrganizeCode=0,$AllotId=0,$CostTypeId=0,$CostItemCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}
		if($AllotId){
			$where[] = "t1.AllotId='".$AllotId."'";
		}
		if($CostTypeId){
			$where[] = "t5.CostTypeId='".$CostTypeId."'";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n t1.BGIncrease "
				."\n FROM "
				."\n tblbudget_allot_external as t1 "
				."\n Inner Join tblbudget_allot AS t2 ON t1.AllotId = t2.AllotId "
				."\n Inner Join tblorganize AS t3 ON t2.OrganizeCode = t3.OrganizeCode AND t2.BgtYear = t3.OrgYear "
				."\n Inner Join tblbudget_init_cost_item AS t4 ON t4.CostItemCode = t1.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t5 ON t5.CostTypeId = t4.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	/* START #F42 */
	/* Function Name: getBGDecreaseExternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบปรับลดจัดสรร/ปรับงบกลางปีรายการงบรายจ่าย(เงินนอกงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getBGDecreaseExternal($BgtYear=0,$OrganizeCode=0,$AllotId=0,$CostTypeId=0,$CostItemCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}
		if($AllotId){
			$where[] = "t1.AllotId='".$AllotId."'";
		}
		if($CostTypeId){
			$where[] = "t5.CostTypeId='".$CostTypeId."'";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n t1.BGDecrease "
				."\n FROM "
				."\n tblbudget_allot_external as t1 "
				."\n Inner Join tblbudget_allot AS t2 ON t1.AllotId = t2.AllotId "
				."\n Inner Join tblorganize AS t3 ON t2.OrganizeCode = t3.OrganizeCode AND t2.BgtYear = t3.OrgYear "
				."\n Inner Join tblbudget_init_cost_item AS t4 ON t4.CostItemCode = t1.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t5 ON t5.CostTypeId = t4.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	/* START #F43 */
	/* Function Name: getResult */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลผลการดำเนินงานของแต่ละกิจกรรมในโครงการ */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Array(loadObjectList) */
	function getResult($PrjActCode=0,$ResultId=0){
		
		$where = array();
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}
		if($ResultId){
			$where[] = "t1.ResultId='".$ResultId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblbudget_project_activity_result AS t1 "
				."\n Inner Join tblbudget_project_activity AS t2 ON t1.PrjActId = t2.PrjActId "
				."\n Inner Join tblbudget_project_detail AS t3 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F44 */
	/* Function Name: getResultFile */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลไฟล์แนบผลการดำเนินงานของแต่ละกิจกรรมในโครงการ */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Array(loadObjectList) */
	function getResultFile($ResultId=0){
		
		$where = array();
		if($ResultId){
			$where[] = "t1.ResultId='".$ResultId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t2.* "
				."\n FROM "
				."\n tblbudget_project_activity_result_file AS t1 "
				."\n Inner Join tblintra_edoc_center AS t2 ON t1.DocId = t2.DocId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F45 */
	/* Function Name: getProgressResult */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของ % ความก้าวหน้าการดำเนินโครงการ */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getProgressResult($PrjActCode=0,$ResultId=0){
		
		$where = array();
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}
		if($ResultId){
			$where[] = "t1.ResultId='".$ResultId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(Progress) as total "
				."\n FROM "
				."\n tblbudget_project_activity_result AS t1 "
				."\n Inner Join tblbudget_project_activity AS t2 ON t1.PrjActId = t2.PrjActId "
				."\n Inner Join tblbudget_project_detail AS t3 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */

	/* START #F46 */
	/* Function Name: checkHasChild */
	/* Description: เป็นฟังก์ชันสำหรับดึงฟิลด์ HasChild(มีรายการลูกหรือไม่? N/Y) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function checkHasChild($CostItemCode){
		$where = array();
		$where[] = "CostItemCode='".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT HasChild "
			 ."\n FROM tblbudget_init_cost_item "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo $sql;
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START F47*/
	/* Function Name: getYear */
	/* Description: เป็นฟังชั่นสำหรับดึงปีงบประมาณ
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getYear($selected=0,$tag_name='BgtYear',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
		$selected = ($selected)?$selected:(date("Y")+543);
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT BgtYear as value , BgtYear as text "
			 ."\n FROM tblbudget_init_year "
			 ."\n ".$where_r
			 ."\n order by BgtYear desc"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/* END */	
	
	/* START  F48*/
	/* Function Name: getOrg */
	/* Description: เป็นฟังชั่นสำหรับดึงหน่วยงาน
	/* Parameter: */
			/* @selected 		= ค่า selected ของ list box */
			/* @tag_attribs 	= attribute ของ list box */
			/* @tag_name 	= ชื่อ list box */
			/* @lebel 			= lebel ของ option ตัวแรก*/
	/* Return Value : List Box */
	function getOrganizeCode($BgtYear=0,$selected=0,$tag_name='OrganizeCode',$tag_attribs='onchange="getfilterorg()"',$lebel='เลือก'){
		
		$where = array();
		$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "t1.BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.OrganizeCode as value , t2.OrgName as text "
			."\n FROM "
			."\n tblbudget_init_year_org as t1  "
			."\n left Join tblorganize AS t2 ON t1.OrgId = t2.OrgId AND t1.BgtYear = t2.OrgYear "
			."\n ".$where_r
			."\n ORDER BY CONVERT(t2.OrgName USING TIS620) ASC "
			;
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	/*END*/
	
	function getOrganizeCode2($BgtYear=0,$selected=0,$tag_name='OrganizeCode',$tag_attribs='onchange="getfilterorg()"',$lebel='เลือก'){
		
		$where = array();
		$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "BgtYear = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.OrganizeCode as value , t2.OrgName as text "
			."\n FROM "
			."\n tblbudget_init_year_org AS t1 "
			."\n Inner Join tblorganize AS t2 ON t1.OrganizeCode = t2.OrganizeCode AND t1.BgtYear = t2.OrgYear "
			."\n ".$where_r
			;
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		return clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	
	/* END */	
	
/* START #F49 */
	/* Function Name: getTotalPrjInternalX4 */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjId){
			$where[] = "t1.PrjId='".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t4.SumCost)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_internal AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n ".$where_r
				;
				
		//echo "<pre>IN <br>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START #F50 */
	/* Function Name: getTotalPrjExternalX4 */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjId){
			$where[] = "t1.PrjId='".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if($SourceExId){
			$where[] = "t4.SourceExId='".$SourceExId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t4.SumCost)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_external AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n Inner Join tblbudget_init_source_external AS t8 ON t8.SourceExId = t4.SourceExId "
				."\n ".$where_r
				;
		//echo "<pre>EX<br>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}

	/* END */
	
	/* START #F51 */
	/* Function Name: getTotalPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ+เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */	

	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild=""){
		$BgtYear = ($BgtYear)?$BgtYear:(date("Y")+543);
		$BGInt		= $this->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$BGExt		= $this->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		
		$BGTotal	= $BGInt+$BGExt;
		return $BGTotal;
	}
	/* END */	

/*	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemId=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0){
		$BgtYear = ($BgtYear)?$BgtYear:(date("Y")+543);
		$BGInt		= $this->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$PItemId,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel);
		$BGExt		= $this->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$PItemId,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId);
		$BGTotal	= $BGInt+$BGExt;
		//echo "<pre>$BGTotal</pre>";
		return $BGTotal;
	}*/
	
	
	/* START #F52 */
	/* Function Name: getNextSCType */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนต่อไปของการจัดทำงบประมาณ  */
	/* Parameter: */
			/* @SCTypeId = ID ขั้นตอนการจัดทำงบประมาณ */
			/* @ScreenLevel = ระดับการกลั่นกลอง */
	/* Return Value : Array(loadObjectList) */
	function getNextSCType($SCTypeId=0, $ScreenLevel=0,$BgtYear=0){
		//echo "<br>SCTypeId=".$SCTypeId;
		//echo "<br>ScreenLevel=".$ScreenLevel;
		//echo "<br>BgtYear=".$BgtYear;
		
		//$SCTypeId = ($_REQUEST["SCTypeId"])?$_REQUEST["SCTypeId"]:$SCTypeId;		
		//$ScreenLevel = ($_REQUEST["ScreenLevel"])?$_REQUEST["ScreenLevel"]:$ScreenLevel;		
		
		$countScreenLevel = $this->countScreenLevel($BgtYear,$SCTypeId);
		//echo "countScreenLevel=".$countScreenLevel;
		
		$where = array();
		
		if($SCTypeId == 1 || $SCTypeId == 3){
			
			$nextScreenLevel = $ScreenLevel+1;
			$nextSCTypeLevel = $SCTypeId+1;
			
			$where[] = "t2.ScreenLevel='".$nextScreenLevel."'";
			$where[] = "t2.BgtYear='".$BgtYear."'";
			$selectT2 = ", t2.ScreenLevel,t2.ScreenName";
			$fromT2 = "left join tblbudget_init_screen_item  AS t2 on t1.SCTypeId=t2.SCTypeId";
			
		//}else if($SCTypeId == 2  && $ScreenLevel < $countScreenLevel ){
		}else if(($SCTypeId == 2 || $SCTypeId == 4 ) && $ScreenLevel < $countScreenLevel ){
			
			$nextScreenLevel = $ScreenLevel+1;
			$nextSCTypeLevel = $SCTypeId;
	
			$where[] = "t2.ScreenLevel='".$nextScreenLevel."'";
			$where[] = "t2.BgtYear='".$BgtYear."'";
			$selectT2 = ", t2.ScreenLevel,t2.ScreenName";
			$fromT2 = "left join tblbudget_init_screen_item  AS t2 on t1.SCTypeId=t2.SCTypeId";
			
		}else{
			
			$nextScreenLevel = 0;
			$nextSCTypeLevel = $SCTypeId+1;
			
		}
		
		$where[] = "t1.SCTypeId='".$nextSCTypeLevel."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT  t1.SCTypeId, t1.SCTypeName, t1.SCTypeName2".$selectT2
		."\n FROM "
		."\n tblbudget_init_screen_type AS t1  "
		.$fromT2
		."\n ".$where_r
		;
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

				
	}
	/* END */	
	
	/* START #F53 */
	/* Function Name: getSCTypeName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อขั้นตอนการจัดทำงบประมาณ  */
	/* Parameter: */
			/* @SCTypeId	= ID ขั้นตอนการจัดทำงบประมาณ */
	/* Return Value : Single(loadResult) */
	function getSCTypeName($SCTypeId=0){
		
		$SCTypeId = ($_REQUEST["SCTypeId"])?$_REQUEST["SCTypeId"]:$SCTypeId;		
		
		$where = array();
		
		$where[] = "t1.SCTypeId='".$SCTypeId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.SCTypeName2"
		."\n FROM "
		."\n tblbudget_init_screen_type AS t1  "
		."\n ".$where_r
		;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	
	
	/* START #F54 */
	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อระดับการกลั่นกลอง  */
	/* Parameter: */
			/* @ScreenLevel	= ระดับการกลั่นกลอง */
	/* Return Value : Single(loadResult) */
	function getScreenName($ScreenLevel=0){
		
		$ScreenLevel = ($_REQUEST["ScreenLevel"])?$_REQUEST["ScreenLevel"]:$ScreenLevel;		
		
		$where = array();
		
		$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.ScreenName"
		."\n FROM "
		."\n tblbudget_init_screen_item AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	
	
	
	/* START #F55 */
	/* Function Name: getProjectScreenType */
	/* Description: เป็นฟังก์ชันสำหรับดึงโครงการตามขึ้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
		/* @BgtYear	= ปีงบประมาณ */
		/* @OrganizeCode	= 	หน่วยงาน */
		/* @SCTypeId	= ขึ้นตอนการจัดทำงบประมาณ */
		/* @ScreenLevel	= ระดับการกลั่นกรองงบ*/
	/* Return Value : Array(loadObjectList) */

	function getProjectScreenType($BgtYear=0, $OrganizeCode=0, $SCTypeId=0, $ScreenLevel=0){

		$where = array();
		
		if($BgtYear){
			$where[] = "t2.BgtYear='".$BgtYear."'";
		}

		if($OrganizeCode){
			$where[] = "t2.OrganizeCode='".$OrganizeCode."'";
		}		
		
		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}	
		
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
	
		$sql="SELECT "
		."\n t1.StatusId, "
		."\n t1.PrjDetailId, "
		."\n t2.PrjId, "
		."\n t2.PrjCode, "
		."\n t2.PrjName, "
		."\n t2.PItemCode, "
		."\n t3.StatusName, "
		."\n t3.TextColor, "
		."\n t3.Icon "		
		."\n FROM "
		."\n tblbudget_project_detail AS t1 "
		."\n Inner Join tblbudget_project AS t2 ON t1.PrjId = t2.PrjId "
		."\n inner Join tblbudget_init_status as t3 on t3.StatusId = t1.StatusId "		
		."\n ".$where_r
		."\n order by t1.PrjDetailId desc "
		;
		
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;	

	}
	/* END */
	
	
	/* START #F56 */
	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	/* Parameter: */
			/* @OrganizeCode	= รหัสหน่วยงาน */
	/* Return Value : Single(loadResult) */
	function getOrganizeName($OrganizeCode=0){
		
		$OrganizeCode = ($_REQUEST["OrganizeCode"])?$_REQUEST["OrganizeCode"]:$OrganizeCode;		
		
		$where = array();
		
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.OrgName"
		."\n FROM "
		."\n tblstructure_operation AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */		
	
	/* START #F57 */
	/* Function Name: getImpParentCode */
	/* Description: เป็นฟังก์ชันสำหรับ CostItemCode มาต่อเป็นรูปแบบ Array */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getImpParentCode($CostItemCode){
		$where = array();
		$where[] = "ParentCode='".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostItemCode "
				."\n from tblbudget_init_cost_item "
				."\n ".$where_r
				."\n or ParentCode in( "
					."\n select CostItemCode "
				   	."\n from tblbudget_init_cost_item "
				  	."\n ".$where_r
				."\n ) "
				;
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$data = $this->db->loadResultArray();
		$datas = implode(",",$data);
		return $datas;
	}
	/* END */
	
	
	/* START #F58 */
	/* Function Name: countScreenLevel */
	/* Description: เป็นฟังก์ชันสำหรับนับจำนวนรวมของระดับกลั่นกลอง */
	/* Parameter: -*/
	/* Return Value : Field */
	function countScreenLevel($BgtYear=0,$SCTypeId=0){
		$BgtYear = ($BgtYear)?$BgtYear:(date("Y")+543);
		$sql = "select count(*) from  tblbudget_init_screen_item where  BgtYear='$BgtYear' and SCTypeId='$SCTypeId' and  EnableStatus='Y' and DeleteStatus='N' ";
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;	
	}
	/* END */
	
	/* START #F58 */
	/* Function Name: getTotalPrjInternalMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการรายเดือน/ไตรมาส(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjInternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostIntId=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjId){
			$where[] = "t1.PrjId='".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if($MonthNo){
			$where[] = "t8.MonthNo='".$MonthNo."'";
		}	
		if($CostIntId){
			$where[] = "t8.CostIntId='".$CostIntId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t8.Budget)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_internal AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n Inner Join tblbudget_project_activity_cost_internal_month AS t8 ON t8.CostIntId = t4.CostIntId "
				."\n ".$where_r
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* START #F59 */
	/* Function Name: getTotalPrjExternalMonth */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการรายเดือน/ไตรมาส(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjExternalMonth($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$MonthNo=0,$CostExtId=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($PItemCode){
			$where[] = "t1.PItemCode='".$PItemCode."'";
		}
		if($PrjId){
			$where[] = "t1.PrjId='".$PrjId."'";
		}
		if($PrjDetailId){
			$where[] = "t2.PrjDetailId='".$PrjDetailId."'";
		}
		if($PrjActId){
			$where[] = "t3.PrjActId='".$PrjActId."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		if($SourceExId){
			$where[] = "t4.SourceExId='".$SourceExId."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if($MonthNo){
			$where[] = "t8.MonthNo='".$MonthNo."'";
		}	
		if($CostExtId){
			$where[] = "t8.CostExtId='".$CostExtId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t8.Budget)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_external AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n Inner Join tblbudget_init_plan_item AS t5 ON t1.PItemCode = t5.PItemCode "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t4.CostItemCode = t6.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t6.CostTypeId = t7.CostTypeId "
				."\n Inner Join tblbudget_project_activity_cost_external_month AS t8 ON t8.CostExtId = t4.CostExtId "
				."\n ".$where_r
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();//echo "val=>".$datas."<br>";
		return $datas;
	}
	/* END */
	
	
	
	/* START #F60 */
	/* Function Name: getTotalBGAllotInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงงบกลั่นกลองที่ระดับกลั่นกลองระดับสุดท้าย(งบแผ่นดิน) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalBGAllotInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$PrjDetailId=0,$PrjActId=0,$PrjActCode=0,$PrjId=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}

		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($AllotId){
			$where[] = "t2.AllotId='".$AllotId."'";
		}
						
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}
	
		if($PrjActId){
			$where[] = "t1.PrjActId='".$PrjActId."'";
		}	
		
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}
		if($PrjId){
			$where[] = "t5.PrjId='".$PrjId."'";
		}				
			
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t1.BGInternal) "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n left join tblbudget_project_detail as t5 on t5.PrjDetailId=t1.PrjDetailId "
				."\n ".$where_r
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
		
		
	/* START #F61 */
	/* Function Name: getScreenLevel */
	/* Description: เป็นฟังก์ชันสำหรับดึงระดับกลั่นกลองระดับสุดท้าย */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */	
	function getScreenLevel($BgtYear=0,$OrganizeCode=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		$where = array();
		
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "OrganizeCode='".$OrganizeCode."'";
		//$where[] = "PrjDetailId='".$PrjDetailId."'";
		//$where[] = "PrjActId='".$PrjActId."'";
		$where[] = "PrjActCode='".$PrjActCode."'";
		$where[] = "SCTypeId= '2' ";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select  AllotId, ScreenLevel, PrjDetailId, PrjActId, PrjActCode "
				."\n from tblbudget_allot "
				."\n ".$where_r
				."\n order by  ScreenLevel  desc  limit 1 "
				;
		//echo "<pre>".$sql."</pre>";			
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */	
	
	/* START #F62 */
	/* Function Name: getTotalBGAllotEnternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงงบกลั่นกลองที่ระดับกลั่นกลองระดับสุดท้าย(เงินนอกงบ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalBGAllotEnternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}

		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($AllotId){
			$where[] = "t2.AllotId='".$AllotId."'";
		}
	
								
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t3.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t4.CostTypeId='".$CostTypeId."'";
		}	
		
		if($SourceExId){
			$where[] = "t2.SourceExId='".$SourceExId."'";
		}		
		
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}
	
		if($PrjActId){
			$where[] = "t1.PrjActId='".$PrjActId."'";
		}	
		
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}
				
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		
		$sql="SELECT "
				."\n sum(t2.BGAllot) "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n Inner Join tblbudget_allot_external AS t2 ON t2.AllotId = t1.AllotId "
				."\n Inner Join tblbudget_init_cost_item AS t3 ON t3.CostItemCode = t2.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t4 ON t4.CostTypeId = t3.CostTypeId "
				."\n ".$where_r
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	
	/* START #F63 */
	/* Function Name: getTotalBGIncreaseInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงงบปรับเพิ่มกลางปี (งบแผ่นดิน) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalBGIncreaseInternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}

		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($AllotId){
			$where[] = "t2.AllotId='".$AllotId."'";
		}
				
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t3.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t4.CostTypeId='".$CostTypeId."'";
		}	
		
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}
	
		if($PrjActId){
			$where[] = "t1.PrjActId='".$PrjActId."'";
		}	
		
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}		
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t2.BGIncrease) AS ValBGIncrease, sum(t2.BGDecrease) AS ValBGDecrease "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n Inner Join tblbudget_allot_internal AS t2 ON t2.AllotId = t1.AllotId "
				."\n Inner Join tblbudget_init_cost_item AS t3 ON t3.CostItemCode = t2.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t4 ON t4.CostTypeId = t3.CostTypeId "
				."\n ".$where_r
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */	
	
	/* START #F64 */
	/* Function Name: getTotalBGIncreaseInternal */
	/* Description: เป็นฟังก์ชันสำหรับดึงงบปรับเพิ่มกลางปี (งบแผ่นดิน) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalBGIncreaseExternal($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$AllotId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="",$SourceExId=0,$PrjDetailId=0,$PrjActId=0,$PrjActCode=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}

		if($SCTypeId){
			$where[] = "t1.SCTypeId='".$SCTypeId."'";
		}
		
		if($ScreenLevel){
			$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($AllotId){
			$where[] = "t2.AllotId='".$AllotId."'";
		}
				
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t3.CostItemCode in(".$CostItemCode.")";
		}
		if($CostTypeId){
			$where[] = "t4.CostTypeId='".$CostTypeId."'";
		}	
		
		if($SourceExId){
			$where[] = "t2.SourceExId='".$SourceExId."'";
		}	
		
		if($PrjDetailId){
			$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		}
	
		if($PrjActId){
			$where[] = "t1.PrjActId='".$PrjActId."'";
		}	
		
		if($PrjActCode){
			$where[] = "t1.PrjActCode='".$PrjActCode."'";
		}			
			
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t2.BGIncrease) AS ValBGIncrease, sum(t2.BGDecrease) AS ValBGDecrease "
				."\n FROM "
				."\n tblbudget_allot AS t1 "
				."\n Inner Join tblbudget_allot_external AS t2 ON t2.AllotId = t1.AllotId "
				."\n Inner Join tblbudget_init_cost_item AS t3 ON t3.CostItemCode = t2.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t4 ON t4.CostTypeId = t3.CostTypeId "
				."\n ".$where_r
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */	
	
	/* START #F65 */
	/* Function Name: getYearList */
	/* Description: เป็นฟังก์ชันสำหรับดึงปีงบประมาณ */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getYearList(){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblbudget_init_year AS t1 "
				."\n ".$where_r
				."\n order by t1.BgtYear desc "
				;
				
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadDataset();
		return $datas;
	}
	/* END */	

	/* START #F66 */
	/* Function Name: getPrjName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อโครงการ */
	/* Parameter: */
			/* @PrjId	= รหัสโครงการ */
	/* Return Value : Single(loadResult) */
	function getPrjName($PrjId=0){
				
		$where = array();
		
		$where[] = "t1.PrjId='".$PrjId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.PrjName"
		."\n FROM "
		."\n tblbudget_project AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	

	/* START #F67 */
	/* Function Name: getPrjActName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อกิจกรรม */
	/* Parameter: */
			/* @PrjActId	= รหัสกิจกรรม */
	/* Return Value : Single(loadResult) */
	function getPrjActName($PrjActId=0){
				
		$where = array();
		
		$where[] = "t1.PrjActId='".$PrjActId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.PrjActName"
		."\n FROM "
		."\n tblbudget_project_activity AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	


	/* START #F68 */
	/* Function Name: getTotalPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ+เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */	
	
	function getTotalAllotPrj($BgtYear=0,$OrganizeCode=0,$ScreenLevel=0,$SCTypeId=0,$PrjDetailId=0,$AllotId=0,$SourceExId=0){
		
		$BgtYear = ($BgtYear)?$BgtYear:(date("Y")+543);
		
		$BGAllotInt = $this->getBGTotalInternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId);
		
		$BGAllotExt	= $this->getBGTotalExternal($BgtYear,$OrganizeCode,$ScreenLevel,$SCTypeId,$PrjDetailId,$AllotId,$SourceExId);
		
		$BGAllotTotal	= $BGAllotInt+$BGAllotExt;
		
		return $BGAllotTotal;
	}
	/* END */

	
	/* START #F69 */
	/* Function Name: getMaxScreenLevel */
	/* Description: เป็นฟังก์ชันสำหรับดึงระดับกลั่นกลองครั้งล่าสุดออกมา */
	/* Parameter: -*/
	/* Return Value : Field */
	function getMaxScreenLevel(){
		$sql = "select max(ScreenLevel) from  tblbudget_init_screen_item where  EnableStatus='Y' and DeleteStatus='N' ";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */

	/* Function Name: getMaxLevel */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getMaxLevel($BgtYear=0,$SCTypeId=0){
		
		$where = array();
		
		if(empty($BgtYear)){
			$BgtYear = date("Y")+543;
		}		
		$where[] = " BgtYear='".$BgtYear."'";
		$where[] = " SCTypeId='".$SCTypeId."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
/*		$sql="SELECT count(ScreenId) as max "
				."\n FROM "
				."\n tblbudget_init_screen_item "
				."\n ".$where_r
				;
*/		

		$sql="SELECT max(ScreenLevel) as max "
				."\n FROM "
				."\n tblbudget_init_screen_item "
				."\n ".$where_r
				;

		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */	

	/* Function Name: getScreenByLevel */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณ */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getScreenByLevel($BgtYear=0,$Level=0){
		
		$where = array();
		if(empty($BgtYear)){
			$BgtYear = date("Y")+543;
		}		
		$where[] = " BgtYear='".$BgtYear."'";
		$where[] = "ScreenLevel='".$Level."'";
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT ScreenId as ScreenId2, ScreenLevel as ScreenLevel2 ,ScreenName as ScreenName2 "
				."\n FROM "
				."\n tblbudget_init_screen_item "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */

	//----------------earn เพิ่ม 21-03-55 ปรับขั้นตอนงบกลางปีมาใช้หน้าเดียวกับจัดทำแผน ---------------
	/*
	Function Name	: getCountSubSCType
	Description		: เป็นฟังก์ชันสำหรับนับว่าขั้นตอนการจัดทำงบประมาณที่วนมามีขั้นตอนย่อยหรือไม่
	Parameter		:
		@$SCTypeId = รหัสขั้นตอนการจัดทำงบประมาณ
	Return Value 	: Single(loadResult) 
	*/		
	function getCountSubSCType($BgtYear,$SCTypeId){
		$where = array();
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
		$where[] = "BgtYear='".$BgtYear."'";
				
		$where[] = "SCTypeId = '".$SCTypeId."'";
		$where[] ="DeleteStatus='N'";
		$where[] ="EnableStatus='Y'";

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql = "select count(*)  "
				."\n from tblbudget_init_screen_item"
				."\n ".$where_r
				;
				
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */		
	
	//-------------------------------------------------------------------------------------------------------------
	
	///--------------------------------------------------------------------------------------------------------------
	/* START #F9 */
	/* Function Name: getScreenRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงระดับการกลั่นกรองงบแต่ละปีงบประมาณ  */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getScreenRecordSet($BgtYear=0){
		$where = array();
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.EnableStatus='Y'";
		$where[] = "t1.DeleteStatus<>'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.ScreenId, t1.ScreenLevel ,t1.ScreenName,t1.SCTypeId,t2.SCTypeName,t1.Allot "
				."\n FROM "
				."\n tblbudget_init_screen_item as t1 "
				."\n left join tblbudget_init_screen_type as t2 on t2.SCTypeId=t1.SCTypeId "
				."\n ".$where_r
				."\n order by t1.ScreenLevel "
				;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}

	/* END */
	
	/* START #F9 */
	/* Function Name: getScreenRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงระดับการกลั่นกรองงบแต่ละปีงบประมาณ  */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getCurProcess($BgtYear=0,$OrganizeCode=0){
		$where = array();
		if(!$BgtYear){
			$BgtYear = date("Y")+543;
		}
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		//$sql="SELECT t1.SCTypeId, t1.ScreenLevel, t2.ScreenName "
		$sql="SELECT t1.SCTypeId, t1.ScreenLevel "
				."\n FROM "
				."\n tblbudget_init_year_org as t1 "
				//."\n left join tblbudget_init_screen_item as t2 on t2.ScreenLevel=t1.ScreenLevel "
				."\n ".$where_r
				;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */
	
	/* START #F9 */
	/* Function Name: getScreenRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงระดับการกลั่นกรองงบแต่ละปีงบประมาณ  */
	/* Parameter: */
	/* Return Value : Array(loadObjectList) */
	function getNextSCTypeID($BgtYear=0,$ScreenLevel=0){
		$ScreenLevel = $ScreenLevel+1;
		$where = array();
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.SCTypeId "
				."\n FROM "
				."\n tblbudget_init_screen_item as t1 "
				."\n ".$where_r
				;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	
	
	/* START #F9 */
	/* Function Name: getScreenLevel */
	/* Description:   */
	/* Parameter: */
	/* Return Value :  */
	function getListScreenLevel($BgtYear=0){
		$where = array();
		$where[] = "t1.BgtYear='".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblbudget_init_screen_item as t1 "
				."\n ".$where_r
				;
		//echo "<pre>$sql;</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */

	
	/* Function Name: getNameByScreen */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณปัจจุบันของแต่ละหน่วยงาน  */
	/* Parameter: */
			/* @BgtYear			= ปีงบประมาณ */
			/* @OrganizeCode 	= รหัสหน่วยงาน */
	/* Return Value : Array(loadObjectList) */
	function getNameByScreen($BgtYear=0,$ScreenLevel=0,$SCTypeId=0,$countScreenLevel=0){
		$where = array();
		$BgtYear = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543);
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.SCTypeId='".$SCTypeId."'";
		$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n concat(t2.SCTypeName,' -> ',t1.ScreenName) "
				."\n FROM "
				."\n tblbudget_init_screen_item as t1  "
				."\n left join tblbudget_init_screen_type as t2 on t2.SCTypeId=t1.SCTypeId "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		 return $datas;
	}
	/* END */
	
		/* START  */
	/* Function Name:  getSourceName */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแหล่งเงิน*/
	function getSourceNamePrj($PrjId){
		$where = array();
		$where[] ="t1.DeleteStatus='N'";
		$where[] ="t1.EnableStatus='Y'";
		$where[] ="t4.PrjId='".$PrjId."'";
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select  distinct(t2.SourceExId), t1.SourceExName"
				."\n from tblbudget_init_source_external as t1 "
				."\n left join tblbudget_project_activity_cost_external as t2 on t2.SourceExId=t1.SourceExId "
				."\n left join tblbudget_project_activity as t3 on t3.PrjActId=t2.PrjActId "
				."\n left join tblbudget_project_detail as t4 on t4.PrjDetailId=t3.PrjDetailId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */
	
	function getMaxRound($BgtYear){
		$where = array();
		$where[] = "Year = '".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select max(Round) "
				."\n from tblstructure_operation_round"
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
	}
	
	/* START   */
	/* Function Name: getOrgNameAct */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงานรับผิดชอบกิจกรรม */
	function getOrgNameAct($BgtYear=0,$OrganizeCode=0){
		$where = array();
		$where[] = "t1.OrgYear='".$BgtYear."'";
		$where[] = "t1.OrgRound='".$this->getMaxRound($BgtYear)."'";
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.OrgShortName "
			 ."\n FROM tblstructure_operation as t1 "
			 ."\n left join tblstructure_operation_round as t2 on t2.RoundCode=t1.OrgRoundCode "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START  13 */
	/* Function Name: getListCheck */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลการตรวจสอบ */
	function getListCheck($PrjDetailId){
		$sql="SELECT * FROM tblbudget_project_check where PrjDetailId='".$PrjDetailId."' order by PrjDetailId";
		$this->db->setQuery($sql);
		$data=$this->db->loadObjectList();	//ltxt::print_r($row);
		return $data;
	}
	/* END */



	///--------------------------------------------------------------------------------------------------------------	
	
	

	
	
	
}// end class