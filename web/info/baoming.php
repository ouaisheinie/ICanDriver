<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>报名</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="information.css">
	<link rel="stylesheet" href="normalize.css">
</head>
<body>
<header class="clearfix">
	<ul>
		<li><button class="information_btn1"></button></li>
		<li><p>报名材料提交</p></li>
	</ul>
</header>
<section class="mainbody">
	<form class="information_collect clearfix" enctype="multipart/form-data" action="../../../work/api/fileImg.php"  method="post">
		<input type="hidden" name="school_id" value="<?php echo $_GET['school_id'] ?>" >
		<input type="hidden" name="token" id="token">
		<span>居住证明:</span>
		<input class="message_input" type="file"  name="live_img" id="photo" >
		<br/>
		<span>白底照片:</span>
		<input class="message_input" type="file" name="user_img" id="photo1">
		<br/>
		<span>回执单:</span>
		<input class="message_input" type="file" name="receipt_img" id="photo2">
		<br/>
		<span>复印件:</span>
		<input class="message_input" type="file" name="ID_img" id="photo3">
		<br/>
		<span>体检单:</span>
		<input class="message_input" type="file" name="check_img" id="photo4">
		<br/>
		<span>居住地址:</span>
		<input class="message_input" type="text" name="address" id="address">
		<br/>
		<span>是否需要居住证明:</span>
		<select id="opt" class="message_input" name="temporary">
			<option value="yes">需要</option>
			<option value="no">不需要</option>
		</select>
		<input class="submit_final"  type="submit" value="提交" >
	</form>
</section>
<script src="jquery.min.js"></script>
<script src="picturefill.js"></script>
<script src="information.js"></script>
<script src="../layer.js"></script>
<script type="text/javascript">
	$(function(){
		 var token =localStorage.phone;
		$("#token").val(token);
	});
	$(".submit_final").click(function(){
		var photo = $("#photo").val();
		if(photo==""){
			layer.msg('请上传居住证明');
			return false;
		}
		var photo1 = $("#photo1").val();
		if(photo1==""){
			layer.msg("请上传白底照片");
			return false;
		}
		var photo2 = $("#photo2").val();
		if(photo2==""){
			layer.msg("请上传回执单");
			return false;
		}
		var photo3 = $("#photo3").val();
		if(photo3==""){
			layer.msg("请上传身份证复印件");
			return false;
		}
		var photo4 = $("#photo4").val();
		if(photo4==""){
			layer.msg("请上传体检单");
			return false;
		}
		var address = $("#address").val();
		if(address==""){
			layer.msg("请填写居住地址");
		}
	});
</script>
</body>
</html>