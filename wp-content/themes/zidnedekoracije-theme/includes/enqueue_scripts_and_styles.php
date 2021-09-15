<?php 

/**
 * Enqueue custom scripts and styles.
 */
function custom_scripts_and_styles() {

	$theme_options = array();
	
	if( defined('ACF_GOOGLE_API_KEY') ){
		$theme_options['google_api_key'] = ACF_GOOGLE_API_KEY;
	}            

	wp_localize_script( 'main', 'theme', $theme_options );
	
}
add_action('wp_enqueue_scripts', 'custom_scripts_and_styles');

?>