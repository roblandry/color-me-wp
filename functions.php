<?php
/*
	Color Me Wp - functions.php
	Copyright (c) 2012 by Rob Landry

	GNU General Public License version 3

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	// Load up our theme options page and related code.
global $color_me_wp_options;
require( get_stylesheet_directory() . '/inc/theme-options.php' );
$color_me_wp_options = new Color_Me_WP_Options();
#--------------------------------------------------------------
# Dequeue Fonts
# Since: 0.1.0
# A function to remove the TwentyTwelve Font
#--------------------------------------------------------------
function cmw_dequeue_fonts() {
	wp_dequeue_style( 'twentytwelve-fonts' );
}
add_action( 'wp_enqueue_scripts', 'cmw_dequeue_fonts', 11 );


#--------------------------------------------------------------
# Theme Options Init
# Since: 0.1.0
# A function to Initialize the theme options page
#--------------------------------------------------------------
function cmw_options_init(){
	//register_setting( 'cmw_options', 'cmw_theme_options');
	//require_once('inc/theme-options.php');
} 
add_action( 'admin_init', 'cmw_options_init' );


#--------------------------------------------------------------
# Theme Options add page
# Since: 0.1.0
# A function to add the theme options page
#--------------------------------------------------------------
function cmw_options_add_page() {
	$page = add_theme_page( __( 'Theme Options', 'cmw_theme' ), __( 'Theme Options', 'cmw_theme' ), 'edit_theme_options', 'theme-options', 'cmw_options_do_page' );
	add_action( 'admin_print_styles-' . $page, 'cmw_admin_scripts' );
}
//add_action( 'admin_menu', 'cmw_options_add_page' ); 


#--------------------------------------------------------------
# Twenty Twelve Credits
# Since: 0.1.0
# A function to add the copyright to the footer
#--------------------------------------------------------------
function cmw_twentytwelve_credits() {
	$year = date("Y");
	$previousyear = $year -1;
	$bloginfo = get_bloginfo( 'name', 'display' );
	echo "<div class=copyright>Copyright &copy; <a href='".site_url()."'>$bloginfo</a> $previousyear - $year</div>";
}
add_action( 'twentytwelve_credits', 'cmw_twentytwelve_credits');


/*
 * @since Twenty Twelve 1.0
 */
function color_me_wp_setup() {
	global $color_me_wp_options;
 	/*
     	 * Makes Twenty Twelve available for translation.
     	 *
    	 */
     	load_theme_textdomain( 'color-me-wp', get_template_directory() . '/languages' );
     

 	// This theme styles the visual editor with editor-style.css to match the theme style.
     	add_editor_style();
}
add_action( 'after_setup_theme', 'color_me_wp_setup' );


