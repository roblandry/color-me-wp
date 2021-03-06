<?php
/**
 * Color Me WP Theme Options
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Color Me WP 1.0
 */

class Color_Me_WP_Options {
	/**
	 * The option value in the database will be based on get_stylesheet()
	 * so child themes don't share the parent theme's option value.
	 *
	 * @access public
	 * @var string
	 */
	public $option_key = 'color_me_wp_theme_options';

	/**
	 * Holds our options.
	 *
	 * @access public
	 * @var array
	 */
	public $options = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 *
	 * @return Color_Me_WP_Options
	 */
	public function __construct() {

        add_action( 'admin_init',           array( $this, 'options_init'        ) );
		add_action( 'customize_register',	array( $this, 'customize_register'  ) );
        add_action( 'wp_head' ,             array( $this, 'header_output'       ) );
        add_action( 'wp_enqueue_scripts',   array( $this, 'cmw_theme_js'        ) );
        //add_action( 'wp_enqueue_styles',    array( $this, 'enqueue_style'       ) );wp_dequeue_style( 'twentytwelve-fonts' );
		add_action( 'customize_preview_init',	array( $this, 'customize_preview_js'	) );
		//add_action( 'customize_controls_print_styles', 	array( $this, 'color_me_wp_admin_styles') );


		$script = $_SERVER['SCRIPT_NAME'];

		if (strpos($script, 'customize.php') !== false || strpos($script, 'themes.php') !== false) {
			//add_action( 'admin_header', array( $this, 'cmw_feedback_link' ) );
			echo self::cmw_feedback_link();
		}
	}

