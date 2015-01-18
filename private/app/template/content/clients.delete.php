			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Clienți</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Ștergere client
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<?php
										$user = isset($_GET['user']) ? sanitize($_GET['user']) : null;
										if(isset($_POST['sure'])) {
											$query = "
												DELETE
													FROM lcpc_clients
												WHERE
													username = '{$user}'
											";
											$affect = $db->query($query);
											$check = $db->query("SELECT COUNT(*) AS nr FROM lcpc_clients WHERE username = '{$user}'")->fetch_array(MYSQLI_ASSOC);
											if (!$check['nr'])
												success('Utilizatorul a fost șters cu succes!', 'clients.php', 2);
											
											/*if(!$db->query("SELECT COUNT(*) FROM lcpc_clients WHERE username = '{$user}'")->num_rows) {
												echo "<script>alert(1)</script>";
												success('Utilizatorul a fost șters cu succes!', 'clients.add.php', 2);
											} else {
												trigger_error('A apărut o eroare în timpul ștergerii.');
											}*/
										}
									?>
									<div class="alert alert-danger">
										<h3>ATENȚIE!</h3>
										<p>
											Ești sigur că dorești să ștergi acest client?<br>
											Prin ștergerea unui client riști să pierzi banii oferiți de acesta și datele de pe acest server.
											Ștergerea accesului la client este definitivă și se poate solda cu înjurături la adresa ta.
										</p>
										<p>
											Ești sigur că vrei să ștergi acest client?
										</p>
									</div>
									<form action="clients.php?action=delete&amp;user=<?= $user ?>" method="post">
										<input type="submit" class="btn btn-danger btn-lg" name="sure" value="Da">
									</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
