<?php
include("config.php");
include($KeyPage."_data.php");
foreach( $_POST as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
?>
