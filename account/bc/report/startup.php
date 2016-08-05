<?php
$MenuName = getMenuItem(ltxt::getVar('mod'))->MenuName;
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบนโยบายแผนงานและโครงการ',
	),
	array(
		'text' => $MenuName,
	),
));



?>
<div class="sysinfo">
<div class="sysname"><?php echo $MenuName;?></div>
<div class="sysdetail">ระบบการทำงานเกี่ยวกับ<?php echo $MenuName;?></div>
</div>
<?php echo InitMenu();?>
