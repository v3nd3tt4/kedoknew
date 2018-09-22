"use strict";
(function ($){

	window.cws_megamenu = cws_megamenu;

	function cws_megamenu ( menu ){
		if ( menu == undefined ) return false;
		var fw_obj, items, item, item_data, item_id, i;
		var that = this;
		that.controller = cws_megamenu_controller;
		that.update_vars = cws_megamenu_update_vars;
		that.update_items_vars = cws_megamenu_update_items_vars;
		that.reposition_items = cws_megamenu_reposition_items;
		that.is_item_right = cws_megamenu_is_item_right;
		that.is_item_top_level = cws_megamenu_is_item_top_level;		
		that.is_rtl = cws_megamenu_is_rtl;
		that.rtl = that.is_rtl();
		that.mobile_init = false;
		that.menu = menu;
		fw_obj = $( that.menu ).closest( ".unilearn_layout_container" );
		if ( !fw_obj.length ) return; 
		that.fw = fw_obj[0];
		items = that.menu.getElementsByClassName( "menu-item-object-megamenu_item" );
		that.vars = {};
		that.vars.fw_width = null;
		that.vars.fw_left = null;
		that.vars.fw_right = null;
		that.items = {};
		for ( i = 0; i < items.length; i++ ){
			item = items[i];
			item_id = item.id;
			that.items[item_id] = {};
			item_data = that.items[item_id];
			item_data['el'] = item;
			item_data['sub_menu'] = item.querySelector( ".sub-menu" );
			item_data['megamenu_item'] = item.querySelector( ".megamenu_item" );
			item_data.vars = {
				'width' : null,
				'left' : null,
				'right' : null
			};
			item_data['is_right'] = that.is_item_right( item );
			item_data['is_top_level'] = that.is_item_top_level( item );
		}
		that.controller();
	}
	function cws_megamenu_controller (){
		var that = this;
		that.update_vars();	
		that.update_items_vars();
		that.reposition_items();
		window.addEventListener( "resize", function (){
			that.update_vars();	
			that.update_items_vars();
			that.reposition_items();
		}, false );
	}
	function cws_megamenu_update_items_vars (){
		var that = this;
		var items, keys, i, item_data, vars, item_id, item;
		items 	= that.items;
		keys 	= Object.keys( items );
		for ( i = 0; i < keys.length; i++ ){
			item_id 		= keys[i];
			item_data 		= items[item_id];
			item 			= item_data['el'];
			vars 			= item_data.vars;
			vars['width'] 	= item.offsetWidth;
			vars['left'] 	= $( item ).offset().left;
			vars['right'] 	= vars['left'] + vars['width'];
		}
	}
	function cws_megamenu_update_vars ( item ){
		var that = this;
		that.vars.fw_width 	= that.fw.offsetWidth;
		that.vars.fw_left 	= $( that.fw ).offset().left;
		that.vars.fw_right 	= that.vars.fw_left + that.vars.fw_width;			
	}
	function cws_megamenu_reposition_items (){
		var that = this;
		var items, keys, i, item_data, item_id, mm_item_width, mm_item_left, mm_item_right;
		items = that.items;
		keys = Object.keys( items );
		for ( i = 0; i < keys.length; i++ ){
			item_id = keys[i];
			item_data = items[item_id];
			if ( item_data.is_top_level ){
				mm_item_width = that.vars.fw_width;
				item_data.sub_menu.style.width = mm_item_width + "px";
				if ( that.rtl ){
					mm_item_right = item_data.vars.right - that.vars.fw_right;
					item_data.sub_menu.style.right = mm_item_right + "px";
				}
				else{
					mm_item_left = -1 * ( item_data.vars.left - that.vars.fw_left );
					item_data.sub_menu.style.left = mm_item_left + "px";				
				}
			}
			else{
				if ( item_data.is_right ){
					if ( that.rtl ){
						mm_item_width = Math.abs( that.vars.fw_right - item_data.vars.right );
						item_data.sub_menu.style.width = mm_item_width + "px";
					}
					else{
						mm_item_width = Math.abs( that.vars.fw_left - item_data.vars.left );
						item_data.sub_menu.style.width = mm_item_width + "px";
					}
				}
				else{
					if ( that.rtl ){
						mm_item_width = Math.abs( that.vars.fw_left - item_data.vars.left );
						item_data.sub_menu.style.width = mm_item_width + "px";
					}
					else{
						mm_item_width = that.vars.fw_right - item_data.vars.right;
						item_data.sub_menu.style.width = mm_item_width + "px";						
					}
				}
			}
		}
	}
	function cws_megamenu_is_item_right ( item ){
		var that = this;
		if ( item == undefined ) return false;
		return cws_has_class( item, "right" ) || $( item ).closest( ".menu-item.right" ).length;
	}
	function cws_megamenu_is_item_top_level ( item ){
		var that = this;
		if ( item == undefined ) return false;
		return !cws_has_class( item.parentNode, "sub-menu" );
	}
	function cws_megamenu_is_rtl (){
		return cws_has_class( document.body, "rtl" );
	}
	
}(jQuery))