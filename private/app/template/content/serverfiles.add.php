			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Clienți</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Adăugare serverfile
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<?php
										if(isset($_POST['send'])) {
											$data = [
												'file_name'	=> isset($_POST['file_name']) ? sanitize($_POST['file_name']) : null,
												'file_url' 	=> isset($_POST['file_url']) ? sanitize($_POST['file_url']) : null,
												'db_url' 	=> isset($_POST['db_url']) ? sanitize($_POST['db_url']) : null
											];

											$query = "
												SELECT
													file_name
												FROM
													lcpc_files
												WHERE
													file_name = '{$data['file_name']}'
											";
											$check = $db->query($query)->num_rows;
											if($check == 0) {
													$query = "INSERT INTO
																lcpc_files (
																	file_name,
																	file_url,
																	db_url
																)
															VALUES (
																'{$data['file_name']}',
																'{$data['file_url']}',
																'{$data['db_url']}'
															)";
													$register = $db->query($query);
													$check = $db->query("SELECT COUNT(*) AS nr FROM lcpc_files WHERE file_name = '{$data['file_name']}'")->fetch_array(MYSQLI_ASSOC);
													if ($check['nr']) {
														insert_log($data['id'], 'Serverfile nou adăugat cu succes');
														success("Serverfile-ul <strong>{$data['file_name']}</strong> a fost adăugat cu succes!", 'add_serverfile.php', 5);
													} else {
														trigger_error('Serverfile-ul nu a putut înregistrat.');
													}
											}
										}
									?>
									<div class="table-responsive">
										<form action="serverfiles.php?action=add" method="post">
										<table class="table table-bordered table-hover table-striped">
											<tbody>
												<tr>
													<td>Nume serverfile:</td>
													<td><input type="text" name="file_name"></td>
												</tr>
												<tr>
													<td>URL SERVERFILE:</td>
													<td><input type="text"" name="file_url"></td>
												</tr>
												<tr>
													<td>DB URL (.tar.gz,.tar format):</td>
													<td><input type="text" name="db_url"></td>
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
