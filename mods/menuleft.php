<?php
$this->Config(array(
	'config' => array(
	)
));
?>

<?php
	
	$Top_menus_left = getMenuItems(0,array("ZoneAlias='"._ZONE."'","MenuName<>'LinkOtherSys'"));

?>
<style>

#m_menuleft.x-modbox .modboxin {
	padding: 0px;
	border: none;
}
#m_menuleft.x-modbox .modtitle {
	border: none;
	background-color: #fff;
	border-bottom: 1px solid #ccc;
}
#m_menuleft.x-modbox .modtitle_text {
	font-size: 14px;
	color: #666;
	padding-bottom: 0px;
	display: block;
}
.f-menu-left .menu-level-1 div.select{
	background-image:none;
}

</style>

<div class="f-menu-left" style="width:180px;">

<ul class="menu-level-1">
<?php foreach( $Top_menus_left as $tml ){?>
<li>
	<div onclick="toggleDisplay('sub-menu-<?php echo $tml->MenuId;?>');"><span class="ico expend" style="line-height:30px; background-position:0px 9px; height:30px; cursor:pointer;" onclick="JQ(this).toggleClass('collab');"><?php echo $tml->MenuName;?></span></div>
    <?php 
	$Menu_left_level2 = array();
	$Menu_left_level2 = getMenuItems( $tml->MenuId );
	?>
    
	<?php if(strtolower($tml->DisplayType) == 'text'){?>
        <ul id="sub-menu-<?php echo $tml->MenuId;?>" class="menu-level-2">
        <?php foreach( $Menu_left_level2 as $mll ){?>
        <?php //$Menu_left_level3 = getMenuItems( $mll->MenuId );?>
        <?php if(!$Menu_left_level3){?>
        <li><a href="<?php echo genMenu($mll);?>"><?php echo $mll->MenuName;?></a></li>
		<?php }else{?>
        <li class="hasChild"><a onclick="toggleDisplay('sub-menu3-<?php echo $mll->MenuId;?>');"><?php echo $mll->MenuName;?></a></li>
                <ul id="sub-menu3-<?php echo $mll->MenuId;?>" class="menu-level-3" style="display:none">
                <?php foreach( $Menu_left_level3 as $ml3 ){?>
									<li><a href="<?php echo genMenu($ml3);?>"><?php echo $ml3->MenuName;?></a></li>
                <?php }?>
                </ul>
        <?php }?>
        <?php }?>
        </ul>
    <?php }?>
	

    <?php if(strtolower($tml->DisplayType) == 'dropdown'){
		$Submenus = null;
		$cbMenus = new stdClass();
		$cbMenus->MenuName = '== กรุณาเลือกระบบ ==';
		$cbMenus->MenuId = 0;
		foreach( $Menu_left_level2 as $SubMenu ){
			$SubMenu->Link = genMenu($SubMenu);
			$Submenus[] = $SubMenu;
					//  level 3
					$Menu_left_level3 = getMenuItems( $SubMenu->MenuId );
					//if($Menu_left_level3) $SubMenu->Link = '';
					/*
					foreach( $Menu_left_level3 as $SubMenu3 ){
						$SubMenu3->Link = genMenu($SubMenu3);
						$SubMenu3->MenuName = ' - '.$SubMenu3->MenuName;
						$Submenus[] = $SubMenu3;
					}
					*/
		}

		$Menu_left_level2 = array_merge(array($cbMenus),$Submenus);
		echo '<div class="select" id="sub-menu-'.$tml->MenuId.'"><span>';
		echo clssHTML::selectList($Menu_left_level2,'mitemid','class="menu-select" onChange="cbGoto(this)"','Link','MenuName',genMenuPath().MenuValue());
		echo '</span></div>';
		
	}?>
    <span class="box_footer"></span>
</li>

<?php }?>
</ul>
</div>

