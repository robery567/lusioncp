<?php

namespace LusionCore\Archive;

class LusionPhar {

  protected $_phar;
  protected $_arch;

  public function __construct($archiveName)
  {
    $this->_arch = $archiveName;
  }

  public function openArchive()
  {
    try {
      if (file_exists($archiveName)) {
        $this->_phar = new Phar($this->_arch, 0);
      } else {
        throw new \Exception('The requested Phar archive wasn\'t found.');
      }
    } catch(\Exception $e) {

    }
  }

  public function createArchive(string $projectPath, string $projectStub)
  {
    try {
      $this->_phar = new Phar($this->_arch, 0, $this->_arch);
      $this->_phar->startBuffering();
      $iterator = new \RecursiveIteratorIterator(new \DirectoryIterator($projectPath), $projectPath);
      $this->_phar->buildFromIterator($iterator);
      $this->_phar->setDefaultStub($projectStub);
      $this->_phar->stopBuffering();
    } catch (\PharException $e) {
      return 'Something went wrong. It is possible that you can\'t write Phar archives.';
    }
  }
}
