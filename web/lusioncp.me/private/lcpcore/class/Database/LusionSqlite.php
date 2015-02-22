<?php

namespace LusionCore\Database;

/**
 * LusionCP SQLite native driver
 * @author Petru
 * TODO: complete the class
 */

class LusionSqlite {
  protected $_filename;
  protected $_mode;
  protected $_errorMsg;

  protected $_dbh;
  protected $_dbe;
  protected $_stmt;

  public function __construct($filename, $mode, $errorMsg) {

    $this->_filename = (string) $filename;
    $this->_mode = (int) $mode;
    $this->_errorMsg = (string) $errorMsg;

    try {
      $this->_dbh = sqlite_open($this->_filename, $this->_mode, $this->_errorMsg);
    } catch(\Exception $e) {
      $this->_dbe = $e->getMessage();
    }
  }

  public function sanitize($item) {
    return sqlite_escape_string($item);
  }

  public function query($query) {
    $query = $this->sanitize($query);
    $this->_stmt = sqlite_queryExec($this->_dbh, $query);
  }
}
