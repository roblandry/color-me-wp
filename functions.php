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

	// This adds theme support for all post formats.
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
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



echo "<script type=\"text/javascript\"> 
$(document).ready(function(){
  $(\"address\").each(function(){                         
    var embed =\"<iframe width='425' height='350' frameborder='0' scrolling='no'  marginheight='0' marginwidth='0'   src='https://maps.google.com/maps?&amp;q=\"+ encodeURIComponent( $(this).text() ) +\"&amp;output=embed'></iframe>\";
                                $(this).html(embed);
                             
   });
});
</script>";

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$plugin = 'subscribe2/subscribe2.php';
if (is_plugin_active($plugin)) {
global $wpdb;
$sub_to_opts = get_option("subscribe2_options");
$s2page = get_site_url().'?page_id='.$sub_to_opts['s2page'];
$get_var = $wpdb->get_var("SELECT COUNT(id) FROM wp_subscribe2 WHERE active='1'");

echo "    
<div id=\"bit\" class=\"\">
  <a class=\"bsub\" href=\"javascript:void(0)\"><span id='bsub-text'>Follow</span></a>
  <div id=\"bitsubscribe\">
    <h3><label for=\"loggedout-follow-field\">Follow &ldquo;".get_bloginfo('name')."&rdquo;</label></h3>
  
    <form action=". $s2page ." method=\"post\" accept-charset=\"utf-8\" id=\"loggedout-follow\">
      <p>Get every new post on this blog delivered to your Inbox.</p>
      <p class='bit-follow-count'>Join $get_var other followers:</p>
      <p>
        <input type=\"text\" name=\"email\" id=\"s2email\" style=\"width: 95%; padding: 1px 2px\" value=\"Enter email address\" onfocus='this.value=(this.value==\"Enter email address\") ? \"\" : this.value;' onblur='this.value=(this.value==\"\") ? \"Enter email address\" : this.value;'  id=\"loggedout-follow-field\"/>
      </p>
       
      <input type=\"hidden\" name=\"ip\" value=".$_SERVER['REMOTE_ADDR'].">
      
      <p id='bsub-subscribe-button'>
        <input type=\"submit\" name=\"subscribe\"  value=\"Sign me up!\" />
      </p>
    </form>
  </div>
</div>";
}

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
		.site-content article, article.comment, li.pingback p, li.trackback p, div#respond, .comments-title, .widget-area aside, footer[role='contentinfo'],.archive-header, .page-header, .author-info, article.format-quote .entry-content blockquote {
			background: ".$new_options['color_article_bg'].";
		}
		
