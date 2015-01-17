<?php

require __DIR__ . '/../private/app/boot/functions.php';

try {
	$db2 = new mysqli('localhost', 'lcp_adevel', 'RxxlRN1yCy', 'lcp_admin');

	if ($db2->connect_error) {
		throw new Exception("PROBLEMA_CONEXIUNE");
	} else {
		if($db2->query("SELECT COUNT(DISTINCT `table_name`) FROM `information_schema`.`columns` WHERE `table_schema` = 'lcp_admin'")->num_rows == 0) {
			throw new Exception("DATABASE_CORUPT");
		}
	}
} catch (Exception $e) {
	switch($e->getMessage()) {
		case "PROBLEMA_CONEXIUNE":
			#@redirect("/mentenanta2.php");
			echo 'PROBLEMA_CONEXIUNE';
		break;

		case "DATABASE_CORUPT":
			#@redirect("/mentenanta.php");
			echo 'DATABASE_CORUPT';
		break;

		default:
			#@redirect("/mentenanta.php");
			echo 'NIMIC';
		break;
	}
}

function generate_key($client_ip, $client_name) {
	global $db;

	$check_integrity = $db->query("SELECT ");
	$salt = [
		'lordylorde', 
		'kylejew',
		'cartmanfatass',
		'standground',
		'dontforgettobringatowel',
		'towliecracker',
		'unclegrandpa',
		'finnlovespb'
	];

	$word = array_rand($salt, 1);
	$date = date('d.m.Y H:i:s');

	return hash('sha512', str_rot13(hash('md5', strtotime($date) . $word . $date)));
}