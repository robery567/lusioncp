<?php

namespace LusionPanel\Models;

class Clients extends LusionCore\Database\Models {
  private $user_id;
  private $username;
  private $email;
  private $password;
  private $license_key;
  private $server_ip;
  private $server_port;
  private $server_username;
  private $server_password;
  private $sf_id;
  private $is_installed;
  private $install_procent;
  private $clearance;

  public function __construct() {
    parent::__construct();
  }

  public function serverIp() {
    $this->query();
  }
}
