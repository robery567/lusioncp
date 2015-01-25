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
			if ($action == "reboot" && !$offline) {
				$remote->doGameAction('reboot');
				insert_log($data['id'], "Reboot VPS", $db);
				echo '<meta http-equiv="refresh" content="0; url=dashboard.php">';
			}
			if ($action == "stop" && !$offline) {
				$remote->doGameAction('stop');
				insert_log($data['id'], "Oprire server Metin2", $db);
				echo '<meta http-equiv="refresh" content="0; url=dashboard.php">';
			}
			if ($action == "start" && !$offline) {
				$remote->doGameAction('start');
				insert_log($data['id'], "Pornire server Metin2", $db);
				echo '<meta http-equiv="refresh" content="0; url=dashboard.php">';
			}
			if ($action == "restart" && !$offline) {
				$remote->doGameAction('restart');
				insert_log($data['id'], "Restart server Metin2", $db);
				echo '<meta http-equiv="refresh" content="0; url=dashboard.php">';
			}
			?>
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
										<td><?php echo server_ip($_SESSION['username']); ?></td>
										<td><?php if(!$offline) echo $remote->getKernel(); else echo 'Necunoscut'; ?></td>
										<td><?php if (!$offline) echo $remote->uptime(); else echo '<font color="red">OFFLINE</font>'; ?></td>
										<td><?php if (!$offline) echo $remote->loadAvg(); else echo 0; ?></td>
										<td><?php if (!$offline) echo $remote->cpuUsage(); else echo '0%'; ?></td>
										<td><?php if (!$offline) echo $remote->ramMemory(); else echo '0'; ?></td>
										<td><?php if (!$offline) echo $remote->freeSpace(); else echo '0'; ?>/<?php if (!$offline) echo $remote->totalSpace(); else echo '0'; ?></td>
									</tr>


								</tbody>

							</table>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-clock-o fa-fw"></i> Acțiuni server
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<?php if(!$offline) { ?>
								<a href="dashboard.php?action=start"><button type="button" class="btn btn-success">Start</button></a>
								<a href="dashboard.php?action=restart"><button type="button" class="btn btn-warning">Restart</button></a>
								<a href="dashboard.php?action=reboot"><button type="button" class="btn btn-danger">Reboot</button></a>
								<a href="dashboard.php?action=stop"><button type="button" class="btn btn-danger">Stop</button></a>
								<a href="serverfiles.php?action=install"><button type="button" class="btn btn-warning">Reinstalare server</button></a>
								<?php }
								else if ($offline || $action == "start") {
									?>
									<button type="button" class="btn btn-success disabled">Start</button><img src="https://www.lusioncp.me/assets/img/spin.gif" alt="Loading..." width="20" height="20">
									<meta http-equiv="refresh" content="5; url=dashboard.php">
									<?php
								}
								else if ($offline || $action == "restart"){
									?>
									<button type="button" class="btn btn-warning disabled">Restart</button><img src="https://www.lusioncp.me/assets/img/spin.gif" alt="Loading..." width="20" height="20">
									<meta http-equiv="refresh" content="5; url=dashboard.php">
									<?php }
									else if ($offline || $action == "restart") {
										?>
										<button type="button" class="btn btn-danger disabled">Reboot</button><img src="https://www.lusioncp.me/assets/img/spin.gif" alt="Loading..." width="20" height="20">
										<meta http-equiv="refresh" content="5; url=dashboard.php">
										<?php }
										else if ($offline || $action == "restart") {
											?>
											<button type="button" class="btn btn-danger disabled">Stop</button><img src="https://www.lusioncp.me/assets/img/spin.gif" alt="Loading..." width="20" height="20">
											<meta http-equiv="refresh" content="5; url=dashboard.php">
										</div>
										<?php } ?>
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
						
