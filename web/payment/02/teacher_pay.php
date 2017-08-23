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
			<span><?php echo $_GET['sign_place'] ?>元</span>
		</li>
		<li>
			<form>
				<label>
					<span>支付宝</span>
					<input type="radio" name="radio1"><i></i>
				</label>
				<label>
					<span>微信</span>
					<input type="radio" name="radio1"><i></i>
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
<script src="=../info/jquery.min.js"></script>
<script src="../vender/src/picturefill.js"></script>
<script src="index.js"></script>
</body>
</html>