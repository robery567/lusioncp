<?php

namespace LusionPanel\Network;

class RemoteDatabase extends Remote {

    protected $_sql_data;
    protected $_sql_xcmd;

    private $_sql_user;
    private $_sql_pass;

    private $rdb;

    public function __construct() {
        $this->_sql_data = $database;

        parent::__construct();

        $this->_sql_user = $this->cmdExec('cat /root/lcp/.lcpsql | grep "user: " | cut -c 7-15');
        $this->_sql_pass = $this->cmdExec('cat /root/lcp/.lcpsql | grep "pass: " | cut -c 7-38');

        try {
            $this->rdb = new \MySQLi(
                $this->_hostname,
                $this->_sql_user,
                $this->_sql_pass,
                $this->_sql_data
            );

            unset($this->_sql_pass);

            if ($this->rdb->connect_error) {
                throw new Exception('CONNECT_ERROR');
            } else {
                if($this->rdb->query("SELECT COUNT(DISTINCT `table_name`) FROM `information_schema`.`columns` WHERE `table_schema` = '{$mysql['database']}'")->num_rows == 0) {
                    throw new Exception('CORRUPT_DATABASE');
                }
            }
        } catch(Exception $e) {
            switch($e->getMessage()) {
                case 'CONNECT_ERROR':
                    return '__CONNECT_ERROR__';
                    break;

                case 'CORRUPT_DATABASE':
                    return '__CORRUPT_DATABASE__';
                    break;

                default:
                    return '__UNKNOWN__';
                    break;
            }
        }
    }

    public function getTotalAccounts() {
        $query = "
            SELECT
                COUNT(login)
            FROM
                account.account
        ";
        return $this->rdb->query($query);
    }

    public function getTotalGuilds() {
        $query = "
            SELECT
                COUNT(login)
            FROM
                player.guilds
        ";

        return $this->rdb->query($query);
    }

    public function getDailyOnlinePlayers() {

    }
}
