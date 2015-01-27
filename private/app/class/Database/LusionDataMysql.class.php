<?php

class LusionDataMysql {
    private $_hostname;
    private $_username;
    private $_password;
    private $_dataport;
    private $_database;

    private $_dbh;
    private $_error;
    private $_stmt;

    public funcion __construct(
        $hostname,
        $username,
        $password,
        $database
    ) {
        $this->_hostname = (string) $hostname;
        $this->_username = (string) $username;
        $this->_password = (string) $password;
        $this->_database = (string) $database;

        try {
            $this->sql = new MySQLi(
                $this->_hostname,
                $this->_username,
                $this->_password,
                $this->_database
            );

            if ($db->connect_error) {
                throw new Exception('CONNECT_ERROR');
            } else if($this->sql->query("SELECT COUNT(DISTINCT `table_name`) FROM `information_schema`.`columns` WHERE `table_schema` = '{$this->_database}'")->num_rows == 0) {
                throw new Exception('CORRUPT_DATABASE');
            }
        } catch(Exception $e) {
            switch($e->getMessage()) {
                case '__CONNECT_ERROR__':
                    return 'lcpdb_errid[10000]::__CONNECT_ERROR__';
                    break;
                case 'CORRUPT_DATABASE':
                    return 'lcpdb_errid[10001]::__CORRUPT_DATABASE__';
                    break;
                default:
                    return 'lcpdb_errid[00000]::__UNKNOWN__':
                    break;
            }
        }

        unset($this->_password);
        unset($password);
    }

    public function query($query) {
        $this->_stmt = $this->_dbh->prepare($query);
    }

    public function bind(
        $value,
        $type = null
    ) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = 'i';
                    break;
                default:
                    $type = 's';
                    break;
            }
        }

        $this->_stmt->bind_param($type, $value);
    }

    public function execute() {
        return $this->_stmt->execute();
    }

    public function resultSet($resultType) {
        $this->execute();
        switch($resultType) {
            case 'MYSQLI_ASSOC':
                $resultMethod = MYSQLI_ASSOC;
                break;
            case 'MYSQLI_OBJECT':
                $resultMethod = MYSQLI_OBJ;
                break;
            default:
                $resultMethod = MYSQLI_ASSOC;
                break;
        }
        return $this->_stmt->fetch($resultMethod);
    }

    public function resultSingle($resultType) {
        $this->execute();
        switch($resultType) {
            case 'MYSQLI_ASSOC':
                $resultMethod = MYSQLI_ASSOC;
                break;
            case 'MYSQLI_OBJECT':
                $resultMethod = MYSQLI_OBJ;
                break;
            default:
                $resultMethod = MYSQLI_ASSOC;
                break;
        }
        return $this->_stmt->fetch($resultMethod);
    }

    public function querySuccess() {
        return $this->_dbh->insert_id;
    }

    public function startTransaction() {
        return $this->_dbh->begin_transaction();
    }

    public function endTransaction() {
        return $this->_dbh->commit();
    }

    public function abortTransaction() {
        return $this->_dbh->rollback();
    }
}
