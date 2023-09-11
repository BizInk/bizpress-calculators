<?php
/**
 * if accessed directly, exit.
 */

use function PHPSTORM_META\map;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bizpress_calculator_init() {
	wp_register_script('bizpress-calculator-block',plugins_url( 'calculator-block.js', __FILE__ ));
}
add_action( 'init', 'bizpress_calculator_init' );

function bizpress_calculator_shortcode( $atts ) {
    // Parse the shortcode attributes
    $atts = shortcode_atts( array(
        'id' => '',
		'slug' => ''
    ), $atts );
	
    // Get the calculator content based on the ID parameter
	$data = bizpress_calculator_get_single( intval( $atts['id'] ) )[0];
	if ( is_wp_error( $data ) ) {
		$calculator_content = 'Error: Could not retrieve calculator content.';
	}
	else{
		$calculator_content = $data->content->rendered . '<div style="display:none;" class="bizpress-data" id="bizpress-data"
		data-single="true"
		data-siteid="'.(function_exists('bizpress_anylitics_get_site_id') ? bizpress_anylitics_get_site_id() : "false").'"
		data-title="'.$data->title->rendered.'"
		data-url="'.get_permalink().'"
		data-slug="'.$data->slug.'"
		data-id="'.$atts['id'].'"
		data-posttype="calculator"
		data-topics="false"
		data-types="false"></div>';
	}

    // Return the calculator content wrapped in a div with a unique ID
    return '<div id="bizpress-calculator-' . esc_attr( $atts['id'] ) . '">' . $calculator_content . '</div>';
}
add_shortcode( 'bizpress-calculator', 'bizpress_calculator_shortcode' );


function bizpress_caculator_settings($sections){
	$calculators = bizpress_caculator_get_all();
	$calculatorsBizpress = [];
	if(is_wp_error($calculators)){
		$calculatorsBizpress = [
			"calculator_error" => [
				"id" => "calculator_error",
				"type" => "admin_message",
				"label" => __('Error', 'bizink-client'),
				"message" => __('Could not retrieve calculator content.','bizink-clinet'),
			]
		];
	}
	else if(!empty($calculators)){
		foreach($calculators as $calc){
			$calculatorsBizpress[ $calc->slug ] = [
				"id" => $calc->slug,
				"label" => $calc->title->rendered,
				"type" => "admin_shortcode",
				"shortcode" => "[bizpress-calculator id=\"".$calc->id."\"]",
				"copy" => true
			];
		}
	}
	else{
		$calculatorsBizpress = [
			"calculator_nodata" => [
				"id" => "calculator_nodata",
				"label" => __('No Caculators', 'bizink-client'),
				"message" => __('There are no calculators to show at the moment','bizink-clinet'),
				"type" => "admin_message"
			]
		];
	}
	$sections["calculators"] = array(
		'id'        => 'calculators',
		'label'     => __( 'Calculators', 'bizink-client' ),
		'icon'      => 'dashicons-calculator',
		'color'		=> '#4c3f93',
		'sticky'	=> false,
		'submit_button' => false,
		'reset_button' => false,
		'fields' => $calculatorsBizpress
	);
	return $sections;
}
add_filter('cx-settings-sections','bizpress_caculator_settings');

add_filter('query_vars', 'bizpress_calculator_qurey');
function bizpress_calculator_qurey($vars) {
    $vars[] = "calculator";
    return $vars;
}

function bizpress_calculator_get_single($id){
	$data = get_transient("bizpress_calculator_".$id);
	if(!empty($data)){
		return json_decode($data);
	}

	if(function_exists('bizink_get_master_site_url')){
        $base_url = bizink_get_master_site_url();
    }
    else{
        $base_url = 'https://bizinkcontent.com/';
    }
    if(function_exists('bizink_url_authontication')){
        $args = bizink_url_authontication();
    }
    else{
        $args = array(
            'timeout' => 10,
		    'httpversion' => '1.1',
            'headers' => array(
                'Content-Type' => 'application/json',
				'Accept' => 'application/json',
            )
        );
    }
    $options = get_option( 'bizink-client_basic' );
    if(empty($options['user_email'])){
		$options['user_email'] = '';
	}
	if(empty($options['user_password'])){
		$options['user_password'] = '';
	}
	$url = add_query_arg( [ 
        'email'         => $options['user_email'],
        'password'      => ncrypt()->encrypt( $options['user_password'] ),
		'p'				=> $id,
		'include'		=> array($id),
        'luca'		    => function_exists('luca') ? true : false
    ], wp_slash( $base_url.'wp-json/wp/v2/calculators' ) );
    $response = wp_remote_get( $url, $args );
    if ( is_wp_error( $response ) ) {
        return $response;
    } 
    else {
		set_transient( "bizpress_calculator_".$id, wp_remote_retrieve_body( $response ), DAY_IN_SECONDS );
        return json_decode( wp_remote_retrieve_body( $response ) );
    }
}

function bizpress_caculator_get_all(){
	$data = get_transient("bizpress_calculators");
	if(!empty($data)){
		//return json_decode($data);
	}
	if(function_exists('bizink_get_master_site_url')){
        $base_url = bizink_get_master_site_url();
    }
    else{
        $base_url = 'https://bizinkcontent.com/';
    }
    if(function_exists('bizink_url_authontication')){
        $args = bizink_url_authontication();
    }
    else{
        $args = array(
            'timeout' => 10,
		    'httpversion' => '1.1',
            'headers' => array(
                'Content-Type' => 'application/json',
				'Accept' => 'application/json',
            )
        );
    }
    $options = get_option( 'bizink-client_basic' );
    if(empty($options['user_email'])){
		$options['user_email'] = '';
	}
	if(empty($options['user_password'])){
		$options['user_password'] = '';
	}
	$url = add_query_arg( [ 
        'email'         => $options['user_email'],
        'password'      => ncrypt()->encrypt( $options['user_password'] ),
        'luca'		    => function_exists('luca') ? true : false
    ], wp_slash( $base_url.'wp-json/wp/v2/calculators' ) );
    $response = wp_remote_get( $url, $args );
    if ( is_wp_error( $response ) ) {
        return $response;
    } 
    else {
		set_transient( "bizpress_calculators", wp_remote_retrieve_body( $response ), DAY_IN_SECONDS );
        return json_decode( wp_remote_retrieve_body( $response ) );
    }
}