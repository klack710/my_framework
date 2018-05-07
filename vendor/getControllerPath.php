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
    require '../route/route.php';

    // routesから、コントローラーのパスを取得する
    if (array_key_exists($uri, $routes) && isset($routes[$uri][0])) {
        $file_full_path = $routes[$uri];
    } elseif (isset($routes_404[0])) {
        $file_full_path = $routes_404;
    } else {
        //(TODO) 404系エラー
        echo '404 not found';
        exit(1);
    }
    return $file_full_path;
}

