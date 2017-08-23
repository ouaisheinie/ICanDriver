$(document).ready(function(){
	var validator1;
	validator1 = $("#form_one").validate({
		debug:true,
		rules:{
			username:{
				required:true,
				rangelength:[11,11]
			},
			verify:{
				required:true,
				rangelength:[6,6]
			}
		},
		messages:{
			username: {
                    required: '请输入手机号',
                    rangelength:'请输入正确手机号'
            },
            verify: {
                    required: '请输入验证码',
                    rangelength:'请输入6位验证码'
            }
		},
		groups:{
			login:"username verify"
		},
		errorPlacement:function(error,element){
			if($('#login-error')){
				$('#login-error').remove();
			}
            error.insertBefore("#info");   //把错误信息集中显示到info元素里
        }
	});
});

