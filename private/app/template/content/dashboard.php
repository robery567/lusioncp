			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Dashboard</h1>
				</div>
			</div>
			<div class="row">
			<?php
			$action = isset($_GET['action']) ? sanitize($_GET['action']) : null;
			if (!is_installed($_SESSION['username'], $db)) {
				if ($action == "install") {
					$remote->installInit();
				}
			?>
				<div class="alert alert-danger">
					Serverul nu a fost inca instalat, va rugam sa o faceti apasand pe butonul alaturat.
					<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
						Instaleaza server
					</button>
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="myModalLabel">Pas 1 din 3</h4>
								</div>
								<div class="modal-body">
									<br>
									 <div class="alert alert-warning">
										<a href="#" class="alert-link">ATENTIE !</a><br>
										Instalarea serverului poate dura pana la 120 minute in functie de configuratia serverului dumneavoastra<br> <br>
										<strong>Odata apasat butonul <font color="black">[ Instaleaza acum ]</font> va rula procedura de instalare . </strong>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Anuleaza</button>
									<a href="?action=install" alt="Install server"><button type="button" class="btn btn-primary">Instaleaza acum</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php } else {
					if ($action == "restart" && !$offline) {
						$remote->cmdExec("shutdown -r now");
						insert_log($_SESSION['user_id'], "Restart Server", $db);
						echo '<meta http-equiv="refresh" content="0; url=dashboard.php">';
					}
				?>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-exchange fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">[buton 1]</div>
									<div>[Meniu 1 ]</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="panel-footer">
								<span class="pull-left">[detalii]</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-tasks fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">[ buton 2 ]</div>
									<div>[meniu 2]</div>

								</div>
							</div>
						</div>
						<a href="#">
							<div class="panel-footer">
								<span class="pull-left">[ detalii 2 ]</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-plus-circle fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">[ buton 3]</div>
									<div>[meniu 3]</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="panel-footer">
								<span class="pull-left">[detalii 3]</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-red">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-exclamation-circle fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">[buton 4 ]</div>
									<div>[meniu 4]</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="panel-footer">
								<span class="pull-left">[detalii 4]</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<div class="panel panel-default">
					  <div class="panel-heading">
							<strong>Statistici server</strong>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>HOSTNAME</th>
											<th>UNIX KERNEL</th>
											<th>UPTIME</th>
											<th>LOAD</th>
											<th>CPU</th>
											<th>RAM</th>
											<th>HDD</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td><strong><font color="green"><?php echo server_ip($_SESSION['username']); ?></font></strong></td>
											<td><?php if(!$offline) echo $remote->getKernel(); else echo 'Necunoscut'; ?></td>
											<td><?php if (!$offline) echo $remote->uptime(); else echo '<font color="red">OFFLINE</font>'; ?></td>
											<td><strong><font color="red"><?php if (!$offline) echo $remote->loadAvg(); else echo 0; ?></font></strong></td>
											<td><strong><font color="orange"><?php if (!$offline) echo $remote->cpuUsage(); else echo '0%'; ?></font></strong></td>
											<td><font color="grey" size="2"><?php if (!$offline) echo $remote->ramMemory(); else echo '0'; ?></font></td>
											<td><strong><font color="green"><?php if (!$offline) echo $remote->freeSpace(); else echo '0'; ?>/<?php if (!$offline) echo $remote->totalSpace(); else echo '0'; ?></font></strong></td>
										</tr>


									</tbody>

								</table>
							</div>
							WARNING!&nbsp;&nbsp;<strong><font color="green">green</font></strong> - OK, &nbsp;&nbsp;<strong><font color="red">red</font></strong>  - critical, &nbsp;&nbsp;<strong><font color="orange">orange</font></strong> - attention!
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-clock-o fa-fw"></i> Acțiuni server
						</div>
						<div class="panel-body">
							<div class="table-responsive">
							 <button type="button" class="btn btn-success">Boot</button>
							 <?php
								if (!$offline) {
									echo '<a href="dashboard.php?action=restart"> <button type="button" class="btn btn-danger">Restart</button> </a>';
								} else if ($offline || $action == "restart") {
									echo '<button type="button" class="btn btn-danger disabled">Restart</button><img src="//lusioncp.me/assets/img/spin.gif" alt="Loading..." width="20" height="20">
											<meta http-equiv="refresh" content="5; url=dashboard.php" />';
								}
							?>
							<button type="button" class="btn btn-warning">Reinstalare Server</button>
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
								<?= show_logs($_SESSION['user_id']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
