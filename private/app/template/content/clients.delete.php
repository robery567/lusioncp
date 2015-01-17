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
										if(isset($_POST['sure'])) {
											$query = "
												DELETE 
													FROM `lcpc_clients`
												WHERE
													`user_id` = '{$_SESSION['user_id']}'
											";
											$affect = $db->query($sql)->affected_rows;
											if($affect) {
												success('Utilizatorul a fost șters cu succes!');
											} else {
												trigger_error('A apărut o eroare în timpul ștergerii.');
											}
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
										<input type="submit"  class="btn btn-danger btn-lg" name="send" value="Da, vreau să-l șterg, suport consecințele!">
									</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>