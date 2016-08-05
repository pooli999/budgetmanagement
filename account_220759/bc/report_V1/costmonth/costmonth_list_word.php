<?php
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=".$_REQUEST["PItemCode"]."_".date("d-m-Y").".doc");

include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

?>


<html xmlns:o='urn:schemas-microsoft-com:office:office'xmlns:x='urn:schemas-microsoft-com:office:word'xmlns='http://www.w3.org/TR/REC-html40'>
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
</HEAD>
<BODY>



<?php include("modules/backoffice/budget/report/costmonth/view_export.php"); ?>

</BODY>
</HTML>