	/**
	 * Registers the form setting for our options array.
	 *
	 * This function is attached to the admin_init action hook.
	 *
	 * This call to register_setting() registers a validation callback, validate(),
	 * which is used when the option is saved, to ensure that our option values are properly
	 * formatted, and safe.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function options_init() {
		// Load our options for use in any method.
		$this->options = $this->get_theme_options();

		// Register our option group.
		register_setting(
			'color_me_wp_options',    // Options group, see settings_fields() call in render_page()
			$this->option_key,         // Database option, see get_theme_options()
			array( $this, 'validate' ) // The sanitization callback, see validate()
		);

		// Register our settings field group.
		add_settings_section(
			'general',        // Unique identifier for the settings section
			'',               // Section title (we don't want one)
			'__return_false', // Section callback (we don't want anything)
			'theme_options'   // Menu slug, used to uniquely identify the page; see add_page()
		);

		global $options_arr;
		$options_arr = array(
			//'enable_fonts' => 'Enable Web Fonts',
			'enable_iscroll' => 'Enable Infinite Scroll',
			'iscroll_text' => 'Infinite Scroll Loading Text',
			'iscroll_finish' => 'Infinite Scroll Finished Loading Text',
			'iscroll_Functions' => 'Infinite Scroll Functions to Load when Finished',
			'color_nav_top' => 'Navigation Bar Top Color',
			'color_nav_bottom' => 'Navigation Bar Bottom Color',
			'color_nav_link' => 'Site Link Color',
			'color_nav_link_hover' => 'Site Link Hover Color',
			'color_article_bg' => 'Article Background Color',
			'color_text' => 'Site Text Color',
		);

		foreach ($options_arr as $option_value => $option_text) {

			// Register our individual settings fields.
			add_settings_field(
				$option_value,
				__( $option_text, 'color-me-wp' ),
				array( $this, 'settings_field_'.$option_value ),
				'theme_options',
				'general'
			);
		}

	}


	/**
	 * Enqueues the Admin Scripts.
	 *
	 * @access public
	 *
	 * @return void
	 */

    
    public function header_output() {
        $cmwpo = get_option( $this->option_key ); ?>
<!--Customizer CSS--> 
<style type="text/css">
.main-navigation {
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from( <?php echo $cmwpo['color_nav_bottom']; ?> ), to( <?php echo $cmwpo['color_nav_top']; ?> ) );
	background: -webkit-linear-gradient(top, <?php echo $cmwpo['color_nav_top']; ?> , <?php echo $cmwpo['color_nav_bottom']; ?> );
	background: -moz-linear-gradient(top, <?php echo $cmwpo['color_nav_top']; ?> , <?php echo $cmwpo['color_nav_bottom']; ?> );
	background: -ms-linear-gradient(top, <?php echo $cmwpo['color_nav_top']; ?> , <?php echo $cmwpo['color_nav_bottom']; ?> );
	background: -o-linear-gradient(top, <?php echo $cmwpo['color_nav_top']; ?> , <?php echo $cmwpo['color_nav_bottom']; ?> );
}

.main-navigation li a {	color: <?php echo $cmwpo['color_nav_link'] ?> ; }

.main-navigation li a:hover { color: <?php echo $cmwpo['color_nav_link_hover']; ?> ; }

.site-content article, article.comment, li.pingback p, li.trackback p, div#respond, 
.comments-title, .widget-area aside, footer[role='contentinfo'],.archive-header, 
.page-header, .author-info, article.format-quote .entry-content blockquote {
	background: <?php echo $cmwpo['color_article_bg']; ?> ;
}

.site-content article, article.comment, li.pingback p, li.trackback p, div#respond, 
.comments-title, .widget-area aside, footer[role='contentinfo'],.archive-header, 
.page-header, .author-info, article.format-quote .entry-content blockquote {
	background: <?php echo $cmwpo['color_article_bg']; ?> ;
}
		
h3.widget-title, .post.format-standard header, .post.format-gallery header, 
.post.format-chat header, .post.format-video header, .post.format-audio header, 
article.page header {
    background:<?php echo $cmwpo['color_nav_bottom']; ?> ;
}

a, .entry-header .entry-title a, .post_comments a, .post_tags a, .post_author a, 
.post_cats a, .post_date a, .edit-link a, .widget-area .widget a, .entry-meta a, 
footer[role='contentinfo'] a, .comments-area article header a time, #bit a.bsub, 
.format-status .entry-header header a, .widget a:visited {
	color: <?php echo $cmwpo['color_nav_link']; ?> !important;
}

a:hover, .entry-header .entry-title a:hover, .post_comments a:hover, 
.post_tags a:hover, .post_author a:hover, .post_cats a:hover, .post_date a:hover, 
.edit-link a:hover, .widget-area .widget a:hover, .entry-meta a:hover, 
footer[role='contentinfo'] a:hover, .comments-area article header a time:hover, 
#bit a.bsub:hover, .format-status .entry-header header a:hover {
    color: <?php echo $cmwpo['color_nav_link_hover']; ?> !important;
}

