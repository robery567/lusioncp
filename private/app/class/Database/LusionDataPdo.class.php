<?php

class LusionDataPdo {
    private $_hostname;
    private $_username;
    private $_password;
    private $_database;

    private $_dbh;
    private $_dbe;
    private $_stmt;

    public function __construct(
        $hostname,
        $username,
        $password,
        $database
    ) {
        $this->_hostname = (string) $hostname;
        $this->_username = (string) $username;
        $this->_password = (string) $password;
        $this->_database = (string) $database;

        $dsn = "
            mysql:
            host={$this->_hostname};
            dbname={$this->_database};
            charset=utf8
        ";

        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->_dbh = new PDO(
                $dsn,
                $this->_username,
                $this->_password,
                $options
            );
        } catch(PDOException $e) {
            $this->_dbe = $e->getMessage();
        }

        unset($this->_password);
        unset($password);
    }

    public function query($query) {
        $this->_stmt = $this->_dbh->prepare($query);
    }

    public function bind(
        $param,
        $value,
        $type = null
    ) {
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

    public function execute() {
        return $this->_stmt->execute();
    }

    public function resultSet($resultType) {
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

    public function resultSingle($resultType) {
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

    public function querySuccess() {
        return $this->_dbh->lastInsertId();
    }

    public function startTransaction() {
        return $this->_dbh->beginTransaction();
    }

    public function endTransaction() {
        return $this->_dbh->commit();
    }

    public function abortTransaction() {
        return $this->_dbh->rollBack();
    }
}
