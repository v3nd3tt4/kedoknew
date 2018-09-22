"use strict";
(function ($){
document.addEventListener( 'DOMContentLoaded', function (){
	unilearn_lp_course_curriculum_sections_init();
	unilearn_lp_course_quiz_sidebar_toggle_init();
	unilearn_lp_course_tab_fix();
}, false );
function unilearn_lp_course_curriculum_sections_init (){
	$( '#learn-press-course-curriculum .curriculum-sections > .section > .section-header > .pointer' ).on( 'click', function( e ) {
		e.stopPropagation();
		var section 		= $(this).closest( '.section' );
		var section_content = section.children('ul');
		if( section.length && section_content.length ) {
			section_content.slideToggle(500);   
			section.toggleClass('active');
			section_content.toggleClass('active')
		} 
	});
}
function unilearn_lp_course_quiz_sidebar_toggle_init (){
	var opnr 			= document.getElementById( 'unilearn_lp_single_quiz_sidebar_opener' );
	if ( !opnr ) 		return false;
	var sidebar 		= opnr.parentNode;
	var active_class	= 'active';
	opnr.addEventListener( 'click', function (){
		if ( cws_has_class( sidebar, active_class ) ){
			cws_remove_class( sidebar, active_class );
		}
		else{
			cws_add_class( sidebar, active_class );
		}
	}, false );
}

//LearnPress single tabs fix.
function unilearn_lp_course_tab_fix (){
	jQuery('.learn-press-nav-tabs li a').on('click',function(e){
		e.preventDefault();
		var tab_name = jQuery(this).data('tab');
		jQuery(this).closest('.course-tabs').find('.course-nav').removeClass('active');
		jQuery(this).parent().addClass('active');
		
		jQuery(this).closest('.course-tabs').find('.course-tab-panel').removeClass('active');
		jQuery(this).closest('.course-tabs').find(tab_name).addClass('active');
		return false;
	});
}

}(jQuery));