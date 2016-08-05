<?php
include("config.php");
include("financepaypc_function.php");
if($action = ltxt::getVar( 'action','req' )) {

	$tsk = new sFunction();
	//echo $listPage;
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
			//echo "save";
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->Save();
		break;
		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;
		case "saveorder":
			$tsk->RedirectPage($listPage);
			$tsk->SaveOrder();
		break;
		case "loadcomp":
			$tsk->getPartnerCodeDetail();
			exit;
		break;
		case "payment":
			$tsk->getPaymentData();
			exit;
		break;
		case "paymentlist":
			$tsk->getPaymentList();	// ดึงข้อมูล รหัส eform
			exit;
		break;
		case 'loadpn':
			$tsk->getPersonalCode("PersonalCode",$tag_attribs,$PersonalCode,"เลือก");
			exit;
		break;
		case 'loadpaymentdetailfinance':
			$PaymentId = ltxt::getVar( 'PaymentId','get' );
			$tsk->getPaymentDetailFinance($PaymentId);
			exit;
		break;
		case 'loadbbnumber':
		 	//$LPlanCode = ltxt::getVar( 'bankid','post' );
			$tsk->getBookbankNumber("BookbankId",$tag_attribs,$BookbankId,"เลือก","");
			exit;
		break;
		case "paymentmethods":
			$tsk->getPaymentMethods();	// ดึงข้อมูล รหัส eform
			exit;
		break;
		 case 'ddlprovince':  // Dropdown จังหวัด
					if($_POST[id]=='') $_POST[id] =-9999;
                    echo DDL::Province($_REQUEST[ProvinceCode],$_POST[id],$_POST[name],'style="width:150px;"','==== เลือก ====') ;
            exit;
            break;

            case 'ddldistrict':  // Dropdown อำเภอ
					if($_POST[id]=='') $_POST[id] =-9999;
                    echo DDL::District($_REQUEST[DistrictCode],$_POST[id],$_POST[name],'style="width:150px;"','==== เลือก ====') ;
            exit;
            break;

            case 'ddlsubdistrict':  // Dropdown ตำบล
					if($_POST[id]=='') $_POST[id] =-9999;
                    echo DDL::SubDistrict($_REQUEST[SubDistrictCode],$_POST[id],$_POST[name],'style="width:150px;"','==== เลือก ====') ;
            exit;
            break;
			 case 'findeformdetail':  // รายการค่าใช้จ่าย eform
					$tsk->getEformdetail();	// ดึงข้อมูล รหัส eform
				exit;
            break;
			case 'findeformdetailvalue':  // รายการค่าใช้จ่าย eform
					$tsk->getEformdetailvalue();	// ดึงข้อมูล รหัส eform
				exit;
            break;

/*		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;*/
	}
exit;

}
?>
