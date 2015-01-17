					<ul class="nav" id="side-menu">
						<li class="sidebar-search">
							<div class="input-group custom-search-form">
								<input type="text" class="form-control" placeholder="Caută...">
								<span class="input-group-btn">
								<button class="btn btn-default" type="button">
									<i class="fa fa-search"></i>
								</button>
							</span>
							</div>
							<!-- /input-group -->
						</li>
						<li>
							<a class="active" href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
						</li>
						<li>
							<a href="statistics.php"><i class="fa fa-bar-chart-o fa-fw"></i> Statistici</a>
						</li>
						<li>
							<a href="#"><i class="fa fa-database fa-fw"></i> Servere<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="#"><?= server_ip($_SESSION['username'], $DB) ?></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-wrench fa-fw"></i> SysAdmin<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="console.php">Consolă SSH</a>
								</li>
								<li>
									<a href="#">Vezi log-uri</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
					</ul>