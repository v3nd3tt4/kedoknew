"use strict";

/**********************************
************ CWS LIBRARY **********
**********************************/

function cws_uniq_id ( prefix ){
	var prefix = prefix != undefined && typeof prefix == 'string' ? prefix : "";
	var d = new Date();
	var t = d.getTime();
	var unique = Math.random() * t;
	var unique_id = prefix + unique;
	return unique_id;
}
function cws_has_class ( el, cls_name ){
	var re = new RegExp( "(^|\\s)" + cls_name + "(\\s|$)", 'g' );
	return re.test( el.className );
}
function cws_add_class ( el, cls_name ){
	el.className =  el.className.length ? el.className + " " + cls_name : cls_name;		
}
function cws_remove_class ( el, cls_name ){
	var re = new RegExp( "\\s?" + cls_name, "g" );
	el.className = el.className.replace( re, '' );
}
function cws_is_mobile_device () {
  if ( navigator.userAgent.match( /(Android|iPhone|iPod|iPad)/ ) ) {
    return true;
  } else {
    return false;
  }
}
function cws_is_mobile_viewport () {
  if ( window.innerWidth < 980 ){
    return true;
  } else {
    return false;
  }		
}
function cws_is_mobile () {
	var device = cws_is_mobile_device();
	var viewport = cws_is_mobile_viewport();
	return device || viewport;
}
function cws_mobile_controller (){
	var device = cws_is_mobile_device();
	var viewport = cws_is_mobile_viewport();
	var mobile_class 	= cws_has_class( document.body, "cws_mobile" );
	if ( !device ){
		if ( viewport ){
			if ( !mobile_class ){
				cws_add_class( document.body, "cws_mobile" );
			}				
		}
		window.addEventListener( "resize", function (){
			var viewport 		= cws_is_mobile_viewport();
			var mobile_class 	= cws_has_class( document.body, "cws_mobile" );
			if ( viewport ){
				if ( !mobile_class ){
					cws_add_class( document.body, "cws_mobile" );
				}				
			}
			else{
				if ( mobile_class ){
					cws_remove_class( document.body, "cws_mobile" );
				}
			}			
		}, false );
	}
	else{
		cws_add_class( document.body, "cws_mobile" );
	}
}
function cws_merge_trees ( arr1, arr2 ){
	if ( typeof arr1 != 'object' || typeof arr2 != 'object' ){
		return false;
	}
	return cws_merge_trees_walker ( arr1, arr2 );
}
function cws_merge_trees_walker ( arr1, arr2 ){
	if ( typeof arr1 != 'object' || typeof arr2 != 'object' ){
		return false;
	}
	var keys1 = Object.keys( arr1 );
	var keys2 = Object.keys( arr2 );
	var r = {};
	var i;
	for ( i = 0; i < keys2.length; i++ ){
		if ( typeof arr2[keys2[i]] == 'object' ){
			if ( Array.isArray( arr2[keys2[i]] ) ){
				if ( keys1.indexOf( keys2[i] ) === -1 ){
					r[keys2[i]] = arr2[keys2[i]];
				}
				else{
					r[keys2[i]] = arr1[keys2[i]];
				}				
			}
			else{
				if ( typeof arr1[keys2[i]] == 'object' ){
					r[keys2[i]] = cws_merge_trees_walker( arr1[keys2[i]], arr2[keys2[i]] );
				}
				else{
					r[keys2[i]] = cws_merge_trees_walker( {}, arr2[keys2[i]] );
				}
			}
		}
		else{
			if ( keys1.indexOf( keys2[i] ) === -1 ){
				r[keys2[i]] = arr2[keys2[i]];
			}
			else{
				r[keys2[i]] = arr1[keys2[i]];
			}
		}
	}
	return r;
}

cws_mobile_controller ();

function cws_get_flowed_previous ( el ){
	var prev = el.previousSibling;
	var is_prev_flowed;
	if ( !prev ) return false;
	is_prev_flowed = cws_is_element_flowed( prev );
	if ( !is_prev_flowed ){
		return cws_get_flowed_previous( prev );
	}
	else{
		return prev;
	}
}

function cws_is_element_flowed ( el ){
	var el_styles;
	if ( el.nodeName === "#text" ){
		return false;
	}
	el_styles = getComputedStyle( el );
	if ( el_styles.display === "none" || ["fixed","absolute"].indexOf( el_styles.position ) != -1 ){
		return false;
	}else{
		return true;
	}
}

function cws_empty_p_filter_callback (){
	var el = this;
	if ( el.tagName === "P" && !el.innerHTML.length ){
		return false;
	}
	else{
		return true;
	}	
}
function cws_br_filter_callback (){
	var el = this;
	if ( el.tagName === "BR" ){
		return false;
	}
	else{
		return true;
	}	
}

/**********************************
************ \CWS LIBRARY *********
**********************************/