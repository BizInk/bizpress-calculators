<?php
/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function calculator_settings_fields( $fields, $section ) {

	//if ( 'bizink-client_basic' != $section['id'] ) return $fields;
	
	if('bizink-client_basic' == $section['id']){
		$fields['calculator_content_page'] = array(
			'id'      => 'calculator_content_page',
			'label'     => __( 'Bizink Client calculator', 'bizink-client' ),
			'type'      => 'select',
			'desc'      => __( 'Select the page to show the content. This page must contain the <code>[bizink-content]</code> shortcode.', 'bizink-client' ),
			'options'	=> cxbc_get_posts( [ 'post_type' => 'page' ] ),
			// 'chosen'	=> true,
			'required'	=> false,
		);
	}
	
	if('bizink-client_content' == $section['id']){
		$fields['calculator_label'] = array(
			'id' => 'calculator',
	        'label'	=> __( 'Bizink Client Calculator', 'bizink-client' ),
	        'type' => 'divider'
		);
		$fields['calculator_title'] = array(
			'id' => 'calculator_title',
			'label'     => __( 'Calculator Page Title', 'bizink-client' ),
			'type'      => 'text',
			'default'   => __( 'Calculators', 'bizink-client' ),
			'required'	=> true,
		);
		$fields['calculator_desc'] = array(
			'id'      	=> 'calculator_desc',
			'label'     => __( 'Calculator page Description', 'bizink-client' ),
			'type'      => 'textarea',
			'default'   => __( 'Free Calculators to help you in your business.', 'bizink-client' ),
			'required'	=> true,
		);
	}

	return $fields;
}
add_filter( 'cx-settings-fields', 'calculator_settings_fields', 10, 2 );

function calculator_content( $types ) {
	$types[] = [
		'key' 	=> 'calculator_content_page',
		'type'	=> 'calculator-content'
	];
	return $types;
}
add_filter( 'bizink-content-types', 'calculator_content' );

if( !function_exists( 'bizink_get_calculator_page_object' ) ){
	function bizink_get_calculator_page_object(){
		$post_id = cxbc_get_option( 'bizink-client_basic', 'calculator_content_page' );
		$post = get_post( $post_id );
		return $post;
	}
}

add_action( 'init', 'bizink_calculator_init');
function bizink_calculator_init(){
	$post = bizink_get_calculator_page_object();
	if( is_object( $post ) && get_post_type( $post ) == "page" ){
		add_rewrite_tag('%'.$post->post_name.'%', '([^&]+)', 'bizpress=');
		add_rewrite_rule('^'.$post->post_name . '/([^/]+)/?$','index.php?pagename=' . $post->post_name . '&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/([a-z0-9-]+)[/]?$",'index.php?pagename='.$post->post_name.'&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/topic/([a-z0-9-]+)[/]?$",'index.php?pagename='.$post->post_name.'&topic=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/type/([a-z0-9-]+)[/]?$" ,'index.php?pagename='.$post->post_name.'&type=$matches[1]','top');
		//flush_rewrite_rules();
	}
}

add_filter('query_vars', 'bizpress_calculator_qurey');
function bizpress_calculator_qurey($vars) {
    $vars[] = "bizpress";
    return $vars;
}