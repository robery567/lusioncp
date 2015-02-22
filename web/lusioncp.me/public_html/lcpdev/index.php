<?php

require __DIR__ . '/../../private/lusioncp/start.php';

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
					<h3 class="panel-title">Conectează-te</h3>
				</div>
				<div class="panel-body">
				<?php
					if(isset($_POST['auth'])) {
						$data = [
							'usermail' => isset($_POST['email']) ? sanitize($_POST['email']) : null,
							'userpass' => isset($_POST['password']) ? sanitize($_POST['password']) : null,
						];

						$query = "
							SELECT
								`password`
							FROM
								`lcpc_clients`
							WHERE
								`email` = '{$data['usermail']}';
						";

						$check = $db->query($query);

						if($check->num_rows == 1) {
							$row = $check->fetch_array(MYSQLI_ASSOC);
							if(password_verify($data['userpass'], $row['password'])) {
								$query = "
									SELECT
										`username`,
										`email`,
										`server_ip`,
										`clearance`
									FROM
										`lcpc_clients`
									WHERE
										`email` = ?
								";

								$statement = $db->prepare($query);
								$statement->bind_param('s', $data['usermail']);
								$statement->execute();
								$statement->bind_result($r_username, $r_email, $r_ip, $r_lvl);

								$statement->fetch();
								$_SESSION['username'] 	= $r_username;
								$_SESSION['email'] 		= $r_email;

								if($r_lvl == 1) {
									redirect('dashboard.php');
								} else if($r_lvl == 3) {
									redirect('mentor.php');
								}
							} else {
								trigger_error('Parola introdusă este invalidă!');
							}
						} else {
							trigger_error('Utilizatorul specificat nu există!');
						}
					}
				?>
				<form role="form" action="index.php" method="post">
					<fieldset>
					<div class="form-group">
						<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
					</div>
					<div class="form-group">
						<input class="form-control" placeholder="Password" name="password" type="password" value="">
					</div>
					<div class="checkbox">
						<label>
						<input name="remember" type="checkbox" value="Remember Me">Reține sesiunea
						</label>
					</div>
					<input type="submit" name="auth" value="Login" class="btn btn-lg btn-success btn-block">
					</fieldset>
				</form>
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
