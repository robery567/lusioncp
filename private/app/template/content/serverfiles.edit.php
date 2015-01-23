<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Clienți</h1>
  </div>
</div>
<div class="row">
  <div class="col-lg-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-user fa-fw"></i> Modificare Serverfile
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <?php
            $file_name = isset($_GET['file_name']) ? sanitize($_GET['file_name']) : null;
            $query = "
            SELECT
            file_name,
            file_url,
            db_url
            FROM
            lcpc_files
            WHERE
            file_name = '{$file_name}'
            ";
            $data2 = $db->query($query)->fetch_object();

            if(isset($_POST['update'])) {
              $form = [
                'file_name' => isset($_POST['file_name'])  ? sanitize($_POST['file_name'])  : $data2->file_name,
                'file_url'  => isset($_POST['file_url'])   ? sanitize($_POST['file_url'])   : $data2->file_url,
                'db_url'    => isset($_POST['db_url'])     ? sanitize($_POST['db_url'])     : $data2->db_url,
              ];

              $query = "
              SELECT
              `file_name`
              FROM
              `lcpc_files`
              WHERE
              `file_name` = '{$file_name}'
              ";
              $check = $db->query($query)->num_rows;
              if($check == 1) {
                $query = "
                UPDATE
                lcpc_files
                SET
                file_name = '{$form['file_name']}',
                file_url = '{$form['file_url']}',
                db_url = '{$form['db_url']}'
                WHERE
                file_name = '{$file_name}'
                ";

                $db->query($query);
                if($db->affected_rows) {
                  insert_log($data['id'], 'Serverfile-ul <strong>' . $file_name . '</strong> a fost modificat.');
                  success("Serverfile-ul <strong>{$file_name}</strong> a fost actualizat cu succes!", 'serverfiles.php', 5);
                } else {
                  trigger_error('Actualizarea serverfile-ului specificat a eșuat.');
                }
              } else {
                trigger_error('Serverfile-ul specificat nu există!');
              }
            }
            ?>
            <div class="table-responsive">
              <form action="serverfiles.php?action=edit&amp;file_name=<?= $file_name ?>" method="post">
                <table class="table table-bordered table-hover table-striped">
                  <tbody>
                    <tr>
                      <td>Nume Serverfile:</td>
                      <td><input type="text" name="file_name" value="<?= $file_name ?>"></td>
                    </tr>
                    <tr>
                      <td> URL Serverfile:</td>
                      <td><input type="text" name="file_url" value="<?= $data2->file_url ?>"></td>
                    </tr>
                    <tr>
                      <td>URL DB:</td>
                      <td><input type="text" name="db_url" value="<?= $data2->db_url ?>"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input type="submit"  class="btn btn-success" name="update" value="Salvează"></td>
                    </tr>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
