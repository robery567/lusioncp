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