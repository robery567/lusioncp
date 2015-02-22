<?php

namespace LusionCore\Database;

/**
 * LusionCP PDO Abstraction Layer Driver
 * @author Petru
 */

class LusionPdo {
  protected $_dbdriver;
  protected $_hostname;
  protected $_username;
  protected $_password;
  protected $_dataport;
  protected $_database;
  protected $_xcharset;

  protected $_dbh;
  protected $_error;
  protected $_stmt;

  public function __construct(array $connection)
  {
    if (is_array($connection)) {
      if (array_key_exists('driver', $connection)) {
        $this->_dbdriver = (string) $connection[0];
      } else {
        throw new \Exception('Invalid array format.');
      }
    } else {
      throw new \Exception('The connection var is not array.');
    }

    try {

      switch ($this->_dbdriver) {
        case 'mysql':
          $dsn = "
            mysql:
              host={$this->_hostname};
              dbname={$this->_database};
              charset={$this->_xcharset}
          ";
          break;
        case 'sqlite':
          $dsn = "
            sqlite:
              {$this->_database}
          ";
          break;
        default:
          throw new \PDOException('Invalid database driver.');
          exit();
      }

      $pdoptions = [
          \PDO::ATTR_PERSISTENT => true,
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
      ];

      $this->_dbh = new \PDO(
        $dsn,
        $this->_username,
        $this->_password,
        $options
      );

    } catch(\PDOException $e) {
      $this->_dbe = $e->getMessage();
    }

    unset($this->_password);
    unset($password);
  }

  public function query($query)
  {
    $this->_stmt = $this->_dbh->prepare($query);
  }

  public function bind($param, $value, $type = null)
  {
    if(is_null($type)) {
      switch(true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
          break;
      }
    }

    $this->_stmt->bindValue($param, $value, $type);
  }

  public function execute()
  {
    return $this->_stmt->execute();
  }

  public function resultSet($resultType)
  {
    $this->execute();
    switch($resultType) {
      case 'PDO_ASSOC':
        $resultMethod = PDO::FETCH_ASSOC;
        break;
      case 'PDO_OBJECT':
        $resultMethod = PDO::FETCH_OBJ;
        break;
      default:
        $resultMethod = PDO::FETCH_BOTH;
        break;
    }

    return $this->_stmt->fetchAll($resultMethod);
  }

  public function resultSingle($resultType)
  {
    $this->execute();
    switch($resultType) {
      case 'PDO_ASSOC':
        $resultMethod = PDO::FETCH_ASSOC;
        break;
      case 'PDO_OBJECT':
        $resultMethod = PDO::FETCH_OBJ;
        break;
      default:
        $resultMethod = PDO::FETCH_BOTH;
        break;
    }

    return $this->_stmt->fetch($resultMethod);
  }

  public function querySuccess()
  {
    return $this->_dbh->lastInsertId();
  }

  public function startTransaction()
  {
    return $this->_dbh->beginTransaction();
  }

  public function endTransaction()
  {
    return $this->_dbh->commit();
  }

  public function abortTransaction()
  {
    return $this->_dbh->rollBack();
  }

  public function __destruct() {
    $this->_dbh = null;
  }
}
