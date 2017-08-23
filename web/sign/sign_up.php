<?php
	include_once('safe.php');
	$school_id = $_GET['school_id'];
	include_once('database.php');
	$sql = "select * from school WHERE school_id = " .$school_id;
	 $res = $mySQLi -> query($sql);
	 while($row = $res -> fetch_array()){
       	 $school[] = $row;
       	 $info = $school[0];	 
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>我的试驾</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="sign_up.css">
	<link rel="stylesheet" href="normalize.css">
</head>
<body>
<header>
	<ul class="clearfix">
		<li><button class="information_btn1"></button></li>
		<li><p>驾校信息</p></li>
	</ul>
</header>
<section class="site_look">
	<img src="<?php echo $info['school_img2'] ?>" alt="场地图片">
</section>
<section class="main_info_module">
	<section class="school_address">
		<img src="click_to_check.png" alt="点击查看">
		<h2><?php  echo $info[1] ?></h2>
		<p><?php  echo $info['school_address'] ?></p>
	</section>
	<section class="link_man">
		<img src="signed&refer.png" alt="报名咨询">
		<h2>报名联系人:<span><?php echo $info['school_man'] ?></span></h2>
		<p>联系电话:<?php echo $info['man_phone'] ?></p>
	</section>
	<section class="how_to_learn">
		<form class="how_to_fee">
			<label for="input_learn_1" class="learn" type="time" palce="<?php echo $info['school_place1'] ?>">
				计时学车<input id="input_learn_1" type="radio" name="option1" checked/><i></i>
			</label>
			<label for="input_learn_2" class="learn" type="one" palce="<?php echo $info['school_place2'] ?>">
				一费制<input id="input_learn_2" type="radio" name="option1"/><i></i>
			</label>
			<input type="hidden" name="type" id="type" value="time">
		</form>
		<section class="material">
			<h2>所需材料:</h2>
			<p>居住证明(外地户口)<span>x1</span>
			</p>
			<p>一寸白底照片6张<span>x1</span>
			</p>
			<p>照相馆拍照上传回执单<span>x1</span>
			</p>
			<p>本人身份证复印件<span>x1</span>
			</p>
			<p>体检合格报告<span>x1</span>
			</p>
			<div class="price">
				<p class="io"><!-- <del>￥1298</del> --><?php echo $info['school_place1'] ?></p>
			</div>
			
		</section>
		<form class="server_final">
			<label for="checked1">
				<input id ="checked1" type="checkbox" name="check1" checked/><i></i>随时退
			</label>
			<label for="checked2">
				<input id ="checked2" type="checkbox" name="check2" checked/><i></i>免预约
			</label>
			<label for="checked3">
				<input id ="checked3" type="checkbox" name="check3" checked/><i></i>接送服务
			</label>
		</form>
	</section>
	<section class="footer_submit">
		<form>
			<input type="button" class="submit" value="立即报名">
		</form>
	</section>
	<input type="hidden"  value="<?php  echo $info['school_id'] ?>" id="id">
</section>
<script src="../info/jquery.min.js"></script>
<script src="index.js"></script>
<script src="picturefill.js"></script>
<script src="../layer.js"></script>
<script >
	localStorage.opq = 'dsfdsfsdf';
	var we = localStorage.opq;


	$(".information_btn1").click(function(){
		window.location.href="../schoolList/schoolList.html";
	});
	$(".material_submit").click(function(){
		var school_id =$("#id").val();
		window.location.href="../info/baoming.php?school_id="+school_id;
	});
	$(".learn").click(function(){
		$(".price p").text($(this).attr('palce'));
		$("#type").val($(this).attr('type'));
	});
	$(".submit").click(function(){


	  	var token = localStorage.phone;
		var type = $("#type").val();
		var sign_place = $(".io").text();
		var school_id =$("#id").val();
		window.location.href="../payment/02/school_pay.php?token="+token+"&sign_type="+type+"&sign_place="+sign_place+"&school_id="+school_id;
				
					
									
	});
</script>
</body>
</html>