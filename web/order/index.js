$(document).ready(function(){
	$('.oder_details ul li').click(function(){
		$(this).addClass("oder_details_active");
		$(this).siblings().removeClass("oder_details_active");
		// 隐藏所有 打开对应选项卡
		$('.orders').hide();
		$('.'+$(this).attr('name')).show();
		// a();
	});
	// a();
});

function a(){
	var height1 = $(window).height();
	var height2 = $('.main_info_oder').height();
	if(height2 >= (height1 - 127)){
		$('.order').show();
	}else{
		$('.order').hide();
	}
}