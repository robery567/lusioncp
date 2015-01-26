<?php

function redirect($link) {
	return header("Location: {$link}");
}

function sanitize($var) {
	if(is_array($var)) {
		return false;
	}
	$var = htmlentities((string) $var, ENT_QUOTES);
	$var = htmlspecialchars((string) $var, ENT_QUOTES, 'UTF-8');

	return $var;
}

function build_url() {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
	$hostname = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
	$pathname = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
	$getquery = (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : getenv('QUERY_STRING');

	$uri = $protocol . $hostname . $pathname . $getquery;
	return $uri;
}

function server_ip($username) {
	global $db;
	$data = $db->query("SELECT server_ip FROM lcpc_clients WHERE username='{$username}'")->fetch_row();
	return $data[0];
}

function is_installed($username) {
	global $db;
	$data = $db->query("SELECT is_installed AS response FROM lcpc_clients WHERE username='{$username}'")->fetch_array(MYSQLI_ASSOC);
	return $data['response'];
}

function is_ipinstalled($ip) {
	global $db;
	$data = $db->query("SELECT is_installed AS response FROM lcpc_clients WHERE server_ip='{$ip}'")->fetch_array(MYSQLI_ASSOC);
	if (is_null($data['response'])) {
		return 1;
	} else {
		return $data['response'];
	}
}

function update_status($ip, $status) {
	global $db;
	$db->query("UPDATE lcpc_clients SET is_installed=1 WHERE server_ip='{$ip}'");
}

function update_procent($ip, $procent) {
	global $db;
	$db->query("UPDATE lcpc_clients SET install_procent='{$procent}' WHERE server_ip='{$ip}'");
}

function ping($host, $port = 22, $timeout = 6) {
	$fsock = @fsockopen($host, $port, $errno, $errstr, $timeout);
	if(!$fsock) {
		return false;
	} else {
		return true;
	}
}

function insert_log($user_id, $action) {
	global $db;
	$date = date("m.d.y H:i:s");
	$query = "
	  INSERT INTO
	    `lcpc_logs`
	    (
	    	`user_id`,
	    	`action`,
	    	`date`
	    )
	  VALUES
	  (
	    '{$user_id}',
	    '{$action}',
	    NOW()
	  )
	";
	return $db->query($query);
}

function show_logs($user_id) {
	global $db;
	$query = $db->query("SELECT action, date FROM lcpc_logs WHERE user_id='{$user_id}' ORDER BY log_id DESC LIMIT 5");
	while($data = $query->fetch_array(MYSQLI_ASSOC)) {
		echo '<a href="#" class="list-group-item">
					' . $data['action'] . '
					<span class="pull-right text-muted small"><em>' . $data['date'] . '</em></span>
				</a>';
	}
}

function get_ip() {
	if(function_exists('apache_request_headers')) {
		$headers = apache_request_headers();
	} else {
		$headers = $_SERVER;
	}

	if(array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		$the_ip = $headers['X-Forwarded-For'];
	} else if(array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
	} else {
		$the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	}

	return $the_ip;
}

function crypt_password($password) {
	$options = [
		'cost' => 10,
		'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
	];

	return password_hash(sanitize($password), PASSWORD_BCRYPT, $options);
}

function error_handler($errno, $errstr) {
	$string = '
		<div class="alert alert-danger">
			<p>' . $errstr . '</p>
		</div>
	';

	return $string;
}

function warning($message) {
	$string = '
		<div class="alert alert-warning">
			<p>' . $message . '</p>
		</div>
	';

	echo $string;
}

function success($message, $redirect = "dashboard.php", $time = 3) {
	$string = '
		<div class="alert alert-success">
			<p>' . $message . '</p>
		</div>
		<meta http-equiv="refresh" content="' . $time . '; url=' . $redirect . '" />
	';

	echo $string;
}

function reseller_credit($license) {
	return file_get_contents("https://www.lusioncp.me/lcpmain/apiservice.php?action=get_credit&key={$license}");
}
