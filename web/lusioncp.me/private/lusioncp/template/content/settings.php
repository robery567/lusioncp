<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profil</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user fa-fw"></i> Setări cont
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $user = isset($_SESSION['username']) ? sanitize($_SESSION['username']) : null;
                        $query = "
                        SELECT
                            username AS useruser,
                            password AS userpass,
                            email AS usermail,
                            server_ip AS hostname,
                            server_username AS hostuser,
                            server_password AS hostpass,
                            server_port AS hostport,
                            clearance AS user_level
                        FROM
                            lcpc_clients
                        WHERE
                            username = '{$user}'
                        ";
                        $data2 = $db->query($query)->fetch_object();

                        if(isset($_POST['update'])) {
                            $form = [
                                'username' => isset($_POST['username']) ? sanitize($_POST['username']) : $data2->useruser,
                                'password' => isset($_POST['password']) ? crypt_password($_POST['password']) : $data2->userpass,
                                'mortword' => isset($_POST['r_password']) ? crypt_password($_POST['r_password']) : $data2->userpass,
                                'usermail' => isset($_POST['email']) ? (filter_var($_POST['email']) ? sanitize($_POST['email'], FILTER_VALIDATE_EMAIL) : false) : null,
                                'mortmail' => isset($_POST['r_email']) ? (filter_var($_POST['r_email']) ? sanitize($_POST['r_email'], FILTER_VALIDATE_EMAIL) : false) : null,
                                'userrank' => isset($_POST['clearance']) ? sanitize($_POST['clearance']) : $data2->user_level,
                            ];

                            $query = "
                            SELECT
                                `username`
                            FROM
                                `lcpc_clients`
                            WHERE
                                `username` = '{$user}'
                            ";
                            $check = $db->query($query)->num_rows;
                            if($check == 1) {
                                if($form['password'] != $form['mortword']) {
                                    $query = "
                                    UPDATE
                                        lcpc_clients
                                    SET
                                        username = '{$form['username']}',
                                        password = '{$form['password']}',
                                        email = '{$form['usermail']}',
                                        clearance = '{$form['userrank']}'
                                    WHERE
                                        username = '{$user}'
                                    ";

                                    $update = $db->query($query);
                                    if($update) {
                                        insert_log($data['id'], 'Clientul <strong>' . $user . '</strong> a fost modificat.');
                                        success("Utilizatorul <strong>{$user}</strong> a fost actualizat cu succes!", 'clients.php', 5);
                                    } else {
                                        trigger_error('Actualizarea utilizatorului specificat a eșuat.');
                                    }
                                } else {
                                    trigger_error('Parolele introduse nu corespund!');
                                }
                            } else {
                                trigger_error('Utilizatorul specificat nu există!');
                            }
                        }
                        ?>
                        <div class="table-responsive">
                            <form action="clients.php?action=edit&amp;user=<?= $user ?>" method="post">
                                <table class="table table-bordered table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Nume de utilizator<strong style="font-color: #AA0000;">*</strong>:</td>
                                            <td><input type="text" name="username" value="<?= $user ?>" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>Email<strong style="font-color: #CF0000;">*</strong>:</td>
                                            <td><input type="email" name="email" value="<?= $data2->usermail ?>" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>Parola:</td>
                                            <td><input type="password" name="password"></td>
                                        </tr>
                                        <tr>
                                            <td>Repetă parola:</td>
                                            <td><input type="password" name="r_password"></td>
                                        </tr>
                                        <tr>
                                            <td>Nivel de acces<strong style="font-color: #AA0000;">*</strong>:</td>
                                            <td>
                                                <select name="clearance" class="btn btn-default btn-xs dropdown-toggle">
                                                    <option value="1"<?php if($data->user_level == 1) echo ' selected'; ?> disabled>Utilizator</option>
                                                    <option value="2" disabled>---</option>
                                                    <option value="3"<?php if($data->user_level == 3) echo ' selected'; ?> disabled>Admin</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Informație!</td>
                                            <td>
                                                <strong style="font-color: #AA0000;">*</strong> - camp needitabil
                                                <strong style="font-color: #CF0000;">*</strong> - camp editabil de catre admin
                                            </td>
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
