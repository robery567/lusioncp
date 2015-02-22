<?php

namespace LusionCore\Network;

use LusionCore\Network\LusionSsh.php

class LusionSshConsole extends LusionSsh {
  protected $shell = [];

  public function __construct()
  {
    parent::__construct();
  }

  public function getPrompt()
  {
    return $this->ssh->read("{$this->_username}@{$this->_hostname}:~> ");
  }

  public function getSuPrompt()
  {
    $this->shell['currentDir'] = $this->ssh->exec('pwd');
    return $this->ssh->read("#[pP]assword[^:]*:|{$this->_username}@{$this->_hostname}:~\>#", NET_SSH2_READ_REGEX);
  }

  public function interactiveShell($command)
  {
    $this->ssh->setTimeout(5);

    $this->getPrompt();
    $this->ssh->write("{$command}\n");
    $this->getPrompt();
  }

  public function interactiveSuShell($command)
  {
    $this->ssh->setTimeout(5);

    $this->getSuPrompt();
    $this->ssh->write("sudo {$command}\n");
    $output = $this->shell['suPrompt'] = $this->getSuPrompt();

    return $output;

    if (preg_match('#[pP]assword[^:]*:#', $output)) {
      $this->ssh->write("{$this->_password}\n");
      return $this->getPrompt();
    }
  }

  public function __destruct()
  {
    $this->ssh = null;
  }
}
