<?php
header("Content-Type: text/css");
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$cmwpo = get_option('color_me_wp_theme_options');
?>

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
    color: <?php echo $cmwpo['color_nav_link_hover']; ?> ;
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