<?php
	require __DIR__ . '/../app/boot/start.php';
	if (!isset($_SESSION['email']) && empty($_SESSION['email'])) {
		redirect('index.php');
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require __DIR__ . '/../app/template/partials/header.php'; ?>
</head>

<body>

	<div id="wrapper">
		 <!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<?php require __DIR__ . '/../app/template/partials/navbar.php'; ?>
		</nav>

		<div id="page-wrapper">
			<?php require __DIR__ . '/../app/template/content/dashboard.php'; ?>
		</div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

	<script src="http://188.166.51.220/js/jquery.js"></script>
	<script src="http://188.166.51.220/js/bootstrap.min.js"></script>
	<script src="http://188.166.51.220/js/plugins/metisMenu/metisMenu.min.js"></script>
	<script src="http://188.166.51.220/js/plugins/morris/raphael.min.js"></script>
	<script src="http://188.166.51.220/js/plugins/morris/morris.min.js"></script>
	<script src="http://188.166.51.220/js/plugins/morris/morris-data.js"></script>
	<script src="http://188.166.51.220/js/sb-admin-2.js"></script>

</body>

</html>
