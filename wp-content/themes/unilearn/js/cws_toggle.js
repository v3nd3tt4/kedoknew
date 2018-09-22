"use strict";

/*********************************************
***************** CWS Toggle *****************
*********************************************/

( function ($){

	window.cws_toggle 	= cws_toggle;

	function cws_toggle ( args, area ){
		var that = this;
		var r = false;
		that.area = typeof area == 'object' ? area : document;
		that.attached = false;
		that.def_args = {
			'mode'			: 'toggle',
			'behaviour'		: 'slide',	/* slide / activeClass / slideOnlyHeight */
			'parent_sel'	: '.menu-item',
			'opnr_sel'		: '.pointer',
			'sect_sel'		: '.sub-menu',
			'speed'			: 300,
			'active_class'	: 'active',
		};
		that.args = {
		};
		that.sections = [];
		that.init = cws_toggle_init;
		that.set_defaults = cws_toggle_set_defaults;
		that.init_section = cws_toggle_init_section;
		that.attach = cws_toggle_attach;
		that.attach_section = cws_toggle_attach_section;
		that.detach = cws_toggle_detach;
		that.detach_section = cws_toggle_detach_section;
		that.check_attachment = cws_toggle_check_attachment;
		that.clear_section = cws_toggle_clear_section;
		that.handlers = {};
		that.handlers.toggle_slide_opnr_click_handler = function (){
			var section_data 	= this.section_data;
			var tgl 			= this.tgl;
			var args 			= tgl.args;
			if ( section_data.active ){
				$( section_data.section ).slideUp( args.speed );
				cws_remove_class( section_data.parent, args.active_class );
				section_data.active = false;
			}
			else{
				$( section_data.section ).slideDown( args.speed );
				cws_add_class( section_data.parent, args.active_class );
				section_data.active = true;
			}
		}
		that.handlers.toggle_activeClass_opnr_click_handler = function (){
			var section_data 	= this.section_data;
			var tgl 			= this.tgl;
			var args 			= tgl.args;
			if ( section_data.active ){
				cws_remove_class( section_data.parent, args.active_class );
				section_data.active = false;
			}
			else{
				cws_add_class( section_data.parent, args.active_class );
				section_data.active = true;
			}
		}
		that.handlers.toggle_slideOnlyHeight_opnr_click_handler = function (){
			var section_data 	= this.section_data;
			var tgl 			= this.tgl;
			var args 			= tgl.args;
			var speed 			= args.speed;
			var transition 		= args.speed / 1000;
			if ( section_data.active ){
				section_data.section.style.height = section_data.section.scrollHeight + "px";				
				section_data.section.style.transition = transition + "s";				
				setTimeout( function (){
					section_data.section.style.height = "0px";
					cws_remove_class( section_data.parent, args.active_class );
					setTimeout( function (){
						section_data.section.style.removeProperty( 'transition' );
						section_data.section.style.removeProperty( 'height' );							
						section_data.active = false;
					}, speed );					
				}, 0);
			}
			else{
				section_data.section.style.height = "0px";
				section_data.section.style.transition = transition + "s";
				setTimeout( function (){
					section_data.section.style.height = section_data.section.scrollHeight + "px";
					cws_add_class( section_data.parent, args.active_class );				
					setTimeout( function (){
						section_data.section.style.removeProperty( 'transition' );
						section_data.section.style.removeProperty( 'height' );					
						section_data.active = true;				
					}, speed );
				}, 0 );
			}
		}
		that.cleaners = {};
		that.cleaners.toggle_slide_section_cleaner = function ( section_data, callback ){
			if ( section_data == undefined ){
				return false;
			}
			cws_remove_class( section_data.parent, args.active_class );
			section_data.section.style.removeProperty( 'display' );
			return true;
		}
		that.cleaners.toggle_activeClass_section_cleaner = function ( section_data, callback ){
			if ( section_data == undefined ){
				return false;
			}
			cws_remove_class( section_data.parent, args.active_class );
			return true;
		}
		that.cleaners.toggle_slideOnlyHeight_section_cleaner = function ( section_data, callback ){
			if ( section_data == undefined ){
				return false;
			}
			cws_remove_class( section_data.parent, args.active_class );
			return true;
		}
		that.cleaners.default = function ( section_data ){
			if ( section_data == undefined ){
				return false;
			}
			cws_remove_class( section_data.parent, args.active_class );
			return true;
		}
		r = that.init( args );
		return r;		
	}
	function cws_toggle_init ( args ){
		var tgl = this;
		tgl.set_defaults( args );
		var args = tgl.args;
		var sections = tgl.sections;
		var sects = tgl.area.querySelectorAll( args.sect_sel );
		var i, sect;
		for ( i = 0; i < sects.length; i++ ){
			sect = sects[i];
			tgl.init_section( sect );
		}
		return tgl;
	}
	function cws_toggle_set_defaults ( args ){
		var tgl = this;
		var def_args = tgl.def_args;
		var arg_names, arg_name, i;
		if ( typeof args != 'object' || !Object.keys( args ).length ){
			tgl.args = def_args;
		}
		else{
			arg_names = Object.keys( def_args );
			for ( i = 0; i < arg_names.length; i++ ){
				arg_name = arg_names[i];
				if ( args[arg_name] != undefined ){
					tgl.args[arg_name] = args[arg_name];
				}
				else{
					tgl.args[arg_name] = def_args[arg_name];					
				}
			}
		}
		return true;		
	}
	function cws_toggle_init_section ( section ){
		var tgl = this;
		var args = tgl.args;
		var sections = tgl.sections;
		var parent, opnr;
		if ( !section ) return false;
		parent = $( section ).closest( args.parent_sel );
		if ( !parent.length ) return false;
		parent = parent[0];
		if ( !( typeof args.opnr_sel == 'string' && args.opnr_sel.length ) ) return false;
		opnr = parent.querySelector( args.opnr_sel );
		if ( !opnr ) return false;
		sections.push({
			opnr 	: opnr,
			parent 	: parent,
			section : section,
			active 	: false
		});
		return true;	
	}
	function cws_toggle_attach (){
		var tgl = this;
		var sections_data = tgl.sections;
		var i, section_data;
		for ( i = 0; i < sections_data.length; i++ ){
			section_data = sections_data[i];
			tgl.attach_section( section_data );
		}
		tgl.attached = true;
		return true;
	}
	function cws_toggle_attach_section ( section_data ){
		var tgl = this;
		var args = tgl.args;
		var handler_id = args.mode + "_" + args.behaviour + "_opnr_click_handler";
		var handler;
		if ( typeof section_data != 'object' ){
			return false;
		}
		if ( tgl.handlers[handler_id] === undefined ){
			return false;
		}
		handler = tgl.handlers[handler_id];
		section_data.opnr.section_data 	= section_data;
		section_data.opnr.tgl 			= tgl;
		section_data.opnr.addEventListener( "click", handler, false );
		return true;
	}
	function cws_toggle_detach (){
		var tgl = this;
		var sections_data = tgl.sections;
		var i, section_data;
		for ( i = 0; i < sections_data.length; i++ ){
			section_data = sections_data[i];
			tgl.detach_section( section_data );
		}
		tgl.attached = false;
		return true;
	}
	function cws_toggle_detach_section ( section_data ){
		var tgl = this;
		var args = tgl.args;
		var handler_id = args.mode + "_" + args.behaviour + "_opnr_click_handler";
		if ( typeof section_data != 'object' ){
			return false;
		}
		if ( tgl.handlers[handler_id] !== undefined ){
			section_data.opnr.removeEventListener( "click", tgl.handlers[handler_id] );		
		}
		tgl.clear_section( section_data );
		section_data.active = false;
		return true;
	}
	function cws_toggle_check_attachment (){
		var tgl = this;
		return tgl.attached;
	}
	function cws_toggle_clear_section ( section_data ){
		var tgl = this;
		var args = tgl.args;
		var cleaner_id = args.mode + "_" + args.behaviour + "_section_cleaner";
		var cleaner;
		if ( typeof section_data != 'object' ){
			return false;
		}
		if ( tgl.cleaners[cleaner_id] === undefined ){
			cleaner = tgl.cleaners.default;
		}
		else{
			cleaner = tgl.cleaners[cleaner_id];	
		}
		cleaner( section_data );
	}
}(jQuery));

/*********************************************
***************** \CWS Toggle ****************
*********************************************/