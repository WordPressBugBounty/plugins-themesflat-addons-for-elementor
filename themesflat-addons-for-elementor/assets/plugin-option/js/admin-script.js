//------------------------------------------
    //Admin JS
//------------------------------------------
jQuery(document).ready(function() {
	initTabClick();
	initLoadTabs();
	jQuery( '.colorpicker' ).wpColorPicker();
	initCheckBoxMany();
	initRadioBtn();
	initSortable();
});

function initSortable(){
	var sClass = '.tf-opt-sortable';
	var sClass_item = 'sortable-item';
	
	var arr_childs = jQuery(sClass).children();
	jQuery(arr_childs).each(function(index, element) {
        jQuery(this).addClass(sClass_item);
    });
	
	jQuery(sClass).sortable({
		stop: function (event, ui) {
			var eSortable = jQuery(this);
			var arr = jQuery(this).find("."+sClass_item);
			var new_order = '';
			var newArr = {};
			var j = 0;
			jQuery(arr).each(function(index, element) {
                var id = jQuery(this).data("id");
					newArr[j] = id;
					j++;
            });
			var new_order = JSON.stringify(newArr);
			jQuery(eSortable).attr("data-orders", new_order);
			
			//update list images
			if(jQuery(eSortable).data("image")==1 && typeof saveAttachmentIds !== 'undefined' && jQuery.isFunction(saveAttachmentIds)){
				saveAttachmentIds(eSortable);
			}
		}
	});
}

function initCheckBoxMany(){
	var sClass = ".checkbox_many";
	jQuery(sClass).click(function(){
		var group = jQuery(this).data('group');
		
		var arr_big = {};
		var new_val = {};
		jQuery("#"+group + " "+sClass).each(function(index, element) {
			var label = jQuery(jQuery(this).next()).text();
			var checked = 0;
			if(jQuery(this).is(":checked")){
				checked = 1;
			}
			new_val[label] = checked;
        });
		arr_big['type'] = 'checkbox_many';
		arr_big['val'] = new_val;  
		
		var str_json = JSON.stringify(arr_big);
		jQuery("#"+group + " input[name='"+group+"']").val(str_json);
	});
	
}

function initRadioBtn(){
	var sClass = ".tf-opt_radio";
	jQuery(sClass).click(function(){
		var group = jQuery(this).data('group');
		
		var arr_big = {};
		var new_val = {};
		jQuery("#"+group + " "+sClass).each(function(index, element) {
			var label = jQuery(jQuery(this).next()).text();
			var checked = 0;
			if(jQuery(this).is(":checked")){
				checked = 1;
			}
			new_val[label] = checked;
        });
		arr_big['type'] = 'radio';
		arr_big['val'] = new_val;  
		
		var str_json = JSON.stringify(arr_big);
		jQuery("#"+group + " input[name='"+group+"']").val(str_json);
	});
	
}

function initTabClick(){
	jQuery("a.tf-opt-tab-btn").click(function(){
		var id = jQuery(this).attr("id");
		var shref = jQuery(this).attr("href");
		jQuery(".has-tabs .section.is_tab").removeClass("active");
		jQuery(shref).addClass("active");
		
		jQuery(".tf-opt-tab-btn.nav-tab-active").removeClass("nav-tab-active");
		jQuery(this).addClass("nav-tab-active");
		
		setCookie('current_tab_id',id,1);
		return false;
	});
}

function initLoadTabs(){
	var current_tab_id = getCookie('current_tab_id');
	if(current_tab_id){
		jQuery("#"+current_tab_id).click();
	}
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name+'=; Max-Age=-99999999;';  
}