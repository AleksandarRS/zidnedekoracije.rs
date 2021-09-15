<?php
/***********************************************************************
** Filters and actions part 
***********************************************************************/

add_filter( 'upload_mimes', 'cc_mime_types');
add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
add_filter( 'use_block_editor_for_post', '__return_false', 10);
add_filter( 'use_block_editor_for_post_type', '__return_false', 10);
add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
add_filter( 'frm_field_label_seen', 'magicwalls_formidable_customize_html', 11, 3);

add_action( 'login_head', 'magicwalls_remove_login_shake' );
add_action( 'admin_head', 'fix_svg_thumb_display');
add_action( 'login_enqueue_scripts', 'lf_login_logo');
add_action( 'acf/init', 'lf_acf_init');
add_action( 'widgets_init', 'magicwalls_widgets_init');
add_action( 'after_setup_theme', 'magicwalls_after_setup_theme_function', 0);
add_action( 'wp_enqueue_scripts', 'magicwalls_scripts_and_styles');
add_action( 'wp_print_styles', 'magicwalls_deregister_styles', 100 );
add_action( 'init', 'magicwalls_init_action' );
add_action( 'admin_enqueue_scripts', 'magicwalls_load_admin_style' );


/***********************************************************************
** Functions part
***********************************************************************/

/**
 * disable_emojis_remove_dns_prefetch
 *
 * @return void
 */
if ( !function_exists('disable_emojis_remove_dns_prefetch') ):

    /**
     * Remove emoji CDN hostname from DNS prefetching hints.
     *
     * @param array $urls URLs to print for resource hints.
     * @param string $relation_type The relation type the URLs are printed for.
     * @return array Difference betwen the two arrays.
     */
    function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
        if ( 'dns-prefetch' == $relation_type ) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
    
        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
   
    return $urls;
   }

endif;

/**
 * disable_emojis_tinymce
 *
 * @return void
 */
if ( !function_exists('disable_emojis_tinymce') ):

    /**
     * Filter function used to remove the tinymce emoji plugin.
     * 
     * @param array $plugins 
     * @return array Difference betwen the two arrays
     */
    function disable_emojis_tinymce( $plugins ) {
        if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
        } else {
        return array();
        }
    }

endif;

/**
 * magicwalls_deregister_styles
 *
 * @return void
 */
if ( !function_exists('magicwalls_init_action') ):

    //Disable gutenberg style in Front
    function magicwalls_init_action() {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    }

endif;

/**
 * magicwalls_deregister_styles
 *
 * @return void
 */
if ( !function_exists('magicwalls_deregister_styles') ):

    //Disable gutenberg style in Front
    function magicwalls_deregister_styles() {
        wp_dequeue_style( 'wp-block-library' );
    }

endif;

/**
 * magicwalls_remove_login_shake
 *
 * @return void
 */
if ( !function_exists('magicwalls_remove_login_shake') ):

    // remove error shaking
	function magicwalls_remove_login_shake() {
		remove_action( 'login_head', 'wp_shake_js', 12 );
	}

endif;

/**
 * cc_mime_types
 *
 * @param array $mimes
 * @return void
 */
if (!function_exists('cc_mime_types')):

    function cc_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

endif;

/**
 * fix_svg_thumb_display
 *
 * @return void
 */
if (!function_exists('fix_svg_thumb_display')):

    function fix_svg_thumb_display() {
        echo '
					<style>
					td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
					width: 100% !important;
					height: auto !important;
					}
					</style>
				';
    }

endif;

/**
 * Wp-Login Logo Change
 *
 * @return void
 */
if (!function_exists('lf_login_logo')):

    function lf_login_logo() {
        ?>
				<style type="text/css">
					#login h1 a, .login h1 a {
						background-image: url(<?php echo (get_header_image()); ?>);
						width: 100% !important;
						background-size: contain;
						max-height: 150px;
						padding-bottom: 30px;
					}

				</style>
				<?php

    }

endif;

/**
 * lf_acf_init
 *
 * @return void
 */

