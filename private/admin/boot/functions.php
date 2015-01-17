<?php

function redirect($link) {
	header("Location: {$link}");
	exit;
}

function sanitize($var) {
	if(is_array($var)) {
		return false;
	}
	$var = htmlentities((string) $var, ENT_QUOTES);
	$var = htmlspecialchars((string) $var, ENT_QUOTES, 'UTF-8');

	return $var;
}

function server_ip($username, $DB) {
	$data = $DB->query("SELECT server_ip FROM lcpc_clients WHERE username='{$username}'")->fetch_row();
	return $data[0];
}

// function taken from freebsd-memory -- List Total System Memory Usage
function mem_rounded($mem_size) {
	$chip_size = 1;
	$chip_guess = ($mem_size/8);
	while($chip_guess != 0) {
		$chip_guess++;
		$chip_size--;
	}
	$mem_round = ((int) ($mem_size / $chip_size) + 1) * $chip_size;
	return $mem_round;
}

function is_installed($username, $DB) {
    $data = $DB->query("SELECT is_installed AS response FROM lcpc_clients WHERE username='{$username}'")->fetch_array(MYSQLI_ASSOC);
    return $data['response'];
}

function is_ipinstalled($ip, $DB) {
    $data = $DB->query("SELECT is_installed AS response FROM lcpc_clients WHERE server_ip='{$ip}'")->fetch_array(MYSQLI_ASSOC);
    if (is_null($data['response'])) {
		return 1;
	} else {
		return $data['response'];
	}
}

function update_status($ip, $status) { // @PARAM : IP (SERVER_IP), STATUS(0/1)
	global $DB, $db;
	$DB->query("UPDATE lcpc_clients SET is_installed=1 WHERE server_ip='{$ip}'");
}

function update_procent($ip, $procent) {
	global $DB, $db;
	$DB->query("UPDATE lcpc_clients SET install_procent='{$procent}' WHERE server_ip='{$ip}'");
}

function ping($host,$port=22,$timeout=6) {
    $fsock = @fsockopen($host, $port, $errno, $errstr, $timeout);
    if (!$fsock) {
        return FALSE;
    } else {
        return TRUE;
    }
}

function insert_log($user_id, $action) {
	global $DB, $db;
	$date = date("m.d.y H:i:s");
	$DB->query("INSERT INTO lcpc_logs (user_id, action, date) VALUES ('{$user_id}', '{$action}', '{$date}')");
}

function show_logs($user_id) {
	global $DB, $db;
	$query = $DB->query("SELECT * FROM lcpc_logs WHERE user_id='{$user_id}' ORDER BY log_id DESC LIMIT 5");
	while($data = $query->fetch_array(MYSQLI_ASSOC)) {
		echo '<a href="#" class="list-group-item">
					<i class="fa fa-upload fa-fw"></i> ' . $data['action'] . '
					<span class="pull-right text-muted small"><em>' . $data['date'] . '</em></span>
				</a>';
	}
}