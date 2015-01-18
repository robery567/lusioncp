<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Dashboard</h1>
  </div>
</div>
<div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-exchange fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class="huge">C</div>
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
                <?php
                $query = "
                  SELECT
                    `username`
                  FROM
                    `lcpc_clients`
                  WHERE
                    `is_installed` = 0
                ";
                $clients = [
                  'uninstalled' => $db->query($query)->num_rows
                ];
                $cu_count = ($clients > 1) ? 'clienți' : 'client';
                ?>
                <div class="huge">Server neinstalat</div>
                <div>Ai <?= $clients['uninstalled'] ?> <?= $cu_count ?> cu server neinstalat.</div>
              </div>
            </div>
          </div>
          <a href="clients.php?action=install">
            <div class="panel-footer">
              <span class="pull-left">
                Poți instala serverul clienților tăi de aici.
              </span>
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
    <div class="row">
      <div class="col-lg-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Statistici server</strong>
          </div>
          <div class="panel-body">
            <p>
              Welcome back, Mentor!
            </p>
            <p>
              Asta este pagina ta specială. Be happy!
            </p>
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
