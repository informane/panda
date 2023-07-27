<?php

namespace db;

use Exception;

class MysqlConnection implements DbConnection{
    public $pdo;
    protected $host;
    protected $db;
    protected $user;
    protected $password;
    protected $charset;

    public function __construct($host, $db, $user, $password, $charset='utf8mb4'){
        $this->host=$host;
        $this->db=$db;
        $this->user=$user;
        $this->password=$password;
        $this->charset=$charset;
    }

    public function connect(){
        $options=[
            \PDO::ATTR_ERRMODE           =>\PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ,
            \PDO::ATTR_EMULATE_PREPARES  =>false,
        ];
        $dsn="mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";

        try{
            $this->pdo=new \PDO($dsn, $this->user, $this->password, $options);
        } catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }
}