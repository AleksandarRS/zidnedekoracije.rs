<?php

if ( ! function_exists( 'magicwalls_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function magicwalls_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'magicwalls' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'magicwalls' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'magicwalls_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function magicwalls_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'magicwalls' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'magicwalls' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'magicwalls' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'magicwalls' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'magicwalls' ), esc_html__( '1 Comment', 'magicwalls' ), esc_html__( '% Comments', 'magicwalls' ) );
			echo '</span>';
		}

		edit_post_link( esc_html__( 'Edit', 'magicwalls' ), '<span class="edit-link">', '</span>' );
	}
endif;

if ( ! function_exists( 'magicwalls_post_navigation' ) ) :
	/**
	 * Lf Post Navigation
	 */
	function magicwalls_post_navigation() {
		?>
		<div class="nav-links">
		<?php
		global $wp_query;

		$big = 999999999; // need an unlikely integer

		echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'prev_text'          => __('<i class="icon-angle-left" aria-hidden="true"></i>'),
				'next_text'          => __('<i class="icon-angle-right" aria-hidden="true"></i>')
		) );
		?>
	</div>
	<?php 
	}
endif;

if ( ! function_exists( 'magicwalls_share_links' ) ) :
	/**
	 * Lf Share links
	 **/

	function magicwalls_share_links() {
		?>
		<div class="share-buttons">
			<div class="share-links-wrapper">
				<!-- Facebook -->
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" title="Share on Facebook" target="_blank" class="btn btn-facebook">
					<i class="fa fa-facebook-square transition-all-05"></i>
				</a>
				<!-- Twitter -->
				<a href="http://twitter.com/home?status=<?php the_permalink(); ?>" title="Share on Twitter" target="_blank" class="btn btn-twitter">
					<i class="fa fa-twitter-square transition-all-05"></i>
				</a>
				<!-- LinkedIn -->
				<a href="http://www.linkedin.com/shareArticle?mini=true&url=&title=&summary=<?php the_permalink(); ?>" title="Share on LinkedIn" target="_blank" class="btn btn-linkedin">
					<i class="fa fa-linkedin-square transition-all-05"></i>
				</a>
				<!-- Pinterest -->
				<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>]&description=<?php the_title(); ?>" class="btn btn-pinterest" target="_blank" title="Share on Pinterest">
					<i class="fa fa-pinterest-square transition-all-05"></i>
				</a>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'magicwalls_archive_title' ) ) :
	/**
	 * @param string $before_title
	 * @param string $after_title
	 * @return string
	 */
	function magicwalls_archive_title( $before_title = "", $after_title = "" ) {

		if ( is_category() ) {
			$title = $before_title . single_cat_title( '', false ) . $after_title;
		} elseif ( is_tag() ) {
			$title = $before_title . single_tag_title( '', false ) . $after_title;
		} elseif ( is_author() ) {
			$title = $before_title . get_the_author() . $after_title;
		} elseif ( is_year() ) {
			$title = $before_title . get_the_date( _x( 'Y', 'yearly archives date format' ) )  . $after_title;
		} elseif ( is_month() ) {
			$title = $before_title . get_the_date( _x( 'F Y', 'monthly archives date format' ) )  . $after_title;
		} elseif ( is_day() ) {
			$title = $before_title . get_the_date( _x( 'F j, Y', 'daily archives date format' ) )  . $after_title;
		} elseif( is_tax() ){
			$title = $before_title . single_term_title('', false) . $after_title;
		} elseif ( is_post_type_archive() ) {
			$title = $before_title . post_type_archive_title( '', false )  . $after_title;
		} elseif( is_single() ) {
			$title = $before_title . get_the_title() . $after_title;
		} else{
			$title = $before_title . '' . $after_title;
		}

		return $title;

	}
endif;

if ( ! function_exists( 'get_footer_widget_class' ) ) :

	function get_footer_widget_class( $option ){

		$classes = explode( ',', $option );
		$orgclasses = array();

		foreach ( $classes as $class ) {
			$exploded = explode( '/', $class );

			if( isset( $exploded[1] ) && intval( $exploded[1] ) != 0 ){
				$orgclasses[] = 12 / intval( $exploded[1] );
			} else {
				$orgclasses[] = 12;
			}
		}
		return $orgclasses;
	}

endif;

