<?php
require_once '../autoload.php';
require_once '../conf/config.php';
//equire_once 'helpers.php';
//use db\Mysql;
use routers\Router;
use facades\Facade;

$facade = new Facade($config);
$facade->dbConnection->connect();

$router = new Router();
$router();