hr.style-one {
	background-image: -webkit-linear-gradient(left, <?php echo $cmwpo['color_article_bg'];?>, #ccc, <?php echo $cmwpo['color_article_bg'];?>); 
	background-image:    -moz-linear-gradient(left, <?php echo $cmwpo['color_article_bg'];?>, #ccc, <?php echo $cmwpo['color_article_bg'];?>); 
	background-image:     -ms-linear-gradient(left, <?php echo $cmwpo['color_article_bg'];?>, #ccc, <?php echo $cmwpo['color_article_bg'];?>); 
	background-image:      -o-linear-gradient(left, <?php echo $cmwpo['color_article_bg'];?>, #ccc, <?php echo $cmwpo['color_article_bg'];?>); 
}

body, .entry-content, .archive-title, .page-title, .widget-title, .entry-content th, 
.comment-content th, footer.entry-meta, footer, .main-navigation .current-menu-item > a, 
.main-navigation .current-menu-ancestor > a, .main-navigation .current_page_item > a, 
.main-navigation .current_page_ancestor > a , .genericon:before, .menu-toggle:after, 
.featured-post:before, .date a:before, .entry-meta .author a:before, .format-audio 
.entry-content:before, .comments-link a:before, .tags-links a:first-child:before, 
.categories-links a:first-child:before, .edit-link a:before, .attachment .entry-title:before, 
.attachment-meta:before, .attachment-meta a:before, .comment-awaiting-moderation:before, 
.comment-reply-link:before, #reply-title small a:before, .bypostauthor .fn:before, 
.error404 .page-title:before, a.more-link:after, 
article.format-link footer.entry-meta a[rel='bookmark']:before, 
article.format-image footer.entry-meta a h1:before, 
article.format-image footer.entry-meta time:before, 
article.sticky .featured-post, 
article.format-aside footer.entry-meta a[rel='bookmark']:before, 
article.format-quote footer.entry-meta a[rel='bookmark']:before .widget h3:before{
	color: <?php echo $cmwpo['color_text'];?> ;
}

input[type='submit'], .menu-toggle, .menu-toggle.toggled-on, input[type='submit'].toggled-on {
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $cmwpo['color_nav_link'];?>), to(<?php echo $cmwpo['color_nav_bottom'];?>));
	background: -moz-linear-gradient(top, <?php echo $cmwpo['color_nav_link'];?>, <?php echo $cmwpo['color_nav_bottom'];?>);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $cmwpo['color_nav_link'];?>', endColorstr='<?php echo $cmwpo['color_nav_bottom'];?>');
}

input[type='submit']:hover, .menu-toggle:hover, article.post-password-required input[type='submit']:hover {
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $cmwpo['color_nav_link_hover'];?>), to(<?php echo $cmwpo['color_nav_bottom'];?>));
	background: -moz-linear-gradient(top, <?php echo $cmwpo['color_nav_link_hover'];?>, <?php echo $cmwpo['color_nav_bottom'];?>);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $cmwpo['color_nav_link_hover'];?>', endColorstr='<?php echo $cmwpo['color_nav_bottom'];?>');
}

