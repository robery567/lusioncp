<?php
 
require __DIR__ . '/../../private/app/boot/functions.php';

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

$l_key = 'b204d431f67c4840d35b7975474788d3a4c9c9aaf82cb5c2acc9d57a536c5966e9ebff0dfc606ab896a64bb06961678a11d42a12efdf5578fa037c4c5532fb24';
$l_ip = $_SERVER['SERVER_ADDR'];

$action = isset($_GET['action']) ? sanitize($_GET['action']) : 'invalid';

switch($action) {
	case 'check':
		$get_ip = isset($_GET['ip']) ? sanitize($_GET['ip']) : 'invalid';
		$get_key = isset($_GET['key']) ? sanitize($_GET['key']) : 'invalid';
		$check_key = $db2->query("SELECT license_ip, license_key, license_startdate, license_expiry, available 
									FROM lcpa_license 
									WHERE license_ip = '{$get_ip}' 
									AND license_key = '{$get_key}'
								");
		$client = $check_key->fetch_array(MYSQLI_ASSOC);

		if($check_key->num_rows == 1) {
			if($client['available'] == 1) {
				if($client['license_key'] == $get_key) {
					if($client['license_ip'] == $get_ip) {
						$now = strtotime(date('Y-m-d H:i:s'));
						$start = strtotime($client['license_startdate']);
						$end = strtotime($client['license_expiry']);

						if($now >= $start && $now <= $end) {
							echo 'valid';
						} else {
							$db2->query("UPDATE lcpa_license SET available = '0' WHERE license_ip = '{$get_ip}' AND license_key = '{$get_key}'");
							echo 'invalid period';
							
						}
					} else {
						echo 'invalid ip';
						
					}
				} else {
					echo 'invalid key';
					
				}
			} else {
				echo 'invalid availability';
				
			}
		} else {
			echo 'invalid account';
			
		}
		break;

	case 'banned':
		$get_ip = isset($_GET['hostname']) ? sanitize($_GET['hostname']) : 'invalid';
		$get_key = isset($_GET['key']) ? sanitize($_GET['key']) : 'invalid';
		$check_key = $db2->query("SELECT license_ip, license_key, license_startdate, license_expiry, available 
									FROM lcpa_license 
									WHERE license_ip = '{$get_ip}' 
									AND license_key = '{$get_key}'
								");
		$client = $check_key->fetch_array(MYSQLI_ASSOC);

		if($check_key->num_rows == 1) {
			if($client['available'] == 0) {
				if($client['license_key'] == $get_key) {
					if($client['license_ip'] == $get_ip) {
						$now = strtotime(date('Y-m-d H:i:s'));
						$start = strtotime($client['license_startdate']);
						$end = strtotime($client['license_expiry']);

						if($now >= $start && $now <= $end) {
							echo 'banned';
						} else {
							echo 'invalid period';
							
						}
					} else {
						echo 'invalid ip';
						
					}
				} else {
					echo 'invalid key';
					
				}
			} else {
				echo 'already banned';
				
			}
		} else {
			echo 'invalid client';
			
		}
		break;
	case 'get_credit':
		$get_key = isset($_GET['key']) ? sanitize($_GET['key']) : 'invalid';
		$check_key = $db2->query("SELECT credits 
									FROM lcpa_clients 
									WHERE license = '{$get_key}' 
								");
		$client = $check_key->fetch_array(MYSQLI_ASSOC);

		if($check_key->num_rows)
			echo $client['credits'];
	break;
	
	case 'add_license':
		$get_key = isset($_GET['key']) ? sanitize($_GET['key']) : 'invalid';
		$check_key = $db2->query("SELECT credits,user_id
									FROM lcpa_clients 
									WHERE license = '{$get_key}' 
								");
		$client = $check_key->fetch_array(MYSQLI_ASSOC);

		if($check_key->num_rows) {
			$license_key 		= isset($_GET['license_key']) ? sanitize($_GET['license_key']) ? NULL;;
			$license_ip 		= isset($_GET['license_ip']) ? sanitize($_GET['license_ip']) ? NULL;
			if (!is_null($license) && !is_null($license_ip)) { 
				$db2->query("UPDATE lcpa_clients SET credits=credits-2 WHERE license = '{$get_key}'");
				$db2->query("INSERT INTO lcpa_license (company_id, license_ip, license_key, license_startdate, license_expiry) 
													VALUES (
															'{$client['user_id']}',
															'{$license_ip}',
															'{$license_key}', 
															CURDATE(), 
															DATE_ADD(CURDATE(), INTERVAL 30 DAY)
														)"
							);
			} else {
				echo 'invalid_request';
			}
		}
	break;
	
	default:
		echo 'invalid action';
		
		break;
}