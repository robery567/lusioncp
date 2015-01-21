			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Statistici</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-8">
					<div class="panel panel-default">
					  <div class="panel-heading">
							<strong>Informații server virtual</strong>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<tr>
											<td>{nume}:</td>
											<td>{valoare}</td>
										</tr>
										<tr>
											<td>{nume}:</td>
											<td>{valoare}</td>
										</tr>
										<tr>
											<td>{nume}:</td>
											<td>{valoare}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
					  <div class="panel-heading">
							<strong>Informații server joc</strong>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<tr>
											<td>Conturi existente:</td>
											<td><?= $remotedb->getTotalAccounts() ?></td>
										</tr>
										<tr>
											<td>{nume}:</td>
											<td>{valoare}</td>
										</tr>
										<tr>
											<td>{nume}:</td>
											<td>{valoare}</td>
										</tr>
									</tbody>
								</table>
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
