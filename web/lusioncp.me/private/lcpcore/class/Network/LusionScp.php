<?php

namespace LusionCore\Network;

use LusionCore\Network\LusionSsh;

class LusionScp extends LusionSsh{
  protected $scp;

  public function __construct()
  {
    parent::__construct();
    try {
      $this->scp = new Net_SCP($this->ssh);
    } catch(\Exception $e) {

    }
  }
}
