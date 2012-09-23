<?php
/*
	Twenty Twelve Custom - functions.php
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


#--------------------------------------------------------------
# Dequeue Fonts
# Since: 0.1.0
# A function to remove the TwentyTwelve Font
#--------------------------------------------------------------
function ttc_dequeue_fonts() {
	wp_dequeue_style( 'twentytwelve-fonts' );
}
add_action( 'wp_enqueue_scripts', 'ttc_dequeue_fonts', 11 );


#--------------------------------------------------------------
# Theme Options Init
# Since: 0.1.0
# A function to Initialize the theme options page
#--------------------------------------------------------------
function theme_options_init(){
	register_setting( 'ttc_options', 'ttc_theme_options');
	require_once('inc/theme-options.php');
} 
add_action( 'admin_init', 'theme_options_init' );


#--------------------------------------------------------------
# Theme Options add page
# Since: 0.1.0
# A function to add the theme options page
#--------------------------------------------------------------
function theme_options_add_page() {
	$page = add_theme_page( __( 'Theme Options', 'ttc_theme' ), __( 'Theme Options', 'ttc_theme' ), 'edit_theme_options', 'theme-options', 'theme_options_do_page' );
	add_action( 'admin_print_styles-' . $page, 'ttc_admin_scripts' );
}
add_action( 'admin_menu', 'theme_options_add_page' ); 


#--------------------------------------------------------------
# Twenty Twelve Credits
# Since: 0.1.0
# A function to add the copyright to the footer
#--------------------------------------------------------------
function ttc_twentytwelve_credits() {
	$year = date("Y");
	$previousyear = $year -1;
	$bloginfo = get_bloginfo( 'name', 'display' );
	echo "<div class=copyright>Copyright &copy; <a href='".site_url()."'>$bloginfo</a> $previousyear - $year</div>";
}
add_action( 'twentytwelve_credits', 'ttc_twentytwelve_credits');


#--------------------------------------------------------------
# Infinite Scroll JS
# Since: 0.1.0
# A function to enqueue the infinite scroll js
#--------------------------------------------------------------
$options = get_option( 'ttc_theme_options' );
function custom_theme_js(){
	wp_register_script( 'infinite_scroll',  get_stylesheet_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'),null,true );
	if( ! is_singular() ) {
		wp_enqueue_script('infinite_scroll');
	}
}
if (!empty($options['i_s_onoff']) && $options['i_s_onoff'] == 'TRUE')
	add_action('wp_enqueue_scripts', 'custom_theme_js');


#--------------------------------------------------------------
# Custom Infinite Scroll JS
# Since: 0.1.0
# A function to add infinite scroll js to the footer
#--------------------------------------------------------------
function custom_infinite_scroll_js() {
	if( ! is_singular() ) { 
	$options = get_option( 'ttc_theme_options' );
	/*img:"http://test.landry.me/wp-content/plugins/infinite-scroll/ajax-loader.gif",
	msgText:"<em>Loading the next set of posts...</em>",
	finishedMsg:"<em>Congratulations, you've reached the end of the internet.</em>"*/
	$i_s_img = get_stylesheet_directory_uri().'/images/ajax-loader.gif';
	$i_s_msgText = $options['i_s_msgText'];
	$i_s_finishedMsg = $options['i_s_finishedMsg'];
	$i_s_functions = $options['i_s_functions'];
?>
		<script type="text/javascript">
			function infinite_scroll_callback(newElements,data){<?php echo $i_s_functions; ?>}
			jQuery(document).ready(function($){
				$("#content").infinitescroll({
					debug:false,
					loading:{
						img:"<?php echo $i_s_img; ?>",
						msgText:"<?php echo $i_s_msgText; ?>",
						finishedMsg:"<?php echo $i_s_finishedMsg; ?>"
					},
					state:{currPage:"1"},
					behavior:"undefined",
					nextSelector:"#nav-below .nav-previous a:first",
					navSelector:"#nav-below",
					contentSelector:"#content",
					itemSelector:"#content article.post"
				},
				function(newElements,data){
					window.setTimeout(
						function(){infinite_scroll_callback(newElements,data)}
					,1);
				});
			});
		</script>
		<style type="text/css">
			#infscr-loading { text-align: center; }
		</style><?php
	}
}
if (!empty($options['i_s_onoff']) && $options['i_s_onoff'] == 'TRUE')
	add_action( 'wp_footer', 'custom_infinite_scroll_js',100 );


