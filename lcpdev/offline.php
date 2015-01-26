<?php

require __DIR__ . '/../../private/app/boot/start.php';

if(isset($_SESSION['email'])) {
	redirect("dashboard.php");
}

?>
<!DOCTYPE html>
<html lang="ro">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Conectare -- LusionCP</title>

<link href="https://lusioncp.me/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="https://lusioncp.me/assets/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
<link href="https://lusioncp.me/assets/css/sb-admin-2.css" rel="stylesheet">

<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Offline</h3>
				</div>
				<div class="panel-body">
				  <h2>Server offline</h2>
				  <p>
				    Momentan serverul este offline. [TODO: add more data]
				  </p>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	range.addEventListener('input', function(){
		document.querySelector('.pace').classList.remove('pace-inactive');
		document.querySelector('.pace').classList.add('pace-active');

		document.querySelector('.pace-progress').setAttribute('data-progress-text', range.value + '%');
		document.querySelector('.pace-progress').setAttribute('style', '-webkit-transform: translate3d(' + range.value + '%, 0px, 0px)');
		document.querySelector('.pace-progress').setAttribute('style', '-moz-transform: translate3d(' + range.value + '%, 0px, 0px)');
	});
</script>
<script src="https://lusioncp.me/assets/js/jquery.js"></script>
<script src="https://lusioncp.me/assets/js/bootstrap.min.js"></script>
<script src="https://lusioncp.me/assets/js/plugins/metisMenu/metisMenu.min.js"></script>
<script src="https://lusioncp.me/assets/js/sb-admin-2.js"></script>

</body>

</html>
