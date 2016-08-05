<?php
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Plan".date("d-m-Y").".doc");
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

?>


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
</HEAD>
<BODY>




<?php include("modules/backoffice/budget/project/view_print.php"); ?>




</BODY>

</HTML>