#--------------------------------------------------------------
# Wp Head
# Since: 0.1.0
# A function to add the styles to the wp_head
#--------------------------------------------------------------
function cmw_wp_head() {
	global $color_me_wp_options;
	$new_options = get_option( $color_me_wp_options->option_key );

	echo "<style type='text/css'>
		.main-navigation {
			background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(".$new_options['color_nav_bottom']."), to(".$new_options['color_nav_top']."));
			background: -webkit-linear-gradient(top, ".$new_options['color_nav_top'].", ".$new_options['color_nav_bottom'].");
			background: -moz-linear-gradient(top, ".$new_options['color_nav_top'].", ".$new_options['color_nav_bottom'].");
			background: -ms-linear-gradient(top, ".$new_options['color_nav_top'].", ".$new_options['color_nav_bottom'].");
			background: -o-linear-gradient(top, ".$new_options['color_nav_top'].", ".$new_options['color_nav_bottom'].");
		}
		.main-navigation li a {
			color: ".$new_options['color_nav_link'].";
		}
		.main-navigation li a:hover {
			color: ".$new_options['color_nav_link_hover'].";
		}
		.site-content article, article.comment, li.pingback p, div#respond, .comments-title, .widget-area aside, footer[role='contentinfo'],.archive-header, .page-header, .author-info {
			background: ".$new_options['color_article_bg'].";
		}
		a, .entry-header .entry-title a, .post_comments a, .post_tags a, .post_author a, .post_cats a, .post_date a, .edit-link a, .widget-area .widget a, .entry-meta a, footer[role='contentinfo'] a, .comments-area article header a time {
			color: ".$new_options['color_nav_link'].";
		}
		a:hover, .entry-header .entry-title a:hover, .post_comments a:hover, .post_tags a:hover, .post_author a:hover, .post_cats a:hover, .post_date a:hover, .edit-link a:hover, .widget-area .widget a:hover, .entry-meta a:hover, footer[role='contentinfo'] a:hover, .comments-area article header a time:hover {
			color: ".$new_options['color_nav_link_hover'].";
		}
		hr.style-one {
			background-image: -webkit-linear-gradient(left, ".$new_options['color_article_bg'].", #ccc, ".$new_options['color_article_bg']."); 
			background-image:    -moz-linear-gradient(left, ".$new_options['color_article_bg'].", #ccc, ".$new_options['color_article_bg']."); 
			background-image:     -ms-linear-gradient(left, ".$new_options['color_article_bg'].", #ccc, ".$new_options['color_article_bg']."); 
			background-image:      -o-linear-gradient(left, ".$new_options['color_article_bg'].", #ccc, ".$new_options['color_article_bg']."); 
		}
		body, .entry-content, .archive-title, .page-title, .widget-title, .entry-content th, .comment-content th, footer.entry-meta, footer, .main-navigation .current-menu-item > a, .main-navigation .current-menu-ancestor > a, .main-navigation .current_page_item > a, .main-navigation .current_page_ancestor > a {
			color: ".$new_options['color_text'].";
		}
		input[type='submit'], .menu-toggle, .menu-toggle.toggled-on, input[type='submit'].toggled-on {
			background: -webkit-gradient(linear, left top, left bottom, from(".$new_options['color_nav_link']."), to(".$new_options['color_nav_bottom']."));
			background: -moz-linear-gradient(top, ".$new_options['color_nav_link'].", ".$new_options['color_nav_bottom'].");
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='".$new_options['color_nav_link']."', endColorstr='".$new_options['color_nav_bottom']."')
			}
		input[type='submit']:hover, .menu-toggle:hover, article.post-password-required input[type='submit']:hover {
			background: -webkit-gradient(linear, left top, left bottom, from(".$new_options['color_nav_link_hover']."), to(".$new_options['color_nav_bottom']."));
			background: -moz-linear-gradient(top, ".$new_options['color_nav_link_hover'].", ".$new_options['color_nav_bottom'].");
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='".$new_options['color_nav_link_hover']."', endColorstr='".$new_options['color_nav_bottom']."')
			}
	</style>";
}
add_action('wp_head', 'cmw_wp_head');


#--------------------------------------------------------------
# TwentyTwelve Entry Meta
# Since: 0.1.0
# A function to style the Entry Meta
# Overrides the Default TwentyTwelve Style
#--------------------------------------------------------------
function twentytwelve_entry_meta() {
	echo "<hr class=style-one>";
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	$utility_text = '';
	if ( $tag_list ) {
		$utility_text .= __('<div class=post_cats><span>Categories:</span> %1$s</div>', 'twentytwelve' );
		$utility_text .= __('<div class=post_tags><span>Tags:</span> %2$s</div>', 'twentytwelve' );
	} elseif ( $categories_list ) {
		$utility_text .= __('<div class=post_cats><span>Categories:</span> %1$s</div>', 'twentytwelve' );
	}

	$utility_text .= __('<div class=post_date><span>Date:</span> %3$s</div>', 'twentytwelve' );
	$utility_text .= __('<div class=post_author><div><span>Author:</span> %4$s</div></div>', 'twentytwelve' );

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}

?>