if (!function_exists('lf_acf_init')):

    /*
     * Google Maps API Key ACF
     * */
    function lf_acf_init() {

        
        if( defined('ACF_GOOGLE_API_KEY') ){
            acf_update_setting('google_api_key', ACF_GOOGLE_API_KEY);
        } else {
            // if( is_admin() ){
            //     add_action( 'admin_notices', function(){
                    ?>
                    <!-- <div class="notice notice-error is-dismissible">
                        <p><?php //_e( "Please define ACF_GOOGLE_API_KEY in wp-config.php: <strong>define('ACF_GOOGLE_API_KEY', 'YOUR_API_KEY_HERE');</strong>", 'magicwalls' ); ?></p>
                    </div> -->
                    <?php
            //     } );
            // }
        }
    }

endif;

if (!function_exists('magicwalls_widgets_init')):

    /**
     * Register widget area.
     *
     * @link http://codex.wordpress.org/Function_Reference/register_sidebar
     */
    function magicwalls_widgets_init() {
        register_sidebar(array(
            'name' => esc_html__('Sidebar', 'magicwalls'),
            'id' => 'sidebar-1',
            'description' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 1', 'magicwalls'),
            'id' => 'footer-1',
            'description' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 2', 'magicwalls'),
            'id' => 'footer-2',
            'description' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 3', 'magicwalls'),
            'id' => 'footer-3',
            'description' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 4', 'magicwalls'),
            'id' => 'footer-4',
            'description' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    }

endif;

if (!function_exists('after_setup_theme_function')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */

    function magicwalls_after_setup_theme_function() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on magicwalls, use a find and replace
         * to change 'magicwalls' to the name of your theme in all the template files
         */
        load_theme_textdomain('magicwalls', get_template_directory() . '/languages');

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global int $content_width
		 */
        $GLOBALS['content_width'] = apply_filters('magicwalls_content_width', 1170);

        // Add theme support for custom header image
        add_theme_support('custom-header', array(
            'flex-width' => true,
            'width' => 260,
            'flex-height' => true,
            'height' => 100,
            'header-selector' => '.site-title a',
            'header-text' => false,

        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support(
            'post-formats',
            array(
                'aside',
                'image',
                'video',
                'quote',
                'link',
            )
        );

        /*
         * Enable support for WooCommerce
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('woocommerce');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
		add_theme_support('post-thumbnails');
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'magicwalls' ),
			)
		);

	}
	
	if ( !function_exists('magicwalls_scripts_and_styles') ) :

		function magicwalls_scripts_and_styles() {

			wp_enqueue_style('magicwalls-style', get_stylesheet_uri());
			wp_enqueue_style('lf-css', get_stylesheet_directory_uri() . '/dist/style.css');

			// wp_enqueue_script('vendor-main', get_template_directory_uri() . '/assets/js/vendor.min.js', array('jquery'), '1.0',true);
			wp_enqueue_script('main', get_template_directory_uri() . '/dist/scripts.js', array('jquery'), '1.1', true);
            
			// Only uncomment this if theme needs to have comments enabled
			if (is_singular() && comments_open() && get_option('thread_comments')) {
				wp_enqueue_script('comment-reply');
			}

		}

	endif;
endif;

if ( !function_exists('magicwalls_formidable_customize_html') ) :

    function magicwalls_formidable_customize_html( $opt, $key, $field ){
		
		if( !is_admin() ){
			
			if( $field['type'] === 'radio' || $field['type'] === 'checkbox'){

				if( strpos($opt, '<span><span></span><span>' ) <= 0 )
					return "<span><span></span><span>$opt</span></span>";
			}

		} else {
			$current_page = get_current_screen();

			if( $current_page->id != 'toplevel_page_formidable' ){
				if( $field['type'] === 'radio' || $field['type'] === 'checkbox'){

					if( strpos($opt, '<span><span></span><span>' ) <= 0 )
						return "<span><span></span><span>$opt</span></span>";
				}
			}
		}
		
		return $opt;
    }

endif;

if ( !function_exists('magicwalls_load_admin_style') ) :

	function magicwalls_load_admin_style() {
		wp_register_style( 'admin_css', get_stylesheet_directory_uri() . '/assets/admin/css/style.css', false, '1.0.0' );
		wp_enqueue_style( 'admin_css', get_stylesheet_directory_uri() . '/assets/admin/css/style.css', false, '1.0.0' );
	}

endif;

?>