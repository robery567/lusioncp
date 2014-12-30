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

// function taken from freebsd-memory -- List Total System Memory Usage
function mem_rounded($mem_size) {
	$chip_size = 1;
	$chip_guess = ($mem_size/8)-1;
	while($chip_guess != 0) {
		$chip_guess += 1;
		$chip_size -= 1;
	}
	$mem_round = ((int) ($mem_size / $chip_size) +1) * $chip_size;
	return $mem_round;
}