<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Clienți</h1>
  </div>
</div>
<div class="row">
  <div class="col-lg-8">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <i class="fa fa-user fa-fw"></i> Ștergere serverfile
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <?php
            $file_name = isset($_GET['file_name']) ? sanitize($_GET['file_name']) : null;
            if(isset($_POST['sure'])) {
              $query = "
              DELETE
              FROM `lcpc_files`
              WHERE
              `file_name` = '{$file_name}'
              ";
              $delete = $db->query($query);
              if($delete) {
                insert_log($data['id'], 'Serverfile-ul ' . $file_name . ' a fost sters.');
                success('Serverfile-ul a fost sters!', 'serverfiles.php', 5);
              } else {
                trigger_error('A apărut o eroare în timpul ștergerii.');
              }
            }
            ?>
            <div class="alert alert-danger">
              <h3>ATENȚIE!</h3>
              <p>
                Ești sigur că dorești să ștergi acest serverfile?<br>
              </p>
            </div>
            <form action="serverfiles.php?action=delete&amp;file_name=<?= $file_name ?>" method="post">
              <input type="submit" class="btn btn-danger btn-lg" name="sure" value="Da">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
