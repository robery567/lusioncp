<?php

//use LusionCP\Network\Remote;

session_save_path(__DIR__ . '/../safelocker/sessions/');
session_name('lcpgame');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'On');

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
				throw new Exception("PROBLEMA_CONEXIUNE");
			} else {
				if($db->query("SELECT COUNT(DISTINCT `table_name`) FROM `information_schema`.`columns` WHERE `table_schema` = '{$mysql['database']}'")->num_rows == 0) {
					throw new Exception("DATABASE_CORUPT");
				}
			}
		break;
	}
} catch (Exception $e) {
	switch($e->getMessage()) {
		case "PROBLEMA_CONEXIUNE":
			@header("Location: /offline.php");
		break;

		case "DATABASE_CORUPT":
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
			server_password AS password 
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