<!DOCTYPE html>
<html>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<meta charset="utf-8">
		<title>Lottery | 404 </title>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="icon" href="<?= base_url()?>assets/assets/images/favicon.png" type="image/x-icon">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/error_404/css/style.css" />
	</head>
	<body>
		<div id="container" class="container">
			<ul id="scene" class="scene">
				<li class="layer" data-depth="1.00"><img src="<?= base_url() ?>assets/error_404/images/404-01.png"></li>
				<li class="layer" data-depth="0.60"><img src="<?= base_url() ?>assets/error_404/images/shadows-01.png"></li>
				<li class="layer" data-depth="0.20"><img src="<?= base_url() ?>assets/error_404/images/monster-01.png"></li>
				<li class="layer" data-depth="0.40"><img src="<?= base_url() ?>assets/error_404/images/text-01.png"></li>
				<li class="layer" data-depth="0.10"><img src="<?= base_url() ?>assets/error_404/images/monster-eyes-01.png"></li>
			</ul>
			<a href="<?= base_url('admin') ?>" class="btn">Back to home</a>
		</div>
		<script src="<?= base_url() ?>assets/error_404/js/parallax.js"></script>
		<script>
			var scene = document.getElementById('scene');
			var parallax = new Parallax(scene);
		</script>
		<script src="<?= base_url()?>assets/assets/js/rocket-loader.min.js" data-cf-settings="-|49" defer=""></script>
	</body>
</html>