<?php
// Added 2011-07-07 By Toon For Access Rule Getting
require 'framework.php';
$AUT = new Authen;
$GLOBALS['arrAccess'] = $AUT->getAccess();
// Added 2011-07-07 By Toon For Access Rule Getting

$login_url = 'login.php';
$MOD_ZONE = $_SESSION["_SYSTEM"];
define('ROOT',dirname(__FILE__));
define("_ZONE",$MOD_ZONE);

$PublicFiles = array(
	'modules/'._ZONE."/class/public.php"
	,'modules/'._ZONE."/class/budget.php"
	,'modules/'._ZONE."/class/eform.php"
);

if(count($PublicFiles)){
	foreach($PublicFiles as $PFile){
		if(is_file($PFile)) require_once $PFile;
	}
}

header('Content-Type: text/html; charset=utf-8');
require_once (defined('_ISSTART')?'':'../../').'ini.php';
$app->Render();
echo JResponse::toString(true);


?>