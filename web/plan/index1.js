$(document).ready(function(){
	whichDay();
	close_current();
})
// 选项卡做切换
function whichDay(){
	$('.which_day span').click(function(){
		$(this).addClass('which_day_active');
		$(this).siblings().removeClass('which_day_active');

		$('.time_frame').hide();
		$('.' + $(this).attr('name')).show()
	});
}
// 删除目前状态
function close_current(){
	$('.current_status button').click(function(){
		$('.current_status').hide();
	});
}