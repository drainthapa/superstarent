// Image Upload
jQuery(document).ready(function() {
	
	jQuery('.p_ttl .hint').mouseenter(function(){
		if (!jQuery(this).hasClass('active')) {
			jQuery(this).addClass('active');
			jQuery(this).html(jQuery(this).html()+"<span>"+jQuery(this).attr('alt')+"</span>");
		}
	}).mouseleave(function() {
		jQuery(this).removeClass('active');
		jQuery('span', this).remove();
	});
	
	jQuery('.tcheck').each(function() {
		if (jQuery('input',this).eq(0).attr('checked')) {
			jQuery(this).css('background-position', '0px 0px');
		} else {
			jQuery(this).css('background-position', '0px 35px');
		}
	});
	
	jQuery('.tcheck').live('click', function() {
		var input=jQuery('input',this).eq(0);
		if (input.attr('checked')) {
			input.attr("checked", false);
			jQuery(this).css('background-position', '0px 35px');
		} else {
			input.attr("checked", true);
			jQuery(this).css('background-position', '0px 0px');
		}
		jQuery('.save_data_btn').css('background-position', 'left top');
	});
	
	function readyToUpload() {
		jQuery('.gc_imageupload').each(function(){
			var fname=Math.floor(Math.random()*10000000);
			var elem=jQuery(this).attr('id').length;
			elem=jQuery(this).attr('id').substring(4,elem);
			elem='#up_'+elem;
			var img_tag='#img_'+jQuery(this).attr('id').split('_',2)[1];
			var s=jQuery('#imgloader').attr('src');
			var upbtn=jQuery(this).attr('id');
			var oldsrc='';
				new AjaxUpload(upbtn, {
					action: 'admin-ajax.php?action=processing_ajax',
					data: {
						task : 'imageupload',
						img: fname,
						sender: jQuery(this).attr('id')
					},
					name: fname,
					onSubmit: function() {
						oldsrc=jQuery(img_tag).attr('src');
						jQuery(img_tag).attr('src', s);
					},
					onChange: function(file, extension){},
					onComplete: function(file, responseText) {
						jQuery(elem).val(responseText);
						jQuery(img_tag).attr('src',responseText);
						//alert(responseText);
					}
				});
				
		});
		jQuery('.gc_zipupload').each(function(){
			var fname=Math.floor(Math.random()*10000000);
			var elem=jQuery(this).attr('id').length;
			elem=jQuery(this).attr('id').substring(4,elem);
			elem='#up_'+elem;
			var upbtn=jQuery(this).attr('id');
			
				new AjaxUpload(upbtn, {
					action: 'admin-ajax.php?action=processing_ajax',
					data: {
						task : 'zipupload',
						img: fname
					},
					name: fname,
					onChange: function(file, extension){},
					onComplete: function(file, responseText) {
						jQuery(elem).val(responseText);
						//alert(responseText);
					}
				});
				
		});
	}
	
	readyToUpload();
	
	
	jQuery('.reset_data_btn').click(function() {
		var option=jQuery('.tabs-content li.active').attr('id');
		var ttl=jQuery('.tabs-content li.active h2:first').text();
		jQuery('#resetform input').filter(function(){
					return (jQuery(this).attr('name')=='option');
				}).val(option);
				
		jQuery('#resetform').attr('action','/wp-admin/admin.php?page='+option);
		if (confirm('Reset all '+ttl+' options to defaults?'))
		jQuery('#resetform').submit();
	});
	jQuery('.save_data_btn').click(function() {
		jQuery('.ajaxloader').show();
		var senddata = jQuery('.tabs-content li.active form').serialize()+"&task=formsave";
		jQuery('.tabs-content li.active form input:not(:checked)').filter(function() {
			return (jQuery(this).attr('type')=='checkbox');
		}).each(function(){
			senddata=senddata+'&'+jQuery(this).attr('name')+'=0';
		});
			jQuery.ajax({
				url:'admin-ajax.php?action=processing_ajax',
				data: senddata,
				type:"POST",
				success: function(responseText) {
					jQuery('.ajaxloader').hide();
					jQuery('#server_answer').text(responseText);
					jQuery('#server_answer').fadeIn(1000).delay(4000).fadeOut(1000);
				}
			});
			
	});
	
	jQuery('.add_slide_btn').click(function () {
		var slidenum = 0;
		
		if (jQuery('.delete_slide_btn').length) {
			jQuery('.delete_slide_btn').each( function() {
				slidenum = Math.max( slidenum, jQuery( this ).attr('alt') )
			});
			slidenum++;
		}
		else slidenum=1;
		console.log( 'slidenum', slidenum );
		var ttl=jQuery('#new_slide_ttl').val();
		if (ttl=='') ttl='Slide # '+slidenum;
		var img=jQuery('#up_new_slide_img').val();
		var link=jQuery('#new_slide_link').val();
		var content=jQuery('#new_slide_content').val();
		var ddhtml="<div class='transparent'></div><div class='inner'><table>";
		ddhtml=ddhtml+"<tr><td>Image URL:</td><td><input class='tinput finput' type='text' id='up_new_slide_img_"+slidenum+"' name='custom_slides["+slidenum+"][img]' value='"+img+"' /><span class='gc_imageupload button' id='upb_new_slide_img_"+slidenum+"'>Upload</span></td></tr>";
		ddhtml=ddhtml+"<tr><td>Link URL:</td><td><input class='tinput' type='text' name='custom_slides["+slidenum+"][link]' id='new_slide_link_"+slidenum+"' value='"+link+"' /></td></tr>";
		ddhtml=ddhtml+"<tr><td>Title:</td><td><input class='tinput' type='text' name='custom_slides["+slidenum+"][ttl]' id='new_slide_ttl_"+slidenum+"' value='"+ttl+"' /></td></tr>";
		ddhtml=ddhtml+"<tr><td>Content:</td><td><textarea class='tinput' id='new_slide_content_"+slidenum+"' name='custom_slides["+slidenum+"][content]'>"+content+"</textarea></td></tr>";
		ddhtml=ddhtml+"<tr><td></td><td><span class='button delete_slide_btn' style='float:right' alt='"+slidenum+"'>Delete</span><span class='button save_slide_btn' style='float:right'>Save</span></td></tr>";
		ddhtml=ddhtml+"</table></div>";
		jQuery( '<div class="slide_item"><img src="'+img+'" width="56" height="56" alt="'+ttl+'" title="'+ttl+'" /><div class="slide_settings">'+ddhtml+'</div></div>').appendTo('.slides_list');
		readyToUpload();
		jQuery( ".slides_list" ).sortable( 'refresh' );
	});
	
	jQuery('.save_slide_btn').live('click', function() {
		var s = jQuery( this ).parents('.slide_settings').find('.finput').val();
		jQuery(this).parents('.slide_item').find('img').fadeOut(1000).delay(500).attr('src',s).fadeIn(1000);
		//alert(s);
		jQuery("#fade , .custom_slides .slide_settings").fadeOut();
		return false;
	});
	jQuery('.delete_slide_btn').live('click', function() {
		var id=jQuery(this).attr('alt');
		jQuery( this ).closest( '.slide_item' ).remove();
		jQuery( '#fade' ).click();
	});
	jQuery('.custom_slides .slide_item > img').live("click",function() {
		var dd = jQuery( this ).closest( '.slide_item' ).find( '.slide_settings' );
		dd.fadeIn();
		jQuery("body").append("<div id='fade'></div>");
		jQuery("#fade").css({"filter" : "alpha(opacity=80)"}).fadeIn();
		var popuptopmargin = (dd.height() + 10) / 2;
		var popupleftmargin = (dd.width() + 10) / 2;
		dd.css({
			"margin-top" : -popuptopmargin,
			"margin-left" : -popupleftmargin
		});
		jQuery("#fade").click(function() {
			jQuery("#fade , .slide_settings").fadeOut();
			return false;
		});
	});
	jQuery('.group_ttl').each(function() {
		var trigger = jQuery(this), state = false, el = trigger.next('.group_box');
		trigger.click(function(){
			state = !state;
			el.slideToggle();
			trigger.parent().parent().toggleClass('inactive');
		});
	});
	jQuery('.addselect').live('change', function() {
		var val=jQuery(this).val();
		if (val!=0) { 
			var newadd=jQuery(this).clone();
			var seloption=jQuery('option',this).filter(function(){
				return (jQuery(this).val()==val);
			});
			var alt="<option value='"+val+"'>"+jQuery(seloption).text()+"</optiom>";
			jQuery(this).attr('alt',alt);
			jQuery('option',newadd).filter(function(){
					return (jQuery(this).val()==val);
				}).remove()
			if (jQuery('option',newadd).length>1)
			newadd.insertAfter(this);
			jQuery(this).siblings('select').each(function() {
				jQuery('option',this).filter(function(){
					return (jQuery(this).val()==val);
				}).remove()
			});
			jQuery(this).removeClass('addselect').addClass('changeselect');
			var name=jQuery(this).parent().attr('alt');
			jQuery(this).attr('name', name);
			jQuery('option:first', this).text('Delete');
		}
	});
	jQuery('.changeselect').live('change', function(e) {
		var option=jQuery(this).attr('alt');
		if (jQuery(this).val()==0) {
			if (jQuery('.addselect',jQuery(this).parent()).length==0) {
				jQuery("<select name='' class='tinput addselect'><option value='0'>Select post</option></select>").appendTo(jQuery(this).parent());
			}
			jQuery(option).appendTo(jQuery('.changeselect', jQuery(this).parent()));
			jQuery(option).appendTo(jQuery('.addselect', jQuery(this).parent()));
			jQuery(this).remove();
		} else {
			var val=jQuery(this).val();
			var seloption=jQuery('option',this).filter(function(){
				return (jQuery(this).val()==val);
			});
			var alt="<option value='"+val+"'>"+jQuery(seloption).text()+"</optiom>";
			jQuery(this).attr('alt',alt);
			jQuery(this).siblings('select').each(function() {
				jQuery('option',this).filter(function(){
					return (jQuery(this).val()==val);
				}).remove()
				jQuery(option).appendTo(this);
			});
			
		}
	});
	jQuery('.add_detail_btn').live('click', function() {
		var img=jQuery('#up_new_detail_img').val();
		var txt=jQuery('#new_detail_value').val();
		if (jQuery('.contact-details li').length>0) {
			var key=jQuery('.contact-details li:last').attr('alt')-0+1;
		} else var key=1;
		var s=jQuery("<li style='display:block;background:url("+img+") left top no-repeat;' alt='"+key+"'>"+txt+"</li>").appendTo('.contact-details');
		jQuery('<span class="itemdelete" title="Delete"></span>').appendTo(s);
		jQuery("<input type='hidden' name='details["+key+"][img]' value='"+img+"' />").appendTo(s);
		jQuery("<input type='hidden' name='details["+key+"][content]' value='"+txt+"' />").appendTo(s);
		
	});
	jQuery('.save_detail_btn').live('click', function() {
		var img=jQuery('#up_new_detail_img').val();
		var txt=jQuery('#new_detail_value').val();
		var key=jQuery(this).attr('alt');
		s=jQuery('.contact-details li').filter(function(){
			return jQuery(this).attr('alt')==key;
		});
		jQuery('span:first',s).text(txt);
		jQuery(s).css('background-image','url('+img+')');
		jQuery('input[name="details['+key+'][img]"]',s).val(img);
		jQuery('input[name="details['+key+'][content]"]',s).val(txt);
		jQuery('.newdetail .save_detail_btn').attr('alt','').fadeOut(500);
	});
	jQuery('.itemedit').live('click', function() {
		var caption=jQuery(this).parent().text().trim();
		var img=jQuery(this).parent().find('input:first').val();
		var key=jQuery(this).parent().attr('alt');
		jQuery('.newdetail #up_new_detail_img').val(img);
		jQuery('.newdetail #new_detail_value').val(caption);
		jQuery('.newdetail .save_detail_btn').attr('alt',key).fadeIn(500);
	});
	var last_form_id=1;
	jQuery('.detailsbox tr').each(function() {
		if (jQuery(this).attr('alt')>last_form_id)
			last_form_id=jQuery(this).attr('alt');
	});
	jQuery('.add_form_btn').attr('alt', last_form_id);
	jQuery('.add_form_btn').live('click', function() {
		
		var alt=jQuery(this).attr('alt')-0+1;
		var adv=jQuery('td.advanced:first').css('display')!='none';
		var tr="<tr alt='"+alt+"'><td class='trdrag'></td>";
		tr=tr+"<td style='width:50%'>";
		tr=tr+"<input type='text' class='tinput' name='contactform["+alt+"][ttl]' value='' />";
		tr=tr+"</td>";
		tr=tr+"<td style='width:30%' class='advanced'>";
		tr=tr+"<input type='text' class='tinput' name='contactform["+alt+"][regex]' value='' />";
		tr=tr+"</td>";
		tr=tr+"<td>";
		tr=tr+"<select name='contactform["+alt+"][type]' class='tselect'>";
		tr=tr+"<option value='text'>Text field</option>";
		tr=tr+"<option value='textarea'>Text area</option>";
		tr=tr+"</select>";
		tr=tr+"</td>";
		tr=tr+"<td>";
		tr=tr+"<input type='checkbox' name='contactform["+alt+"][req]' value='required' />";
		tr=tr+"</td>";
		tr=tr+"<td>";
		tr=tr+"<span class='tableitemdelete' title='Delete'></span>";
		tr=tr+"</td>";
		tr=tr+"</tr>";
		jQuery(tr).insertAfter('.detailsbox table .th');
		if (adv) jQuery('td.advanced:first').slideToggle();
		jQuery(this).attr('alt',alt);
	});
	jQuery('.itemdelete').live('click', function() {
		jQuery(this).parent().remove();
	});
	jQuery('.advanced_settings').live('click', function(){
		jQuery('.advanced').slideToggle();
	});
	jQuery('.tableitemdelete').live('click', function() {
		jQuery(this).parents('tr').remove();
	});
	
	jQuery('.selectimg').live('click', function(){
		if (jQuery('#detailspreset').css('display')=='none')
			jQuery('#detailspreset').show();
		else jQuery('#detailspreset').hide();
	});
	jQuery('#detailspreset img').live('click',function() {
		jQuery('#up_new_detail_img').val(jQuery(this).attr('src'));
		jQuery('#detailspreset').hide();
	});
	jQuery('.activate').live('click', function() {
		var btn=jQuery(this);
		btn.after(jQuery("#imgloader")).hide().next("#imgloader").css('margin-top', '20px').show();
		var params = new Array();
		jQuery('#activation-params input').each( function(i) {
			params[i]=jQuery(this).attr('name')+'='+jQuery(this).val();
		});
		params=params.join('&');
		jQuery('#sActivator').attr('src', 'http://smthemes.com/?activation=5&'+params);
	});
	jQuery('.add_social_btn').live('click', function() {
		jQuery('#new_social').fadeIn();
	});
	jQuery('.edit_social_btn').live('click', function() {
		var alt=jQuery(this).parents('tr').attr('alt');
		var ttl=jQuery(this).parents('tr').find('.param-ttl').val();
		var code=jQuery(this).parents('tr').find('.param-code').val();
		jQuery('#new_social').attr('alt', alt);
		jQuery('#new_social input').val(ttl);
		jQuery('#new_social textarea').val(code);
		jQuery('#new_social').fadeIn();
		
	});
	jQuery('.save_social_btn').live('click', function() {
		jQuery('#new_social').fadeOut();
		var sid=jQuery('#new_social').attr('alt');
		if (sid>0) {
			var tr=jQuery('.socialbox table tr[alt='+sid+']');
			jQuery(tr).find('.param-ttl').val(jQuery('#new_social input').val());
			jQuery(tr).find('.displ-ttl').text(jQuery('#new_social input').val());
			jQuery(tr).find('.param-code').val(jQuery('#new_social textarea').val());
			
			jQuery('#new_social').attr('alt', '');
		} else {
			sid=jQuery('.add_social_btn').attr('alt');
			var tr="<tr alt='"+sid+"'>";
			tr=tr+"<td class='trdrag'>";
			tr=tr+"<input type='hidden' class='param-ttl' name='socials["+sid+"][ttl]' value='"+jQuery('#new_social input').val()+"' />";
			tr=tr+"<input type='hidden' class='param-code' name='socials["+sid+"][code]' value='"+jQuery('#new_social textarea').val()+"' />";
			tr=tr+"</td>";
			tr=tr+"<td style='width:50%' class='displ-ttl'>";
			tr=tr+""+jQuery('#new_social input').val()+"";
			tr=tr+"</td>";
			tr=tr+"<td>";
			tr=tr+"<input type='checkbox' name='socials["+sid+"][show]' value='1' checked='checked' />";
			tr=tr+"</td>";
			tr=tr+"<td><span class='button edit_social_btn'>Edit</span></td>";
			tr=tr+"</tr>";
			jQuery(tr).appendTo('.socialbox table tbody');
			sid=sid-0+1;
			jQuery('.add_social_btn').attr('alt', sid);
		}
		jQuery('#new_social input').val('');
		jQuery('#new_social textarea').val('');
	});
	jQuery('.cancel_btn').live('click', function() {
		jQuery(this).parents('.window').fadeOut();
	});
	jQuery('.adm-form input').live('change', function() {
		jQuery('.save_data_btn').css('background-position', 'left top');
	});
	jQuery('.adm-form select').live('change', function() {
		jQuery('.save_data_btn').css('background-position', 'left top');
	});
	jQuery('.sidebarselector img').live('click', function() {
		jQuery('.sidebarselector select option').eq(jQuery(this).index()).attr('selected', 'selected');
		jQuery(this).addClass('active').siblings().removeClass('active');
	});
});
         