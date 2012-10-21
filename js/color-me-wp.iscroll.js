function infinite_scroll_callback(newElements,data){ ColorMeWPSettings.ifunctions }
jQuery(document).ready(function($){
	$("#content").infinitescroll({
		debug:false,
		loading:{
			img: ColorMeWPSettings.img,
			msgText: ColorMeWPSettings.msgText,
			finishedMsg: ColorMeWPSettings.finishedMsg
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
