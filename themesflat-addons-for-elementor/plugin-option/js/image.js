jQuery(document).ready(function($) {
	imageMultipleInit();
	removeItem();
	tf_opt_Img_Auto_Sort_Txt();
	tf_opt_Img_Auto_Sort_Checkbox();
});

function tf_opt_Img_Auto_Sort_Txt(){
	jQuery(".tf-opt-auto-sort-text").bind("keyup", function(e) {
		var eContainer = jQuery("#"+jQuery(this).data("container")); 
		saveAttachmentIds(eContainer);
	});
}

function tf_opt_Img_Auto_Sort_Checkbox(){
	jQuery(".tf-opt-auto-sort-checkbox").click(function(){
		var eContainer = jQuery("#"+jQuery(this).data("container")); 
		saveAttachmentIds(eContainer);
	});
}

function removeItem(){
	jQuery(".removeit").click(function(){
		var divIt = jQuery(this).parents('.attachment');
		var eContainer = jQuery(divIt).parent(); 
		
		jQuery(divIt).remove();
		saveAttachmentIds(eContainer);
		
		var count_li = jQuery(jQuery(eContainer).find("li")).length;
		if(count_li==0){
			jQuery(eContainer).html('<span class="tf-opt-no-photo">'+jQuery(eContainer).data("nophoto")+'</span>');
		}
	});
}

function imageMultipleInit(){
	
	jQuery('.tf-opt-image-type .btn-img-field').on('click',function(e){
		
		var eContainer = jQuery(jQuery(this).parent()).find(".images").get(0);
		
		e.preventDefault();
		var frame_multiple = false;
		
		if (frame_multiple) {
			frame_multiple.open();
			return;
		}
		
		//Select many photos
		var i_number = jQuery(this).attr("data-number");
		if(i_number=='*'){
			var is_multiple = true;
		}else{
			var is_multiple = false;
		}
		
		var media_upload_title = jQuery(this).data('title');
		if(media_upload_title==''){
			media_upload_title = 'Select or Upload Media Of Your Chosen Persuasion';
		}
		
		var media_upload_btn_text = jQuery(this).data('btntext');
		if(media_upload_btn_text==''){
			media_upload_btn_text = 'Use this media';
		}
		
		frame_multiple = wp.media({
			title: media_upload_title,
			button: {
				text: media_upload_btn_text
			},
			multiple: is_multiple
		});
		
		
		// Register Event
		frame_multiple.on( "select", function() {
			var selection = frame_multiple.state().get('selection');
				selection.map( function( attachment ) {
					attachment = attachment.toJSON();
					//console.log(attachment);
					
					// append image
					createImgBlockHtml(attachment, eContainer, is_multiple)
				});
				
				removeItem();
				
				// Close the media frame_multiple
				frame_multiple.close();
		});
		
		// Show media frame_multiple
		frame_multiple.open();
	});//------------------------------------------------------------------------
	
	return false;
///////////////////////////////////////////////////////
}

