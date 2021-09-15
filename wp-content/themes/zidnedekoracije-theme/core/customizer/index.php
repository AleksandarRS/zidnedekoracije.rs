<?php

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function magicwalls_customize_register( $wp_customize ) {

	/**
	 * Implement the social functionality.
	 */
	require get_template_directory() . '/core/customizer/social.php';
    
    /*
    * Theme Footer options
    */
    require get_template_directory() . '/core/customizer/footer.php';

    /*
    * Theme Google analytics options
    */
    require get_template_directory() . '/core/customizer/google-analytics.php';

    /*
    * Option sanitize functions
    */
   require get_template_directory() . '/core/customizer/sanitize.php';
   
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
add_action( 'customize_register', 'magicwalls_customize_register' );

?>