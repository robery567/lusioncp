<?php

use LusionCore\Database\LusionPdo;
use LusionCore\Network\LusionSsh;

require __DIR__ . '/../../../../lcpdefs.php';

session_save_path($config['session_savepath']);
session_name('lcpbsd');
session_start();

if($config['debug']) {
	error_reporting(E_ALL);
	if (function_exists('ini_set')) {
		ini_set('display_errors', 'On');
	}
} else {
	error_reporting(0);
}

date_default_timezone_set($config['default_timezone']);

require LCP_LIBS.'/autoload.php';
require LCP_XAPP.'/boot/functions.php';

require_once LCP_CONF.'/lcp/database.php';
require_once LCP_CONF.'/lcp/license.php';

require LCP_CORE.'/class/Network/LusionSsh.php';
require LCP_CORE.'/class/Database/LusionPdo.php';

set_error_handler('error_handler');

try {
	$db = new LusionPdo($database['appdb']);
} catch (Exception $e) {
	redirect(base_url().'/server_error.php');
}

if(isset($_SESSION['email'])) {
	$data = $db->query("
		SELECT
			user_id AS id,
			username AS user,
			server_ip AS ip,
			server_port AS port ,
			server_username AS username,
			server_password AS password,
			clearance
		FROM
			lcpc_clients
		WHERE
			email = :email
	");
	$data->bind(':email', $_SESSION['email'])->execute();
	$userInfo = $data->resultSingle('PDO_OBJECT');

	try {
		$remote = @new Remote($data['ip'], $data['username'], $data['password']);
		$remotedb = @new RemoteDatabase('account');
		$offline = false;
	} catch (\Exception $e) {
		$offline = true;
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
