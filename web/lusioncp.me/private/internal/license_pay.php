<?php
$mysql = [
	'hostname' => 'localhost',
	'username' => 'lcp_adevel',
	'password' => 'RxxlRN1yCy',
	'database' => 'lcp_admin',
];

$DB = new MySQLi($mysql['hostname'], $mysql['username'], $mysql['password'], $mysql['database']);


$query = $DB->query("SELECT * FROM lcpa_clients ORDER BY user_id ASC");
while ($data = $query->fetch_array(MYSQLI_ASSOC)) {
		$query2 = $DB->query("SELECT * FROM lcpa_license WHERE company_id='{$data['user_id']}' AND is_reseller='0' AND available='1' ORDER BY license_id ASC");
		$count = 0;
		while ($data2 = $query2->fetch_array(MYSQLI_ASSOC)) {
			$timestamp = strtotime($data2['license_expiry']);
			if (date("y", $timestamp) < date("y") || ((date("d", $timestamp) < date("d")) && (date("m", $timestamp) <= date("m")))) {
				$count++;
				$license[$count] = $data2['license_id'];
			}
		}
		$final_price = $count * $data['license_price'];
		if ($final_price) { 
			$DB->query("UPDATE lcpa_clients SET credits=credits-$final_price WHERE user_id='{$data['user_id']}'");
			for ($i = 1 ; $i <= $count ; $i++) {
				$DB->query("UPDATE lcpa_license SET license_expiry=DATE_ADD(CURDATE(), INTERVAL 30 DAY) WHERE company_id = '{$data['user_id']}' AND license_id={$license[$i]}");
			}
			// TODO : NOTIFICARE CLIENT CREDIT NEGATIV
		}
}