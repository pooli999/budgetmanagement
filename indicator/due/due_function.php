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
		//ltxt::print_r($_POST);
		//$this->db->debug(2);
		if($pk = $this->db->arecSave('tblbudget_init_year',$_POST)){	
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}





}

?>