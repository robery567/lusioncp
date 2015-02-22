<?php

require __DIR__ . '/../../private/lusioncp/start.php';
if (!isset($_SESSION['email']) && empty($_SESSION['email'])) {
	header('Location: index.php');
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
			<?php
				$action = isset($_GET['action']) ? sanitize($_GET['action']) : null;
				switch($action):
					case 'add':
						require __LCP_APP__ . '/app/template/content/clients.add.php';
						break;
					case 'edit':
						require __LCP_APP__ . '/app/template/content/clients.edit.php';
						break;
					case 'delete':
						require __LCP_APP__ . '/app/template/content/clients.delete.php';
						break;
					case 'connect':
						require __LCP_APP__ . '/app/template/content/clients.connect.php';
						break;
					default:
						require __LCP_APP__ . '/app/template/content/clients.php';
				endswitch;
			?>
		</div>
	</div>

	<?php require __LCP_APP__ . '/app/template/partials/scripts.php' ?>
</body>

</html>
