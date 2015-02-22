<?php

/**
 * 
 * LusionDB Maintainer tools
 * @version 0.1a
 * 
 */

require_once __DIR__.'/../app/boot/functions.php';
require_once __DIR__.'/../app/config/database.php';
require_once __DIR__.'/../app/classes/Database/LusionDataPdo.class.php';

// TODO: reset users.user_id, logs.log_id and logs.user_log
try {
  $dbh = new LusionDataPdo($mysql['hostname'], $mysql['username'], $mysql['password'], $mysql['database']);
} catch(Exception $e) {
  redirect_error(base_url().'maintenance.php', 500, 'The server is currently down.');
}

// reset users counter
try {
  $counter = [
    "SELECT user_id FROM lcpc_clients LIMIT 1",
    "UPDATE lcpc_clients SET user_id = :newid",
    "ALTER TABLE lcpc_clients AUTO_INCREMENT = 1",
    //FIXME: reset foreign key's value in logs && reset counter
    
  ];

  $dbh->startTransaction();
  // FIXME: do incremental counter
  for ($i = 1; $i < count($counter); $i++) {
    $fetch = $dbh->query($i)->bind($newid, 1)->execute();
  }

  $dbh->commitTransaction();
} catch(Exception $e) {
  $dbh->abortTransaction();
}
