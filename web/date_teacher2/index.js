$(document).ready(function(){
	$('.headline ul li').click(function(){
		$(this).css('background','#ffffff');
		$(this).siblings().css('background','#e6f1ea');
	});
    $('.headline ul li').click(function(){
    	$("input[type='checkbox']").removeAttr('checked')
		$('#subject').val($(this).attr('subject'))
		$('#place').val($('#'+$(this).attr('place')).val());
    });
})