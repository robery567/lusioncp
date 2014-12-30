			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Dashboard</h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
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
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-8">
				<!-- /.panel-heading -->
					
					<!-- /.panel -->
					<div class="panel panel-default">
						
					  <div class="panel-heading">
							<b>SERVERS STATISTICS</b>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>HOSTNAME</th>
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
											<td><b><font color="green"><?php echo server_ip($_SESSION['username'], $DB); ?></font></td>
											<td><?= $remote->uptime() ?></td>
											<td><b><font color="red">100%</font></td>
											 <td><b><font color="orange">58%</font></td>
											<td><font color="grey">2GB used</font></td>
											<td><b><font color="green"><?= $remote->freeSpace() ?>/ <?= $remote->totalSpace() ?></font></td>
											 
										</tr>
										<tr>
											<td>2</td>
											<td>Jacob</td>
											<td>Thornton</td>
											<td>@fat</td>
											 <td>Jacob</td>
											<td>Thornton</td>
											<td>@fat</td
											
										</tr>
										<tr>
											<td>3</td>
											<td>Larry</td>
											<td>the Bird</td>
											<td>@twitter</td>
											 <td>Larry</td>
											<td>the Bird</td>
											<td>@twitter</td>
										</tr>
										 
									</tbody>
								
								</table>
							</div>
							WARNING !&nbsp;&nbsp;<b><font color="green">green  </font>- OK, &nbsp;&nbsp;<b> <font color="red">red</font>  - critical  ,&nbsp;&nbsp;<font color="orange"><b> orange</font>- attention !
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-clock-o fa-fw"></i> [SERVER DETAILS]
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<ul class="timeline">
								
							 
							</ul>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<!-- /.col-lg-8 -->
				<div class="col-lg-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-bell fa-fw"></i> [Notifications Panel]
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="list-group">
						   
								<a href="#" class="list-group-item">
									<i class="fa fa-tasks fa-fw"></i> New Task
									<span class="pull-right text-muted small"><em>43 minutes ago</em>
									</span>
								</a>
								<a href="#" class="list-group-item">
									<i class="fa fa-upload fa-fw"></i> Server Rebooted
									<span class="pull-right text-muted small"><em>11:32 AM</em>
									</span>
								</a>
								<a href="#" class="list-group-item">
									<i class="fa fa-bolt fa-fw"></i> Server Crashed!
									<span class="pull-right text-muted small"><em>11:13 AM</em>
									</span>
								</a>
								<a href="#" class="list-group-item">
									<i class="fa fa-warning fa-fw"></i> Server Not Responding
									<span class="pull-right text-muted small"><em>10:57 AM</em>
									</span>
								</a>
								
							</div>
							<!-- /.list-group -->
							
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-bar-chart-o fa-fw"></i> [Casuta Exemplu]
						</div>
						<div class="panel-body">
							<div id="morris-donut-chart"></div>
						   View Details
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
					<div class="chat-panel panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-comments fa-fw"></i>
						 [Ceva]
						</div>
						<!-- /.panel-heading -->
					   
					<!-- /.panel .chat-panel -->
				</div>
				<!-- /.col-lg-4 -->
			</div>
			<!-- /.row --> 
