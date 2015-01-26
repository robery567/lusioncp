<?php

require __DIR__ . '/../config/variables.php';

session_save_path($config['session_savepath']);
session_name('lcpgame');
session_start();

if($config['debug']) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
} else {
	error_reporting(0);
}

date_default_timezone_set($config['default_timezone']);

define('__LCP_APP__', __DIR__ . '/../..');

require __LCP_APP__ . '/vendor/autoload.php';
require __DIR__ . '/functions.php';

require_once __DIR__ . '/../config/database.php';
require_once __DIR__.'/../config/license.php';

require __DIR__ . '/../class/Network/Remote.class.php';
require __DIR__ . '/../class/Network/RemoteDatabase.class.php';

set_error_handler('error_handler');

try {
	switch ($mysql['connection_type']) {
		case 'mysqli':
			$db = new MySQLi($mysql['hostname'], $mysql['username'], $mysql['password'], $mysql['database']);

			if ($db->connect_error) {
				throw new Exception('CONNECT_ERROR');
			} else {
				if($db->query("SELECT COUNT(DISTINCT `table_name`) FROM `information_schema`.`columns` WHERE `table_schema` = '{$mysql['database']}'")->num_rows == 0) {
					throw new Exception('CORRUPT_DATABASE');
				}
			}
		break;
	}
} catch (Exception $e) {
	switch($e->getMessage()) {
		case 'CONNECT_ERROR':
			@redirect("offline.php");
			break;

		case 'CORRUPT_DATABASE':
			@redirect("/offline.php");
			break;

		default:
			@redirect("/offline.php");
			break;
	}
}

if(isset($_SESSION['email'])) {
	$data = $db->query("
		SELECT
			user_id AS id,
			server_ip AS ip,
			server_port AS port ,
			server_username AS username,
			server_password AS password,
			clearance
		FROM
			lcpc_clients
		WHERE
			email='{$_SESSION['email']}'
	")->fetch_array(MYSQLI_ASSOC);

	if (ping($data['ip'])) {
		$remote = @new Remote($data['ip'], $data['username'], $data['password']);
		$remotedb = @new RemoteDatabase('account');
		$offline=0;
	} else {
		$offline=1;
	}
}

$apiservice = file_get_contents('https://www.lusioncp.me/lcpmain/apiservice.php?action=check&ip=' . $license['ip'] . '&key=' . $license['key']);

switch ($apiservice) {
	case 'valid':
		continue;
		break;

	case 'invalid period':
	case 'invalid ip':
	case 'invalid key':
		redirect('https://www.lusioncp.me/lcpmain/banned.php');
		exit();
		break;

	default:
		echo 'Something went terribly wrong.';
		exit();
}
