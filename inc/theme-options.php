<?php
/*
	Color Me WP - theme-options.php
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
# Defaults
# Since: 0.1.0
#--------------------------------------------------------------

global $fields_dark;
global $fields_light;
$fields_dark = array(
	'nav-top-color' => array('color' => '#3a3636','title' => 'Navigation Top Color'),
	'nav-bottom-color' => array('color' => '#030303','title' => 'Navigation Bottom Color'),
	'nav-link-color' => array('color' => '#21759B','title' => 'Navigation Link Color'),
	'nav-hlink-color' => array('color' => '#64b7dd','title' => 'Navigation Link Hover Color'),
	'art-bg-color' => array('color' => '#111','title' => 'Article Background Color'),
	'text-color' => array('color' => '#777','title' => 'Text Color')
	);
$fields_light = array(
	'nav-top-color' => array('color' => '#ddd','title' => 'Navigation Top Color'),
	'nav-bottom-color' => array('color' => '#8a8a8a','title' => 'Navigation Bottom Color'),
	'nav-link-color' => array('color' => '#21759B','title' => 'Navigation Link Color'),
	'nav-hlink-color' => array('color' => '#0b2d83','title' => 'Navigation Link Hover Color'),
	'art-bg-color' => array('color' => '#FFF','title' => 'Article Background Color'),
	'text-color' => array('color' => '#777','title' => 'Text Color')
	);


#--------------------------------------------------------------
# Admin Head
# Since: 0.1.0
# A function to add the styling to the admin head
#--------------------------------------------------------------
function cmw_admin_head() {
	global $fields_dark;
	global $fields_light;
	$options = get_option( 'cmw_theme_options' );

	if ($options['color-scheme'] == 'dark') {
		$fields = $fields_dark;
		foreach ($fields as $field => $value) {
			$options[$field] = $value['color'];
		}
		update_option('cmw_theme_options',$options);
	} elseif ($options['color-scheme'] == 'light') {
		$fields = $fields_light;
		foreach ($fields as $field => $value) {
			$options[$field] = $value['color'];
		}
		update_option('cmw_theme_options',$options);
	}

	cmw_wp_head();

	echo "<script>
		jQuery(document).ready(function($) {
			$('.pickcolor').click( function(e) {
				colorPicker = jQuery(this).next('div');
				input = jQuery(this).prev('input');
				$(colorPicker).farbtastic(input);
				colorPicker.show();
				e.preventDefault();
				$(document).mousedown( function() {
					$(colorPicker).hide();
				});
			});

		});
	</script>";
}
# Load the css only on our page
if (isset($_GET['page']) && $_GET['page'] == 'theme-options') {
	add_action('admin_head', 'cmw_admin_head');
	wp_enqueue_style("cmw_css", get_stylesheet_directory_uri()."/css/theme-options.css", false, "1.0", "all");
}

#--------------------------------------------------------------
# Admin Scripts
# Since: 0.1.0
# A function to add the scripts to the admin head
#--------------------------------------------------------------
function cmw_admin_scripts() {
    wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
}


#--------------------------------------------------------------
# Theme Options Page
# Since: 0.1.0
# A function to add the Theme Options to the admin
#--------------------------------------------------------------
function cmw_options_do_page() {
	global $select_options;
	global $fields_dark;
	global $fields_light;
	if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false; ?>

	<?php screen_icon(); echo "<h2>". __( 'Custom Theme Options', 'cmw_theme' ) . "</h2><br>"; ?>

	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved', 'cmw_theme' ); ?></strong></p></div><br>
	<?php endif; ?> 

	<div id=wrap>
	<div id=left>

	<form method="post" action="options.php">
	<?php settings_fields( 'cmw_options' ); ?>  

	<?php $options = get_option( 'cmw_theme_options' ); 

	$fields = array(
		'nav-top-color' => array('color' => '#','title' => 'Navigation Top Color'),
		'nav-bottom-color' => array('color' => '#','title' => 'Navigation Bottom Color'),
		'nav-link-color' => array('color' => '#','title' => 'Navigation Link Color'),
		'nav-hlink-color' => array('color' => '#','title' => 'Navigation Link Hover Color'),
		'art-bg-color' => array('color' => '#','title' => 'Article Background Color'),
		'text-color' => array('color' => '#','title' => 'Text Color')
		);


	$disabled_color = 'style="color:gray;"';
	if (!empty($options)) {
		switch ($options['color-scheme']) {
			case 'dark':
				$options_disabled = 'disabled';
				$fields = $fields_dark;
				break;
			case 'light':
				$options_disabled = 'disabled';
				$fields = $fields_light;
				break;
			case 'custom':
				$options_disabled = '';
				$disabled_color = '';
				break;
		}
	} else {
		$options['color-scheme'] = 'dark';
		$options_disabled = 'disabled';
		$options['i_s_onoff'] = 'FALSE';
		$options['i_s_msgText'] = __( '<em>Loading the next set of posts...</em>', 'cmw_theme' );
		$options['i_s_finishedMsg'] = __( '<em>All posts loaded.</em>', 'cmw_theme' );
		$options['i_s_functions'] = '';
	}

	?> 
	<table class="widefat clear" cellspacing='5'>
	<thead><tr><th colspan=2><?php _e( 'Color Options', 'cmw_theme' ); ?></th></tr></thead>
	<tbody>
		<tr valign="top"><td><?php _e( 'Color Scheme', 'cmw_theme' ); ?></td>
		<td>
		<select name="cmw_theme_options[color-scheme]">
			<?php
				$color_scheme_dark = $color_scheme_light = $color_scheme_custom = '';
				if ($options['color-scheme'] == 'dark') $color_scheme_dark = 'selected';
				if ($options['color-scheme'] == 'light') $color_scheme_light = 'selected';
				if ($options['color-scheme'] == 'custom') $color_scheme_custom = 'selected';

			?>
			<option value='dark' <?php echo $color_scheme_dark; ?>><?php _e('Dark', 'cmw_theme'); ?></option>
			<option value='light' <?php echo $color_scheme_light; ?>><?php _e('Light', 'cmw_theme'); ?></option>
			<option value='custom' <?php echo $color_scheme_custom; ?>><?php _e('Custom', 'cmw_theme'); ?></option>
			</select>
		</td>
		</tr>


		<?php foreach($fields as $field => $value) {
			echo "<tr valign='top'><td $disabled_color>".__( $value['title'], 'cmw_theme' )."</td>";
			echo "<td $disabled_color>";
			echo "<input type='text' name='cmw_theme_options[$field]' value='";
			if ($options_disabled == 'disabled') {
				echo $value['color']."' $disabled_color $options_disabled />";
			}else{
				echo $options[$field]."' />";
			}
			echo "<input type='button' class='pickcolor button-secondary' value='Select Color' $options_disabled>";
			echo "<div id='colorpicker' style='z-index: 100; background: none repeat scroll 0% 0% rgb(238, 238, 238); border: 1px solid rgb(204, 204, 204); position: absolute;'></div>";
			if ($options_disabled == 'disabled')
				echo "<input type='hidden' name='cmw_theme_options[$field]' value='".$value['color']."' />";
			echo "</td></tr>";		
		} ?>

	</tbody>
	<tfoot><tr><th colspan='2'></th></tr></tfoot>
	</table><br>

		<!-- Infinite Scroll Settings -->
		<table class=widefat cellspacing=5>
			<thead><tr><th valign=top colspan=2><?php _e( 'Infinite Scroll Settings', 'cmw_theme' ); ?></th></tr></thead>

			<!-- On/Off -->
			<tr><td><strong><?php _e( 'On or Off', 'cmw_theme' ); ?></strong></td>
			<td>
			<select name="cmw_theme_options[i_s_onoff]">
			<?php
				$i_s_on = $i_s_off = '';
				if ($options['i_s_onoff'] == 'TRUE') $i_s_on = 'selected';
				if ($options['i_s_onoff'] == 'FALSE') $i_s_off = 'selected';

			?>
			<option value='TRUE' <?php echo $i_s_on; ?>><?php _e('On', 'cmw_theme'); ?></option>
			<option value='FALSE' <?php echo $i_s_off; ?>><?php _e('Off', 'cmw_theme'); ?></option>
			</select>
			</td></tr>

			<!-- Loading Message -->
			<tr>
			<td colspan=2><strong><?php _e( 'Loading Message', 'cmw_theme' ); ?></strong></td></tr>
			<td colspan=2><textarea name="cmw_theme_options[i_s_msgText]" cols='65' rows='1'><?php echo $options['i_s_msgText']; ?></textarea></td>
			</tr>

			<!-- Finished Message -->
			<tr>
			<td colspan=2><strong><?php _e( 'Finished Message', 'cmw_theme' ); ?></strong></td></tr>
			<td colspan=2><textarea name="cmw_theme_options[i_s_finishedMsg]" cols='65' rows='1'><?php echo $options['i_s_finishedMsg']; ?></textarea></td>
			</tr>

			<!-- Functions -->
			<tr>
			<td colspan=2><strong><?php _e( 'Functions to Load', 'cmw_theme' ); ?></strong> - <a href='http://www.infinite-scroll.com/lightbox-compatibility-code/' target='_blank'><?php _e( 'Known Functions', 'cmw_theme' ); ?></a></td></tr>
			<td colspan=2><textarea name="cmw_theme_options[i_s_functions]" cols='65' rows='3'><?php echo $options['i_s_functions']; ?></textarea></td>
			</tr>

			<tfoot><tr><th colspan=2></th></tr></tfoot>
		</table><br>
	<p>
	<input type="submit" value="<?php _e( 'Save Options', 'cmw_theme' ); ?>" />
	</p>
	</form>

	</div> <!-- End Left -->
	<div id=right>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="menu-main-container">
			<ul style=padding:0px;>
				<li><a title="Home" href="#">Home</a></li>
				<li><a href="#">Example Parent</a>
					<ul class="sub-menu">
						<li><a href="#">Example Sub 1</a></li>
						<li><a href="#">Example Sub 2</a></li>
					</ul>
				</li>
			</ul>
			</div>
		</nav>

		<div class=site-content>
			<article>
				<header class="entry-header">

				<div class="post_header"><span style="float:left;">
				<h1 class="entry-title"><a href=#" title="Permalink to My Title" rel="bookmark">My Title</a></h1>
				</span></div>
			
				<div class="post_comments"><span><a href="#" title="Comment on My Title">No Comments</a></span></div>

				</header><!-- .entry-header -->

				<div style="clear:both;"></div>

				<div class="entry-content"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam turpis sem, semper et faucibus non, luctus vitae ipsum. Fusce fermentum rutrum auctor. Aliquam erat volutpat. Quisque eros dolor, pretium eget aliquet sed, tempor eget velit. Maecenas neque lacus, condimentum consequat varius ut, mollis ac ipsum. Curabitur tempor, lacus vel eleifend vulputate, leo enim hendrerit ligula, ut cursus nunc lorem quis justo. Suspendisse cursus, metus id tempus congue, mi nibh euismod odio, ut ullamcorper erat sapien sed nibh.</p><br><input type='submit' class='cmw-submit'></div><!-- .entry-content -->
		
				<footer class="entry-meta">
				<hr class="style-one">
				<div class="post_cats"><span>Categories:</span> <a href="#" title="View all posts in My Category" rel="category tag">My Category</a></div>
				<div class="post_date"><span>Date:</span> <a href="#" title="2:48 am" rel="bookmark"><time class="entry-date" datetime="2012-04-14T02:48:50+00:00" pubdate="">April 14, 2012</time></a></div>
				<div class="post_author"><div><span>Author:</span> <span class="author vcard"><a class="url fn n" href="#" title="View all posts by Me" rel="author">Me</a></span></div></div>
				<span class="edit-link"><a class="post-edit-link" href="#" title="Edit Post">Edit</a></span>
				</footer><!-- .entry-meta -->

			</article>
		</div> <!-- End site-content -->
		<br>

		<!-- RSS -->
		<table class=widefat cellspacing=5 style="margin:0 15px;width:94%">
			<thead><tr><th valign=top ><?php _e( 'News', 'cmw_theme' ); ?></th></tr></thead>
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
		</table>
	</div> <!-- End Right -->
	</div> <!-- End Wrap -->
<?php } ?>
