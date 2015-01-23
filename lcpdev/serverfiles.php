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
			<?php
				$action = isset($_GET['action']) ? sanitize($_GET['action']) : null;
				switch($action):

					case 'add':
						require __LCP_APP__ . '/app/template/content/serverfiles.add.php';
						break;

					case 'edit':
						require __LCP_APP__ . '/app/template/content/serverfiles.edit.php';
						break;

					case 'delete':
						require __LCP_APP__ . '/app/template/content/serverfiles.delete.php';
						break;

					case 'install':
						require __LCP_APP__ . '/app/template/content/serverfiles.install.php';
						break;

					default:
						require __LCP_APP__ . '/app/template/content/serverfiles.php';

				endswitch;
			?>
		</div>
	</div>
	<?php require __LCP_APP__ . '/app/template/partials/scripts.php' ?>
</body>

</html>
