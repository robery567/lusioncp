<?php

namespace LusionCore\Network;

class LusionSftp {
  protected $sftp;
  protected $_hostname;
  protected $_username;
  private $_password;

  public function __construct($hostname, $username, $password)
  {
    $this->_hostname = $hostname;
    $this->_username = $username;
    $this->_password = $password;

    $this->sftp = new Net_SFTP($this->_hostname);

    try {
      if(@fsockopen($this->_hostname, 22, $errno, $errstr, 6)) {
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

    unset($this->_password);
    unset($password);
  }

  public function upload($localFile, $remoteFile)
  {
    $this->sftp->put($localFile, $remoteFile, NET_SFTP_STRING);
  }

  public function download($remoteFile, $localFile)
  {
    $this->sftp->get($remoteFile, $localFile);
  }

  public function createDir($dirName)
  {
    $this->sftp->mkdir($dirName);
  }

  public function openDir($dirName)
  {
    $this->sftp->chdir($dirName);
  }

  public function currentDir()
  {
    return $this->sftp->pwd();
  }

  public function removeDir($dirName)
  {
    $this->sftp->delete($dirName, true);
  }

  public function listDirs()
  {
    return $this->sftp->rawlist();
  }

  public function createFile($fileName)
  {
    $this->sftp->touch($fileName);
  }

  public function chmod($permissions, $fileName)
  {
    $this->sftp->chmod($permissions, $fileName, true);
  }

  public function chown($fileName, $userId)
  {
    $this->sftp->chown($filename, $userId, true);
  }

  public function chgrp($filename, $groupId)
  {
    $this->sftp->chgrp($filename, $group, true);
  }

  public function truncateFile($fileName, $size = 1024)
  {
    $this->sftp->truncate($fileName, $size);
  }

  public function fileSize($fileName)
  {
    return $this->sftp->size($fileName);
  }

  public function fileInfo($fileName)
  {
    foreach($this->sftp->stat($fileName) as $info) {
      return $info."PHP_EOL";
    }
  }

  public function fileRemove($fileName) {
    $this->removeDir($fileName);
  }

  public function fileRename($oldName, $newName)
  {
    $this->sftp->rename($oldName, $newName);
  }

  public function __destruct()
  {
    $this->ssh = null;
  }
}
