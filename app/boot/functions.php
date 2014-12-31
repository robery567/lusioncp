<?php

function redirect($link) {
	header("Location: {$link}");
	exit;
}

function sanitize($var) {
	$var = htmlentities((string) $var, ENT_QUOTES);
	$var = htmlspecialchars((string) $var, ENT_QUOTES, 'UTF-8');

	return $var;
}

function server_ip($username, $DB) {
	$data = $DB->query("SELECT server_ip FROM lcpc_clients WHERE username='{$username}'")->fetch_row();
	return $data[0];
}

function is_installed($ip, $DB) {
    $data = $DB->query("SELECT is_installed AS response FROM lcpc_clients")->fetch_array(MYSQLI_ASSOC);
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
    $DB->query("UPDATE lcpc_clients SET is_installed=1 WHERE server_ip='{$ip}'");
}

function update_procent($ip, $procent) {
    $DB->query("UPDATE lcpc_clients SET install_procent='{$procent}' WHERE server_ip='{$ip}'");
}