if ( ! function_exists( 'the_social_links' ) ) :

	/**
	 * Return or echo social network icons
	 *
	 * @param boolean $echo
	 * @return void
	 */
	function the_social_links( $echo = false ){
		
		$return_html = '<div class="lf-social-wrapper">';
			
			/*------- Variables ------*/
			$facebook_icon = get_theme_mod('social_customizer_fb_icon');
			$facebook_url = esc_url(get_theme_mod('social_customizer_fb_url'));
			$twitter_icon = get_theme_mod('social_customizer_tw_icon');
			$twitter_url = esc_url(get_theme_mod('social_customizer_tw_url'));
			$youtube_icon = get_theme_mod('social_customizer_youtube_icon');
			$youtube_url = esc_url(get_theme_mod('social_customizer_youtube_url'));
			$google_icon = get_theme_mod('social_customizer_g_icon');
			$google_url = esc_url(get_theme_mod('social_customizer_g_url'));
			$linkedIn_icon = get_theme_mod('social_customizer_lni_icon');
			$linkedIn_url = esc_url(get_theme_mod('social_customizer_lni_url'));
			$instagram_icon = get_theme_mod('social_customizer_instagram_icon');
			$instagram_url = esc_url(get_theme_mod('social_customizer_instagram_url'));
			$pinterest_icon = get_theme_mod('social_customizer_pinterest_icon');
			$pinterest_url = esc_url(get_theme_mod('social_customizer_pinterest_url'));

			/*---------------Icon Checker -------------------*/
			if($facebook_icon!=''): $fb_icon = '<img src='.$facebook_icon.'>'; else: $fb_icon = '<i class="icon icon-facebook"></i>';endif;
			if($twitter_icon!=''): $tw_icon ='<img src='.$twitter_icon.'>'; else: $tw_icon = '<i class="icon icon-twitter"></i>';endif;
			if($google_icon!=''): $go_icon = '<img src='.$google_icon.'>'; else: $go_icon = '<i class="icon icon-google-plus-g"></i>';endif;
			if($youtube_icon!=''): $you_icon = '<img src='.$youtube_icon.'>'; else: $you_icon = '<i class="icon icon-youtube"></i>';endif;
			if($linkedIn_icon!=''): $li_icon = '<img src='.$linkedIn_icon.'>'; else: $li_icon = '<i class="icon icon-linkedin"></i>';endif;
			if($instagram_icon!=''): $inst_icon = '<img src='.$instagram_icon.'>'; else: $inst_icon ='<i class="icon icon-instagram"></i>';endif;
			if($pinterest_icon!=''): $pt_icon = '<img src='.$pinterest_icon.'>'; else: $pt_icon = '<i class="icon icon-pinterest"></i>';endif;

			if($facebook_url!=''){
				$return_html .= '<div class="social-icon-menu-items facebook">';
				$return_html .= '<a href="'.$facebook_url.'" target="_blank">'.$fb_icon.'</a>';
				$return_html .= '</div>';
			}

			if($instagram_url!=''){
				$return_html .= '<div class="social-icon-menu-items instagram">';
				$return_html .= '<a href="'.$instagram_url.'" target="_blank">'.$inst_icon.'</a>';
				$return_html .= '</div>';
			}

			if($twitter_url!=''){
				$return_html .= '<div class="social-icon-menu-items twitter">';
				$return_html .= '<a href="'.$twitter_url.'" target="_blank">'.$tw_icon.'</a>';
				$return_html .= '</div>';
			}

			if($google_url!=''){
				$return_html .= '<div class="social-icon-menu-items google">';
				$return_html .= '<a href="'.$google_url.'" target="_blank">'.$go_icon.'</a>';
				$return_html .= '</div>';
			}

			if($youtube_url!=''){
				$return_html .= '<div class="social-icon-menu-items youtube">';
				$return_html .= '<a href="'.$youtube_url.'" target="_blank">'.$you_icon.'</a>';
				$return_html .= '</div>';
			}

			if($linkedIn_url!=''){
				$return_html .= '<div class="social-icon-menu-items linkedin">';
				$return_html .= '<a href="'.$linkedIn_url.'" target="_blank">'.$li_icon.'</a>';
				$return_html .= '</div>';
			}

			if($pinterest_url!=''){
				$return_html .= '<div class="social-icon-menu-items pinterest">';
				$return_html .= '<a href="'.$pinterest_url.'" target="_blank">'.$pt_icon.'</a>';
				$return_html .= '</div>';
			}

		$return_html .= '</div>';

		if( $echo )
			echo $return_html;
		else
			return $return_html;
	}

endif;



/**
 * Create test page on theme activation
 */
if (isset($_GET['activated']) && is_admin()){

    $new_page_title = 'HTML Markup Test page';

	ob_start();
	
	get_template_part('core/data/test', 'data');
	
	$new_page_content = ob_get_contents();
	
    ob_end_clean();

    $new_page_template = ''; //ex. template-custom.php. Leave blank if you don't want a custom page template.
	//don't change the code bellow, unless you know what you're doing
	
    $page_check = get_page_by_title($new_page_title);

    $new_page = array(
        'post_type' => 'page',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_status' => 'draft',
        'post_author' => 1,
	);
	
    if(!isset($page_check->ID)){
        $new_page_id = wp_insert_post($new_page);
        if(!empty($new_page_template)){
            update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
        }
    }
}

/**
 * ACF Link
 */

if ( ! function_exists( 'lf_acf_link' ) ) :

	function lf_acf_link($link, $class) {
		if ( $link ) :
			$link_url = $link['url'];
			$link_title = $link['title'];
			$link_target = ( $link['target'] != '' ) ? 'target="' . $link['target'] . '"' : '';
		
			return '<a href="' . $link_url .'" class="' . $class . '"' . $link_target . '>' . $link_title . '</a>';
		endif;
	}

endif;