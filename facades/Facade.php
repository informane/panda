<?php

namespace facades;

class Facade{

    public $dbms;
    public $dbConnection;

    public function __construct($config){
        $this->dbms=$config['db']['dbms'];
        $dbConnectionClass="db\\" . ucfirst($config['db']['dbms']) . 'Connection';
        $this->dbConnection=new $dbConnectionClass($config['db']['host'], $config['db']['db'], $config['db']['user'], $config['db']['password'], $config['db']['charset']);
    }
}