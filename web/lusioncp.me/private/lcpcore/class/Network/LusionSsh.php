<?php

namespace LusionCore\Network;

class LusionSsh {
  protected $ssh;
  protected $_hostname;
  protected $_username;
  private $_password;

  public function __construct($hostname, $username, $password)
  {
    $this->_hostname = $hostname;
    $this->_username = $username;
    $this->_password = $password;

    try {
      if(@fsockopen($this->_hostname, 22, $errno, $errstr, 6)) {
        $this->ssh = new Net_SSH2($this->_hostname);
        $this->ssh->enableQuietMode();
        $this->ssh->login($this->_username, $this->_password);
      } else {
        throw new \Exception('__CONN_ERR__');
      }
    } catch (\Exception $e) {
      switch ($e->getMessage()) {
        case '__CONN_ERR__':
          return 'The connection to remote server has failed';
          break;
        default:
          return '__UNKNOWN__';
          break;
      }
    }
  }

  public function cmdExec($command)
  {
    $this->ssh->setTimeout(5);
    return $this->ssh->exec($cmd);
  }

  public function __destruct()
  {
    unset($this->_password);
    $this->ssh = null;
  }
}
