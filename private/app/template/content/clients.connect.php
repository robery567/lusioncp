<?php

$as = isset($_GET['user']) ? sanitize($_GET['user']) : null;

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Clienți</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user fa-fw"></i> Conectare ca <?= $as ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                        <?php
                            $query = "
                                SELECT
                                    `username`
                                FROM
                                    `lcpc_clients`
                                WHERE
                                    `username` = '{$as}';
                            ";

                            $check = $db->query($query);

                            if($check->num_rows == 1) {
                                $query = "
                                    SELECT
                                        `username`,
                                        `email`,
                                        `server_ip`,
                                        `clearance`
                                    FROM
                                        `lcpc_clients`
                                    WHERE
                                        `email` = ?
                                ";

                                $statement = $db->prepare($query);
                                $statement->bind_param('s', $as);
                                $statement->execute();
                                $statement->bind_result($r_username, $r_email, $r_ip, $r_lvl);

                                $statement->fetch();
                                $_SESSION['previous_user'] = $_SESSION['username'];
                                $_SESSION['username'] 	= $r_username;
                                $_SESSION['email'] 		= $r_email;
                                $_SESSION['server_ip'] 	= $r_ip;

                                success('Te-ai conectat cu succes!', 'dashboard.php', 10);
                            } else {
                                trigger_error('Utilizatorul nu a fost găsit!');
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
