			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Clienți</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Clienți (Credit: <?php echo reseller_credit($mysql['license_key']); ?>)
							<div class="pull-right">
								<div class="btn-group">
									<button type="button"
										class="btn btn-default btn-xs dropdown-toggle"
										data-toggle="dropdown">
										Acțiuni <span class="caret"></span>
									</button>
									<ul class="dropdown-menu pull-right" role="menu">
										<li>
											<a href="clients.php?action=add">Adaugă</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Nume de utilizator</th>
													<th>Email</th>
													<th>Hostname</th>
													<th>Instalat?</th>
													<th>Acțiuni</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$id = 1;
													$fetch = $db->query("SELECT username, email, server_ip, is_installed FROM lcpc_clients");
													while($client = $fetch->fetch_object()):
												?>
												<tr>
													<td><?= $id++ ?></td>
													<td><?= $client->username ?></td>
													<td><?= $client->email ?></td>
													<td><?= $client->server_ip ?></td>
													<?php if($client->is_installed == '1'): ?>
													<td>Da</td>
													<?php elseif($client->is_installed == '0'): ?>
													<td>Nu</td>
													<?php else: ?>
													<td>Invalid</td>
													<?php endif ?>
													<td>
														<div class="btn-group">
															<button type="button"
																class="btn btn-default btn-xs dropdown-toggle"
																data-toggle="dropdown">
																Acțiuni <span class="caret"></span>
															</button>
															<ul class="dropdown-menu pull-right" role="menu">
																<li>
																	<a href="clients.php?action=edit&amp;user=<?= $client->username ?>"><i class="fa fa-edit"></i> Modifică</a>
																</li>
																<li>
																	<a href="clients.php?action=delete&amp;user=<?= $client->username ?>"><i class="fa fa-remove"></i> Șterge</a>
																</li>
															</ul>
														</div>
													</td>
												</tr>
												<?php
													endwhile;
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-bell fa-fw"></i> Notificări
						</div>
						<div class="panel-body">
							<div class="list-group">
								<?= show_logs($data['id']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
