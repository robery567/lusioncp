<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Serverfiles</h1>
  </div>
</div>
<div class="row">
  <div class="col-lg-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-user fa-fw"></i> Serverfiles
        <div class="pull-right">
          <div class="btn-group">
            <button type="button"
            class="btn btn-default btn-xs dropdown-toggle"
            data-toggle="dropdown">
            Acțiuni <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li>
              <a href="serverfiles.php?action=add">Adaugă</a>
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
                  <th>Nume Serverfile</th>
                  <th>URL Serverfile</th>
                  <th>DB URL</th>
                  <th>Actiune</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $id = 1;
                $fetch = $db->query("
                  SELECT
                    file_name AS name,
                    file_url AS url,
                    db_url AS urld
                    FROM lcpc_files
                ");
                while($client = $fetch->fetch_object()):
                  ?>
                  <tr>
                    <td><?= $id++ ?></td>
                    <td><?= $client->name ?></td>
                    <td><?= $client->url ?></td>
                    <td><?= $client->urld ?></td>
                    <td>
                      <div class="btn-group">
                        <button type="button"
                        class="btn btn-default btn-xs dropdown-toggle"
                        data-toggle="dropdown">
                        Acțiuni <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <li>
                          <a href="serverfiles.php?action=edit&amp;user=<?= $client->name ?>"><i class="fa fa-edit"></i> Modifică</a>
                        </li>
                        <li>
                          <a href="serverfiles.php?action=delete&amp;user=<?= $client->name ?>"><i class="fa fa-remove"></i> Șterge</a>
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
