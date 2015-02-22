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
									<a href="#"><?= server_ip($_SESSION['username']) ?></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-wrench fa-fw"></i> SysAdmin<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="console.php">Consolă SSH</a>
								</li>
								<!-- TBD
									<li>
									<a href="#">Vezi log-uri</a>
								</li> -->
							</ul>
						</li>
						<?php
						$udata = $db->query("SELECT clearance FROM lcpc_clients WHERE email = '{$_SESSION['email']}'")->fetch_array(MYSQLI_ASSOC);
						if($udata['clearance'] == 3) { ?>
						<li>
							<a href="#"><i class="fa fa-wrench fa-fw"></i> Admin Reseller<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="clients.php">Vezi clienți</a>
								</li>
								<li>
									<a href="serverfiles.php">Vezi serverfiles</a>
								</li>
								<!-- TBD
								<li>
									<a href="#">Vezi log-uri</a>
								</li>
							-->
							</ul>
						</li>
						<?php
						}
						?>
					</ul>
