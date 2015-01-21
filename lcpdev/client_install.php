<?php

	require __DIR__ . '/../../private/app/boot/start.php';

	if (is_ipinstalled($_SERVER['REMOTE_ADDR'])) {
		redirect('index.php');
	}

	$action  = isset($_GET['action'])  ? $_GET['action']  : null;
	$procent = isset($_GET['percent']) ? $_GET['percent'] : null;

	if (is_null($action)) {
		redirect('index.php');
	}

	switch ($action) {
		case 'install_percent':
			if (is_null($procent)) {
				redirect('index.php');
			} else {
				update_procent($_SERVER['REMOTE_ADDR'], $procent);
			}
		break;

		case 'update_status':
			update_status($_SERVER['REMOTE_ADDR'], 1);
		break;

	}
?>
