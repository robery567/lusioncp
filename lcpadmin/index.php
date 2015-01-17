<?php
	require __DIR__ . '/../../private/admin/boot/start.php';

	if(isset($_SESSION['email'])) {
		redirect("dashboard.php");
	}

	$action = isset($_POST['login']) ? $_POST['login'] : null;

	if(isset($_POST['login']) && $_POST['login'] == 'Login') {
		$email = isset($_POST['email']) ? sanitize($_POST['email']) : null;
		$password = isset($_POST['password']) ? sanitize($_POST['password']) : null;

		if($db->query("SELECT user_id FROM lcpc_clients WHERE email = '{$email}' AND password = PASSWORD('{$password}')")->num_rows == 1) {
			$statement = $db->prepare("SELECT username, email, server_ip FROM lcpc_clients WHERE email = ? AND password = PASSWORD(?)");
			$statement->bind_param('ss', $email, $password);
			$statement->execute();
			$statement->bind_result($r_username, $r_email, $r_ip);

			$statement->fetch();
			$_SESSION['username'] 	= $r_username;
			$_SESSION['email'] 		= $r_email;
			$_SESSION['server_ip'] 	= $r_ip;

			redirect("dashboard.php");
		} else {
			echo "<script>alert('Datele introduse nu sunt valide!')</script>";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Please login -- LusionCP</title>

    <link href="https://www.lusioncp.me/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://www.lusioncp.me/assets/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="https://www.lusioncp.me/assets/css/sb-admin-2.css" rel="stylesheet">
   
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php require __LCP_APP__ . '/app/template/partials/loadbar.php' ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
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
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="login" value="Login" class="btn btn-lg btn-success btn-block">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="https://www.lusioncp.me/assets/js/plugins/metisMenu/metisMenu.min.js"></script>
    <script src="https://www.lusioncp.me/assets/js/sb-admin-2.js"></script>

</body>

</html>