#--------------------------------------------------------------
# Wp Head
# Since: 0.1.0
# A function to add the styles to the wp_head
#--------------------------------------------------------------
function ttc_wp_head() {
	$options = get_option( 'ttc_theme_options' );
	echo "<style type='text/css'>
		.main-navigation {
			background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(".$options['nav-bottom-color']."), to(".$options['nav-top-color']."));
			background: -webkit-linear-gradient(top, ".$options['nav-top-color'].", ".$options['nav-bottom-color'].");
			background: -moz-linear-gradient(top, ".$options['nav-top-color'].", ".$options['nav-bottom-color'].");
			background: -ms-linear-gradient(top, ".$options['nav-top-color'].", ".$options['nav-bottom-color'].");
			background: -o-linear-gradient(top, ".$options['nav-top-color'].", ".$options['nav-bottom-color'].");
		}
		.main-navigation li a {
			color: ".$options['nav-link-color'].";
		}
		.main-navigation li a:hover {
			color: ".$options['nav-hlink-color'].";
		}
		.site-content article, article.comment, div#respond, .comments-title, .widget-area aside, footer[role='contentinfo'],.archive-header, .page-header, #author-info {
			background: ".$options['art-bg-color'].";
		}
		a, .entry-header .entry-title a, .post_comments a, .post_tags a, .post_author a, .post_cats a, .post_date a, .edit-link a, .widget-area .widget a, .entry-meta a, footer[role='contentinfo'] a, .comments-area article header a time {
			color: ".$options['nav-link-color'].";
		}
		a:hover, .entry-header .entry-title a:hover, .post_comments a:hover, .post_tags a:hover, .post_author a:hover, .post_cats a:hover, .post_date a:hover, .edit-link a:hover, .widget-area .widget a:hover, .entry-meta a:hover, footer[role='contentinfo'] a:hover, .comments-area article header a time:hover {
			color: ".$options['nav-hlink-color'].";
		}
		hr.style-one {
			background-image: -webkit-linear-gradient(left, ".$options['art-bg-color'].", #ccc, ".$options['art-bg-color']."); 
			background-image:    -moz-linear-gradient(left, ".$options['art-bg-color'].", #ccc, ".$options['art-bg-color']."); 
			background-image:     -ms-linear-gradient(left, ".$options['art-bg-color'].", #ccc, ".$options['art-bg-color']."); 
			background-image:      -o-linear-gradient(left, ".$options['art-bg-color'].", #ccc, ".$options['art-bg-color']."); 
		}
		body, .entry-content, .archive-title, .page-title, .widget-title, .entry-content th, .comment-content th, footer.entry-meta, footer, .main-navigation .current-menu-item > a, .main-navigation .current-menu-ancestor > a, .main-navigation .current_page_item > a, .main-navigation .current_page_ancestor > a {
			color: ".$options['text-color'].";
		}
		input[type='submit'], .menu-toggle, .menu-toggle.toggled-on, input[type='submit'].toggled-on {
			background: -webkit-gradient(linear, left top, left bottom, from(".$options['nav-link-color']."), to(".$options['nav-bottom-color']."));
			background: -moz-linear-gradient(top, ".$options['nav-link-color'].", ".$options['nav-bottom-color'].");
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='".$options['nav-link-color']."', endColorstr='".$options['nav-bottom-color']."')
			}
		input[type='submit']:hover, .menu-toggle:hover, article.post-password-required input[type='submit']:hover {
			background: -webkit-gradient(linear, left top, left bottom, from(".$options['nav-hlink-color']."), to(".$options['nav-bottom-color']."));
			background: -moz-linear-gradient(top, ".$options['nav-hlink-color'].", ".$options['nav-bottom-color'].");
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='".$options['nav-hlink-color']."', endColorstr='".$options['nav-bottom-color']."')
			}
	</style>";
}
add_action('wp_head', 'ttc_wp_head');


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