function createImgBlockHtml(attachment, eContainer, is_multiple){ //alert(888); console.log(attachment);
	var type = attachment.type; // image, video
	// 1 ----------------------------
	var img_link = '';
	if(type == 'image'){
		if((attachment.sizes).hasOwnProperty('thumbnail')){
			var src_attachment = attachment.sizes.thumbnail.url;
		}else{
			var src_attachment = attachment.url;
		}
	}else if( type == 'video' ){
		src_attachment = attachment.icon;
		img_link = attachment.url;
	}
	
	var id_attachment = attachment.id;
	
	var container_id = jQuery(eContainer).attr('id');
	
	var hideattribute = jQuery(eContainer).data('hideattribute');
	//alert(hideattribute);
	var attr_list = ''; 
	if(hideattribute =='0'){
		var uni_id = Math.random().toString(36).substring(2);
		
		var arr_title_html = '<div class="attribute-it"><input type="text" data-container="'+container_id+'" class="attr-title tf-opt-auto-sort-text" placeholder="'+jQuery(eContainer).data('title')+'" value=""></div>';
		
		var arr_desciption_html = '<div class="attribute-it"><textarea data-container="'+container_id+'" class="attr-desciption tf-opt-auto-sort-text"  placeholder="'+jQuery(eContainer).data('desciption')+'"></textarea></div>';
		
		var arr_link_html = '<div class="attribute-it"><input type="text" data-container="'+container_id+'" class="attr-link tf-opt-auto-sort-text" placeholder="'+jQuery(eContainer).data('link')+'" value="'+img_link+'"></div>';
		
		var arr_link_title_html = '<div class="attribute-it"><input type="text" data-container="'+container_id+'" class="attr-link_title tf-opt-auto-sort-text" placeholder="'+jQuery(eContainer).data('link_title')+'" value=""></div>';
		
		var arr_color_html = '<div class="attribute-it"><input type="text" data-container="'+container_id+'" class="attr-color tf-opt-auto-sort-text" placeholder="'+jQuery(eContainer).data('color')+'" value=""></div>';
		
		var arr_target_html = '<div class="attribute-it"><input data-container="'+container_id+'" type="checkbox" class="attr-target widefat tf-opt-checkbox tf-opt-auto-sort-checkbox" id="'+uni_id+'"><label for="'+uni_id+'" class="checkbox_label">'+jQuery(eContainer).data('target')+'</label></div>';
		
		var attr_list = '<div class="tf-opt-attribute-list">'
							+ arr_title_html 
							+ arr_desciption_html 
							+ arr_link_html
							+ arr_link_title_html
							+ arr_color_html
							+ arr_target_html
						+'</div>';
	}
	
	var sitem = '<li id="'+id_attachment+'" data-id="'+id_attachment+'" class="attachment save-ready"><a class="dashicons dashicons-no removeit"></a><div class="attachment-preview js--select-attachment type-image subtype-png landscape"><div class="thumbnail"><div class="centered"><img src="'+src_attachment+'" draggable="false"></div></div></div>'+attr_list+'</li>';
	
	if(is_multiple){
		var count_li = jQuery(jQuery(eContainer).find("li")).length;
		if(count_li>0){
			jQuery(eContainer).append(sitem);
		}else{
			jQuery(eContainer).html(sitem);
		}
	}else{
		jQuery(eContainer).html(sitem);
	}
	
	//Update event
	tf_opt_Img_Auto_Sort_Txt();
	tf_opt_Img_Auto_Sort_Checkbox();
	
	// 2 ----------------------
	saveAttachmentIds(eContainer);
}

function saveAttachmentIds(eContainer){ 
	var aItems = jQuery(eContainer).find('li.attachment');
	
	var arr_big = {};
	var arrAttachment = {};
	jQuery(aItems).each(function(index, element) {
		var attachment_id = jQuery(this).attr("id"); //alert(attachment_id);
		
		var arr_attr = {};
		
		//attachment_id attribute
		arr_attr['id'] = attachment_id;
		
		
		//title attribute
		var attr_title = jQuery(jQuery(this).find('.attribute-it .attr-title').get(0)).val();
		arr_attr['title'] = attr_title;
		
		//desciption attribute
		var attr_desciption = jQuery(jQuery(this).find('.attribute-it .attr-desciption').get(0)).val();
		arr_attr['desciption'] = attr_desciption;
		
		//href attribute
		var attr_link = jQuery(jQuery(this).find('.attribute-it .attr-link').get(0)).val();
		arr_attr['link'] = attr_link;
	
		
		//title link attribute
		var attr_link_title = jQuery(jQuery(this).find('.attribute-it .attr-link_title').get(0)).val();
		arr_attr['link_title'] = attr_link_title;
		
		//color link attribute
		var attr_color = jQuery(jQuery(this).find('.attribute-it .attr-color').get(0)).val();
		arr_attr['link_color'] = attr_color;
		
		//target link attribute
		var e_checked = 0;
		var e_target = jQuery(this).find('.attribute-it .attr-target').get(0);
		if( jQuery(e_target).is(":checked") ){
			e_checked = 1;
		}
		arr_attr['target'] = e_checked;
		
		
		//-----
        arrAttachment[index] = arr_attr;
    });
	var eIntHidden = jQuery(eContainer).prev();
	//-----------
	var str_json = '';
	if(jQuery(aItems).length){
		arr_big['type'] = jQuery(eContainer).data('type');
		arr_big['val'] = arrAttachment;  
		str_json = JSON.stringify(arr_big);
	}
		
	jQuery(eIntHidden).val(str_json);
}