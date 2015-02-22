<?php

require __DIR__ . '/../../private/lusioncp/start.php';

if(isset($_SESSION['username']) && isset($_SESSION['previous_user'])) {
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
    $statement->bind_param('s', sanitize($_SESSION['previous_user']));
    $statement->execute();
    $statement->bind_result($r_username, $r_email, $r_ip, $r_lvl);

    $statement->fetch();
    if($r_lvl == 3) {
        unset($_SESSION['previous_user']);
        $_SESSION['username'] 	= $r_username;
        $_SESSION['email'] 		= $r_email;
    } else {
        session_unset();
        session_destroy();
        redirect('index.php');
    }
} else if(isset($_SESSION['username']) && !isset($_SESSION['previous_user'])) {
    session_unset();
    session_destroy();
    redirect('index.php');
} else {
    redirect('index.php');
}
