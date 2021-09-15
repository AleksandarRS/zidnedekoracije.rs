<?php 
    function textarea_sanitize( $textarea_content ) {
		if ( $textarea_content == '' ) {
			$textarea_content = '';
		}
		return $textarea_content;
	}

	function text_sanitize( $sanitize_text ) {
        if ( '' == $sanitize_text ) {
            $sanitize_text = '';
        }
        return $sanitize_text;
    }

    function sanitize_image( $image ) {
        $length_url = strlen( $image) ;
        $image_ext = substr( $image, $length_url-4, $length_url );
        $ext_array = array( '.png', '.jpg', '.gif' );

        if ( in_array( $image_ext, $ext_array) ) {
            $image = $image;
        }
        else $image = '';

        return $image;
    }
    function sanitize_color( $hexadecimal, $default = '' ) {
    if ( validate_hex( $hexadecimal ) ) {
        return $hexadecimal;
    }
    return $default;
    }

    function validate_hex( $hexadecimal ) {
        $hexadecimal = trim( $hexadecimal );
        /* Strip recognized prefixes. */
        if ( 0 === strpos( $hexadecimal, '#' ) ) {
            $hexadecimal = substr( $hexadecimal, 1 );
        }
        elseif ( 0 === strpos( $hexadecimal, '%23' ) ) {
            $hexadecimal = substr( $hexadecimal, 3 );
        }
        /* Regex match. */
        if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hexadecimal ) ) {
            return false;
        }
        else {
            return true;
        }
    }

    function sanitize_choices( $element ) {
        if ( $element == 'yes' ) {
            return 'yes';
        } else {
            return 'no';
        }
    }

    function font_sanizite($value){
        $selectDirectoryInc = get_stylesheet_directory_uri().'/inc/';

        $finalselectDirectory = $selectDirectoryInc;

        $fontFile = $finalselectDirectory . 'google-web-fonts.txt';
        $font_file_body = wp_remote_get($fontFile);
        $content = json_decode($font_file_body['body']);

        if(! array_key_exists($value , $content->items )){
            $value = 0;
        }
        return $value;
    }
    function sanitize_page_choose($value){
        $args = array('post_type' =>'page');
        $page_dropdown_query = new WP_Query($args);
        $all_pages = array();
        if($page_dropdown_query->have_posts()):
            while ( $page_dropdown_query->have_posts() ) : $page_dropdown_query->the_post();
                $all_pages[] = get_the_ID();
            endwhile;
        endif;


        if ( ! in_array( $value, $all_pages ) ){
            $frontpage_ID = get_option('page_on_front');
            $value = $frontpage_ID;
        }


        return $value;
    }




    /*Sanitize functions*/
    function sidebar_sanitize_layout( $value ) {
        if ( ! in_array( $value, array( 'left-sidebar', 'right-sidebar','no-sidebar' ) ) )
            $value = 'right-sidebar';

        return $value;
    }
    function sidebar_choose_sanitize( $value ) {
        $registered_sidebars  = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
            $registered_sidebars[] = $sidebar['id'] ;

        }
        if ( ! in_array( $value, $registered_sidebars ) )
            $value = 'sidebar-1';

        return $value;
    }
    function blog_sanitize_layout( $value ) {
        if ( ! in_array( $value, array( 'default','2-column', '3-column','masonary' ) ) )
            $value = 'default';

        return $value;
    }

    function footer_sidebar_sanizie( $value ) {
        $column_number = array(1, 2, 3, 4);
        if ( ! in_array( $value, $column_number ) )
            $value = 4;

        return $value;
    }
    function footer_layout_sanizie($value){
        $footer_layout = array('1/1','1/2,1/2', '1/2,1/4,1/4', '1/4,1/4,1/4,1/4', '1/3,1/3,1/3' );
        if ( ! in_array( $value, $footer_layout ) ){
            $value = '1/2,1/4,1/4';
        }

        return $value;

    }

function blog_sanitize_aligment( $value ) {
    if ( ! in_array( $value, array( 'center','left', 'right' ) ) )
        $value = 'center';

    return $value;
}
?>