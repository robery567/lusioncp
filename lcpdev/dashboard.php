<?php

require __DIR__ . '/../../private/app/boot/start.php';
if (!isset($_SESSION['email']) && empty($_SESSION['email'])) {
	redirect('index.php');
}

?>

<!DOCTYPE html>
<html lang="ro">

<head>
	<?php require __LCP_APP__ . '/app/template/partials/header.php'; ?>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<?php require __LCP_APP__ . '/app/template/partials/navbar.php'; ?>
		</nav>

		<div id="page-wrapper">
			<?php require __LCP_APP__ . '/app/template/content/dashboard.php'; ?>
		</div>

	</div>

	<?php require __LCP_APP__ . '/app/template/partials/scripts.php' ?>
</body>

</html>
