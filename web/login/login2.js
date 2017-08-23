$(document).ready(function(){
	var validator1;
	validator1 = $("#form_one").validate({
		debug:true,
		rules:{
			username:{
				required:{
					depends:function(element){
						return $('#verify').is(':filled');
					}
				},
				minlength:8,
				maxlength:20
			},
			verify:{
				required: true,
				minlength:6,
				maxlength:20

			}
		},
		messages:{
			username: {
                    required: '请输入用户名',
                    minlength: '用户名不能小于6个字符',
                    maxlength: '用户名不能超过20个字符',
                    remote: '用户名不存在'
            },
            verify: {
                    required: '请输入验证码',
                    minlength: '验证码为6个字符',
                    maxlength: '验证码为6个字符'
            }
		},
		groups:{
			login:"username verify"
		},
		errorPlacement:function(error,element){
			if($('#login-error')){
				$('#login-error').remove();
			};
            error.insertBefore("#info");   //把错误信息集中显示到info元素里
        }
	});
});
window.onload = function(){
	var username = document.getElementById('username');
	var verify = document.getElementById('verify');
	var get = document.getElementById('getVerify');
	verify.onfocus = function(){
		get.value = '登录';
	};
	verify.onblur = function(){
		get.value = '获取验证码';
	};
}

