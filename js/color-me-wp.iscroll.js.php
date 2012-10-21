<?php
//Header("content-type: application/x-javascript");
header("Content-type: text/javascript");
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
$color_me_wp_options = new Color_Me_WP_Options();
$options = get_option( $color_me_wp_options->option_key );
$i_s_img = get_stylesheet_directory_uri().'/images/ajax-loader.gif';
$i_s_msgText = $options['iscroll_text'];
$i_s_finishedMsg = $options['iscroll_finish'];
$i_s_functions = $options['iscroll_functions'];
$js = <<<JS
function infinite_scroll_callback(newElements,data){ $i_s_functions }
jQuery(document).ready(function($){
	$("#content").infinitescroll({
		debug:false,
		loading:{
			img:"$i_s_img",
			msgText:"$i_s_msgText",
			finishedMsg:"$i_s_finishedMsg"
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
JS;
header("Content-type: text/javascript");
echo $js;
exit(); ?>
