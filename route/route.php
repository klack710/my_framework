<?php
namespace route\route;

use controller\top\obachanController;
use controller\top\hasuminController;
use controller\top\otherController;

require_once 'controller/top/hasuminController.php';
require_once 'controller/top/obachanController.php';
require_once 'controller/top/otherController.php';


// URLから、クエリを取り除いてURIのみ取得する
$uri = $_SERVER['REQUEST_URI'];
$query = $_SERVER['QUERY_STRING'];
$uri = str_replace('?' . $query, '', $uri);

// URIから、呼び出すコントローラーを選択する
if ($uri === '/obachan') {
    $controller = new obachanController();
} else if ($uri === '/hasumin') {
    $controller = new hasuminController();
} else {
    $controller = new otherController();
}

//画面の表示
$controller->action();
