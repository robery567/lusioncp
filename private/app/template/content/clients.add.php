			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Clienți</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Adăugare client
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<?php
										if(isset($_POST['send'])) {
											$data = [
												'username' => isset($_POST['username']) ? sanitize($_POST['username']) : null,
												'password' => isset($_POST['password']) ? crypt_password($_POST['password']) : null,
												'usermail' => isset($_POST['email']) ? (filter_var($_POST['email']) ? sanitize($_POST['email'], FILTER_VALIDATE_EMAIL) : false) : null,
												'userrank' => isset($_POST['clearance']) ? sanitize($_POST['clearance']) : null,
												'licensek' => file_get_contents('https://www.lusioncp.me/lcpmain/apiservice.php?action=keygen'),
												'hostname' => isset($_POST['hostname']) ? sanitize($_POST['hostname']) : null,
												'hostuser' => isset($_POST['hostuser']) ? sanitize($_POST['hostuser']) : null,
												'hostpass' => isset($_POST['hostpass']) ? sanitize($_POST['hostpass']) : null,
											];

											$query = "
												SELECT
													username,
													email
												FROM
													lcpc_clients
												WHERE
													username = '{$data['username']}'
													OR
														email = '{$data['email']}'
											";
											$check = $db->query($query)->num_rows;
											if($check == 0) {
												if($data['usermail']) {
													$query = "
															INSERT INTO
																lcpc_clients (
																	username,
																	email,
																	password,
																	clearance,
																	license_key,
																	server_ip,
																	server_username,
																	server_password
																)
															VALUES (
																'{$data['username']}',
																'{$data['usermail']}',
																'{$data['password']}',
																'{$data['userrank']}',
																'{$data['licensek']}',
																'{$data['hostname']}',
																'{$data['hostuser']}',
																'{$data['hostpass']}'
															)";
													$send = file_get_contents("https://www.lusioncp.me/lcpmain/apiservice.php?action=add_license&key={$license['key']}&license_key={$data['licensek']}&license_ip={$data['hostname']}");
													$register = $db->query($query);
													if ($register->insert_id) {
														insert_log($data['id'], 'Client nou adăugat cu succes');
														success("Utilizatorul <strong>{$data['username']}</strong> a fost adăugat cu succes!", 'clients.php', 5);
													} else {
														trigger_error('Utilizatorul nu a putut fi înregistrat.');
													}
												} else {
													trigger_error('Adresa de e-mail este invalidă.');
												}
											} else {
												trigger_error('Utilizatorul specificat este existent.');
											}
										}
									?>
									<div class="table-responsive">
										<form action="clients.php?action=add" method="post">
										<table class="table table-bordered table-hover table-striped">
											<tbody>
												<tr>
													<td>Nume de utilizator:</td>
													<td><input type="text" name="username"></td>
												</tr>
												<tr>
													<td>Email:</td>
													<td><input type="email" name="email"></td>
												</tr>
												<tr>
													<td>Parola:</td>
													<td><input type="password" name="password"></td>
												</tr>
												<tr>
													<td>Hostname:</td>
													<td><input type="text" name="hostname"></td>
												</tr>
												<tr>
													<td>User:</td>
													<td><input type="text" name="hostuser"></td>
												</tr>
												<tr>
													<td>Parola:</td>
													<td><input type="password" name="hostpass"></td>
												</tr>
												<tr>
													<td>Nivel de acces:</td>
													<td>
														<select name="clearance" class="btn btn-default btn-xs dropdown-toggle">
															<option value="1" selected>Utilizator</option>
															<option value="2" disabled>---</option>
															<option value="3">Admin</option>
														</select>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td><input type="submit"  class="btn btn-success" name="send" value="Trimite"></td>
												</tr>
											</tbody>
										</table>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
