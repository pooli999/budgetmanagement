<?php
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];
//$noImage = '../../images/noimage.png';

$PublicFiles = array(
	'modules/'._ZONE."/front/eform/class/eform.php"
);

if(count($PublicFiles)){
	foreach($PublicFiles as $PFile){
		if(is_file($PFile)) require_once $PFile;
	}
}

$PathUpload = VSROOT.'upload/eform/';

// Not Remove //
$GLOBALS["PathUpload"] = $PathUpload;
////

?>