h3.widget-title, .post header, article.page header {background:".$new_options['color_nav_bottom']."}


		a, .entry-header .entry-title a, .post_comments a, .post_tags a, .post_author a, .post_cats a, .post_date a, .edit-link a, .widget-area .widget a, .entry-meta a, footer[role='contentinfo'] a, .comments-area article header a time, #bit a.bsub, .format-status .entry-header header a {

			color: ".$new_options['color_nav_link'].";

		}

		a:hover, .entry-header .entry-title a:hover, .post_comments a:hover, .post_tags a:hover, .post_author a:hover, .post_cats a:hover, .post_date a:hover, .edit-link a:hover, .widget-area .widget a:hover, .entry-meta a:hover, footer[role='contentinfo'] a:hover, .comments-area article header a time:hover, #bit a.bsub:hover, .format-status .entry-header header a:hover {

			color: ".$new_options['color_nav_link_hover'].";
		}

		hr.style-one {
			background-image: -webkit-linear-gradient(left, ".$new_options['color_article_bg'].", #ccc, ".$new_options['color_article_bg']."); 

			background-image:    -moz-linear-gradient(left, ".$new_options['color_article_bg'].", #ccc, ".$new_options['color_article_bg']."); 

			background-image:     -ms-linear-gradient(left, ".$new_options['color_article_bg'].", #ccc, ".$new_options['color_article_bg']."); 

			background-image:      -o-linear-gradient(left, ".$new_options['color_article_bg'].", #ccc, ".$new_options['color_article_bg']."); 

		}

		body, .entry-content, .archive-title, .page-title, .widget-title, .entry-content th, .comment-content th, footer.entry-meta, footer, .main-navigation .current-menu-item > a, .main-navigation .current-menu-ancestor > a, .main-navigation .current_page_item > a, .main-navigation .current_page_ancestor > a , .genericon:before, .menu-toggle:after, .featured-post:before, .date a:before, .entry-meta .author a:before, .format-audio .entry-content:before, .comments-link a:before, .tags-links a:first-child:before, .categories-links a:first-child:before, .edit-link a:before, .attachment .entry-title:before, .attachment-meta:before, .attachment-meta a:before, .comment-awaiting-moderation:before, .comment-reply-link:before, #reply-title small a:before, .bypostauthor .fn:before, .error404 .page-title:before, a.more-link:after, article.format-link footer.entry-meta a[rel='bookmark']:before, article.format-image footer.entry-meta a h1:before, article.format-image footer.entry-meta time:before, article.sticky .featured-post, article.format-aside footer.entry-meta a[rel='bookmark']:before, article.format-quote footer.entry-meta a[rel='bookmark']:before .widget h3:before{

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

		code, pre, ins, div.featured-post {background-color: ".$new_options['color_nav_top']."}
	</style>";

}
add_action('wp_head', 'cmw_wp_head');


function color_me_wp_styles()  
{ 
  // Register the style like this for a theme:  
  // (First the unique name for the style (custom-style) then the src, 
  // then dependencies and ver no. and media type)
  wp_register_style( 'color-me-wp-style', 
    get_stylesheet_directory_uri() . '/css/theme-options.css.php', 
    array('twentytwelve-style'), 
    '20120208', 
    'all' );

  // enqueing:
  //wp_enqueue_style( 'color-me-wp-style' );

$plugin = 'subscribe2/subscribe2.php';
if (is_plugin_active($plugin)) {
  wp_register_style( 'color-me-wp-s2-style', 
    get_stylesheet_directory_uri() . '/css/subscribe2.css', 
    array(), 
    '20130225', 
    'all' );
  wp_enqueue_style( 'color-me-wp-s2-style' );

  wp_register_script( 'color-me-wp-s2-script', 
    get_stylesheet_directory_uri() . '/js/subscribe2.js', 
    array('jquery'), 
    '20130225',
    true );

  wp_enqueue_script( 'color-me-wp-s2-script' );
}
}
add_action('wp_enqueue_scripts', 'color_me_wp_styles');

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
		$utility_text .= __('<div><span class="categories-links">%1$s</span></div>', 'twentytwelve' );
		$utility_text .= __('<div><span class="tags-links">%2$s</span></div>', 'twentytwelve' );
	} elseif ( $categories_list ) {
		$utility_text .= __('<div><span class="categories-links">%1$s</span></div>', 'twentytwelve' );
	}

	$utility_text .= __('<div><span class="date">%3$s</span></div>', 'twentytwelve' );
	$utility_text .= __('<div>%4$s</div>', 'twentytwelve' );

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}

#--------------------------------------------------------------
# Chat Posts
# Since: 
# A function to add post formats to class
# 
#--------------------------------------------------------------
function tb_chat_post($content) {
	global $post;

	static $instance = 0;
	$instance++;

	if ( has_post_format('chat') ){//&& is_singular() ) {
		remove_filter ('the_content',  'wpautop');
		$chatoutput = '';
		$split = preg_split("/(\r?\n)+|(<br\s*\/?>\s*)+/", $content);
		$speakers = array();
		$row_class_ov = 'odd';
		foreach($split as $haystack) {
			if (strpos($haystack, ':')) {
				$string = explode(':', trim($haystack), 2);
				$who = strip_tags(trim($string[0]));
				if ( !in_array( $who, $speakers ) ) {
					$speakers[] = $who;
					$speaker_key = count( $speakers );
				} else {
					$speaker_key = array_search( $who, $speakers ) + 1;
				}
				$what = strip_tags(trim($string[1]));
				$row_class_ov = ( $row_class_ov == 'even' )? 'odd' : 'even';
				$row_class = $row_class_ov . ' speaker-' . $speaker_key;
				$chatoutput = $chatoutput . "<p class=\"$row_class triangle-obtuse left\"><span class=\"name\">$who:</span><span class=\"text\">$what</span></p>";
			} else {
				// the string didn't contain a needle. Displaying anyway in case theres anything additional you want to add within the transcript
				$chatoutput = $chatoutput . '<li class="aside-text">' . $haystack . '</li>';
			}
		}
		$speakers_select = '';
		foreach ($speakers as $key => $speaker) {
			$key = $key + 1;
			$speakers_select = $speakers_select . "<p class=\"speaker-$key\"><span class=\"name\">$speaker</span><span class=\"hide\">[-]</span><span class=\"show\">[+]</span><span class=\"toleft\">[&lt;]</span><span class=\"toright\">[&gt;]</span></p> ";
		}
		$speakers_select = '';//<ul class="chat-select">' . $speakers_select . '</ul>';
		$chat_before = '<div class="chat-transcript' . ' speakers-' . count( $speakers ) . '">';
		$chat_after = '</div>';
		// print our new formated chat post
		$content = '<div id="chat-' . $instance . '" class="tb-chat">' . $speakers_select . $chat_before . $chatoutput . $chat_after . '</div>';
		return $content;
	} else {
		add_filter ('the_content',  'wpautop');
		return $content;
	}
}
add_filter( "the_content", "tb_chat_post", 9);

// add scripts
function tb_chat_js(){
	global $tb_chat_animation, $tb_chat_load_script;
$theme_dir = dirname( get_bloginfo('stylesheet_url') );
	//if ( !$tb_chat_load_script ) return;

	wp_enqueue_script( 'tb-chat-script', $theme_dir.'/js/chat.js', array('jquery'), '', true );

	$data = array(
		'animation' => in_array( $tb_chat_animation, array('slide','fade','none') ) ? $tb_chat_animation : 'none'
	);
	wp_localize_script( 'tb-chat-script', 'tbChat_l10n', $data );

}
//add_action( 'wp_enqueue_scripts', 'tb_chat_js' ); // Add js scripts

// add style
function tb_chat_css(){
	global $tb_chat_load_style;
	$theme_dir = dirname( get_bloginfo('stylesheet_url') );
	//if ( !$tb_chat_load_style ) return;

	wp_enqueue_style( 'chat_css', $theme_dir.'/css/bubbles.css', false, '', 'screen' );

}
add_action( 'wp_enqueue_scripts', 'tb_chat_css' ); // Add css stylesheet

?>