code, pre, ins, div.featured-post {
    background-color: <?php echo $cmwpo['color_nav_bottom'];?> ;
}
</style> 
<!--/Customizer CSS--><?php

		if (!empty($cmwpo['enable_iscroll']) && $cmwpo['enable_iscroll'] == true)
			$this->cmw_infinite_scroll_style();
    }


	/**
	 * Returns the default options.
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_default_theme_options() {
		$default_theme_options = array(
			'enable_fonts' => false,
			// Added
			'enable_iscroll' => false,
			'iscroll_text' => '<em>Loading the next set of posts...</em>',
			'iscroll_finish' => '<em>All posts loaded.</em>',
			'iscroll_functions' => '',
			'color_default' => 'Dark',
			'color_nav_top' => '#3a3636',
			'color_nav_bottom' => '#030303',
			'color_nav_link' => '#21759B',
			'color_nav_link_hover' => '#64b7dd',
			'color_article_bg' => '#111',
			'color_text' => '#777',
            'web_fonts' => array(),
			// \Added
		);
		return apply_filters( 'color_me_wp_default_theme_options', $default_theme_options );
	}

	/**
	 * Returns the options array.
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_theme_options() {
		return get_option( $this->option_key, $this->get_default_theme_options() );
	}


	/**
	 * Sanitizes and validates form input.
	 *
	 * @see options_init()
	 * @access public
	 * @param array $input
	 *
	 * @return array The validated data.
	 */
	public function validate( $input ) {
		$output = $defaults = $this->get_default_theme_options();

		// The enable fonts checkbox should a boolean value, true or false.
		$output['enable_fonts'] = ( isset( $input['enable_fonts'] ) && $input['enable_fonts'] );
		$output['enable_iscroll'] = ( isset( $input['enable_iscroll'] ) && $input['enable_iscroll'] );
		$output['iscroll_text'] = $input['iscroll_text'];
		$output['iscroll_finish'] = $input['iscroll_finish'];
		$output['iscroll_functions'] = $input['iscroll_functions'];
		$output['color_default'] = $input['color_default'];
		$output['color_nav_top'] = $input['color_nav_top'];
		$output['color_nav_bottom'] = $input['color_nav_bottom'];
		$output['color_nav_link'] = $input['color_nav_link'];
		$output['color_nav_link_hover'] = $input['color_nav_link_hover'];
		$output['color_article_bg'] = $input['color_article_bg'];
		$output['color_text'] = $input['color_text'];

		return apply_filters( 'color_me_wp_options_validate', $output, $input, $defaults );
	}

	/**
	 * Implements Color Me WP theme options into Theme Customizer.
	 *
	 * @since Color Me WP 1.0
	 * @access public
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @return void
	 */

	public function customize_register( $wp_customize ) {
		$defaults = $this->get_default_theme_options();

		// Enable Web Fonts
		$wp_customize->add_section( $this->option_key . '_enable_fonts', array(
			'title'    => __( 'Fonts', 'color-me-wp' ),
			'priority' => 35,
		) );

		$wp_customize->add_setting( $this->option_key . '[enable_fonts]', array(
			'default'    => $defaults['enable_fonts'],
			'type'       => 'option',
			'transport'  => 'postMessage',
		) );

		$wp_customize->add_control( $this->option_key . '_enable_fonts', array(
			'label'    => __( 'Enable the Open Sans typeface.', 'color-me-wp' ),
			'section'  => $this->option_key . '_enable_fonts',
			'settings' => $this->option_key . '[enable_fonts]',
			'type'     => 'checkbox',
		) );

		// Enable Infinite Scroll
		$wp_customize->add_section( $this->option_key . '_enable_iscroll', array(
			'title'    => __( 'Infinite Scroll', 'color-me-wp' ),
			'priority' => 35,
		) );

		$wp_customize->add_setting( $this->option_key . '[enable_iscroll]', array(
			'default'    => $defaults['enable_iscroll'],
			'type'       => 'option',
			'transport'  => 'refresh',
		) );

		$wp_customize->add_control( $this->option_key . '_enable_iscroll', array(
			'label'    => __( 'Enable Infinite Scroll.', 'color-me-wp' ),
			'section'  => $this->option_key . '_enable_iscroll',
			'settings' => $this->option_key . '[enable_iscroll]',
			'type'     => 'checkbox',
		) );

		// Infinite Scroll Loading Text
		$wp_customize->add_setting( $this->option_key . '[iscroll_text]', array(
			'default'    => $defaults['iscroll_text'],
			'type'       => 'option',
			'transport'  => 'refresh',
		) );

		$wp_customize->add_control( $this->option_key . '_iscroll_text', array(
			'label'    => __( 'Loading Message.', 'color-me-wp' ),
			'section'  => $this->option_key . '_enable_iscroll',
			'settings' => $this->option_key . '[iscroll_text]',
			'type'     => 'text',
		) );

		// Infinite Scroll Finished Loading Text
		$wp_customize->add_setting( $this->option_key . '[iscroll_finish]', array(
			'default'    => $defaults['iscroll_finish'],
			'type'       => 'option',
			'transport'  => 'refresh',
		) );

		$wp_customize->add_control( $this->option_key . '_iscroll_finish', array(
			'label'    => __( 'Finished Message.', 'color-me-wp' ),
			'section'  => $this->option_key . '_enable_iscroll',
			'settings' => $this->option_key . '[iscroll_finish]',
			'type'     => 'text',
		) );

		// Infinite Scroll Functions to load
		$wp_customize->add_setting( $this->option_key . '[iscroll_functions]', array(
			'default'    => $defaults['iscroll_functions'],
			'type'       => 'option',
			'transport'  => 'refresh',
		) );

		$wp_customize->add_control( $this->option_key . '_iscroll_functions', array(
			'label'    => __( 'Functions.', 'color-me-wp' ),
			'section'  => $this->option_key . '_enable_iscroll',
			'settings' => $this->option_key . '[iscroll_functions]',
			'type'     => 'text',
		) );

		// Colors - default
		/*$wp_customize->add_setting( $this->option_key . '[color_default]', array(
			'default'    => $defaults['color_default'],
			'type'       => 'option',
			'transport'  => 'refresh',
		) );

		$wp_customize->add_control( $this->option_key . '_color_default', array(
			'label'    => __( 'Color Theme', 'color-me-wp' ),
			'section'  => 'colors',
			'settings' => $this->option_key . '[color_default]',
			'priority' => 1,
			'type'    => 'select',
			'choices'    => array(
				'value1' => 'Dark',
				'value2' => 'Light',
				'value3' => 'Custom',
			),
		) );*/

		// Colors - Navigation Top
		$wp_customize->add_setting( $this->option_key . '[color_nav_top]', array(
			'default'    => $defaults['color_nav_top'],
			'type'       => 'option',
			//'transport'  => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $this->option_key . '_color_nav_top', array(
			'label'    => __( 'Navigation Top Color', 'color-me-wp' ),
			'section'  => 'colors',
			'settings' => $this->option_key . '[color_nav_top]',
			'priority' => 3,
		) ) );

		// Colors - Navigation Bottom
		$wp_customize->add_setting( $this->option_key . '[color_nav_bottom]', array(
			'default'    => $defaults['color_nav_bottom'],
			'type'       => 'option',
			//'transport'  => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $this->option_key . '_color_nav_bottom', array(
			'label'    => __( 'Navigation Bottom Color', 'color-me-wp' ),
			'section'  => 'colors',
			'settings' => $this->option_key . '[color_nav_bottom]',
			'priority' => 4,
		) ) );

		// Colors - Navigation Link
		$wp_customize->add_setting( $this->option_key . '[color_nav_link]', array(
			'default'    => $defaults['color_nav_link'],
			'type'       => 'option',
			//'transport'  => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $this->option_key . '_color_nav_link', array(
			'label'    => __( 'Navigation Link Color', 'color-me-wp' ),
			'section'  => 'colors',
			'settings' => $this->option_key . '[color_nav_link]',
			'priority' => 5,
		) ) );

		// Colors - Navigation Link Hover
		$wp_customize->add_setting( $this->option_key . '[color_nav_link_hover]', array(
			'default'    => $defaults['color_nav_link_hover'],
			'type'       => 'option',
			//'transport'  => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $this->option_key . '_color_nav_link_hover', array(
			'label'    => __( 'Navigation Link Hover Color', 'color-me-wp' ),
			'section'  => 'colors',
			'settings' => $this->option_key . '[color_nav_link_hover]',
			'priority' => 6,
		) ) );

		// Colors - Article Background
		$wp_customize->add_setting( $this->option_key . '[color_article_bg]', array(
			'default'    => $defaults['color_article_bg'],
			'type'       => 'option',
			//'transport'  => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $this->option_key . '_color_article_bg', array(
			'label'    => __( 'Article Background Color', 'color-me-wp' ),
			'section'  => 'colors',
			'settings' => $this->option_key . '[color_article_bg]',
			'priority' => 7,
		) ) );

		// Colors - Text
		$wp_customize->add_setting( $this->option_key . '[color_text]', array(
			'default'    => $defaults['color_text'],
			'type'       => 'option',
			//'transport'  => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $this->option_key . '_color_text', array(
			'label'    => __( 'Text Color', 'color-me-wp' ),
			'section'  => 'colors',
			'settings' => $this->option_key . '[color_text]',
			'priority' => 8,
		) ) );

		// Donate
		$wp_customize->add_section( $this->option_key . '_donate', array(
			'title'    => __( 'Donate', 'color-me-wp' ),
			'priority' => 200,
		) );

		$wp_customize->add_setting( $this->option_key . '[donate]', array(
			'default'    => '',
			'type'       => 'donate',
		) );

		$wp_customize->add_control( new CMW_Donate_Control(
			$wp_customize, $this->option_key . '_donate', array(
			'label'    => __( 'Donate', 'color-me-wp' ),
			'section'  => $this->option_key . '_donate',
			'settings' => $this->option_key . '[donate]',
			)));

		// RSS
		$wp_customize->add_section( $this->option_key . '_rss', array(
			'title'    => __( 'Theme News', 'color-me-wp' ),
			'priority' => 1,
		) );

		$wp_customize->add_setting( $this->option_key . '[rss]', array(
			'default'    => '',
			'type'       => 'rss',
		) );

		$wp_customize->add_control( new CMW_RSS_Control(
			$wp_customize, $this->option_key . '_rss', array(
			'label'    => __( 'News', 'color-me-wp' ),
			'section'  => $this->option_key . '_rss',
			'settings' => $this->option_key . '[rss]',
			)));

		if ( $wp_customize->is_preview() && ! is_admin() )
			add_action( 'wp_footer', array( $this, 'color_me_wp_customize_preview'), 21);
	}


	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since Color Me WP 1.0
	 * @access public
	 *
	 * @return void
	 */
	public function customize_preview_js() {
		//wp_enqueue_script( 'color-me-wp-customizer', get_stylesheet_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120802', true );
		wp_localize_script( 'color-me-wp-customizer', 'color-me-wp_customizer', array(
			'option_key' => $this->option_key . '[enable_fonts]',
			'link'       => $this->custom_fonts_url(),
		) );
	}


	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since Color Me WP 1.0
	 * @access public
	 *
	 * @return void
	 */
	public function color_me_wp_customize_preview() {
		?>
		<script type="text/javascript">
		( function( $ ){

		wp.customize( '<?php echo $this->option_key; ?>[color_nav_link]', function( value ) {
			value.bind( function( to ) {
				$('.main-navigation li a, a, .entry-header .entry-title a, .post_comments a, .post_tags a, .post_author a, .post_cats a, .post_date a, .edit-link a, .widget-area .widget a, .entry-meta a, footer[role="contentinfo"] a, .comments-area article header a time, #bit a.bsub').css('color', to ? to : '' );
			});
		});

		wp.customize( '<?php echo $this->option_key; ?>[color_nav_link_hover]', function( value ) {
			value.bind( function( to ) {
				$('.main-navigation li a:hover,a:hover, .entry-header .entry-title a:hover, .post_comments a:hover, .post_tags a:hover, .post_author a:hover, .post_cats a:hover, .post_date a:hover, .edit-link a:hover, .widget-area .widget a:hover, .entry-meta a:hover, footer[role='contentinfo'] a:hover, .comments-area article header a time:hover, #bit a.bsub:hover').css('color', to ? to : '' );
			});
		});

		wp.customize( '<?php echo $this->option_key; ?>[color_article_bg]', function( value ) {
			value.bind( function( to ) {
				$('.site-content article, article.comment, li.pingback p, li.trackback p, div#respond, .comments-title, .widget-area aside, footer[role='contentinfo'],.archive-header, .page-header, .author-info, article.format-quote .entry-content blockquote').css('background', to ? to : '' );
			});
		});

		wp.customize( '<?php echo $this->option_key; ?>[color_text]', function( value ) {
			value.bind( function( to ) {
				$('body, .entry-content, .archive-title, .page-title, .widget-title, .entry-content th, .comment-content th, footer.entry-meta, footer, .main-navigation .current-menu-item > a, .main-navigation .current-menu-ancestor > a, .main-navigation .current_page_item > a, .main-navigation .current_page_ancestor > a , .genericon:before, .menu-toggle:after, .featured-post:before, .date a:before, .entry-meta .author a:before, .format-audio .entry-content:before, .comments-link a:before, .tags-links a:first-child:before, .categories-links a:first-child:before, .edit-link a:before, .attachment .entry-title:before, .attachment-meta:before, .attachment-meta a:before, .comment-awaiting-moderation:before, .comment-reply-link:before, #reply-title small a:before, .bypostauthor .fn:before, .error404 .page-title:before, a.more-link:after ').css('color', to ? to : '' );
			});
		});

		wp.customize( '<?php echo $this->option_key; ?>[color_nav_bottom]', function( value ) {
			value.bind( function( to ) {
				$('code, pre, ins, div.featured-post').css('background', to ? to : '' );
			});
		});

		} )( jQuery )
		</script>
		<?php
	}


	/**
	 * Creates path to load fonts CSS file with correct protocol.
	 *
	 * @since Color Me WP 1.0
	 * @access public
	 *
	 * @return string Path to load fonts CSS.
	 */
	public function custom_fonts_url() {
		$protocol = is_ssl() ? 'https' : 'http';
		return $protocol . '://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700';
	}


	/**
	 * Enqueue the infinite scroll js.
	 *
	 * @since Color Me WP 1.0
	 * @access public
	 *
	 * @return void
	 */
	function cmw_theme_js(){
		if( ! is_singular() ) {
			wp_register_script( 'infinite_scroll',  get_stylesheet_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'),null,true );
			wp_enqueue_script('infinite_scroll');
		}
	}


	/**
	 * Create the Feedback Link.
	 *
	 * @since Color Me WP 1.0
	 * @access public
	 *
	 * @return void
	 */
	function cmw_feedback_link() { ?>
        <script type="text/javascript">
            var head  = document.getElementsByTagName("head")[0];
            var link  = document.createElement("link");
                link.rel  = "stylesheet";
                link.type = "text/css";
                link.href = "http://feedback.landry.me/public/themes/default/assets/css/widget.css";
                link.media = "all";head.appendChild(link);
			var mystyle = document.createElement("style");mystyle.type = "text/css";
			var mystyletxt = document.createTextNode(".l-ur-body{z-index:999999;}");mystyle.appendChild(mystyletxt);head.appendChild(mystyle);
        </script>
        <script type="text/javascript">widget = {url:'http://feedback.landry.me/'}</script>
        <script src="http://feedback.landry.me/public/assets/modules/system/js/widget.js" type="text/javascript"></script>
        <a class="widget-tab widget-tab-right w-round w-shadow" 
            style="margin-top:-52px;background-color:#4F2D92;border-color:#FFF830;z-index: 999999;" 
            title="Feedback" href="javascript:popup('widget', 'http://feedback.landry.me/widget', 600, 400);"  >
            <img width="15" alt="" src="http://feedback.landry.me/public/files/logo/widget-text-default.png" />
        </a> <?php
	}

	/**
	 * The infinite scroll js.
	 *
	 * @since Color Me WP 1.0
	 * @access public
	 *
	 * @return void
	 */
	function cmw_infinite_scroll_style() {

	        if( ! is_singular() ) { 
			$options = get_option( $this->option_key );
			$i_s_img = get_stylesheet_directory_uri().'/images/ajax-loader.gif';
			$i_s_msgText = $options['iscroll_text'];
			$i_s_finishedMsg = $options['iscroll_finish'];
			$i_s_functions = $options['iscroll_functions']; ?>
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
} # End Class


require_once(ABSPATH.'/wp-includes/class-wp-customize-control.php');

class CMW_Donate_Control extends WP_Customize_Control {
	public $type = 'donate';
	public function render_content() { ?>
		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DNWX23LBQJ5KE" target='_blank'><img src='<?php echo get_stylesheet_directory_uri().'/images/donate.gif'; ?>'></a>
		<?php
	}
}


class CMW_RSS_Control extends WP_Customize_Control {
	public $type = 'donate';
	public function render_content() { ?>
		<table class=widefat cellspacing=5 >
			<thead><tr><th valign=top ><?php _e( 'News', 'color-me-wp' ); ?></th></tr></thead>
			<?php 
			$rss = fetch_feed('http://redmine.landry.me/projects/color-me-wp/news.atom');
			$out = '';
			if (!is_wp_error( $rss ) ) {
				$maxitems = $rss->get_item_quantity(50);     
				$rss_items = $rss->get_items(0, $maxitems);  

				if ($maxitems == 0) {
					$out = "<tr><td>Nothing to see here.</td></tr>";     
				} else {     

					foreach ( $rss_items as $item ) {

						$title = $item->get_title();
						$content = $item->get_content();
						$description = $item->get_description();
						$author = $item->get_author();
						$author = $author->get_name();

						$out .= "<tr><td>";
						$out .= "<a target='_BLANK' href='". $item->get_permalink() ."'  title='Posted ". $item->get_date('j F Y | g:i a') ."'>";
				       		$out .= "$title</a> $description";
						$out .= "</td></tr>";
					} 
				}
			} else {$out = "<tr><td>Nothing to see here.</td></tr>";}
			echo $out; ?>
			<tfoot><tr><th></th></tr></tfoot>
		</table> <?php
	}
}