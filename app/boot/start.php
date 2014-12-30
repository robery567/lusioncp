<?php

session_save_path(__DIR__ . '/../safelocker/sessions/');
session_name('lcp_game');
session_start();

error_reporting(E_ALL);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/functions.php';

require __DIR__ . '/Remote.class.php';

require_once __DIR__ . '/../config/database.php';

	try {
		switch ($mysql['connection_type']) {
			case 'mysqli':
				$db = $DB = new MySQLi($mysql['hostname'], $mysql['username'], $mysql['password'], $mysql['database']);

				if ($DB->connect_error) {
					throw new Exception("PROBLEMA_CONEXIUNE");
				} else {
					if($DB->query("SELECT COUNT(DISTINCT `table_name`) FROM `information_schema`.`columns` WHERE `table_schema` = '{$mysql['database']}'")->num_rows == 0) {
						throw new Exception("DATABASE_CORUPT");
					}
				}
			break;
		}
	} catch (Exception $e) {
			switch($e->getMessage()) {
				case "PROBLEMA_CONEXIUNE":
					@redirect("/mentenanta2.php");
				break;
				
				case "DATABASE_CORUPT":
					@redirect("/mentenanta.php");
				break;
				
				default:
					@redirect("/mentenanta.php");
				break;
			}			
		}
		
$data = $DB->query("SELECT 	server_ip AS ip, 
							server_port AS port , 
							server_username AS username, 
							server_password AS password 
							FROM lcpc_clients 
							WHERE username='{$_SESSION['username']}'")->fetch_array(MYSQLI_ASSOC);

$remote = @new Remote($data['ip'], $data['username'], $data['password']);