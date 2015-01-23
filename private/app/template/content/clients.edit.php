			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Clienți</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Modificare Client
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<?php
										$user = isset($_GET['user']) ? sanitize($_GET['user']) : null;
										$query = "
											SELECT
												username AS useruser,
												password AS userpass,
												email AS usermail,
												server_ip AS hostname,
												server_username AS hostuser,
												server_password AS hostpass,
												server_port AS hostport,
												clearance AS user_level
											FROM
												lcpc_clients
											WHERE
												username = '{$user}'
										";
										$data = $db->query($query)->fetch_object();

										if(isset($_POST['update'])) {
											$form = [
												'username' => isset($_POST['username']) ? sanitize($_POST['username']) : $data->useruser,
												'password' => isset($_POST['password']) ? crypt_password($_POST['password']) : $data->userpass,
												'usermail' => isset($_POST['email']) ? (filter_var($_POST['email']) ? sanitize($_POST['email'], FILTER_VALIDATE_EMAIL) : false) : null,
												'hostname' => isset($_POST['hostname']) ? sanitize($_POST['hostname']) : $data->hostname,
												'hostuser' => isset($_POST['hostuser']) ? sanitize($_POST['hostuser']) : $data->hostuser,
												'hostpass' => isset($_POST['hostpass']) ? sanitize($_POST['hostpass']) : $data->hostpass,
												'hostport' => isset($_POST['hostport']) ? sanitize($_POST['hostport']) : $data->hostport,
												'userrank' => isset($_POST['clearance']) ? sanitize($_POST['clearance']) : $data->user_level,
											];

											$query = "
												SELECT
													`username`
												FROM
													`lcpc_clients`
												WHERE
													`username` = '{$user}'
											";
											$check = $db->query($query)->num_rows;
											if($check == 1) {
												$query = "
													UPDATE
														lcpc_clients
													SET
														username = '{$form['username']}',
														password = '{$form['password']}',
														email = '{$form['usermail']}',
														server_ip = '{$form['hostname']}',
														server_username = '{$form['hostuser']}',
														server_password = '{$form['hostpass']}',
														server_port = '{$form['hostport']}',
														clearance = '{$form['userrank']}'
													WHERE
														username = '{$user}'
												";
                        $sql = $db->query($query);
												if($sql->insert_id) {
													insert_log($data['id'], 'Clientul <strong>' . $user . '</strong> a fost modificat.');
													success("Utilizatorul <strong>{$user}</strong> a fost actualizat cu succes!", 'clients.php', 5);
												} else {
													trigger_error('Actualizarea utilizatorului specificat a eșuat.');
												}
											} else {
												trigger_error('Utilizatorul specificat nu există!');
											}
										}
									?>
									<div class="table-responsive">
										<form action="clients.php?action=edit&amp;user=<?= $user ?>" method="post">
										<table class="table table-bordered table-hover table-striped">
											<tbody>
												<tr>
													<td>Nume de utilizator:</td>
													<td><input type="text" name="username" value="<?= $user ?>"></td>
												</tr>
												<tr>
													<td>Email:</td>
													<td><input type="email" name="email" value="<?= $data->usermail ?>"></td>
												</tr>
												<tr>
													<td>Parola:</td>
													<td><input type="password" name="password"></td>
												</tr>
												<tr>
													<td>Hostname:</td>
													<td><input type="text" name="hostname" value="<?= $data->hostname ?>"></td>
												</tr>
												<tr>
													<td>User:</td>
													<td><input type="text" name="hostuser" value="<?= $data->hostuser ?>"></td>
												</tr>
												<tr>
													<td>Parola:</td>
													<td><input type="password" name="hostpass" value="<?= $data->hostpass ?>"></td>
												</tr>
												<tr>
													<td>Nivel de acces:</td>
													<td>
														<select name="clearance" class="btn btn-default btn-xs dropdown-toggle">
															<option value="1"<?php if($data->user_level == 1) echo ' selected'; ?>>Utilizator</option>
															<option value="2" disabled>---</option>
															<option value="3"<?php if($data->user_level == 3) echo ' selected'; ?>>Admin</option>
														</select>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td><input type="submit"  class="btn btn-success" name="update" value="Salvează"></td>
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
