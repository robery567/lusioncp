<?php

require __DIR__ . '/../../private/app/boot/functions.php';
require __DIR__ . '/../../private/internal/lcp-install-template.php';

try {
	$db2 = new mysqli('localhost', 'lcp_adevel', 'RxxlRN1yCy', 'lcp_admin');

	if ($db2->connect_error) {
		throw new Exception('CONNECT_PROBLEM');
	} else {
		if($db2->query("SELECT COUNT(DISTINCT `table_name`) FROM `information_schema`.`columns` WHERE `table_schema` = 'lcp_admin'")->num_rows == 0) {
			throw new Exception('CORRUPT_DATABASE');
		}
	}
} catch (Exception $e) {
	switch($e->getMessage()) {
		case 'CONNECT_PROBLEM':
			echo '__PROBLEMA_CONEXIUNE__';
		break;

		case 'CORRUPT_DATABASE':
			echo '__DATABASE_CORUPT__';
		break;

		default:
			echo '__NECUNOSCUT__';
		break;
	}
}

function strrand($string) {
	$letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$rand_n = mt_rand(1, 26);
	$number = $rand_n % 26;

	if(!$number) {
		return $string;
	}

	if ($number == 13) {
		return str_rot13($string);
	}

	for ($i = 0; $i < strlen($string); $i++) {
		$char = $string[$i];
		if ($char >= 'a' && $char <= 'z') {
			$string[$i] = $letters[(ord($char) - 71 + $number) % 26];
		} else if ($char >= 'A' && $char <= 'Z') {
			$string[$i] = $letters[(ord($char) - 39 + $number) % 26 + 26];
		}
	}

	return $string;
}

$action = isset($_GET['action']) ? sanitize($_GET['action']) : 'invalid';
$get_ip = isset($_GET['ip']) ? sanitize($_GET['ip']) : 'invalid';
$get_key = isset($_GET['key']) ? sanitize($_GET['key']) : 'invalid';

