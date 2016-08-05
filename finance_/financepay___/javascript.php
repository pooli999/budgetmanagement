<script type="text/javascript">

JQ('document').ready(function(){

	var actionURL = "?mod=<?php echo LURL::dotPage($actionPage)?>";
	var pkField = "<?php echo $get->pk?>[]";
	
	JQ("#container").tabs().tabs('select',0);
	
	
	/*JQ("#adminForm").submit(function(){
		
        		if(JQ.trim(JQ("#SourceId").val()) == ''){jAlert('กรุณาเลือกที่มาของภาคี','แจ้งเตือน',function(){JQ("#SourceId").focus()}) ;return false ;}
				
				if(JQ("#SourceId").val() == 1 || JQ("#SourceId").val() == 3 ){ // กรณีที่มาเป็นบุคคล/บุคคลภายใน
					if(JQ.trim(JQ("#PrefixUid").val()) == ''){jAlert('กรุณาเลือกคำนำหน้า','แจ้งเตือน',function(){JQ("#PrefixId").focus()}) ;return false ;}
					if(JQ.trim(JQ("#PtnFname").val()) == ''){jAlert('กรุณาระบุชื่อ','แจ้งเตือน',function(){JQ("#PtnFname").focus()}) ;return false ;}
					if(JQ.trim(JQ("#PtnSname").val()) == ''){jAlert('กรุณาระบุนามสกุล','แจ้งเตือน',function(){JQ("#PtnSname").focus()}); return false ;}
					//if(JQ.trim(JQ("#IDCard").val()) == ''){jAlert('กรุณาระบุหมายเลขบัตรประชาชน','แจ้งเตือน',function(){JQ("#IDCard").focus()}); return false ;} 
					
					if(JQ(".disabled").size() > 0){jAlert('กรุณาตรวจสอบข้อมูลให้ถูกต้อง','แจ้งเตือน');return false ;}
				}
				
				if(JQ("#SourceId").val() == 2){ // กรณีที่มาเป็นองค์กร
					if(JQ.trim(JQ("#Under").val()) == ''){jAlert('กรุณากรอกสังกัด','แจ้งเตือน',function(){JQ("#Under").focus()}) ;return false ;}
					if(JQ.trim(JQ("#PositionName").val()) == ''){jAlert('กรุณากรอกตำแหน่ง','แจ้งเตือน',function(){JQ("#PositionName").focus()}) ;return false ;}
				}
				
				
				
				JQ("[name='CatGroupCode2[]'] option").attr('selected','selected');

		                            
	});*/
	
		
	JQ("#name").submit(function(){ // กรณีแก้เฉพาะชื่อภาคี
		
				 if(JQ("#SourceId").val() != '2'){
					 
					if(JQ.trim(JQ("#PrefixUid").val()) == ''){jAlert('กรุณาเลือกคำนำหน้า','แจ้งเตือน',function(){JQ("#PrefixId").focus()}) ;return false ;}
					if(JQ.trim(JQ("#PtnFname").val()) == ''){jAlert('กรุณาระบุชื่อ','แจ้งเตือน',function(){JQ("#PtnFname").focus()}) ;return false ;}
					if(JQ.trim(JQ("#PtnSname").val()) == ''){jAlert('กรุณาระบุนามสกุล','แจ้งเตือน',function(){JQ("#PtnSname").focus()}); return false ;}
				 }
					JQ("[name='CatGroupCode2[]'] option").attr('selected','selected');
					if(JQ(".disabled").size() > 0){jAlert('กรุณาตรวจสอบข้อมูลให้ถูกต้อง','แจ้งเตือน');return false ;}
                   
	});
	
	
	JQ("#position").submit(function(){ // กรณีแก้เฉพาะตำแหน่งสังกัด 
		
					if(JQ.trim(JQ("#Under").val()) == ''){jAlert('กรุณากรอกสังกัด','แจ้งเตือน',function(){JQ("#Under").focus()}) ;return false ;}
					if(JQ.trim(JQ("#PositionName").val()) == ''){jAlert('กรุณากรอกตำแหน่ง','แจ้งเตือน',function(){JQ("#PositionName").focus()}) ;return false ;}
                   
	});
	
	
	JQ("#address").submit(function(){ // กรณีแก้ไขเฉพาะที่อยู่ที่ติดต่อ
		
	});
	
	
	

	JQ("#normal").submit(function(){ // กรณีแก้เฉพาะข้อมูลทั่วไป
		
			if(JQ.trim(JQ("#SourceId").val()) == ''){jAlert('กรุณาเลือกที่มาของภาคี','แจ้งเตือน',function(){JQ("#SourceId").focus()}) ;return false ;}
			JQ("[name='CatGroupCode2[]'] option").attr('selected','selected');
                   
	});
	
	
	
		
	JQ("span:[name='EnableStatus[]']").live('click',function(){ 
		
		var index = JQ("span:[name='EnableStatus[]']").index(this); 
		var obj = JQ("span:[name='EnableStatus[]']").eq(index);
		var id = JQ("[name='"+pkField+"']").eq(index).val();
		
			
				obj.attr('status')=='Y'?_status='N':_status='Y';
				
				JQ.post(actionURL,{action:"enable",id:id,status:_status},function(r){
				
						if(r==1){
								
						obj.attr('status',_status);
						obj.toggleClass('disabled').toggleClass('enabled');
						if(obj.hasClass('enabled'))
							obj.children('a').text('เปิดใช้งาน');
						else
							obj.children('a').text('ปิดใช้งาน');
						}
					})
	
		});
		


	
	
		JQ("span:[name='DeleteStatus[]']").live('click',function(){
			
					var index = JQ("span:[name='DeleteStatus[]']").index(this); 
					var obj = JQ("span:[name='DeleteStatus[]']").eq(index);
					var id = JQ("[name='"+pkField+"']").eq(index).val();
			
					jConfirmQ("คุณต้องการลบรายการ",'ระบบยืนยัน',function(callback){
					if(callback){
					JQ.post(actionURL,{action:"delete",id:id,status:'Y'},function(r){
				
						//if(r==1){JQ("tr:[name='tbl-rows[]']").eq(index).remove();}
						window.location.reload();
					});
				 }
				 
				});
		});
		
		
		JQ("span:[name='Edit[]']").live('click',function(){
	                var index = JQ("span:[name='Edit[]']").index(this); 
                    var obj = JQ("span:[name='Edit[]']").eq(index);
                    var id = JQ("[name='"+pkField+"']").eq(index).val();
					window.location = "?mod=<?php echo LURL::dotPage('add')?>&id="+id;
					
		});
		
		JQ("span:[name='Address[]']").live('click',function(){
	                var index = JQ("span:[name='Address[]']").index(this); 
                    var obj = JQ("span:[name='Address[]']").eq(index);
                    var id = JQ("[name='"+pkField+"']").eq(index).val();
					window.location = "?mod=<?php echo LURL::dotPage('sublist')?>&id="+id;
					
		});


	
});
</script>
<script type="text/javascript">
JQ(function(){

	var ActionURL = "?mod=<?php echo LURL::dotPage('action')?>";
	
	// Initialize 
	checkPtnExist();
	toggleArea(JQ("#SourceId").val());
	//checkIDCardExist();
	JQ("[name^=PostCode]").numeric();
	JQ("[name=IDCard]").mask("9-9999-99999-99-9");
	JQ("[name='Mobile[]']").mask("99 9999 9999");
	JQ(":text[name^='Phone']").mask("9 9999 9999");
	JQ(":text[name^='Fax']").mask("9 9999 9999");

	
	function checkPtnExist(){ // Check Duplicate Partner Full Name
		var Fname = JQ.trim(JQ("[name=PtnFname]").val());
		var Sname = JQ.trim(JQ("[name=PtnSname]").val());
		var PartnerCode = JQ.trim(JQ("[name=PartnerCode]").val());
		
		if(Fname == '' || Sname == '') return ;
		
		JQ.post(ActionURL,{action:'checkPtnExist',PartnerCode:PartnerCode,PtnFname:Fname,PtnSname:Sname},function(result){
		
				if(result==0){
					JQ("[name=PtnSname]").next("span").removeClass('disabled').addClass('enabled').html('สามารถใช้งานได้').css('color','green').fadeIn('slow');
					JQ("[name=PtnFname],[name=PtnSname]").css('color','green');
				}else{
					<?php if($_REQUEST["id"]==""){?>
					JQ("[name=PtnSname]").next("span").removeClass('enabled').addClass('disabled').html('ไม่สามารถใช้งานได้').css('color','red').fadeIn('slow');
					JQ("[name=PtnFname],[name=PtnSname]").css('color','red');
					jAlert(Fname+" "+Sname,"พบข้อมูลซ้ำในระบบ");
					<?php }else{?>
					JQ("[name=PtnSname]").next("span").removeClass('disabled').addClass('enabled').html('สามารถใช้งานได้').css('color','green').fadeIn('slow');
					JQ("[name=PtnFname],[name=PtnSname]").css('color','green');
					<?php }?>
				}
		});
	}
	
	JQ("#checkPtnExist").click(function(){
			checkPtnExist();
	});
	
	JQ("#PtnFname,#PtnSname").focusout(function(){
		checkPtnExist();

	});
	
	
	
	// IDCard
	
	JQ("[name=IDCard_BK]").focusout(function(){
		checkIDCardExist();
	})
	
	
	function checkIDCardExist(){
		var IDCard = JQ.trim(JQ("[name=IDCard]").val());
		var PartnerCode = JQ.trim(JQ("[name=PartnerCode]").val());
		
		if(JQ.trim(IDCard).length == 13  ) {

		JQ.post(ActionURL,{action:'checkIDCardExist',PartnerCode:PartnerCode,IDCard:IDCard},function(result){
		
				if(result=='0'){
					JQ("[name=IDCard]").next("span").removeClass('disabled').addClass('enabled').html('สามารถใช้งานได้').css('color','green').fadeIn('slow');
					JQ("[name=IDCard]").css('color','green');
				}else if(result!==''){
					JQ("[name=IDCard]").next("span").removeClass('enabled').addClass('disabled').html('ไม่สามารถใช้งานได้').css('color','red').fadeIn('slow');
					JQ("[name=IDCard]").css('color','red');
					jAlert(IDCard,"พบข้อมูลซ้ำในระบบ");
				}
		});
		
		}else if(JQ.trim(IDCard).length >= 1 && JQ.trim(IDCard).length < 13 ){
					JQ("[name=IDCard]").next("span").removeClass('enabled').addClass('disabled').html('ไม่สามารถใช้งานได้').css('color','red').fadeIn('slow');
					JQ("[name=IDCard]").css('color','red');
		}
	
	}
	

	// Delete Child
	
	JQ("span[name*='delete']").live('click',function(){
		
				var table = JQ(this).attr('table');
				var tr = JQ(this).parent().parent() ;
				var id = tr.find("input:hidden").eq(0).val();
				var clone = tr.clone() ;
				clone.find("input[type=text] , input:[type=hiddend]").val('').
				end().find("span[name*=Num]").html("1");

				if(id==''){ 
					if(tr.parent().find("tr").size()>1){ 
						tr.remove(); 
					}else{
						tr.find('input[type="text"]').val("");
						tr.find('select option:selected').removeAttr("selected");
					}
					return;
				}
				if(!table || JQ.trim(table)==''){ jAlert('กรุณาระบุตรางเป้าหมาย',"แจ้งเตือนโปรแกรมเมอร์") ;return;}
	
			jConfirmQ('คุณต้องการลบ','ยืนยันการทำรายการ',function(ok){
			
					if(ok){
					
							JQ.post(ActionURL,{action:'delchild',table:table,id:id},function(){

									if(tr.parent().find("tr").size()==1){
										tr.parent().prepend(clone);	
										tr.remove();
									}else{
										tr.remove();
									}
							});
					}
			});
	
	});
	
	
	
	function toggleArea(value){
	
		if(value == 1){
			JQ("#PersonDetail").show();	
			JQ(".mainUnder").hide();
			JQ(".detailUnder").show();
			JQ("span.require_2").html('');
			JQ("#PtnFname").focus();
		}else if(value == 2){
			JQ("#PersonDetail").hide();
			JQ(".mainUnder").show();
			JQ(".detailUnder").hide();
			JQ("span.require_2").html('*').css({color:'red','font-weight':'bold'});
			JQ("#Under").focus();
		}else if(value == 3){
			JQ("#PersonDetail").show();	
			JQ(".mainUnder").show();
			JQ(".detailUnder").hide();
			JQ("span.require_2").html('');
			JQ("#PtnFname").focus();
		}
	
	}
	
	JQ("#SourceId").change(function(){// เลือกแหล่งที่มาภาคี
	
		toggleArea(JQ(this).val());
			
	});
	
	
	// Resize Preview Image
	var max_size = 130;
	jQuery("#preview_img").each(function(i) {
	  if (jQuery(this).height() > jQuery(this).width()) {
		var h = max_size;
		var w = Math.ceil(jQuery(this).width() / jQuery(this).height() * max_size);
	  } else {
		var w = max_size;
		var h = Math.ceil(jQuery(this).height() / jQuery(this).width() * max_size);
	  }
	  jQuery(this).css({ height: h, width: w });
	});
	

})
</script>

