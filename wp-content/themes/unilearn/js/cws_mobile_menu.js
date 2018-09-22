"use strict";

/*********************************************
************** CWS Mobile Menu ***************
*********************************************/

(function ($){

	window.cws_mobile_menu 			= cws_mobile_menu;
	window.cws_mobile_menu_instance = cws_mobile_menu_instance;

	function cws_mobile_menu ( args ){
		var that = this;
		that.def_args = {
			behaviour			: 'toggle',		/* toggle/accordeon ... */
			mobile_class		: 'cws_mobile_menu',					
			menu_sel 			: '',
			toggles				: [
				{
					'parent_sel'	: '.menu-item',
					'opnr_sel'		: '',
					'sect_sel'		: '.sub-menu',
					'speed'			: 300,
					'active_class'	: 'active'				
				}
			]
		};
		that.args = typeof args === 'object' ? args : {};
		that.instances 			= {};
		that.set_defaults 		= cws_mobile_menu_set_defaults;
		that.init_instances		= cws_mobile_menu_init_instances;
		that.set_instances 		= cws_mobile_menu_set_instances;
		that.reset_instances 	= cws_mobile_menu_reset_instances;
		that.set_defaults();
		that.init_instances();
	}

	function cws_mobile_menu_set_defaults (){
		var that = this;
		that.args = cws_merge_trees( that.args, that.def_args );
		return true;	
	}

	function cws_mobile_menu_init_instances (){
		var that = this;
		var sections = document.querySelectorAll( that.args.menu_sel );
		var i, section, section_id, instance;
		if ( !sections.length ) return false;
		for ( i = 0; i < sections.length; i++ ){
			section = sections[i];
			section_id = section.id;
			instance = new cws_mobile_menu_instance( section, that.args );
			if ( instance !== false ){
				that.instances[section_id] = instance;
			}
		}
	}

	function cws_mobile_menu_set_instances (){
		var that = this;
		var i, section_id, instance;
		for ( section_id in that.instances ){
			instance = that.instances[section_id];
			instance.set();
		}
	}

	function cws_mobile_menu_reset_instances (){
		var that = this;
		var i, section_id, instance;
		for ( section_id in that.instances ){
			instance = that.instances[section_id];
			instance.reset();
		}
	}	



	function cws_mobile_menu_instance ( section, menu_args ){
		var instance = this;
		var i, tgl_settings, tgl_instance;
		if ( typeof section != 'object' && typeof mobile_class != 'string' ){
			return false;
		}
		instance.section 		= section;
		instance.mobile_class 	= menu_args.mobile_class;
		instance.tgls 			= [];
		instance.set 		 	= cws_mobile_menu_instance_set;
		instance.reset 		 	= cws_mobile_menu_instance_reset;
		instance.attach_tgls 	= cws_mobile_menu_instance_attach_toggles;
		instance.detach_tgls 	= cws_mobile_menu_instance_detach_toggles;
		for ( i in menu_args.toggles ){
			tgl_settings = menu_args.toggles[i];
			tgl_instance = new cws_toggle( tgl_settings, section );
			if ( tgl_instance !== false ){
				instance.tgls.push( tgl_instance );
			}
		}
	}

	function cws_mobile_menu_instance_attach_toggles (){
		var instance = this;
		var i, tgl;
		for ( i = 0; i < instance.tgls.length; i++ ){
			tgl = instance.tgls[i];
			tgl.attach();
		}
	}

	function cws_mobile_menu_instance_detach_toggles (){
		var instance = this;
		var i, tgl;
		for ( i = 0; i < instance.tgls.length; i++ ){
			tgl = instance.tgls[i];
			tgl.detach();
		}
	}	

	function cws_mobile_menu_instance_set (){
		var instance = this;
		instance.attach_tgls();
		if ( instance.mobile_class.length ){
			cws_add_class( instance.section, nstance.mobile_class );
		}
	}		

	function cws_mobile_menu_instance_reset ( section, menu ){
		var instance = this;
		instance.detach_tgls();
		if ( instance.mobile_class.length ){
			cws_remove_class( instance.section, nstance.mobile_class );
		}
	}

}(jQuery))