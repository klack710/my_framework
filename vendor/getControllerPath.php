<?php

/**
 * URIとルートファイルから、
 * 動かすコントローラーを取得する
 *
 * @param String $uri URI
 * @return String $file_full_path コントローラーの書かれたファイルパス
 */
function getControllerPath($uri)
{
    // route.phpから、routesの情報を取得する
    $routes = [];
    $routes_404 = '/controller/top/OtherController';
    require_once '../route/route.php';

    // routesから、コントローラーのパスを取得する
    if (array_key_exists($uri, $routes) && isset($routes[$uri])) {
        $file_full_path = $routes[$uri];
    } elseif (isset($routes_404)) {
        header("HTTP/1.1 404 Not Found");
        $file_full_path = $routes_404;
    } else {
        //(TODO) 404系エラー
        header("HTTP/1.1 404 Not Found");
        echo '404 not found';
        exit(1);
    }
    return $file_full_path;
}