<script type="text/javascript">
  // Pagked :Geo SelectList Slide
  // Author : MR.Wittaya Yaowapong
  //Copyright: GOCO Company Limited
  JQ(function(){

		var actionURL = "?mod=<?php echo LURL::dotPage('action')?>";
		
		JQ("[name^=GeoId],[name^=ProvinceCode],[name^=DistrictCode]").live('change',function(){
	
			var tbody = JQ(this).parents("tbody#geo") ;
			var el = JQ(this);

			//el.parents('tr').nextAll().find("select").val('');
			
			if(el.attr('name').match("^(Geo)")){
				_action='ddlprovince';
				_name = tbody.find("[name^=ProvinceCode]").attr('name');
				
				}		
			if(el.attr('name').match("^(Province)")){
				_action='ddldistrict';
				_name = tbody.find("[name^=DistrictCode]").attr('name');
				}
			if(el.attr('name').match("^(District)")){
				_action='ddlsubdistrict';
				_name = tbody.find("[name^=SubDistrictCode]").attr('name');
				}		
				
			// Set Html Dropdown Object
			actionURL = "?mod=finance.financepay.financepay_action";
			JQ.post(actionURL,{action:_action,id:JQ(this).val(),name:_name},function(html){
					//alert("actionURL="+actionURL);
					//alert("action="+_action);
					//alert("val="+JQ(this).val());
					//alert("name="+_name);
					JQ("select:[name="+_name+"]").parent().html(html);
			});
		})
	
	})
	


</script>






<script type="text/javascript" >
  // Pagked : Call Nested CatGroup
  // Author : MR.Wittaya Yaowapong
  //Copyright: GOCO Company Limited
  JQ(function(){
	  
	  	var actionURL = "?mod=<?php echo LURL::dotPage($actionPage)?>";

		JQ("#lv1CatGroup").live('change',function(){
			
				JQ.post(actionURL,{action:'getnestedcatgroup',node:JQ(this).val()},function(callback){
				
						JQ("#nestedcatgroup").html(callback);
				})
		});
			
	
		
	
	})
	
</script>

