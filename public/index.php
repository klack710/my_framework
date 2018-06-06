<?php
// echo phpinfo();

require_once __DIR__.'/../vendor/ControllerHandler.php';

// テーブル作成SQL
// 'CREATE TABLE Pages (id int, name nchar(255), created_at datetime)';
// 'CREATE TABLE Hasvars (id int not null AUTO_INCREMENT, hasvar nchar(255) NOT NULL, created_at datetime NOT NULL, PRIMARY KEY (id))'
// 

$controllerHandler = new ControllerHandler();
$controllerHandler->execController();

