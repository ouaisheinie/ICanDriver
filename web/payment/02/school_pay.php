<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" >
	<title>支付</title>
	<link rel="stylesheet" href="../vender/css/normalize.css">
	<link rel="stylesheet" href="pay-page.css">
</head>
<body>
<header>
	<img src="return.png" alt="返回">
	<p>支付页面</p>
</header>
<section>
	<ul>
		<li class="how-much-money">
			<span>总计:</span>
			<span class="place"><?php echo $_GET['sign_place'] ?>元</span>
		</li>
		<li>
			<form>
				<label >
					<span>支付宝</span>
					<input type="radio" name="radio1" class="pay"  value="zfb"><i></i>
				</label>
				<label >
					<span>微信</span>
					<input type="radio" name="radio1"  class="pay" value="wx"><i></i>
				</label>
			</form>
		</li>
		<!-- <li>
			<span>微信</span>
			<form>
				<label>
					<input type="checkbox"><i></i>
				</label>
			</form>
		</li> -->
	</ul>
</section>
<footer>
	<button class="btn_comfirm">立即支付</button>
</footer>
<input type="hidden" id="place" value="zfb">
<input type="hidden" id="token" value="<?php echo $_GET['token'] ?>">
<input type="hidden" id="type" value="<?php echo $_GET['sign_type'] ?>">
<input type="hidden" id="id" value="<?php echo $_GET['school_id'] ?>">
<script src="jquery.min.js"></script>
<script src="../vender/src/picturefill.js"></script>
<script src="index.js"></script>
<script src="../../layer.js"></script>
<script type="text/javascript">
	$(".pay").click(function(){
		$("#place").val($(this).val());
	});
	$(".btn_comfirm").click(function(){
		var sign_place=$(".place").text();
	var school_id  =$("#id").val();
	var sign_type =$("#type").val();
	var newplace = sign_place.substring(0,sign_place.length-1);
	var payment_type =$("#place").val();
	var token =$("#token").val();
	$.ajax({
		url:"http://localhost/work/api/sign.php",
		data:{token:token,sign_type:sign_type,sign_place:newplace,payment_type:payment_type,school_id:school_id},
		dataType:'json',
		type:'get',
		success:function(data){
			if(data.status==200){
				layer.msg("支付成功,请上传资料");
				setInterval(function(){
					window.location.href="http://localhost/work/web/info/baoming.php";
				},2000)

			}
		},
		error:function(){
			layer.msg("请求失败");
		}
	});
	});
	

</script>
</body>
</html>