switch($action) {
	case 'check':
		$get_ip = isset($_GET['ip']) ? sanitize($_GET['ip']) : 'invalid';
		$get_key = isset($_GET['key']) ? sanitize($_GET['key']) : 'invalid';
    $query = "
      SELECT
        `license_ip`,
        `license_key`,
        `license_startdate`,
        `license_expiry`,
        `available`
      FROM
        `lcpa_license`
      WHERE
        `license_ip` = '{$get_ip}'
        AND
          `license_key` = '{$get_key}'
    ";
		$check_key = $db2->query($query);
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
              $query = "
                UPDATE
                  `lcpa_license`
                SET
                  `available` = '0'
                WHERE
                  `license_ip` = '{$get_ip}'
                  AND
                    `license_key` = '{$get_key}'
              ";
							$db2->query($query);
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
    $query = "
      SELECT
        `license_ip`,
        `license_key`,
        `license_startdate`,
        `license_expiry`,
        `available`
      FROM
        `lcpa_clients`
      WHERE
        `license_ip` = '{$get_ip}'
      AND
        `license_key` = '{$get_key}'
    ";
    $check_key = $db2->query($query);
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
							echo 'valid period';
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
    	$query = "
      		SELECT
        		`credits`,
				`license_key`
      		FROM
        		`lcpa_clients`
      		WHERE
        		`license_key` = '{$get_key}'
    	";
		$check_key = $db2->query($query);
		$client = $check_key->fetch_object();


		if($check_key->num_rows == 1) {
			if($get_key == $client->license_key) {
				echo $client->credits;
			} else {
				echo 'invalid key';
			}
		} else {
			echo 'invalid client';
		}
		break;

	case 'add_license':
		$get_key = isset($_GET['key']) ? sanitize($_GET['key']) : 'invalid';
    $query = "
      SELECT
        `credits`,
        `user_id`
      FROM
        `lcpa_clients`
      WHERE
        `license_key` = '{$get_key}'
    ";
		$check_key = $db2->query($query);
		$client = $check_key->fetch_array(MYSQLI_ASSOC);

		if($check_key->num_rows) {
			$license_key 		= isset($_GET['license_key']) ? sanitize($_GET['license_key']) : null;
			$license_ip 		= isset($_GET['license_ip']) ? sanitize($_GET['license_ip']) : null;
			$is_reseller		=	isset($_GET['is_reseller']) ? sanitize($_GET['is_reseller']) : 0;
			if (!is_null($license_key) && !is_null($license_ip)) {
        $query = [
          "
          UPDATE
            `lcpa_clients`
          SET
            `credits` = `credits` - 2
          WHERE
            `license_key` = '{$get_key}'
          ",
          "
          INSERT INTO
            `lcpa_license` (
              `company_id`,
              `license_ip`,
              `license_key`,
              `license_startdate`,
              `license_expiry`,
							`is_reseller`
            )
          VALUES (
              '{$client['user_id']}',
              '{$license_ip}',
              '{$license_key}',
              CURDATE(),
              DATE_ADD(CURDATE(), INTERVAL 30 DAY),
							'{$is_reseller}'
            )
          "
        ];
				$db2->query($query[0]);
				$db2->query($query[1]);
			} else {
				echo 'invalid request';
			}
		} else {
      echo 'invalid account';
    }
	break;

	case 'keygen':
		$options = [
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];

		echo hash('sha512', strrand(hash('md5', $options['salt'])));
		break;

	case 'sync_license':
		$get_sync = isset($_GET['sync_key']) ? sanitize($_GET['sync_key']) : 'invalid';
		$query = "
			SELECT
				`license_ip`,
				`license_key`,
				`license_startdate`,
				`license_expiry`,
				`available`
			FROM
				`lcpa_clients`
			WHERE
				`license_ip` = '{$get_ip}'
				AND
					`license_key` = '{$get_key}'
		";
		$check_key = $db2->query($query);
		$client = $check_key->fetch_array(MYSQLI_ASSOC);

		if($check_key->num_rows == 1) {
			if($client['available'] == 0) {
				if($client['license_key'] == $get_key) {
					if($client['license_ip'] == $get_ip) {
						$query = "
							SELECT
								`lcpa_clients`.`user_id` AS `company`
							FROM
								`lcpa_clients`
							INNER JOIN
								`lcpa_license`
								ON
									`lcpa_clients`.`user_id` = `lcpa_license`.`company_id`
							WHERE
								`lcpa_license`.`license_ip` = '{$get_ip}'
								AND
									`lcpa_license`.`license_key` = '{$get_key}'

						";
						$check = $db2->query($query);
						if ($check->num_rows == 1) {
							$row = $check->fetch_object();
							$query = "
								INSERT INTO
									`lcpa_license` (
										`company_id`,
										`company_parent`,
										`license_key`,
										`available`
									) VALUES (
										'{$row->company}',
										'{$row->company}',
										'{$get_sync}',
										'1'
									)
							";
							$send = $db2->query($query);
							if ($send->insert_id) {
								echo 'sync ok';
							} else {
								echo 'sync fail';
							}
						} else {
							echo 'invalid company';
						}
					} else {
						echo 'invalid ip';
					}
				} else {
					echo 'invalid license key';
				}
			} else {
				echo 'invalid expired';
			}
		} else {
			echo 'invalid license';
		}
		break;

	case 'get_company_url':
		$query = "
			SELECT
				company_id
			FROM
				lcpa_license
			WHERE
				license_ip = '{$get_ip}'
		";
		$data = $db->query($query)->fetch_array(MYSQLI_ASSOC);
		$query = "
					SELECT
					 	company_url
					FROM lcpa_clients
					WHERE
						user_id='{$data['company_id']}'
						";
		$data = $db->query($query);
		if($data->num_rows == 1) {
			echo $data->company_url;
		} else {
			echo 'invalid license';
		}
		break;

	case 'deploy_bash':
		$company_url = '';
		echo $content;
		break;
	default:
		echo 'invalid action';
		break;
}
