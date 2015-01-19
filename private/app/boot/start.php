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

require __DIR__ . '/../class/Network/Remote.class.php';

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
			@header("Location: /offline.php");
		break;

		case 'CORRUPT_DATABASE':
			@header("Location: /offline.php");
		break;

		default:
			@header("Location: /offline.php");
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
		$offline=0;
	} else {
		$offline=1;
	}
}
